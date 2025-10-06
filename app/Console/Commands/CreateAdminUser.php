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

        // Si pas de mot de passe fourni, en demander un
        if (!$password) {
            $password = $this->secret('Entrez le mot de passe pour l\'administrateur');
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