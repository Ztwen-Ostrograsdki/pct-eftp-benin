
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="communique-manager-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full mt-4">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Gestion de communiqué
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
                        <label for="from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instance de publication</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='from' type="text" name="from" id="from" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="L'Instance publiant le communiqué: La direction, le Président, le commité de gestion...">
                        @error('from')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Le titre du communiqué</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='title' type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Le titre du communiqué">
                        @error('title')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="objet" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">L'objet du communiqué</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='objet' type="text" name="objet" id="objet" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="L'objet du communiqué">
                        @error('objet')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="col-span-2">
                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenu</label>
                        <textarea rows="8" wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='content' id="content" rows="4" class="block p-2.5 w-full text-sm font-semibold letter-spacing-1 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Le Contenu du communiqué ici..."></textarea>                    
                        @error('content')
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
