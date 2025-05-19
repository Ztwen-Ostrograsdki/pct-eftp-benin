<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carte de membre prête</title>
    <!-- Inclure Tailwind via CDN pour les emails -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <!-- En-tête -->
        <header class="mb-4 border-b border-gray-200 pb-2">
            <h1 class="text-2xl font-bold text-gray-800">

                @php
                    $salutation = __greatingMessager(auth()->user()->getUserNamePrefix(true, false));

                @endphp
                {{ $salutation }}
            </h1>
        </header>
       
        <!-- Corps du message -->
        <section class="mb-4 text-gray-700">
            <ul class="list-disc list-inside ml-4 mb-4">
                <li>#Identifiant: {{ $user->identifiant }}</li>
                <li>Email: {{ $user->email }}</li>
                <!-- Ajoutez d'autres détails -->
            </ul>
            <p class="mb-2">
                Votre carte de membre est prête!
            </p>
        </section>
       
        <!-- Bouton d'action -->
       
        <!-- Pied de page -->
        <footer class="mt-6 border-t border-gray-200 pt-4 text-gray-500 text-sm text-center">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </footer>
    </div>
</body>
</html>
