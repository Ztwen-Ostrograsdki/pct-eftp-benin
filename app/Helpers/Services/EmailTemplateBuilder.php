<?php
namespace App\Helpers\Services;

use Illuminate\Support\Carbon;

class EmailTemplateBuilder
{
    public static function render(string $templateName, array $templates_data = []): string
    {
        $file = base_path("resources/maizzle/build_production/{$templateName}.html");

        if (!file_exists($file)) {

            throw new \Exception("Template introuvable : {$file}");
        }

        $html = file_get_contents($file);

        // Ajoute automatiquement le logo
        $logo = self::resolveLogoUrl();


        $date = self::resolveDate();

        $templates_data['logo_url'] = $logo;

        $templates_data['date'] = $date;

        $templates_data['app_full_name'] = env('APP_FULL_NAME');

        $templates_data['association'] = env('APP_NAME');

        // Remplace chaque variable {{ var }}
        foreach ($templates_data as $key => $value) {

            $html = str_replace("{{ {$key} }}", $value, $html);

        }

        return $html;
    }

    protected static function resolveLogoUrl(): string
    {
        $logoPath = public_path('images/logo.jpg');

        if (app()->environment('local')) {

            // Encode en base64 si en local
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);

            $data = file_get_contents($logoPath);

            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        // Sinon, URL publique
        return asset('images/logo.jpg');
    }

    protected static function resolveDate(): string
    {
        Carbon::setLocale('fr');
        
        return ucfirst(Carbon::now()->translatedFormat("F Y"));
    }
}


