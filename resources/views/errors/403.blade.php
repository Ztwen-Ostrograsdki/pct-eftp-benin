@if((request()->query('expires') || request()->query('signature')))
	@include('errors.419')
@else
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>
		Erreur 403 - Accès interdit
	</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
	<style>
		.letter-spacing-3{
		letter-spacing: 3px;
		}
		.letter-spacing-2{
		letter-spacing: 2px;
		}

		.letter-spacing-1{
		letter-spacing: 1px;
		}

		.letter-spacing-0{
		letter-spacing: 0.5px;
		}
	</style>
</head>
<body class="">
    <section class="bg-white dark:bg-gray-900 letter-spacing-1">
		<div class="py-10 px-4 mx-auto max-w-screen-xl h-screen flex flex-col items-center justify-center">
			<div class="mx-auto max-w-screen-sm text-center">
				<h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-orange-600">403</h1>
				<p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white letter-spacing-1">
					Vous décrivez quel type de mouvement là?
				</p>
				<p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">
					Revenez lorsque vous serez animé d'un mouvement rectiligne uniformément varié!
				</p>
				
			</div> 
			<a href="/" class="text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-semibold rounded-lg text-lg px-5 py-2.5 text-center my-4 flex flex-col">
				<span class="">Repartons au labo</span> 
				<span class="text-7xl">🧪🧪🧪</span> 
			</a>
			<h6 class="text-red-500 font-semibold text-2xl uppercase">Bref, Désolé mais, vous n'êtes pas authorisé à accéder à cette page ou à effectuer une telle action!</h6>
		</div>

	</section>
	<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
@endif