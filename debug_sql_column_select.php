<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = ['nom_complet', 'email', 'telephone', 'type_demande', 'justification', 'password', 'statut', 'created_at', 'updated_at'];

foreach ($columns as $column) {
    try {
        DB::table('demande_comptes')->select($column)->first();
        echo "YES: $column\n";
    } catch (\Exception $e) {
        echo "NO: $column - " . $e->getMessage() . "\n";
    }
}
