<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$cats = Category::orderBy('name')->get(['id','name','slug']);
echo "Categories (".$cats->count()."):\n";
foreach ($cats as $c) {
    echo " - {$c->id}: {$c->name} ({$c->slug})\n";
}

