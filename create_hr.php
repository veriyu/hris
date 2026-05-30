<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::firstOrCreate(
    ['email' => 'hrd@hrms.com'], 
    ['name' => 'HR Manager', 'password' => bcrypt('password')]
);
$user->assignRole('HR');
echo "HR created";
