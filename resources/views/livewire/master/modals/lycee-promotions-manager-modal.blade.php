
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="lycee-promotions-manager-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl mt-24 max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Gestion des promotions 
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

                @if($selected_lycee)
                <div class="letter-spacing-1 font-semibold p-2">
                    <h6 class="text-orange-300">
                        Du lycée ou centre de formation
                    </h6>
                    <h6 class="text-sky-500">
                        {{ $selected_lycee->name }}

                        @if($selected_lycee->is_public)
                        <span class="text-green-600 text-right">
                            (PUBLIC)
                        </span>
                        @else
                        <span class="text-orange-400 text-right">
                            (PRIVE)
                        </span>
                        @endif
                    </h6>
                </div>
                @endif

                <div class="w-full my-2">
                    <h5 class="my-3 text-gray-500 xs:text-xs lg:text-base w-full">
                        <span>Veuillez sélectionner les promotions</span>

                        <span class="float-right text-orange-300"> {{ count($selecteds) }} promotions sélectionnées </span>
                    </h5>
                </div>
                <div class="mt-3 w-full mb-5 group overflow-y-auto p-3" style="max-height: 300px">

                    <table class="w-full text-sm text-center border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400 xs:text-xs lg:text-base">
            
                        @if(count($promotions) > 0)
                        <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-blue-900 dark:text-gray-400 items-center">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left">
                                    N°
                                </th>
                                <th scope="col" class="px-6 py-3 text-left">
                                   Promotions
                                </th>
                                <th scope="col" class="px-6 py-3 float-right text-right">
                                    Action à effectuer 
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotions as $key => $promotion)
                            <tr wire:key="promotion-joined-to-lycee-{{$promotion->id}}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 text-left font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ numberZeroFormattor($loop->iteration) }}
                                </th>
                                <td class="px-6 py-4 text-left">
                                    {{$promotion->name}} 
                                </td>
                                <td class="px-6 py-4 float-right">
                                    @if(!in_array($promotion->id, $selecteds))
                                    <span wire:click='pushIntoSelecteds({{$promotion->id}})' class="bg-blue-500 text-gray-950 cursor-pointer border rounded-lg py-2 px-3">
                                        <span>Ajouter</span>
                                        <span class="fas fa-plus"></span>
                                    </span>
                                    @endif

                                    @if(in_array($promotion->id, $selecteds))
                                    <span wire:click='retrieveFromSelecteds({{$promotion->id}})' class="bg-red-500 cursor-pointer text-gray-950 border rounded-lg py-2 px-3">
                                        <span>Retirer</span>
                                        <span class="fas fa-trash"></span>
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif 
                        </tbody>
                    </table>
                    
                </div>
                @if($selecteds == [])
                    <div class="w-full my-2">
                        <span class="text-red-600">Veuiller selectionner les promotions</span>
                    </div>
                @else
                <div class="w-full my-2 p-2">
                    <span wire:click="insert" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                        <span wire:loading.remove wire:target='insert'>Mettre à jour</span>
                        <span wire:loading wire:target='insert' class="">Traitement en cours...</span>
                        <span wire:loading wire:target='insert' class="fas fa-rotate animate-spin"></span>
                    </span>
                </div>
                @endif

            </form>
        </div>
    </div>
</div> 
