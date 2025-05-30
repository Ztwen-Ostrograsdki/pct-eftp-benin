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
    <div class="mb-6">
        <div class="flex items-center justify-between flex-col gap-x-2 mb-6 lg:text-lg md:text-lg sm:text-xs xs:text-xs">
            <h2 class="lg:text-lg md:text-lg sm:text-sm w-full flex gap-x-3  font-semibold letter-spacing-1 uppercase text-sky-500">Détails cotisations mensuelles

                <span class="text-yellow-500">
                    {{  $selected_month }} {{  $selected_year }}
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
                        wire:click="printMembersCotisations"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='printMembersCotisations'>
                            <span>Imprimer</span>
                            <span class="fas fa-print"></span>
                        </span>
                        <span wire:target='printMembersCotisations' wire:loading>
                            <span>Impression en cours...</span>
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
            <button
            id="filter-toggle-btn"
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition flex items-center gap-2"
            aria-expanded="false"
        >
            <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-gray-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            >
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 018 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
            </svg>
            Filtrer
        </button>
        <div class="px-3 mb-4 w-8/12">
            <div class="items-center flex float-end border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">
                <div class="">
                    <select wire:model.live='selected_year' class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                        <option class="py-4" value="">Trier par Années</option>
                        <option value="{{$all_year}}">{{ "Toutes les années" }}</option>
                        @foreach (getYears() as $year_val => $year)
                        <option wire:key="listing-des-cotisations-par-annees-{{$year}}" class="py-4 px-3" value="{{$year}}"> 
                            Les cotisations de l'année {{ $year }} 
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="">
                    <select wire:model.live='selected_month' class="w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                        <option class="py-4" value="">Trier par Mois</option>
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
        <div
            id="members-filter-panel"
            class="mt-3 w-full text-gray-200 overflow-hidden max-h-0 opacity-0 transition-all duration-500 ease-in-out"
            style="transition-property: max-height, opacity;"
        >
            <form id="members-filter-form" class="bg-transparent border border-gray-300 rounded p-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="members-filter-member" class="block  font-medium mb-1">Membre</label>
                <input
                type="text"
                id="members-filter-member"
                name="members-filter-member"
                placeholder="Nom ou prénoms du membre"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="members-filter-amount-min" class="block  font-medium mb-1">Montant min (FCFA)</label>
                <input
                type="number"
                id="members-filter-amount-min"
                name="members-filter-amount-min"
                step="0.01"
                min="0"
                placeholder="0.00"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="members-filter-amount-max" class="block  font-medium mb-1">Montant max (FCFA)</label>
                <input
                type="number"
                id="members-filter-amount-max"
                name="members-filter-amount-max"
                step="0.01"
                min="0"
                placeholder="100.00"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="members-filter-date" class="block  font-medium mb-1">Date</label>
                <input
                type="date"
                id="members-filter-date"
                name="members-filter-date"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div class="md:col-span-4 flex justify-end gap-3 mt-2">
                <button
                type="reset"
                id="members-filter-reset-btn"
                class="px-4 py-2 border rounded  hover:bg-primary-800 transition"
                >Réinitialiser</button>
            </div>
            </form>
        </div>
    </div>

  <!-- Tableau des paiements -->
  <div class="overflow-x-auto rounded-lg shadow border border-gray-200 z-bg-secondary-light">
    @if (count($payment_data) > 0)

    @if($selected_members AND count($selected_members) > 0)
        <h6 class="w-full text-zinc-400 text-right font-semibold letter-spacing-2 p-2">
            <span class="text-yellow-400">
                {{ numberZeroFormattor(count($selected_members)) }}
            </span> membres sélectionnés
        </h6>
    @endif
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-gray-900 text-gray-300 font-semibold">
        <tr>
            <th class="px-3 py-4 text-center">#N°</th>
            <th class="px-3 py-4 text-left">Membre</th>
            <th class="px-3 py-4 text-left">Description</th>
            <th class="px-3 py-4 text-left">Montant (FCFA)</th>
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
                                <span wire:click="editMemberPayment({{$cotisation->id}})" class="hover:bg-blue-500 text-gray-300 border rounded-md bg-blue-600 px-2 py-1" title="Editer cette cotisation enregistrée au nom de {{ $cotisation->member->user->getFullName() }}">
                                    <span class="fas fa-edit"></span>
                                    <span>Editer</span>
                                </span>
                                <span wire:click="deleteMemberPayment({{$cotisation->id}})" class="hover:bg-red-500 text-gray-300 border rounded-md bg-red-600 px-2 py-1" title="Supprimer cette cotisation enregistrée au nom de {{ $cotisation->member->user->getFullName() }}">
                                    <span class="fas fa-trash"></span>
                                    <span>Suppr.</span>
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

                            <span title="Envoyer les details de payemnts mensuels à {{ $member->user->getFullName(true) }}" wire:click="generateAndSendDetailsToMember('{{$member->id}}')" class="bg-green-500 hover:bg-green-700 py-1 px-2 border rounded-lg cursor-pointer">
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
        <!-- Lignes dynamiques -->
      </tbody>
    </table>
    @else
        <div class="w-full text-center py-4 border-none bg-red-300 text-red-600 text-base">
            <span class="fas fa-trash"></span>
            <span>Oupps aucune données trouvées!!!</span>
        </div>
    @endif
  </div>

  <!-- Modal Ajouter / Éditer -->
  
</div>

<!-- Script minimal pour ouvrir/fermer modal et soumettre formulaire -->
<script>
  const filterToggleBtn = document.getElementById('filter-toggle-btn');
  const filterPanel = document.getElementById('members-filter-panel');
  const filterForm = document.getElementById('members-filter-form');
  const resetBtn = document.getElementById('members-filter-reset-btn');

  filterToggleBtn.addEventListener('click', () => {
    const isOpen = filterPanel.style.maxHeight && filterPanel.style.maxHeight !== '0px';

    if (isOpen) {
      filterPanel.style.maxHeight = '0';
      filterPanel.style.opacity = '0';
      filterToggleBtn.setAttribute('aria-expanded', 'false');
    } else {
      filterPanel.style.maxHeight = filterPanel.scrollHeight + 'px';
      filterPanel.style.opacity = '1';
      filterToggleBtn.setAttribute('aria-expanded', 'true');
    }
  });

  function applyFilter() {
    const memberFilter = filterForm['members-filter-member'].value.toLowerCase();
    const minAmount = parseFloat(filterForm['members-filter-amount-min'].value) || 0;
    const maxAmount = parseFloat(filterForm['members-filter-amount-max'].value) || Infinity;
    const dateFilter = filterForm['members-filter-date'].value;

    const rows = document.querySelectorAll('#payments-tbody tr');

    rows.forEach(row => {
      const cells = row.querySelectorAll('td');
      const member = cells[0].textContent.toLowerCase();
      const amount = parseFloat(cells[2].textContent.replace(',', '.')) || 0;
      const date = cells[4].textContent.split('/').reverse().join('-'); // jj/mm/yyyy => yyyy-mm-dd

      let show = true;
      if (memberFilter && !member.includes(memberFilter)) show = false;
      if (amount < minAmount) show = false;
      if (amount > maxAmount) show = false;
      if (dateFilter && date !== dateFilter) show = false;

      row.style.display = show ? '' : 'none';
    });
  }

  // Appliquer filtre à chaque changement de champ
  ['members-filter-member', 'members-filter-amount-min', 'members-filter-amount-max', 'members-filter-date'].forEach(id => {
    filterForm[id].addEventListener('input', applyFilter);
  });

  // Réinitialiser filtre (affiche tout)
  resetBtn.addEventListener('click', () => {
    setTimeout(() => {
      const rows = document.querySelectorAll('#payments-tbody tr');
      rows.forEach(row => (row.style.display = ''));
    }, 0);
  });

  
</script>



