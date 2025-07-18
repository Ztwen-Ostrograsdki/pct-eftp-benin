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
						{{ $document_title }}
					</h4>  
					<h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-gray-800 fas fa-2x letter-spacing-1 flex flex-col">
						<span>{{ env('APP_NAME') }}</span>
                        <span class="text-xs font-mono letter-spacing-1">
                            {{ getAppFullName() }}
                        </span>
					</h3>
				</span>
				<img src="{{asset(env('APP_LOGO'))}}" style="height: 60px" alt="" class="rounded-full float-end border">
			</div>
		</h6>
	</div>
	<div class="overflow-x-auto my-2 p-1 shadow border-2 border-gray-800 bg-gray-300">
    @if ($the_month && $the_year && count($payment_data) > 0)
    <table class="min-w-full divide-y divide-gray-200 m-0 text-sm border-gray-800">
      <thead class="bg-sky-400 text-gray-900 font-semibold">
        <tr class="tr-head">
          <th class="px-3 py-3 text-center">#N°</th>
          <th class="px-3 py-3 text-left">Membres</th>
          <th class="px-3 py-3 text-left">Description</th>
          <th class="px-3 py-3 text-left">Montant</th>
          <th class="px-3 py-3 text-left">Cotisation de </th>
          <th class="px-3 py-3 text-left">Date de payement</th>
          <th class="px-3 py-3 text-left">Observations / Visa</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100" id="payments-tbody">
        
            @foreach ($payment_data as $member_id => $cotisation)

                @php
                    $member = findMember($member_id);
                @endphp

                @if($cotisation && isset($cotisation->id))
                    <tr wire:key='list-des-cotisations-mensuelles-{{$cotisation->id}}'>
                        <td class="px-3 py-2 text-gray-900 text-center">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </td>
                        <td class="px-3 py-2 text-gray-900 font-medium">{{ $cotisation->member->user->getFullName() }}</td>
                        <td class="px-3 py-2 text-gray-800">
                            {{ $cotisation->description ? $cotisation->description : 'Non précisée' }}
                        </td>
                        <td class="px-3 py-2 text-gray-950 font-semibold">
                            {{ __moneyFormat($cotisation->amount) }} FCFA
                        </td>
                        <td class="px-3 py-2 text-gray-800">
                            {{ $cotisation->getCotisationMonthYear()}}
                        </td>
                        <td class="px-3 py-2 text-gray-900">
                            {{ __formatDate($cotisation->payment_date) }}
                        </td>
                        <td class="px-3 py-2 text-center">
                            
                        </td>
                    </tr>
                @else
                    <tr wire:key='list-des-cotisations-mensuelles-{{getRand(2999, 8888888)}}'>
                    <td class="px-3 py-2 text-gray-800 text-center">
                        {{ numberZeroFormattor($loop->iteration) }}
                    </td>
                    <td class="px-3 py-2 text-gray-800 font-medium">{{ $member->user->getFullName() }}</td>
                    <td class="px-3 py-2 text-gray-800 text-center">
                        Non payé
                    </td>
                    <td class="px-3 py-2 text-green-900 text-right font-semibold">
                        ..............FCFA
                    </td>
                    <td class="px-3 py-2 text-gray-900">
                        {{  $the_month }} {{  $the_year }}
                    </td>
                    <td class="px-3 py-2 text-gray-900">
                        
                    </td>
                    <td class="px-3 py-2 text-center">
                        
                    </td>
                </tr>
                @endif
            @endforeach
        <!-- Lignes dynamiques -->
      </tbody>
    </table>
	<div class="text-gray-950 w-full">
		<h4 class="w-full font-semibold text-2xl text-center items-center py-2 mt-2 flex justify-center gap-x-9">
			<span>
				Montant total enregistré: 
			</span>
			<span>
				{{ __moneyFormat($total_amount) }} FCFA
			</span>
		</h4>
	</div>
	@elseif (!$the_month && $the_year && count($yearly_payments) > 0)
		@if($yearly_payments)
			<table class="min-w-full divide-y divide-gray-200 m-0 text-sm border-gray-800">
				<thead class="bg-sky-400 text-gray-900 font-semibold">
					<tr class="tr-head">
						<th class="px-3 py-3 text-center">#N°</th>
						<th class="px-3 py-3 text-left">Membre</th>
						<th class="px-3 py-3 text-left">Nombre de payements effectués</th>
						<th class="px-3 py-3 text-left">Montant</th>
						<th class="px-3 py-3 text-left">Cotisation de l'année</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100" id="payments-tbody">
					
					@foreach ($yearly_payments as $member_id => $member_payment)

						@php
							$member = findMember($member_id);
						@endphp

						@if($member_payment)
							<tr wire:key='list-des-cotisations-annuelles-{{$member_id}}'>
								<td class="px-3 py-2 text-gray-900 text-center ">
									{{ numberZeroFormattor($loop->iteration) }}
								</td>
								<td class="px-3 py-2 text-gray-900 text-left">
									{{ $member->user->getFullName() }}
								</td>
								<td class="px-3 py-2 text-gray-900 text-center">
									{{ numberZeroFormattor($member_payment['payments_done']) }}
								</td>
								<td class="px-3 py-2 text-gray-900 text-center">
									{{ __moneyFormat($member_payment['total']) }} FCFA
								</td>
								<td class="px-3 py-2 text-gray-900 text-center">
									{{ $the_year }}
								</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
			<div class="text-gray-950 w-full">
				<h4 class="w-full font-semibold text-2xl text-center items-center py-2 mt-2 flex justify-center gap-x-9">
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

    @else
        <div class="w-full text-center py-2 border-none bg-red-300 text-red-600 text-base">
            <span class="fas fa-trash"></span>
            <span>Oupps aucune données trouvées!!!</span>
        </div>
    @endif
</div>

</body>
</html>