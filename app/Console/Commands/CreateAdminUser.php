<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {--name=Admin : The name of the admin user}
                            {--email=admin@museum.sn : The email of the admin user}
                            {--password= : The password for the admin user}';

    protected $description = 'Create an admin user for the museum';

    public function handle()
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');

        // Si pas de mot de passe fourni, générer un mot de passe sécurisé
        if (!$password) {
            // En environnement interactif, demander le mot de passe
            if ($this->input->isInteractive()) {
                $password = $this->secret('Entrez le mot de passe pour l\'administrateur');
            } else {
                // En environnement non-interactif (Laravel Cloud), générer un mot de passe
                $password = 'Admin@' . date('Y') . rand(1000, 9999);
                $this->warn("Mot de passe généré automatiquement: {$password}");
            }
        }

        // Vérifier si l'utilisateur existe déjà
        if (User::where('email', $email)->exists()) {
            $this->error("Un utilisateur avec l'email {$email} existe déjà.");
            return 1;
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("Utilisateur administrateur créé avec succès:");
        $this->line("Nom: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->warn("Conservez précieusement ces informations de connexion.");

        return 0;
    }
}