<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="{{ mix('resources/css/app.css') }}" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<title>Document</title>

	<style>
		.bg-hover-secondary {
		background-color: #334 !important;
		color: #bbb !important;
		}

		.z-bg-secondary-dark {
		background-color: #334 !important;
		}

		.bg-secondary-dark {
		background-color: #334 !important;
		}

		.z-bg-secondary-light-opac {
		background-color: rgba(10, 10, 40, 0.87) !important;
		}

		.z-bg-secondary-light {
		background-color: rgba(10, 10, 40, 0.97) !important;
		}

		.bg-secondary-light {
		background-color: rgba(10, 10, 50, 0.97) !important;
		}

		.bg-secondary-light-opac {
		background-color: rgba(10, 10, 40, 0.87) !important;
		}

		.bg-choosen-marks {
		background-color: rgba(10, 53, 30, 0.87) !important;
		}


		.bg-secondary-light-0 {
		background-color: rgba(30, 15, 45, 0.87) !important;
		}


		.bg-secondary-light-2 {
		background-color: rgba(9, 15, 20, 0.9) !important;
		}


		.bg-secondary-light-3 {
		background-color: rgba(12, 20, 45, 0.91) !important;
		}

		.bg-secondary-light-1 {
		background-color: rgba(12, 15, 30, 0.92) !important;
		}
	</style>
</head>

<body>

	<div style="width: 620px; height: 580px;" class="my-2 mx-auto py-3 px-0 border border-gray-500 rounded-md shadow-3 z-bg-secondary-light">

		<div  class="text-center mx-auto my-4 px-3">
			<h6 class="letter-spacing-2 flex flex-col items-center gap-y-1">
				<div class="text-sky-400 flex w-full">
					<img src="{{asset(env('APP_LOGO'))}}" alt="" style="height: 40px; " class=" shadow-3 shadow-sky-500 rounded-full float-right">
					<span class="flex flex-col font-bold mx-auto">
						<span class="uppercase text-orange-600">
							République du Bénin
						</span>
						<span class="text-yellow-400 text-sm">
							Ministère de l'Enseignement Technique et de la Formation Professionnelle
						</span>
						<span class="mx-auto inline-block w-full mt-1">
							<span class="w-full flex mx-auto ">
								<span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
								<span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
								<span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
							</span>
						</span>
						<span>
							Carte de membre
						</span>  
						<small class="text-orange-400 letter-spacing-1">
							{{ env('APP_NAME') }}
						</small>
					</span>
					<img src="{{asset(env('APP_LOGO'))}}" style="height: 40px" alt="" class="shadow-3 shadow-sky-500 rounded-full float-end">
				</div>
			</h6>
			<hr class="text-gray-500 bg-gray-500 my-2 ">
		</div>
	
		<div style="width: 620px" class="grid grid-cols-5 gap-x-2 items-center ">
			<div class="col-span-3 text-right">
				<h1 class="text-sky-400 lg:text-3xl xl:text-3xl sm:text-base sm:font-semibold font-bold letter-spacing-1">
					{{ $reverse_name }}
				</h1>
				<h6 class="bg-blue-800 text-gray-400 font-bold letter-spacing-1 p-1">
					{{ $role }}
				</h6>
	
				<div class="flex flex-col text-start w-3/5 mx-auto text-sky-400 letter-spacing-1 font-semibold sm:text-xs">
					<h6>
						<span class="fas fa-phone"></span>
						<span>
							{{ $contacts }}
						</span>
					</h6>
	
					<h6>
						<span class="fas fa-envelope"></span>
						<span>
							{{ $email }}
						</span>
					</h6>
	
					<h6>
						<span class="fas fa-home"></span>
						<span>
							{{ $address }}
						</span>
					</h6>
					
					<h6>
						<span class="fab fa-codepen"></span>
						<span>
							{{ $identifiant }}
						</span>
					</h6>
				</div>
			</div>
	
			<div class="col-span-2 mr-3 flex flex-col gap-y-3 items-center mb-4">
				<img class="w-60 h-52 mx-auto border shadow-lg" src="{{ $photo }}" alt="Photo de profil de {{ $name }}"/>
	
				<h6 class="text-gray-500 letter-spacing-1 font-sans">
					Signature
				</h6>
			</div>
		</div>
	
		<div class="mx-auto w-full text-center my-7">
			<h1 class="text-sky-400 text-3xl font-bold letter-spacing-1">
				{{ $identifiant }}
			</h1>
		</div>
	
		<h6 class="text-yellow-500 letter-spacing-1 font-sans text-xs text-right px-4">
			Cette carte expirera le 22 Janv 2026
		</h6>
	</div>
	
	
</body>
</html>