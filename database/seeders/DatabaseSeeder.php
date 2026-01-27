<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Categorie;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        $roles = [
            'Admin' => 'Administrateur du système',
            'Responsable Technique' => 'Responsable technique de ressources',
            'Utilisateur' => 'Utilisateur interne (Ingénieur/Enseignant/Doctorant)',
            'Invite' => 'Visiteur invité'
        ];

        $createdRoles = [];
        foreach ($roles as $nom => $description) {
            $createdRoles[$nom] = Role::firstOrCreate(['nom' => $nom]);
        }

        // Create a test admin user
        User::firstOrCreate(
            ['email' => 'admin@datacenter.ma'],
            [
                'role_id' => $createdRoles['Admin']->id,
                'nom' => 'Admin',
                'prenom' => 'Super',
                'password' => Hash::make('password123'),
                'statut' => 'active',
                'secret_question' => 'Nom de votre premier animal ?',
                'secret_answer' => 'Rex'
            ]
        );

        // Create a test internal user
        User::firstOrCreate(
            ['email' => 'user@datacenter.ma'],
            [
                'role_id' => $createdRoles['Utilisateur']->id,
                'nom' => 'Utilisateur',
                'prenom' => 'Test',
                'password' => Hash::make('password123'),
                'statut' => 'active',
                'secret_question' => 'Nom de votre premier animal ?',
                'secret_answer' => 'Rex'
            ]
        );

        // Create a test responsable
        User::firstOrCreate(
            ['email' => 'manager@datacenter.ma'],
            [
                'role_id' => $createdRoles['Responsable Technique']->id,
                'nom' => 'Manager',
                'prenom' => 'Test',
                'password' => Hash::make('password123'),
                'statut' => 'active',
                'secret_question' => 'Nom de votre premier animal ?',
                'secret_answer' => 'Rex'
            ]
        );
        // Create default categories for ressources
        $categories = [
            'Serveurs',
            'Machines virtuelles',
            'Stockage',
            'Équipements réseau',
            'Énergie',
            'Sauvegardes',
        ];

        foreach ($categories as $catNom) {
            Categorie::firstOrCreate(['nom' => $catNom]);
        }


        $this->command->info('Database seeded successfully!');
        $this->command->info('Test users created:');
        $this->command->info('  Admin: admin@datacenter.ma / password123');
        $this->command->info('  User: user@datacenter.ma / password123');
        $this->command->info('  Manager: manager@datacenter.ma / password123');
    }
}
