<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = ['user_id', 'type', 'titre', 'contenu', 'lien', 'lu'];

foreach ($columns as $column) {
    try {
        DB::table('notifications')->select($column)->first();
        echo "YES: $column\n";
    } catch (\Exception $e) {
        echo "NO: $column - " . $e->getMessage() . "\n";
    }
}
