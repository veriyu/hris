$php = "C:\laragon\bin\php\php-8.4.10-Win32-vs17-x64\php.exe"
& $php artisan make:filament-resource Company --panel=admin --generate --soft-deletes --view
& $php artisan make:filament-resource Outlet --panel=admin --generate --soft-deletes --view
& $php artisan make:filament-resource Department --panel=admin --generate --soft-deletes --view
& $php artisan make:filament-resource Position --panel=admin --generate --soft-deletes --view
