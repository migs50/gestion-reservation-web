<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    App\Models\DemandeCompte::create([
        'nom_complet'   => 'Test',
        'email'         => 'test' . rand() . '@example.com',
        'telephone'     => '123',
        'type_demande'  => 'Interne',
        'justification' => 'Test test test test test test test test test test test test',
        'password'      => 'password',
        'statut'        => 'pending',
    ]);
} catch (\Exception $e) {
    echo "FULL_ERROR: " . $e->getMessage() . "\n";
}
