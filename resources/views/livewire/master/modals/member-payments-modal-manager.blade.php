
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="members-payments-modal-manager" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Formulaire d'enregistrement de cotisations
                    @if($cotisation)
                    <span class="block text-yellow-500 letter-spacing-1 font-semibold text-xs">
                        Modification de la cotisation de {{ $cotisation->month }} {{ $cotisation->year }}
                    </span>
                    @endif

                    @if($member_id)
                    <span class="block text-yellow-300 letter-spacing-1 font-semibold text-xs">
                        de {{ findMember($member_id)->user->getFullName() }}
                    </span>
                    @endif
                </h3>
                <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:ignore.self class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">

                    <div class="col-span-2">
                        <label for="member_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Le membre</label>
                        <select wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='member_id' id="member_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="{{null}}">Sélectionner le membre</option>
                            @foreach ($members as $m)
                              <option value="{{$m->id}}">{{ $m->user->getFullName() }}</option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="member_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Cotisation de 
                            <span class="letter-spacing-1 font-semibold text-orange-500">
                                {{ $month ? $month : "Mois " }} - {{ $year ? $year : "Année"}}
                            </span>
                        </label>
                        <div class="flex gap-x-3 justify-between ">
                            <div class="w-1/2">
                                <select wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='month' id="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option selected="">Sélectionner le mois</option>
                                    @foreach ($months as $mk =>  $mth)
                                    <option value="{{$mth}}">{{ $mth }}</option>
                                    @endforeach
                                </select>
                                @error('month')
                                    <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <select wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='year' id="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option selected="">Sélectionner l'année</option>
                                    @foreach ($years as $yk => $yr)
                                    <option value="{{$yr}}">{{ $yr }}</option>
                                    @endforeach
                                </select>
                                @error('year')
                                    <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Le montant payé en FCFA</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='amount' type="text" name="amount" id="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Le montant payé en FCFA">
                        @error('amount')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="payment_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            La date de payement
                            <span class="letter-spacing-1 capitalize text-orange-400 float-end">
                                {{ $payment_date ? __formatDate($payment_date) : '' }}
                            </span>
                        </label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='payment_date' type="date" name="payment_date" id="payment_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="La date de payement">
                        @error('payment_date')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="col-span-2">
                        <label for="new-role-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <small class="text-yellow-300">Facultative</small> </label>
                        <textarea wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='description' id="new-role-description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Décrivez brièvement cette fonction"></textarea>                    
                        @error('description')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    
                </div>
                <span wire:click="insert" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                    <span wire:loading.remove wire:target='insert'>Insérer</span>
                    <span wire:loading wire:target='insert' class="">Traitement en cours...</span>
                    <span wire:loading wire:target='insert' class="fas fa-rotate animate-spin"></span>
                </span>
            </form>
        </div>
    </div>
</div> 

