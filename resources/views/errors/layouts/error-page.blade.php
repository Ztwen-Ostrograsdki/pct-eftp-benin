<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur {{ $code }} – {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-indigo-900 via-slate-900 to-black min-h-screen flex items-center justify-center text-white p-6">
    <div class="max-w-xl text-center space-y-6">
        <img src="{{ $image }}" alt="Erreur {{ $code }}" class="w-32 mx-auto float">
        <h1 class="text-6xl font-bold text-pink-400">{{ $code }}</h1>
        <h2 class="text-2xl md:text-3xl font-semibold">{{ $title }}</h2>
        <p class="text-lg md:text-xl text-gray-300">
            {{ $message }}
        </p>
        <a href="{{ url('/') }}"
           class="inline-block mt-4 px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-xl shadow-lg transition duration-300">
            Retour à l’accueil
        </a>
    </div>
	<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
