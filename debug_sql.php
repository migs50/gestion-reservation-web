<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    App\Models\DemandeCompte::create([
        'nom_complet'   => 'Test user',
        'email'         => 'test@example.com',
        'telephone'     => '12345678',
        'type_demande'  => 'Interne',
        'justification' => 'Test justification for the account request.',
        'password'      => 'password123',
        'statut'        => 'pending',
    ]);
    echo "SUCCESS: Record created.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
