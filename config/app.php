<?php

return [


    'marital_statuses' => [

        'Marié' => "Marié",
        'Divorcé' => "Divorcé",
        'Célibataire' => "Célibataire",
        'Fiancé' => "Fiancé",
        'Autre' => "Autre",

    ],


    'genders' => [
        'Féminin' => "Féminin",
        'Masculin' => "Masculin",
        'Autre' => "Autre",
    ],

    'teachers_statuses' => [
        'ACDPE' => 'ACDPE', 
        'ACE' => 'ACE', 
        'APE' => 'APE', 
        'AME' => 'AME'
    ],

    'teachers_graduates' => [
        'BTS' => 'BTS', 
        'DUES-1' => 'DUES-1', 
        'DUES-2' => 'DUES-2', 
        'LICENCE' => 'LICENCE', 
        'MAITRISE' => 'MAITRISE', 
        'MASTER' => 'MASTER', 
        'DOCTORAT' => 'DOCTORAT', 
        'AUTRE' => 'AUTRE', 
    ],

    'teachers_graduate_type' => [
        'Académique' => 'Académique', 
        'Professionnel' => 'Professionnel', 
        'Autre' => 'Autre', 
    ],
    
    'notifications_sections' => [
        null => "Récentes non lues",
        'unread' => "Non lues",
        'read' => "Déjà lues",
        'hidden' => "Masquées",
    ],

    'filiars' => [
        'FC' => ['name' => 'FC', 'description' => 'Froid et Climatisation', 'option' => 'Industrielle'], 
        'MA' => ['name' => 'MA', 'description' => 'Mécanique et Auto', 'option' => 'Industrielle'],
        'OBB' => ['name' => 'OBB', 'description' => 'OBB', 'option' => 'Industrielle'],
        'OG' => ['name' => 'OG', 'description' => 'Opérateur Géomètre', 'option' => 'Industrielle'],
        'FM' => ['name' => 'FM', 'description' => 'Fabrication Mécanique', 'option' => 'Industrielle'],
        'BTP' => ['name' => 'BTP', 'description' => 'Batiment et Travaux Publics', 'option' => 'Industrielle'],
        'F1' => ['name' => 'F1', 'description' => 'Mécanique Générale', 'option' => 'Technique'],
        'F2' => ['name' => 'F2', 'description' => 'Electronique', 'option' => 'Technique'],
        'F3' => ['name' => 'F3', 'description' => 'Mécanique Générale', 'option' => 'Technique'],
        'F4' => ['name' => 'F4', 'description' => 'Génie Civil', 'option' => 'Technique'],
        'IMI' => ['name' => 'IMI', 'description' => 'Installation et Maintenance Industrielle', 'option' => 'Informatique'],
        'HR' => ['name' => 'HR', 'description' => 'Hotellerie et Restauration', 'option' => null],
    ],

    'filiars_options_defaults' => [
        'FC' => 'Industrielle', 
        'MA' => 'Industrielle',
        'OBB' => 'Industrielle',
        'OG' => 'Industrielle',
        'FM' => 'Industrielle',
        'BTP' => 'Industrielle',
        'F1' => 'Technique',
        'F2' => 'Technique',
        'F3' => 'Technique',
        'F4' => 'Technique',
        'IMI' => 'Informatique',
        'HR' => null,
    ],

    'filiars_options' => [
        'Industrielle' => 'Industrielle', 
        'Technique' => 'Technique',
        'Informatique' => 'Informatique',
        'Comptabilité' => 'Comptabilité',
        'Commerce' => 'Commerce',
        'Secrétariat' => 'Secrétariat',
        'Hotellerie' => 'Hotellerie',
        'Restauration' => 'Restauration',
        'Gestion' => 'Gestion',
        'Banque et Finance' => 'Banque et Finance',
    ],

    'payments_status' => [
        'pending' => "En attente",
        'approved' => "Payé",
        'failed' => "Echec payement",
        'cancel' => "Payement annulé",
    ],

    'payments_methods' => [
        'stripe' => 'Stripe',
        'momo_mtn' => 'MTN MOMO',
        'moov_money' => 'MOOV MONEY',
        'celtiis_cash' => 'Celtiis Cash',
    ],

    'shipping_methods' => [
        'fedex' => "FedEx",
        'ups' => "UPS",
        'dhl' => "DHL",
        'usps' => "USPS",
        'gozem' => "GoZem",
        'other' => "Autre",
    ],

    'currencies' => [
        'inr' => "INR",
        'usd' => "USD",
        'cfa' => "CFA",
        'eur' => "EUR"
    ],

    'order_status' => [
        'new' => "Nouvelle demande",
        'processing' => "En cours de traitement",
        'procecced' => "Traité",
        'shipped' => "Expédié",
        'delivered' => "Livrée",
        'canceled' => "Annulée",
        'pending' => "En attente",
        'approved' => "Approuvée"
    ],






    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'fr'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'fr'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
