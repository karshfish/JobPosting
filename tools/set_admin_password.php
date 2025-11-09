<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = env('ADMIN_EMAIL', 'admin@example.com');
$password = env('ADMIN_PASSWORD', 'password');

$updated = User::where('email', $email)->update(['password' => Hash::make($password)]);
echo $updated ? "Updated password for {$email}\n" : "Admin user not found: {$email}\n";
