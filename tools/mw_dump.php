<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$router = $app->make(Illuminate\Routing\Router::class);
echo "Middleware groups:\n";
foreach ($router->getMiddlewareGroups() as $name => $stack) {
    echo "- $name:\n";
    foreach ($stack as $mw) {
        echo "  * $mw\n";
    }
}

