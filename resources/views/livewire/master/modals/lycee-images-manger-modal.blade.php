<div wire:ignore.self id="{{str_replace('#', '', $modal_name)}}" tabindex="-1"  class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    @if($lycee)
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Gestion des images 
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="user-profil-photo-edition">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            @if($lycee->hasImages())
            <div class="flex flex-col items-center mt-3 px-2">
                
            </div>
            @endif
            <!-- Modal body -->
            <form class="p-1 md:p-5">
                
                <div class="flex items-center justify-center w-full">
                    {{-- Upload zone --}}
                    @if(!$images)
                    <div class="flex items-center justify-center w-full">
                        <label for="images" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            @if(!$images)
                                <div wire:loading.remove wire:target='images' class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" ...></svg>
                                    <p class="mb-2 text-sm text-gray-500 text-center"><span class="font-semibold">Sélectionner des images</span> ou glisser-déposer</p>
                                    <p class="text-xs text-gray-500 text-center">SVG, PNG, JPG ou GIF</p>
                                </div>
                            @endif
                            <input multiple wire:model.live="images" name="images" id="images" type="file" class="hidden" />
                        </label>
                    </div>
                    @endif

                    {{-- Thumbnails preview --}}
                    @if($images)
                        <div class="w-full flex gap-2 justify-between items-center">
                            <div class="w-auto grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach ($images as $key => $image)
                                    <div class="group relative border rounded overflow-hidden" style="z-index: 2000 !important;" x-data="{ show: false }"
                                        x-init="setTimeout(() => show = true, {{ $key * 100 }})"
                                        x-show="show"
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 scale-90"
                                        x-transition:enter-end="opacity-100 scale-100">
                                        <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-32" alt="Preview">
                                        <span wire:click="removeImage({{ $key }})"
                                            class="absolute inset-0 bg-red-600 bg-opacity-80 text-white text-xs font-semibold opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center cursor-pointer">
                                            ✖ Retirer cette image
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <label for="images" class="flex flex-col        items-center justify-center py-5 w-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div wire:loading.remove wire:target='images' class="flex flex-col items-center justify-center">
                                        <p class="mb-2 text-sm text-gray-500 text-center"><span class="font-semibold">Sélectionner de nouvelles images</span> ou glisser-déposer</p>
                                        <p class="text-xs text-gray-500 text-center">SVG, PNG, JPG ou GIF</p>
                                    </div>
                                    <input multiple wire:model.live="images" name="images" id="images" type="file" class="hidden" />
                                </label>
                            </div>
                        </div>
                    @endif

                </div> 

                <div class="bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='images'>
                    <span class=" text-yellow-400 text-center text-base letter-spacing-2">
                    <span class="fas fa-rotate animate-spin"></span>
                    Chargement des images en cours... Veuillez patientez!
                    </span>
                </div>

                @error('images') 
                    <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                        {{ $message }}
                    </span> 
                @enderror
                @error('images.*') 
                    <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                        {{ $message }}
                    </span> 
                @enderror

                <div wire:loading.class='opacity-15' wire:target='images' class="grid grid-cols-2 gap-x-4 my-2 mt-5">
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
    @endif
</div> 