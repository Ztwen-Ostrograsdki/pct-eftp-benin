<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="{{ mix('resources/css/app.css') }}" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<title>{{ $document_title }}</title>
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

		tr{
			border: thin solid black;
		}

		tr:nth-child(odd) {
			background: #bfe1e1;
			
		}

		tr:nth-child(even) {
		background: #a3b5ea;
		}
		
		tr.tr-head{
			background: #1681b3;
		}

		table {
			border-collapse: collapse;
		}

		th, td{
			border: thin solid black !important;
		}
	</style>
</head>
<body class="">
	<div class="text-center mx-auto mt-2 px-3 border-2 border-gray-900 p-3">
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
					<h4 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-gray-900 my-0 uppercase letter-spacing-1 fas fa-2x">
						Fiche de cotisation de l'année {{ $the_year }} de {{ $name }}
					</h4>  
					<small class="text-orange-400 h-6 letter-spacing-1">
						{{ env('APP_NAME') }}
					</small>
				</span>
				<img src="{{asset(env('APP_LOGO'))}}" style="height: 60px" alt="" class="rounded-full float-end border">
			</div>
		</h6>
	</div>
	<div class="overflow-x-auto my-2 p-1 shadow border-2 border-gray-800 bg-gray-300">
    @if (count($months) > 0)
    <table class="min-w-full divide-y divide-gray-200 m-0 text-sm border-gray-800">
      <thead class="bg-sky-400 text-gray-900 font-semibold">
        <tr class="tr-head">
          <th class="px-3 py-3 text-center">Mois</th>
          <th class="px-3 py-3 text-left">Description</th>
          <th class="px-3 py-3 text-left">Montant Payé (FCFA)</th>
          <th class="px-3 py-3 text-left">Cotisation de </th>
          <th class="px-3 py-3 text-left">Date de payement</th>
          <th class="px-3 py-3 text-center">Observations / Visa</th>
        </tr>
      </thead>
      <tbody class="" id="payments-tbody">
        
            @foreach ($months as $mk => $month)

              <tr class="border border-gray-800" wire:key='list-des-cotisations-mensuelles-{{$member->id}}-{{$mk}}'>
                  @php

                    $cotisation = getMemberCotisationOfMonthYear($member->id, $month, $the_year);

                  @endphp
                    <td class="px-3 py-2 text-gray-800 font-medium">{{ $month }}</td>
                    <td class="px-3 py-2 text-gray-800">
                        @if($cotisation)

                          {{ $cotisation->description ? $cotisation->description : 'Non précisée' }}

                        @else

                          Non payé

                        @endif
                    </td>
                    <td class="px-3 py-2 text-gray-900 font-semibold">

                        @if($cotisation)

                          {{ __moneyFormat($cotisation->amount) }} FCFA

                        @else

                          
                          
                        @endif
                    </td>
                    <td class="px-3 py-2 text-gray-900">

                      {{ $month }} {{ $the_year }}
                      
                    </td>
                    <td class="px-3 py-2 text-gray-900">
                      @if($cotisation)
                        {{ __formatDate($cotisation->payment_date) }}
                      @else
                        
                      @endif
                    </td>
                    <td class="px-3 py-2 text-center">
                        
                    </td>
                </tr>
            @endforeach
        <!-- Lignes dynamiques -->
      </tbody>
    </table>
    
	<div class="text-gray-950 w-full">
		<h4 class="w-full font-semibold uppercase text-lg text-center items-center py-2 mt-2 flex justify-center gap-x-9">
			<span>
				Montant total enregistré: 
			</span>
			<span>
				{{ __moneyFormat($total_amount) }} FCFA
			</span>
		</h4>
	</div>
    @else
        <div class="w-full text-center py-2 border-none bg-red-300 text-red-600 text-base">
            <span class="fas fa-trash"></span>
            <span>Oupps aucune données trouvées!!!</span>
        </div>
    @endif
</div>

</body>
</html>