<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$count = User::count();
echo "Users count: {$count}\n";

$admin = User::where('email', env('ADMIN_EMAIL', 'admin@example.com'))->first();
if ($admin) {
    echo "Admin exists: {$admin->email}, role={$admin->role}\n";
} else {
    echo "Admin not found\n";
}

$test = User::where('email', 'test@example.com')->first();
if ($test) {
    echo "Test user exists: {$test->email}, role={$test->role}\n";
}

