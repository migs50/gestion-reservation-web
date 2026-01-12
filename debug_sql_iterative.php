<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$fields = [
    'nom_complet'   => 'Test user',
    'email'         => 'test' . rand() . '@example.com',
    'telephone'     => '12345678',
    'type_demande'  => 'Interne',
    'justification' => 'Test justification.',
    'password'      => 'password123',
    'statut'        => 'pending',
];

foreach ($fields as $key => $value) {
    try {
        App\Models\DemandeCompte::create([$key => $value]);
        echo "OK: $key\n";
    } catch (\Exception $e) {
        echo "FAIL: $key - " . $e->getMessage() . "\n";
    }
}
