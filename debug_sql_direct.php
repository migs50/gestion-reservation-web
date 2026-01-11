<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    DB::table('demande_comptes')->insert([
        'nom_complet'   => 'Test direct',
        'email'         => 'test_direct' . rand() . '@example.com',
        'telephone'     => '123',
        'type_demande'  => 'Interne',
        'justification' => 'Test direct justification.',
        'password'      => 'secret',
        'statut'        => 'pending',
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);
    echo "SUCCESS: Direct DB insert worked.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
