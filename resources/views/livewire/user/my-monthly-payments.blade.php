<div class="p-6 max-w-6xl mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500">
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
        border: thin solid rgb(177, 167, 167) !important;
      }
    </style>
  <div class="mb-6 lg:text-lg md:text-lg sm:text-sm xs:text-xs">
        <div class="flex items-center justify-between gap-x-2 mb-6">
            <h2 class="lg:text-lg md:text-lg sm:text-sm xs:text-xs  font-semibold letter-spacing-1 uppercase text-sky-500">Fiche des cotisations mensuelles 
            </h2>
            @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole(['cotisations-manager', 'members-manager']))
              <span wire:click="redirectToMembersHomePayments" class="cursor-pointer border px-4 py-2 rounded-lg bg-gray-700 text-sky-300 hover:bg-gray-800 hover:text-gray-100" >
                <span wire:loading.remove wire:target='redirectToMembersHomePayments'>Page des cotisations</span>
                <span wire:loading wire:target='redirectToMembersHomePayments' class="">
                  <span class="fas fa-rotate animate-spin mr-2"></span>
                  <span>Chargement de la page de cotisations en cours...</span>
                </span>
              </span>
            @endif
        </div>
        <div class="flex justify-end gap-x-2">
          @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole(['cotisations-manager', 'members-manager']))
            <div class="flex items-center">
                <button
                    wire:click="addMemberPayment"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800 hover:text-gray-800 transition"
                >
                    <span wire:loading.remove wire:target='addMemberPayment'>
                        Enregistrer un paiement
                    </span>
                    <span wire:target='addMemberPayment' wire:loading>
                        <span>Chargement en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
            </div>
            @endif
            <div class="flex items-center">
                <button
                    wire:click="printMemberCotisations"
                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-800 hover:text-gray-900 transition"
                >
                    <span wire:loading.remove wire:target='printMemberCotisations'>
                        @if(auth_user()->id == $member->user->id)
                          Recevoir ma fiche de cotisation
                        @else
                          Générer et envoyer la fiche de cotisation
                        @endif
                        par mail
                    </span>
                    <span wire:target='printMemberCotisations' wire:loading>
                        <span>Impression en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="flex items-center w-full justify-center">
              <h6 class="w-full items-center flex justify-center gap-x-9 py-3 font-semibold letter-spacing-1 text-yellow-400">
                <span>
                    <span class="text-gray-300">Membre : </span>
                    <span>{{ $member->user->getFullName() }}</span>
                </span>

                <span>
                    <span class="text-gray-300">Année :</span>
                    <span>{{  $selected_year }}</span>
                </span>
                
              </h6>
            </div>
        <hr class="border-sky-600 mb-2">

        <div class="w-full flex justify-between items-center">
            
        <div class="mb-4">
            <div class="items-center flex justify-start border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">
                <div class="">
                    <select wire:model.live='selected_year' class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                        <option disabled class="py-4" value="">Trier par Années</option>
                        @foreach (getYears() as $year_val => $year)
                        <option wire:key="listing-des-cotisations-par-annees-{{$year}}" class="py-4 px-3" value="{{$year}}"> 
                            Les cotisations de l'année {{ $year }} 
                        </option>
                        @endforeach
                    </select>
                </div>

              </div>
            </div>
        </div>
    </div>

  <!-- Tableau des paiements -->
  <div class="overflow-x-auto shadow border border-gray-200 z-bg-secondary-light">
    
    <table class="min-w-full divide-y divide-gray-200 lg:text-sm md:text-sm sm:text-sm xs:text-xs">
      <thead class="bg-gray-900 text-gray-300 font-semibold ">
        <tr style="" class="border-b border-b-gray-400">
          <th class="px-3 py-4 text-center">Mois</th>
          <th class="px-3 py-4 text-left">Description</th>
          <th class="px-3 py-4 text-left">Montant Payé (FCFA)</th>
          <th class="px-3 py-4 text-left">Cotisation de </th>
          <th class="px-3 py-4 text-left">Date de payement</th>
          @if(__isAdminAs())
          <th class="px-3 py-4 text-center">Actions</th>
          @endif
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100" id="payments-tbody">
        
            @foreach ($months as $mk => $month)

              <tr class="admin-user-list-tr" wire:key='list-des-cotisations-mensuelles-{{$member->id}}-{{$mk}}'>
                  @php

                    $cotisation = getMemberCotisationOfMonthYear($member->id, $month, $selected_year);

                  @endphp
                    <td class="px-3 py-2 text-gray-300 font-medium">{{ $month }}</td>
                    <td class="px-3 py-2 text-gray-400">
                        @if($cotisation)

                          {{ $cotisation->description ? $cotisation->description : 'Non précisée' }}

                        @else

                          Non payé

                        @endif
                    </td>
                    <td class="px-3 py-2 text-green-600 font-semibold">

                        @if($cotisation)

                          {{ __moneyFormat($cotisation->amount) }} FCFA

                        @else

                          
                          
                        @endif
                    </td>
                    <td class="px-3 py-2 text-yellow-600">

                      {{ $month }} {{ $selected_year }}
                      
                    </td>
                    <td class="px-3 py-2 text-gray-300">
                      @if($cotisation)
                        {{ __formatDate($cotisation->payment_date) }}
                      @else
                        
                      @endif
                    </td>
                    @if(__isAdminAs())
                    <td class="px-3 py-2 text-center">
                      @if($cotisation)
                        <span class="flex gap-x-3 w-full justify-start items-center">
                            <span wire:click="editMemberPayment({{$cotisation->id}})" class="hover:bg-blue-500 text-gray-300 border rounded-md bg-blue-600 px-2 py-1" title="Editer cette cotisation enregistrée au nom de {{ $member->user->getFullName() }}">
                                <span class="fas fa-edit"></span>
                                <span>Editer</span>
                            </span>
                            <span wire:click="deleteMemberPayment({{$cotisation->id}})" class="hover:bg-red-500 text-gray-300 border rounded-md bg-red-600 px-2 py-1" title="Supprimer cette cotisation enregistrée au nom de {{ $member->user->getFullName() }}">
                                <span class="fas fa-trash"></span>
                                <span>Suppr.</span>
                            </span>
                        </span>
                      @else
                        <span class="flex gap-x-3 w-full justify-start items-center">
                            <span wire:click="addMemberPayment('{{$month}}')" class="hover:bg-blue-500 text-gray-300 border rounded-md bg-blue-600 px-2 py-1" title="Editer cette cotisation enregistrée au nom de {{ $member->user->getFullName() }}">
                                <span class="fas fa-edit"></span>
                                <span>Editer</span>
                            </span>
                        </span>
                      @endif
                    </td>
                    @endif
                </tr>
            @endforeach
        <!-- Lignes dynamiques -->
      </tbody>
    </table>
    
  </div>

</div>