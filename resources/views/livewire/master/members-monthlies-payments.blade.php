<div class="p-6 w-full mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500">
    <style>
      tr{
			border: thin solid white !important;
      }

      tr:nth-child(odd) {
        
      }

      tr:nth-child(even) {
      background: #141b32;
      }
      

      table {
        border-collapse: collapse;
      }

      th, td{
        border: thin solid rgb(177, 167, 167);
      }
    </style>
    <div class="mb-6 lg:text-lg md:text-sm sm:text-sm xs:text-xs">
        <div class="flex items-center justify-between flex-col gap-x-2 mb-6 lg:text-lg md:text-lg sm:text-xs xs:text-xs">
            <h2 class="lg:text-lg md:text-sm sm:text-sm xs:text-xs w-full flex gap-x-3  font-semibold letter-spacing-1 uppercase text-sky-500">Détails cotisations mensuelles

                <span class="text-yellow-500">
                    @if($selected_month)
                        {{  $selected_month }} {{  $selected_year }}
                    @else
                        de tous les mois de l'année {{  $selected_year }}
                    @endif
                </span>
            </h2>
            <div class="flex justify-end gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                <button
                    wire:click="toggleSelectionsCases"
                    class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                >
                    <span wire:loading.remove wire:target='toggleSelectionsCases'>
                        <span class="fas fa-check"></span>
                        <span>De/Cocher</span>
                    </span>
                    <span wire:target='toggleSelectionsCases' wire:loading>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <div class="flex items-center">
                    <button
                        wire:click="memberPaymentsManager"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='memberPaymentsManager'>
                            <span class="fas fa-save"></span>
                            <span>Enregistrer un paiement</span>
                        </span>
                        <span wire:target='memberPaymentsManager' wire:loading>
                            <span>Chargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
                <div class="flex gap-x-2 items-center">
                    <button
                        wire:click="sendDocumentToOthers"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-800 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='sendDocumentToOthers'>
                            <span>Envoyez aux admins</span>
                            <span class="fas fa-paper-plane"></span>
                        </span>
                        <span wire:target='sendDocumentToOthers' wire:loading>
                            <span>Envoie en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    <button
                        wire:click="printMembersCotisations"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='printMembersCotisations'>
                            <span>Recevoir par mail</span>
                            <span class="fas fa-print"></span>
                        </span>
                        <span wire:target='printMembersCotisations' wire:loading>
                            <span>Processus en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    @if($selected_month && $selected_year)
                        @if($selected_members AND count($selected_members) > 0)
                            <button
                                wire:click="buildAndSendToMembersByMail"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 hover:text-gray-900 transition"
                            >
                                <span wire:loading.remove wire:target='buildAndSendToMembersByMail'>
                                    <span>Générer et envoyés en masse</span>
                                    <span class="fas fa-envelope"></span>
                                </span>
                                <span wire:target='buildAndSendToMembersByMail' wire:loading>
                                    <span>Impression en cours...</span>
                                    <span class="fas fa-rotate animate-spin"></span>
                                </span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>

        </div>
        <hr class="border-sky-600 mb-2">

        <div class="w-full flex justify-between items-center">
            
        <div class="mb-4">
            <div class="items-center flex float-start border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">
                <div class="">
                    <select wire:model.live='selected_year' class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                        <option disabled class="py-4" value="">Lister par Années</option>
                        @foreach (getYears() as $year_val => $year)
                        <option wire:key="listing-des-cotisations-par-annees-{{$year}}" class="py-4 px-3" value="{{$year}}"> 
                            Les cotisations de l'année {{ $year }} 
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <select wire:model.live='selected_month' class="w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                        <option disabled class="py-4" value="">Lister par Mois</option>
                        <option value="{{null}}" value="py-4 px-3">Tous les mois</option>
                        @foreach ($months as $month_rank =>  $month)
                            <option wire:key="listing-des-cotisations-par-mois-{{$month_rank}}" class="py-4 px-3" value="{{$month}}"> 
                                Les cotisations de {{ $month }} 
                            </option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
        </div>
        
    </div>

  <!-- Tableau des paiements -->
  <div class="overflow-x-auto letter-spacing-1 rounded-lg shadow border border-gray-200 z-bg-secondary-light">
        @if($selected_month)
            @if (count($payment_data) > 0)

                @if($selected_members AND count($selected_members) > 0)
                    <h6 class="w-full text-zinc-400 text-right font-semibold letter-spacing-2 p-2">
                        <span class="text-yellow-400">
                            {{ numberZeroFormattor(count($selected_members)) }}
                        </span> membres sélectionnés
                    </h6>
                @endif
                <table class="min-w-full divide-y divide-gray-200 xl:text-sm lg:text-sm md:text-sm sm:text-sm xs:text-xs">
                <thead class="bg-gray-900 text-gray-300 font-semibold">
                    <tr>
                        <th class="px-3 py-4 text-center">#N°</th>
                        <th class="px-3 py-4 text-left">Membre</th>
                        <th class="px-3 py-4 text-left">Description</th>
                        <th class="px-3 py-4 text-left">Montant </th>
                        <th class="px-3 py-4 text-left">Cotisation de </th>
                        <th class="px-3 py-4 text-left">Date de payement</th>
                        <th class="px-3 py-4 text-center">Actions</th>
                        @if($display_select_cases)
                        <th class="px-3 py-4 text-center">
                            <button
                                    wire:click="toggleSelectAll"
                                    class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                                >
                                <span wire:loading.remove wire:target='toggleSelectAll'>
                                    <span class="fas fa-check-double"></span>
                                    <span>Tout dé/cocher</span>
                                </span>
                                <span wire:target='toggleSelectAll' wire:loading>
                                    <span class="fas fa-rotate animate-spin"></span>
                                </span>
                            </button>
                        </th>
                    @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="payments-tbody">
                    
                        @foreach ($payment_data as $member_id => $cotisation)

                            @php
                                $member = findMember($member_id);
                            @endphp

                            @if($cotisation && isset($cotisation->id))
                                <tr wire:key='list-des-cotisations-mensuelles-{{$cotisation->id}}'>
                                    <td class="px-2 py-2 text-gray-400 text-center @if(in_array($member->id, $selected_members)) bg-green-500 text-gray-900 @endif ">
                                        {{ numberZeroFormattor($loop->iteration) }}
                                    </td>
                                    <td class="px-2 py-2 text-gray-300 font-medium">
                                        <a href="{{route('member.payments', ['identifiant' => $member->user->identifiant])}}">
                                            {{ $cotisation->member->user->getFullName() }}
                                        </a>
                                    </td>
                                    <td class="px-2 py-2 text-gray-400">
                                        {{ $cotisation->description ? $cotisation->description : 'Non précisée' }}
                                    </td>
                                    <td class="px-2 py-2 text-green-600 font-semibold">
                                        {{ __moneyFormat($cotisation->amount) }} FCFA
                                    </td>
                                    <td class="px-2 py-2 text-yellow-600">
                                        {{ $cotisation->getCotisationMonthYear()}}
                                    </td>
                                    <td class="px-2 py-2 text-gray-300">
                                        {{ __formatDate($cotisation->payment_date) }}
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <span class="flex gap-x-3 w-full justify-center items-center">
                                            <span title="Envoyer les details de payemnts mensuels à {{ $member->user->getFullName(true) }}" wire:click="generateAndSendDetailsToMember('{{$member->id}}')" class="bg-green-500 hover:bg-green-700 py-1 px-2 border rounded-lg cursor-pointer hover:text-gray-200">
                                                <span wire:loading.remove wire:target="generateAndSendDetailsToMember('{{$member->id}}')">
                                                    <span class="hidden lg:inline">Envoyer</span>
                                                    <span class="fa fa-envelope"></span>
                                                </span>
                                                <span wire:loading wire:target="generateAndSendDetailsToMember('{{$member->id}}')">
                                                    <span class="hidden lg:inline">En cours...</span>
                                                    <span class="fas fa-rotate animate-spin"></span>
                                                </span>
                                            </span>
                                            <span wire:click="editMemberPayment({{$cotisation->id}})" class="hover:bg-blue-500 text-gray-300 border rounded-md bg-blue-600 px-2 py-1" title="Editer cette cotisation enregistrée au nom de {{ $cotisation->member->user->getFullName() }}">
                                                <span class="fas fa-edit"></span>
                                                <span class="hidden lg:inline">Editer</span>
                                            </span>
                                            <span wire:click="deleteMemberPayment({{$cotisation->id}})" class="hover:bg-red-500 text-gray-300 border rounded-md bg-red-600 px-2 py-1" title="Supprimer cette cotisation enregistrée au nom de {{ $cotisation->member->user->getFullName() }}">
                                                <span wire:loading.remove wire:target="deleteMemberPayment('{{$cotisation->id}}')">
                                                    <span class="fas fa-trash"></span>
                                                    <span class="hidden lg:inline">Suppr.</span>
                                                </span>
                                                <span wire:loading wire:target="deleteMemberPayment('{{$cotisation->id}}')">
                                                    <span class="hidden lg:inline">En cours...</span>
                                                    <span class="fas fa-rotate animate-spin"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </td>
                                    @if($display_select_cases)
                                    <td>
                                        <span wire:click="pushOrRetrieveFromSelectedMembers({{$member->id}})" class="w-full mx-auto text-center font-bold inline-block cursor-pointer">
                                            @if(in_array($member->id, $selected_members))
                                                <span class="fas fa-user-check text-green-600"></span>
                                            @else
                                                <span class="text-xs text-zinc-500">Cliquer pour ajouter</span>
                                            @endif
                                        </span>
                                    </td>
                                    @endif
                                </tr>
                            @else
                                <tr wire:key='list-des-cotisations-mensuelles-{{getRand(2999, 8888888)}}'>
                                    <td class="px-2 py-2 text-gray-400 text-center @if(in_array($member->id, $selected_members)) bg-green-500 text-gray-900 border-gray-900 border @endif ">
                                        {{ numberZeroFormattor($loop->iteration) }}
                                    </td>
                                    <td class="px-2 py-2 text-gray-300 font-medium">
                                        <a href="{{route('member.payments', ['identifiant' => $member->user->identifiant])}}">
                                            {{ $member->user->getFullName() }}
                                        </a>
                                    <td class="px-2 py-2 text-gray-400">
                                        Non payé
                                    </td>
                                    <td class="px-2 py-2 text-green-600 font-semibold">
                                        0 FCFA
                                    </td>
                                    <td class="px-2 py-2 text-yellow-600">
                                        {{  $selected_month }} {{  $selected_year }}
                                    </td>
                                    <td class="px-2 py-2 text-gray-300">
                                        Non Payé
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <span class="flex gap-x-3 w-full justify-center items-center">
                                            <span wire:click="addMemberPayment({{$member->id}})" class="hover:bg-blue-500 text-gray-300 border rounded-md bg-blue-600 px-2 py-1" title="Editer cette cotisation enregistrée au nom de {{ $member->user->getFullName() }}">
                                                <span class="fas fa-plus"></span>
                                                <span class="hidden lg:inline">Ajouter</span>
                                            </span>

                                            <span title="Envoyer les details de payemnts mensuels à {{ $member->user->getFullName(true) }}" wire:click="generateAndSendDetailsToMember('{{$member->id}}')" class="bg-green-500 hover:bg-green-700 py-1 px-2 border rounded-lg cursor-pointer hover:text-gray-100">
                                                <span wire:loading.remove wire:target="generateAndSendDetailsToMember('{{$member->id}}')">
                                                    <span class="hidden lg:inline">Envoyer</span>
                                                    <span class="fa fa-envelope"></span>
                                                </span>
                                                <span wire:loading wire:target="generateAndSendDetailsToMember('{{$member->id}}')">
                                                    <span>En cours...</span>
                                                    <span class="fas fa-rotate animate-spin"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </td>
                                    @if($display_select_cases)
                                        <td>
                                            <span wire:click="pushOrRetrieveFromSelectedMembers({{$member->id}})" class="w-full mx-auto text-center font-bold inline-block cursor-pointer">
                                                @if(in_array($member->id, $selected_members))
                                                    <span class="fas fa-user-check text-green-600"></span>
                                                @else
                                                    <span class="text-xs text-zinc-500">Cliquer pour ajouter</span>
                                                @endif
                                            </span>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="w-full text-center py-4 border-none bg-red-300 text-red-600 text-base">
                    <span class="fas fa-trash"></span>
                    <span>Oupps aucune données trouvées!!!</span>
                </div>
            @endif
        @else
            @if($yearly_payments)

                <table class="min-w-full divide-y divide-gray-200 lg:text-base md:text-sm sm:text-sm xs:text-xs">
                    <thead class="bg-gray-900 text-gray-300 font-semibold">
                        <tr>
                            <th class="px-3 py-4 text-center">#N°</th>
                            <th class="px-3 py-4 text-left">Membre</th>
                            <th class="px-3 py-4 text-left">Nombre de payements effectués</th>
                            <th class="px-3 py-4 text-left">Montant</th>
                            <th class="px-3 py-4 text-left">Cotisation de l'année</th>
                            <th class="px-3 py-4 text-center">Actions</th>
                            @if($display_select_cases)
                            <th class="px-3 py-4 text-center">
                                <button
                                        wire:click="toggleSelectAll"
                                        class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                                    >
                                    <span wire:loading.remove wire:target='toggleSelectAll'>
                                        <span class="fas fa-check-double"></span>
                                        <span>Tout dé/cocher</span>
                                    </span>
                                    <span wire:target='toggleSelectAll' wire:loading>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </button>
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="payments-tbody">
                        
                            @foreach ($yearly_payments as $member_id => $member_payment)

                                @php
                                    $member = findMember($member_id);
                                @endphp

                                @if($member_payment)
                                    <tr wire:key='list-des-cotisations-annuelles-{{$member_id}}'>
                                        <td class="px-2 py-2 text-gray-400 text-center @if(in_array($member->id, $selected_members)) bg-green-500 text-gray-900 @endif ">
                                            {{ numberZeroFormattor($loop->iteration) }}
                                        </td>
                                        <td class="px-2 py-2 text-gray-300 font-medium">
                                            <a href="{{route('member.payments', ['identifiant' => $member->user->identifiant])}}">
                                                {{ $member->user->getFullName() }}
                                            </a>
                                        </td>
                                        <td class="px-2 py-2 text-gray-400">
                                            {{ $member_payment['payments_done'] }}
                                        </td>
                                        <td class="px-2 py-2 text-green-600 font-semibold">
                                            {{ __moneyFormat($member_payment['total']) }} FCFA
                                        </td>
                                        <td class="px-2 py-2 text-sky-400">
                                            {{ $selected_year }}
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            - 
                                        </td>
                                        @if($display_select_cases)
                                        <td>
                                            <span wire:click="pushOrRetrieveFromSelectedMembers({{$member->id}})" class="w-full mx-auto text-center font-semibold inline-block cursor-pointer">
                                                @if(in_array($member->id, $selected_members))
                                                    <span class="fas fa-user-check text-green-600"></span>
                                                @else
                                                    <span class="text-xs text-zinc-500">Cliquer pour ajouter</span>
                                                @endif
                                            </span>
                                        </td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        <!-- Lignes dynamiques -->
                    </tbody>
                </table>
            @endif

        @endif
  </div>

</div>




