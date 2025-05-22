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
  <div class="mb-6">
        <div class="flex items-center justify-between gap-x-2 mb-6">
            <h2 class="lg:text-lg md:text-lg sm:text-sm  font-semibold letter-spacing-1 uppercase text-sky-500">Fiche des cotisations mensuelles 
              
            </h2>
            <div class="flex justify-end gap-x-2">
                @if(__isAdminAs())
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
                            Imprimer
                        </span>
                        <span wire:target='printMemberCotisations' wire:loading>
                            <span>Impression en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
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

              </div>
            </div>
        </div>
        <div
            id="filter-panel"
            class="mt-3 w-full text-gray-200 overflow-hidden max-h-0 opacity-0 transition-all duration-500 ease-in-out"
            style="transition-property: max-height, opacity;"
        >
            <form id="filter-form" class="bg-transparent border border-gray-300 rounded p-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="filter-member" class="block  font-medium mb-1">Membre</label>
                <input
                type="text"
                id="filter-member"
                name="filter-member"
                placeholder="Nom du membre"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="filter-amount-min" class="block  font-medium mb-1">Montant min (FCFA)</label>
                <input
                type="number"
                id="filter-amount-min"
                name="filter-amount-min"
                step="0.01"
                min="0"
                placeholder="0.00"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="filter-amount-max" class="block  font-medium mb-1">Montant max (FCFA)</label>
                <input
                type="number"
                id="filter-amount-max"
                name="filter-amount-max"
                step="0.01"
                min="0"
                placeholder="100.00"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div>
                <label for="filter-date" class="block  font-medium mb-1">Date</label>
                <input
                type="date"
                id="filter-date"
                name="filter-date"
                class="w-full border rounded bg-transparent px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div class="md:col-span-4 flex justify-end gap-3 mt-2">
                <button
                type="reset"
                id="filter-reset-btn"
                class="px-4 py-2 border rounded  hover:bg-primary-800 transition"
                >Réinitialiser</button>
            </div>
            </form>
        </div>
    </div>

  <!-- Tableau des paiements -->
  <div class="overflow-x-auto shadow border border-gray-200 z-bg-secondary-light">
    
    <table class="min-w-full divide-y divide-gray-200 text-sm">
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
                        <span class="flex gap-x-3 w-full justify-center items-center">
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
                        <span class="flex gap-x-3 w-full justify-center items-center">
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

  <!-- Modal Ajouter / Éditer -->
  
</div>

<!-- Script minimal pour ouvrir/fermer modal et soumettre formulaire -->
<script>
  const filterToggleBtn = document.getElementById('filter-toggle-btn');
  const filterPanel = document.getElementById('filter-panel');
  const filterForm = document.getElementById('filter-form');
  const resetBtn = document.getElementById('filter-reset-btn');

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
    const memberFilter = filterForm['filter-member'].value.toLowerCase();
    const minAmount = parseFloat(filterForm['filter-amount-min'].value) || 0;
    const maxAmount = parseFloat(filterForm['filter-amount-max'].value) || Infinity;
    const dateFilter = filterForm['filter-date'].value;

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
  ['filter-member', 'filter-amount-min', 'filter-amount-max', 'filter-date'].forEach(id => {
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



