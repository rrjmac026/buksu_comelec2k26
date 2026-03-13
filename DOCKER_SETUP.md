# Docker Setup for COMELEC 2K26

## Quick Start

### Build and Run with Docker Compose

```bash
# Build the image
docker-compose build

# Start the application
docker-compose up -d

# Access the application
# Navigate to http://localhost
```

### Manual Build and Run

```bash
# Build the image
docker build -t comelec2k26 .

# Run the container
docker run -d \
  -p 80:80 \
  --name comelec2k26_app \
  -v $(pwd):/app \
  comelec2k26
```

## Prerequisites

- Docker and Docker Compose installed
- `.env` file configured (copy from `.env.example` if needed)
- `composer.lock` and `package-lock.json` for dependency consistency

## Container Details

### Image Specifications
- **Base Image**: PHP 8.2 Alpine (multi-stage build)
- **Web Server**: Nginx
- **Application Server**: PHP-FPM
- **Process Manager**: Supervisor
- **Database**: SQLite (built-in support)
- **Node.js**: Included for asset building

### Exposed Ports
- **Port 80**: HTTP

### Volumes
- `/app` - Application root
- `/app/storage` - Storage files
- `/app/bootstrap/cache` - Bootstrap cache

## Environment Variables

Key environment variables that can be set:

```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
APP_KEY=<your-app-key>
```

If not set via `.env`, you can pass them to the container:

```bash
docker run -e APP_ENV=production -e APP_DEBUG=false ...
```

## Running Artisan Commands

### Using Docker Compose
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan seed
docker-compose exec app php artisan tinker
```

### Using Docker Run
```bash
docker exec comelec2k26_app php artisan <command>
```

## Development vs Production

### For Development:
```bash
# Use docker-compose with volumes mounted
docker-compose up

# Run with development environment
docker-compose exec app php artisan migrate:fresh --seed
```

### For Production:
- Change `APP_ENV=production` in environment
- Set `APP_DEBUG=false`
- Ensure all dependencies are locked (`composer.lock`, `package-lock.json`)
- Use named volumes instead of bind mounts for storage

## Building Assets

Assets are built automatically during container build. To rebuild:

```bash
docker-compose exec app npm run build
```

## Logs

### Nginx logs
```bash
docker-compose exec app tail -f /var/log/nginx/error.log
```

### Laravel logs
```bash
docker-compose exec app tail -f storage/logs/laravel.log
```

### All supervisor logs
```bash
docker logs comelec2k26_app
```

## Database Setup

For SQLite:
```bash
# The database is stored at database/database.sqlite
docker-compose exec app php artisan migrate
```

## Troubleshooting

### Container won't start
```bash
docker-compose logs app
```

### Permission denied errors
```bash
docker-compose exec app chown -R www-data:www-data /app/storage
```

### Clear cache
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Rebuild without cache
```bash
docker-compose build --no-cache
```

## Stopping and Removing

```bash
# Stop container
docker-compose down

# Remove images
docker-compose down --rmi all

# Remove volumes (cleanup everything)
docker-compose down -v
```

## Performance Optimization

For production deployments:

1. Use a proper database (MySQL, PostgreSQL) instead of SQLite
2. Use proper volume drivers instead of bind mounts
3. Set up proper resource limits in docker-compose
4. Use a reverse proxy (Traefik, nginx) in front of the container
5. Configure caching headers and CDN for static assets

## Additional Resources

- [Laravel Docker Documentation](https://laravel.com/docs/deployment#docker)
- [PHP Docker Official Images](https://hub.docker.com/_/php)
- [Nginx Configuration](https://nginx.org/en/docs/)
