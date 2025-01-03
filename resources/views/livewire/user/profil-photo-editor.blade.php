  <div wire:ignore.self id="user-profil-photo-edition" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edition Photo de profil
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="user-profil-photo-edition">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            @if($user->profil_photo)
            <div class="flex flex-col items-center mt-3 px-2">
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}"/>
                <h5 class="mb-1 text-sm text-center border-b font-medium text-gray-900 dark:text-white">
                    Photo de profil actuelle de {{ $user->getFullName(true) }}
                </h5>
            </div>
            @endif
            <!-- Modal body -->
            <form wire:ignore.self class="p-1 md:p-5">
                
                <div class="flex items-center justify-center w-full">
                    <label for="profil_photo" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        @if(!$profil_photo)
                        <div wire:loading.remove wire:target='profil_photo' class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-center text-gray-500 dark:text-gray-400"><span class="font-semibold">Sélectionner votre nouveau photo de profil</span> ou glisser et déposer</p>
                            <p class="text-xs text-gray-500 text-center dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        @else
                        <div class="flex w-full p-2 my-2 shadow-4 shadow-green-500" >
                            <img wire:loaded wire:target='profil_photo' class="border " src="{{$profil_photo->temporaryUrl()}}" alt="">
                        </div>
                        @endif
                        <div class="bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='profil_photo'>
                            <span class=" text-yellow-400 text-center text-lg letter-spacing-2">
                                <span class="fas fa-rotate animate-spin"></span>
                                Chargement de l'image en cours... Veuillez patientez!
                            </span>
                        </div>
                        <input wire:model.live="profil_photo" name="profil_photo" id="profil_photo" type="file" class="hidden" />
                    </label>
                </div> 

                <div wire:loading.class='opacity-15' wire:target='profil_photo' class="grid grid-cols-2 gap-x-4 my-2 mt-5">
                    <span wire:click="save" class="border col-span-1 cursor-pointer flex items-center text-center justify-center bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                        <span wire:loading.remove wire:target='save'>Valider</span>
                        <span wire:loading wire:target='save' class="">Traitement en cours...</span>
                        <span wire:loading wire:target='save' class="fas fa-rotate animate-spin"></span>
                    </span>
                    <span data-modal-toggle="user-profil-photo-edition" class="border col-span-1 cursor-pointer flex items-center text-center justify-center bg-gray-700 text-gray-100 hover:bg-gray-600 px-5 py-2 rounded-full">
                        <span>Fermer</span>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div> 
