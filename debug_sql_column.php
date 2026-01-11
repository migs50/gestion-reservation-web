<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    App\Models\DemandeCompte::create(['email' => 'test' . rand() . '@example.com']);
} catch (\Exception $e) {
    if (preg_match("/Unknown column '(.+?)'/", $e->getMessage(), $matches)) {
        echo "MISSING_COLUMN: " . $matches[1] . "\n";
    } else {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}
