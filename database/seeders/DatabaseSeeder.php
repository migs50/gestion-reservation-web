<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

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
            'Responsable' => 'Responsable technique de ressources',
            'Interne' => 'Utilisateur interne (Ingénieur/Enseignant/Doctorant)',
            'Invite' => 'Visiteur invité'
        ];

        $createdRoles = [];
        foreach ($roles as $nom => $description) {
            $createdRoles[$nom] = Role::firstOrCreate(['nom' => $nom]);
        }

        // Create Permissions
        $permissions = [
            // User management
            'manage_users' => 'Gérer les utilisateurs',
            'manage_roles' => 'Gérer les rôles et permissions',
            'approve_accounts' => 'Approuver les demandes de comptes',
            
            // Resource management
            'manage_resources' => 'Gérer toutes les ressources',
            'manage_own_resources' => 'Gérer ses propres ressources',
            'view_resources' => 'Voir les ressources',
            
            // Reservation management
            'create_reservation' => 'Créer une réservation',
            'approve_reservation' => 'Approuver/Refuser les réservations',
            'view_own_reservations' => 'Voir ses propres réservations',
            'view_all_reservations' => 'Voir toutes les réservations',
            
            // Statistics & Reports
            'view_statistics' => 'Voir les statistiques globales',
            'view_logs' => 'Voir les journaux d\'activité',
            
            // Moderation
            'moderate_discussions' => 'Modérer les discussions',
            
            // Incidents
            'manage_incidents' => 'Gérer les incidents',
            'report_incident' => 'Signaler un incident',
        ];

        $createdPermissions = [];
        foreach ($permissions as $nom => $description) {
            $createdPermissions[$nom] = Permission::firstOrCreate(['nom' => $nom]);
        }

        // Assign permissions to roles
        
        // Admin: All permissions
        if ($createdRoles['Admin']->permissions()->count() === 0) {
            $createdRoles['Admin']->permissions()->attach(collect($createdPermissions)->pluck('id')->toArray());
        }

        // Responsable: Resource & reservation management
        if ($createdRoles['Responsable']->permissions()->count() === 0) {
            $createdRoles['Responsable']->permissions()->attach([
                $createdPermissions['manage_own_resources']->id,
                $createdPermissions['view_resources']->id,
                $createdPermissions['create_reservation']->id,
                $createdPermissions['approve_reservation']->id,
                $createdPermissions['view_all_reservations']->id,
                $createdPermissions['moderate_discussions']->id,
                $createdPermissions['manage_incidents']->id,
                $createdPermissions['report_incident']->id,
            ]);
        }

        // Interne: Basic user permissions
        if ($createdRoles['Interne']->permissions()->count() === 0) {
            $createdRoles['Interne']->permissions()->attach([
                $createdPermissions['view_resources']->id,
                $createdPermissions['create_reservation']->id,
                $createdPermissions['view_own_reservations']->id,
                $createdPermissions['report_incident']->id,
            ]);
        }

        // Invite: Read-only access
        if ($createdRoles['Invite']->permissions()->count() === 0) {
            $createdRoles['Invite']->permissions()->attach([
                $createdPermissions['view_resources']->id,
            ]);
        }

        // Create a test admin user
        User::firstOrCreate(
            ['email' => 'admin@datacenter.ma'],
            [
                'role_id' => $createdRoles['Admin']->id,
                'nom' => 'Admin',
                'prenom' => 'Super',
                'password' => Hash::make('password123'),
                'statut' => 'active'
            ]
        );

        // Create a test internal user
        User::firstOrCreate(
            ['email' => 'user@datacenter.ma'],
            [
                'role_id' => $createdRoles['Interne']->id,
                'nom' => 'Utilisateur',
                'prenom' => 'Test',
                'password' => Hash::make('password123'),
                'statut' => 'active'
            ]
        );

        // Create a test responsable
        User::firstOrCreate(
            ['email' => 'manager@datacenter.ma'],
            [
                'role_id' => $createdRoles['Responsable']->id,
                'nom' => 'Manager',
                'prenom' => 'Test',
                'password' => Hash::make('password123'),
                'statut' => 'active'
            ]
        );

        $this->command->info('Database seeded successfully!');
        $this->command->info('Test users created:');
        $this->command->info('  Admin: admin@datacenter.ma / password123');
        $this->command->info('  User: user@datacenter.ma / password123');
        $this->command->info('  Manager: manager@datacenter.ma / password123');
    }
}
