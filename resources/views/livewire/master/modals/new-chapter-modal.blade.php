
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="chapter-manager-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    @if($law)
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Ajout de chapitre à la loi :
                </h3>
                <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="my-2 px-3 mx-auto w-full">
                <h6 class="text-sm letter-spacing-1 font-semibold uppercase w-full text-center text-sky-500 border-b border-sky-400">
                    {{ $law->name }}
                </h6>
                @if(count($law->chapters))
                <div class="flex flex-wrap gap-2 text-center justify-start">
                    @foreach ($law->chapters as $chpt)
                        <h6 wire:key="law-chapters-listing-{{$chpt->id}}" class="mx-1 p-2 text-sm">
                            <span> {{ $chpt->chapter }} </span>
                        </h6>
                    @endforeach
                </div>
                @endif
            </div>
            <form wire:ignore.self class="p-4 md:p-5">
                
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="chapter-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Le chapitre</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='chapter' type="text" name="chapter" id="chapter-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Le chapitre">
                        @error('chapter')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="col-span-2">
                        <label for="law-chapter-description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <small class="text-yellow-300">Facultative</small> </label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='description' type="text" name="description" id="law-chapter-description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Décrivez brièvement ce chapitre">                  
                        @error('description')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-between gap-x-2 mb-2">
                    @if($chapter)
                        <span wire:click="pushIntoData" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-green-700 text-gray-100 hover:bg-green-600 px-5 py-2 rounded-full">
                            <span wire:loading.remove wire:target='pushIntoData'>
                                <span>Ajouter</span>
                                <span class="fas fa-arrow-right-long mr-2"></span>
                            </span>
                            <span wire:loading wire:target='pushIntoData' class="">Ajout en cours...</span>
                            <span wire:loading wire:target='pushIntoData' class="fas fa-rotate animate-spin"></span>
                        </span>
                    @endif
                </div>

                @if(count($chapters_data) > 0)
                    <div class="mx-auto w-full text-sm p-2 shadow-2 shadow-sky-500">
                        <h6 class="letter-spacing-2 font-semibold text-sky-300 mb-2 text-center uppercase flex justify-between items-center py-2">
                            <span>Liste des chapitres en cours d'ajout</span>
                            <span class="ml-2 text-sm">
                                <span wire:click="resetAllData" title="Rafraichir les données" class="cursor-pointer p-2 border rounded-lg bg-danger-500 text-gray-900">
                                    Effacer
                                    <span class="fas fa-trash text-danger-700"></span>
                                </span>
                            </span>
                        </h6> 
                       <div>
                          @foreach ($chapters_data as $pos => $ch_dt)
                              <div class="flex justify-between items-center rounded-lg shadow-2 shadow-sky-500 p-2 mb-2  letter-spacing-1 font-semibold" wire:key="inserting-chapter-to-law-{{$loop->iteration}}">
                                <div class="flex flex-col my-1">
                                    <h6 class="text-gray-300">
                                        {{ $ch_dt['chapter'] }} 
                                     </h6>
                                     <span class="text-orange-400 text-xs">
                                         {{ $ch_dt['description'] }}
                                     </span>
                                </div>

                                <span wire:click="removeFromData('{{$pos}}')" title="Retirer ce chapitre" class="cursor-pointer p-2 border rounded-lg bg-danger-400 text-danger-700">
                                    <span>Retirer ce chapitre</span>
                                    <span class="fas fa-trash"></span>
                                </span>  
                              </div>
                          @endforeach  
                       </div>

                       <span wire:click="insert" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                        <span wire:loading.remove wire:target='insert'>Insérer les {{ count($chapters_data) }} données </span>
                        <span wire:loading wire:target='insert' class="">Traitement en cours...</span>
                        <span wire:loading wire:target='insert' class="fas fa-rotate animate-spin"></span>
                    </span>
                    </div>
                    
                @endif
            </form>
        </div>
    </div>
    @endif
</div> 


