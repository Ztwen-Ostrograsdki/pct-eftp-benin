<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="{{ mix('resources/css/app.css') }}" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Carte de membre de {{ $reverse_name }} </title>

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
	<div style="width: 620px; height: 550px;" class="my-2 mx-auto p-2 shadow-3 bg-gray-100">
		<div class="border-2 border-green-600 p-1">
			<div class="border-2 border-yellow-300 p-1">
				<div class="border-2 border-red-600 p-1">
					<div class="text-center mx-auto mt-2 px-3">
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
									<small class="text-gray-900 h-6 letter-spacing-1">
										{{ env('APP_NAME') }}
									</small>
								</span>
								<img src="{{asset(env('APP_LOGO'))}}" style="height: 60px" alt="" class="rounded-full float-end border">
							</div>
						</h6>
						<hr class="text-gray-500 bg-gray-500 my-2 ">
					</div>
				
					<div style="width: 600px" class="grid grid-cols-7 gap-x-2 items-center ">
						<div class="col-span-4 text-right">
							<h1 class="text-gray-900 lg:text-3xl xl:text-3xl sm:text-base sm:font-semibold font-bold letter-spacing-1">
								{{ $reverse_name }}
							</h1>
							<h6 class="bg-blue-800 text-gray-200 font-bold letter-spacing-1 p-1 font-mono">
								{{ $role }}
							</h6>
				
							<div class="flex flex-col text-start w-3/5 mx-auto text-gray-900 letter-spacing-1 font-semibold sm:text-xs">
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
				
						<div class="col-span-3 flex flex-col gap-y-3 items-center mb-4">
							<h6 class="font-semibold letter-spacing-1">
								N° {{ $card_number ? $card_number : 'Numero de la carte' }}
							</h6>
							<img style="width: 150px; height: 150px;" class=" border-gray-950 border-2" src="{{ $photo }}" alt="Photo de profil de {{ $name }}"/>
				
							<h6 class="text-gray-800 letter-spacing-1 font-mono">
								Signature
							</h6>
						</div>
					</div>
				
					<div class="mx-auto w-full text-center mt-3 flex items-center justify-between">
						<span style="" class="ml-4">
							{{ $qrcode ? $qrcode : 'QR code' }}
						</span>
						<div class="mr-20">
							<h6 class="text-sm font-mono">
								Notre mission, faire de l'Enseignement technique au Benin, Un socle pour un développement garanti et durable!
							</h6>
						</div>
						<span></span>
					</div>
				
					<h6 class="text-purple-500 letter-spacing-1 font-sans text-xs text-right font-semibold px-4">
						Expire {{ $expired_at ? __formatDate($expired_at) : "Date d'expiration de la carte (1an)" }}
					</h6>
				</div>
			</div>
		</div>
	</div>
	
	
</body>
</html>