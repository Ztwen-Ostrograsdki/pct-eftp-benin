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
	<div style="width: 620px; height: 580px;" class="my-2 mx-auto p-2 shadow-3 bg-gray-100">
		<div class="border-2 border-red-600 p-1">
			<div class="border-2 border-green-600 p-1">
				<div class="border-2 border-yellow-600 p-1">
					<div class="text-center mx-auto my-4 px-3">
						<h6 class="letter-spacing-2 flex flex-col items-center gap-y-1">
							<div class="text-sky-400 flex w-full">
								<img src="{{asset(env('APP_LOGO'))}}" alt="" style="height: 60px; " class="border rounded-full float-right">
								<span class="flex flex-col font-bold mx-auto">
									<span class="uppercase text-orange-600">
										République du Bénin
									</span>
									<span class="text-gray-800 text-sm">
										Ministère de l'Enseignement Technique et de la Formation Professionnelle
									</span>
									<span class="mx-auto inline-block w-full mt-1">
										<span class="w-full flex mx-auto ">
											<span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
											<span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
											<span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
										</span>
									</span>
									<h4 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-blue-800 uppercase letter-spacing-1 fas fa-2x">
										Carte de membre
									</h4>  
									<small class="text-orange-400 h-6 letter-spacing-1">
										{{ env('APP_NAME') }}
									</small>
								</span>
								<img src="{{asset(env('APP_LOGO'))}}" style="height: 60px" alt="" class="rounded-full float-end border">
							</div>
						</h6>
						<hr class="text-gray-500 bg-gray-500 my-2 ">
					</div>
				
					<div style="width: 600px" class="grid grid-cols-6 gap-x-2 items-center ">
						<div class="col-span-3 text-right">
							<h1 class="text-gray-900 lg:text-3xl xl:text-3xl sm:text-base sm:font-semibold font-bold letter-spacing-1">
								{{ $reverse_name }}
							</h1>
							<h6 class="bg-blue-800 text-gray-200 font-bold letter-spacing-1 p-1">
								{{ $role }}
							</h6>
				
							<div class="flex flex-col text-start w-3/5 mx-auto text-gray-900 letter-spacing-1 font-semibold sm:text-xs">
								<h6>
									<span>
										<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
										<path d="M7.978 4a2.553 2.553 0 0 0-1.926.877C4.233 6.7 3.699 8.751 4.153 10.814c.44 1.995 1.778 3.893 3.456 5.572 1.68 1.679 3.577 3.018 5.57 3.459 2.062.456 4.115-.073 5.94-1.885a2.556 2.556 0 0 0 .001-3.861l-1.21-1.21a2.689 2.689 0 0 0-3.802 0l-.617.618a.806.806 0 0 1-1.14 0l-1.854-1.855a.807.807 0 0 1 0-1.14l.618-.62a2.692 2.692 0 0 0 0-3.803l-1.21-1.211A2.555 2.555 0 0 0 7.978 4Z"/>
										</svg>
									</span>
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
				
						<div class="col-span-3 flex flex-col gap-y-3 items-center mb-4">
							<img style="width: 200px" class="h-52 border-gray-950 border-2" src="{{ $photo }}" alt="Photo de profil de {{ $name }}"/>
				
							<h6 class="text-gray-800 letter-spacing-1 font-sans">
								Signature
							</h6>
						</div>
					</div>
				
					<div class="mx-auto w-full text-center my-2 mt-5">
						<span class="text-sm font-semibold letter-spacing-1">#Identifiant membre</span>
						<h1 class="text-gray-600 text-3xl font-bold letter-spacing-1">
							{{ $identifiant }}
						</h1>
					</div>
				
					<h6 class="text-yellow-500 letter-spacing-1 font-sans text-xs text-right px-4">
						
						Cette carte expirera le 22 Janv 2026
					</h6>
				</div>
			</div>
		</div>
	</div>
	
	
</body>
</html>