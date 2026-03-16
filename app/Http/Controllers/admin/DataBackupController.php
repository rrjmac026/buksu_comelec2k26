<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataBackup;
use App\Services\BackupService;
use App\Jobs\CreateDatabaseBackupJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DataBackupController extends Controller
{
    protected BackupService $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    // ─────────────────────────────────────────────────────────────
    // GET /admin/backups
    // ─────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = DataBackup::with('creator')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('backup_type', $request->type);
        }

        $backups = $query->paginate(15)->withQueryString();
        $stats   = $this->getBackupStats();

        return view('admin.backups.index', compact('backups', 'stats'));
    }

    // ─────────────────────────────────────────────────────────────
    // POST /admin/backups
    // ─────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'backup_type'    => 'nullable|in:database,full',
                'retention_days' => 'nullable|integer|min:1|max:365',
                'async'          => 'nullable|boolean',
            ]);

            $backupType    = $validated['backup_type']    ?? 'database';
            $retentionDays = $validated['retention_days'] ?? 30;
            $async         = $validated['async']          ?? false;

            // Ensure backup directory exists
            $backupPath = storage_path('app/backups');
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            if ($async && config('queue.default') !== 'sync') {
                CreateDatabaseBackupJob::dispatch(
                    Auth::id(),
                    $backupType,
                    $retentionDays
                );

                return back()->with('success', 'Backup queued successfully. It will run in the background.');
            }

            // Synchronous — runs immediately
            $backup = $backupType === 'full'
                ? $this->backupService->createFullBackup(Auth::id(), $retentionDays)
                : $this->backupService->createDatabaseBackup(Auth::id(), $retentionDays);

            if ($backup->status === 'completed') {
                return back()->with('success', "Backup completed successfully! Size: {$backup->formatted_size}");
            }

            return back()->with('error', 'Backup failed: ' . ($backup->error_message ?? 'Unknown error'));

        } catch (\Exception $e) {
            Log::error('Backup store failed', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────
    // GET /admin/backups/{backup}/download
    // ─────────────────────────────────────────────────────────────
    public function download(DataBackup $backup)
    {
        try {
            if (!$backup->canDownload()) {
                return back()->with('error', 'This backup is not available for download.');
            }

            $filePath = storage_path('app/' . $backup->file_path);

            if (!File::exists($filePath)) {
                Log::error('Backup file not found on disk', [
                    'backup_id' => $backup->id,
                    'file_path' => $filePath,
                ]);
                return back()->with('error', 'Backup file not found on disk.');
            }

            return response()->download(
                $filePath,
                $backup->backup_name . '.zip',
                [
                    'Content-Type'        => 'application/zip',
                    'Content-Disposition' => 'attachment; filename="' . $backup->backup_name . '.zip"',
                ]
            );

        } catch (\Exception $e) {
            Log::error('Backup download failed', [
                'backup_id' => $backup->id,
                'error'     => $e->getMessage(),
            ]);
            return back()->with('error', 'Failed to download backup: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────
    // DELETE /admin/backups/{backup}
    // ─────────────────────────────────────────────────────────────
    public function destroy(DataBackup $backup)
    {
        try {
            if (!$backup->canDelete()) {
                return back()->with('error', 'This backup cannot be deleted while it is processing.');
            }

            $this->backupService->deleteBackup($backup);

            return back()->with('success', 'Backup deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Backup delete failed', [
                'backup_id' => $backup->id,
                'error'     => $e->getMessage(),
            ]);
            return back()->with('error', 'Failed to delete backup: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────
    // POST /admin/backups/cleanup
    // ─────────────────────────────────────────────────────────────
    public function cleanup()
    {
        try {
            $deletedCount = $this->backupService->cleanExpiredBackups();

            return back()->with('success', "Cleaned up {$deletedCount} expired backup(s).");

        } catch (\Exception $e) {
            Log::error('Backup cleanup failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Cleanup failed: ' . $e->getMessage());
        }
    }

    // ─────────────────────────────────────────────────────────────
    // GET /admin/backups/{backup}/status   (JSON — AJAX polling)
    // ─────────────────────────────────────────────────────────────
    public function status(DataBackup $backup)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'            => $backup->id,
                'status'        => $backup->status,
                'progress'      => $backup->progress ?? 0,
                'error_message' => $backup->error_message,
                'file_size'     => $backup->file_size,
                'formatted_size'=> $backup->formatted_size,
                'completed_at'  => $backup->completed_at?->toIso8601String(),
                'can_download'  => $backup->canDownload(),
                'can_delete'    => $backup->canDelete(),
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // GET /admin/backups/statistics   (JSON — AJAX polling)
    // ─────────────────────────────────────────────────────────────
    public function statistics()
    {
        try {
            $totalSize = DataBackup::where('status', 'completed')->sum('file_size');

            $stats = [
                'total'      => DataBackup::count(),
                'completed'  => DataBackup::where('status', 'completed')->count(),
                'failed'     => DataBackup::where('status', 'failed')->count(),
                'processing' => DataBackup::where('status', 'processing')->count(),
                'pending'    => DataBackup::where('status', 'pending')->count(),
                'total_size' => $totalSize,
                'formatted_total_size' => $this->formatBytes($totalSize),
                'latest_backup' => DataBackup::where('status', 'completed')
                    ->latest('completed_at')
                    ->first(),
                'expired_count' => DataBackup::where('retention_until', '<=', now())->count(),
                'by_type' => [
                    'database' => DataBackup::where('backup_type', 'database')->count(),
                    'full'     => DataBackup::where('backup_type', 'full')->count(),
                ],
                'recent_backups' => DataBackup::latest()->limit(5)->get(),
            ];

            return response()->json(['success' => true, 'data' => $stats]);

        } catch (\Exception $e) {
            Log::error('Backup statistics failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics.',
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // GET /admin/backups/test-system   (JSON — system diagnostics)
    // ─────────────────────────────────────────────────────────────
    public function testBackup()
    {
        try {
            $results = [
                'timestamp' => now()->toDateTimeString(),
                'tests'     => [],
            ];

            // ── Test 1: Database connection ──
            try {
                $connection = config('database.default');
                $config     = config("database.connections.{$connection}");
                \DB::connection()->getPdo();

                $results['tests']['database_connection'] = [
                    'status'   => 'success',
                    'driver'   => $config['driver'],
                    'host'     => $config['host'] ?? 'N/A',
                    'database' => $config['database'],
                ];
            } catch (\Exception $e) {
                $results['tests']['database_connection'] = [
                    'status' => 'failed',
                    'error'  => $e->getMessage(),
                ];
            }

            // ── Test 2: Backup directory ──
            $backupDir = storage_path('app/backups');
            try {
                if (!File::exists($backupDir)) {
                    File::makeDirectory($backupDir, 0755, true);
                }

                $results['tests']['backup_directory'] = [
                    'status'     => 'success',
                    'path'       => $backupDir,
                    'exists'     => File::exists($backupDir),
                    'writable'   => is_writable($backupDir),
                    'free_space' => $this->formatBytes(disk_free_space($backupDir)),
                ];
            } catch (\Exception $e) {
                $results['tests']['backup_directory'] = [
                    'status' => 'failed',
                    'error'  => $e->getMessage(),
                ];
            }

            // ── Test 3: mysqldump availability ──
            $output     = [];
            $returnCode = null;
            exec('mysqldump --version 2>&1', $output, $returnCode);

            $results['tests']['mysqldump'] = [
                'status'      => $returnCode === 0 ? 'available' : 'not_available',
                'return_code' => $returnCode,
                'output'      => implode("\n", $output),
                'note'        => $returnCode !== 0 ? 'Will use PHP fallback method' : null,
            ];

            // ── Test 4: PHP extensions ──
            $results['tests']['php_extensions'] = [
                'zip'    => extension_loaded('zip')    ? 'installed' : 'missing',
                'pdo'    => extension_loaded('pdo')    ? 'installed' : 'missing',
                'mysqli' => extension_loaded('mysqli') ? 'installed' : 'missing',
            ];

            // ── Test 5: Queue configuration ──
            $queueDriver = config('queue.default');
            $results['tests']['queue_configuration'] = [
                'driver' => $queueDriver,
                'status' => $queueDriver === 'sync' ? 'synchronous' : 'asynchronous',
                'note'   => $queueDriver === 'sync'
                    ? 'Backups run immediately (no queue:work needed)'
                    : 'Backups run in background (requires queue:work)',
            ];

            // ── Overall status ──
            $criticalTests  = ['database_connection', 'backup_directory'];
            $criticalPassed = collect($results['tests'])
                ->filter(fn($t, $k) => in_array($k, $criticalTests))
                ->every(fn($t) => ($t['status'] ?? '') === 'success');

            $results['overall_status'] = $criticalPassed ? 'ready' : 'issues_found';
            $results['message']        = $criticalPassed
                ? 'All critical systems are ready for backup.'
                : 'Some critical issues were found. Please review before running a backup.';

            return response()->json($results);

        } catch (\Exception $e) {
            Log::error('Backup test failed', ['error' => $e->getMessage()]);

            return response()->json([
                'overall_status' => 'failed',
                'message'        => 'Diagnostics encountered an unexpected error.',
                'error'          => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // POST /admin/backups/quick-backup   (JSON — AJAX quick action)
    // ─────────────────────────────────────────────────────────────
    public function quickBackup()
    {
        try {
            $processing = DataBackup::where('status', 'processing')->exists();

            if ($processing) {
                return response()->json([
                    'success' => false,
                    'message' => 'A backup is already in progress. Please wait for it to finish.',
                ], 409);
            }

            $backup = $this->backupService->createDatabaseBackup(Auth::id(), 30);

            if ($backup->status === 'completed') {
                return response()->json([
                    'success' => true,
                    'message' => 'Quick backup completed successfully.',
                    'backup'  => [
                        'id'   => $backup->id,
                        'name' => $backup->backup_name,
                        'size' => $backup->formatted_size,
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . ($backup->error_message ?? 'Unknown error'),
            ], 500);

        } catch (\Exception $e) {
            Log::error('Quick backup failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to run quick backup: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────────────────────
    protected function getBackupStats(): array
    {
        $totalSize = DataBackup::where('status', 'completed')->sum('file_size');

        return [
            'total'                => DataBackup::count(),
            'completed'            => DataBackup::where('status', 'completed')->count(),
            'failed'               => DataBackup::where('status', 'failed')->count(),
            'processing'           => DataBackup::where('status', 'processing')->count(),
            'pending'              => DataBackup::where('status', 'pending')->count(),
            'total_size'           => $totalSize,
            'formatted_total_size' => $this->formatBytes($totalSize),
            'latest_backup'        => DataBackup::where('status', 'completed')
                ->latest('completed_at')
                ->first(),
        ];
    }

    private function formatBytes(int|float $bytes, int $precision = 2): string
    {
        if ($bytes <= 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i     = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}