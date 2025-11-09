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

// List all admin users
$admins = User::where('role', 'admin')->get(['id','name','email']);
if ($admins->count()) {
    echo "Admins (role=admin):\n";
    foreach ($admins as $u) {
        echo " - {$u->id}: {$u->email} ({$u->name})\n";
    }
} else {
    echo "No users with role=admin found.\n";
}
