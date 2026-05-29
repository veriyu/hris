$php = "C:\laragon\bin\php\php-8.4.10-Win32-vs17-x64\php.exe"
& $php C:\laragon\bin\composer\composer.phar dump-autoload
& $php artisan filament:install --panels --force
& $php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
& $php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
& $php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"

New-Item -ItemType Directory -Force -Path app\Actions
New-Item -ItemType Directory -Force -Path app\Data
New-Item -ItemType Directory -Force -Path app\Enums
New-Item -ItemType Directory -Force -Path app\Services
New-Item -ItemType Directory -Force -Path app\Policies
