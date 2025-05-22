<div class="fixed" style="z-index: 800;">
    @if(auth_user() && $toasters_data)
        @foreach ($toasters_data as $key => $toaster)
            @php
                $name = $toaster->id;
            @endphp
        <div wire:key="toaster-page-{{getRandom(253435, 7736535534)}}" id="toaster-{{$toaster->id}}" class="flex my-2 items-center w-full max-w-xs p-2 px-3 mb-4 text-yellow-500 bg-gray-800 rounded-lg shadow-sm  opacity-85 transition-opacity" role="alert" >
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-gray-500 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200">
                <span class="fas fa-envelope-open"></span>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ms-3 lg:text-sm md:text-xs xs:text-xs font-normal">{{ $toaster->data ? $toaster->data['message'] : 'Une notification...' }}</div>
            <button wire:click='deleteNotification("{{$name}}")' title="Cliquer pour Masquer cette notification" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toaster-{{$toaster->id}}" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        @endforeach

        <div wire:click='deleteAllNotifications' title="Cliquer pour tout effacer" wire:key="toaster-page-{{getRandom(253435, 7736535534)}}" id="toaster-deleter" class="hidden flex my-2 items-center w-full max-w-xs p-2 px-3 mb-4 text-gray-50 bg-red-600 cursor-pointer rounded-lg shadow-sm  opacity-85 transition-opacity" role="alert" >
            
            <div class="flex justify-between items-center w-full" wire:loading.remove wire:target='deleteAllNotifications'>
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-gray-50 bg-red-500 rounded-lg ">
                    <span class="fas fa-trash"></span>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 lg:text-sm md:text-xs xs:text-xs font-normal">Tout effacer</div>
                <span class="ms-auto -mx-1.5 -my-1.5 text-gray-50 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-red-100 inline-flex items-center justify-center h-8 w-8 bg-red-800" data-dismiss-target="#toaster-deleter" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <span>
                        {{ numberZeroFormattor(count($toasters_data)) }}
                    </span>
                </span>
            </div>
            <div class="flex justify-between w-full" wire:loading wire:target='deleteAllNotifications'>
                <div class="ms-3 text-xs font-normal">Suppression en cours...</div>
                <span  class="ms-auto -mx-1.5 -my-1.5 text-gray-50 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-red-100 inline-flex items-center justify-center h-8 w-8 bg-red-800" data-dismiss-target="#toaster-deleter" aria-label="Close">
                    <span class="fas fa-rotate animate-spin"></span>
                </span>
            </div>
        </div>
    @endif

</div>
