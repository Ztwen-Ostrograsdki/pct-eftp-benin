<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;

class SendWelcomeEmail extends Command
{
    protected $signature = 'mail:welcome {user_id}';
    
    protected $description = 'Envoie un e-mail de bienvenue avec Maizzle';

    public function handle()
    {
        $user = User::findOrFail($this->argument('user_id'));

        // Compile Maizzle
        $this->info('Compilation du template avec Maizzle...');
        $process = Process::fromShellCommandline('npm run build', base_path('resources/maizzle'));
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Erreur Maizzle : ' . $process->getErrorOutput());
            return;
        }

        // Récupérer le HTML
        $html = file_get_contents(resource_path('maizzle/build_production/transactional.html'));

        // Remplacer les variables
        $html = str_replace(['{{ name }}', '{{ url }}'], [$user->name, url('/')], $html);

        // Envoi du mail
        Mail::html($html, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Bienvenue chez nous !');
        });

        $this->info("E-mail envoyé à {$user->email}");
    }
}
