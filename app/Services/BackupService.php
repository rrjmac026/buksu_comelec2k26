<?php

namespace App\Services;

use App\Models\DataBackup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class BackupService
{
    public function createDatabaseBackup(int $userId, int $retentionDays = 30): DataBackup
    {
        $backup = DataBackup::create([
            'backup_name'     => 'backup-db-' . now()->format('Y-m-d-His'),
            'backup_type'     => 'database',
            'status'          => 'processing',
            'created_by'      => $userId,
            'retention_until' => now()->addDays($retentionDays),
        ]);

        try {
            $backup->update(['progress' => 10]);

            $sqlPath = $this->dumpDatabase($backup->backup_name);

            $backup->update(['progress' => 60]);

            $zipPath = $this->createZip($backup->backup_name, [$sqlPath]);

            // Cleanup the raw sql file
            File::delete($sqlPath);

            $backup->update([
                'status'       => 'completed',
                'file_path'    => 'backups/' . basename($zipPath),
                'file_size'    => filesize($zipPath),
                'progress'     => 100,
                'completed_at' => now(),
            ]);

        } catch (\Exception $e) {
            Log::error('Database backup failed', ['error' => $e->getMessage()]);
            $backup->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }

        return $backup->fresh();
    }

    public function createFullBackup(int $userId, int $retentionDays = 30): DataBackup
    {
        $backup = DataBackup::create([
            'backup_name'     => 'backup-full-' . now()->format('Y-m-d-His'),
            'backup_type'     => 'full',
            'status'          => 'processing',
            'created_by'      => $userId,
            'retention_until' => now()->addDays($retentionDays),
        ]);

        try {
            $backup->update(['progress' => 10]);

            $sqlPath = $this->dumpDatabase($backup->backup_name);

            $backup->update(['progress' => 50]);

            // Gather app files (exclude heavy dirs)
            $filesToZip = [$sqlPath];
            $appDirs    = ['app', 'config', 'database', 'resources', 'routes'];
            foreach ($appDirs as $dir) {
                $path = base_path($dir);
                if (File::exists($path)) {
                    $filesToZip[] = $path;
                }
            }

            $backup->update(['progress' => 70]);

            $zipPath = $this->createZip($backup->backup_name, $filesToZip);

            File::delete($sqlPath);

            $backup->update([
                'status'       => 'completed',
                'file_path'    => 'backups/' . basename($zipPath),
                'file_size'    => filesize($zipPath),
                'progress'     => 100,
                'completed_at' => now(),
            ]);

        } catch (\Exception $e) {
            Log::error('Full backup failed', ['error' => $e->getMessage()]);
            $backup->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }

        return $backup->fresh();
    }

    public function deleteBackup(DataBackup $backup): void
    {
        $filePath = storage_path('app/' . $backup->file_path);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $backup->delete();
    }

    public function cleanExpiredBackups(): int
    {
        $expired = DataBackup::where('retention_until', '<=', now())->get();

        foreach ($expired as $backup) {
            $this->deleteBackup($backup);
        }

        return $expired->count();
    }

    // ── Private helpers ──────────────────────────────────────────────────

    private function dumpDatabase(string $name): string
    {
        $connection = config('database.default');
        $config     = config("database.connections.{$connection}");
        $sqlPath    = storage_path("app/backups/{$name}.sql");

        File::ensureDirectoryExists(storage_path('app/backups'));

        // Try mysqldump first, fall back to PHP query dump
        if ($this->mysqldumpAvailable()) {
            $this->runMysqldump($config, $sqlPath);
        } else {
            $this->phpDump($sqlPath);
        }

        return $sqlPath;
    }

    private function mysqldumpAvailable(): bool
    {
        exec('mysqldump --version 2>&1', $output, $code);
        return $code === 0;
    }

    private function runMysqldump(array $config, string $outputPath): void
    {
        $cmd = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s 2>&1',
            escapeshellarg($config['host']),
            escapeshellarg($config['port'] ?? '3306'),
            escapeshellarg($config['username']),
            escapeshellarg($config['password']),
            escapeshellarg($config['database']),
            escapeshellarg($outputPath)
        );

        exec($cmd, $output, $code);

        if ($code !== 0) {
            throw new \RuntimeException('mysqldump failed: ' . implode("\n", $output));
        }
    }

    private function phpDump(string $outputPath): void
    {
        $tables = DB::select('SHOW TABLES');
        $sql    = "-- PHP Fallback Dump\n-- Generated: " . now() . "\n\n";
        $sql   .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $tableObj) {
            $table = array_values((array) $tableObj)[0];

            // CREATE TABLE
            $create = DB::select("SHOW CREATE TABLE `{$table}`");
            $sql   .= array_values((array) $create[0])[1] . ";\n\n";

            // INSERT rows
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = collect((array) $row)->map(
                    fn($v) => is_null($v) ? 'NULL' : "'" . addslashes($v) . "'"
                )->implode(', ');

                $sql .= "INSERT INTO `{$table}` VALUES ({$values});\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        File::put($outputPath, $sql);
    }

    private function createZip(string $name, array $paths): string
    {
        $zipPath = storage_path("app/backups/{$name}.zip");

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException("Cannot create zip at {$zipPath}");
        }

        foreach ($paths as $path) {
            if (File::isFile($path)) {
                $zip->addFile($path, basename($path));
            } elseif (File::isDirectory($path)) {
                $this->addDirectoryToZip($zip, $path, basename($path));
            }
        }

        $zip->close();

        return $zipPath;
    }

    private function addDirectoryToZip(ZipArchive $zip, string $dir, string $prefix): void
    {
        $files = File::allFiles($dir);
        foreach ($files as $file) {
            $zip->addFile(
                $file->getRealPath(),
                $prefix . '/' . $file->getRelativePathname()
            );
        }
    }
}