<div class="p-2">
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
    <div class="m-auto z-bg-secondary-light rounded my-1 min-h-80 p-2">
        <div class="flex items-center justify-between flex-col gap-x-2 mb-6 lg:text-lg md:text-lg sm:text-xs xs:text-xs">
            <h2 class="lg:text-lg md:text-sm sm:text-sm xs:text-xs w-full flex gap-x-3  font-semibold letter-spacing-1 text-sky-500">
                <span class="uppercase">
                    Détails de l'épreuve
                </span>
                <span class="text-yellow-500 flex flex-col">
                    <span>{{ $epreuve->name }}</span>
                    <span class="text-purple-400">{{ $epreuve->baseName() }}</span>
                    <span class="text-xs text-orange-600 uppercase"> {{ $epreuve->uuid }} </span>
                </span>
            </h2>
            <div class="flex justify-end gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                <div class="flex items-center">
                    <button
                        wire:click="addNewResponse"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='addNewResponse'>
                            <span class="fas fa-plus"></span>
                            <span>
                                @if(!$uplaod_new_file) 
                                    Proposer un élément de réponses
                                @else
                                    Masquer la page d'envoi
                                @endif
                            </span>
                        </span>
                        <span wire:target='addNewResponse' wire:loading>
                            <span>Chargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
                <div class="flex gap-x-2 items-center">
                    <button
                        wire:click="sendDocumentToOthers"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-800 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='sendDocumentToOthers'>
                            <span>Envoyez aux admins</span>
                            <span class="fas fa-paper-plane"></span>
                        </span>
                        <span wire:target='sendDocumentToOthers' wire:loading>
                            <span>Envoie en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    <button
                        wire:click="printAllResponses"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='printAllResponses'>
                            <span>Télécharger toutes les réponses</span>
                            <span class="fas fa-print"></span>
                        </span>
                        <span wire:target='printAllResponses' wire:loading>
                            <span>Téléchargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
            </div>

        </div>
        <hr class="border-sky-600 mb-2">

        @if(!$uplaod_new_file)
        <div class="relative w-full overflow-x-auto p-2 shadow-md border sm:rounded-lg">
            <h5 class="text-yellow-500 flex font-semibold text-lg my-3 justify-end gap-x-2">
                <span>{{ numberZeroFormattor(count($epreuve->answers)) }}</span>
                <span class=""> réponse(s) proposée(s) </span>
            </h5>
            <table class="w-full xs:text-xs text-left border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400">
                
                @if(count($epreuve->answers) > 0)
                <thead class="text-sky-400 font-semibold letter-spacing-1">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            N°
                        </th>
                        <th scope="col" class="px-6 py-3">

                            Eléments de réponses
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Téléchargements
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Proposé par
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Proposé Le
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Supprimer
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($epreuve->answers as $epreuve_response)
                    <tr wire:key='epreuve-response-listing-page-{{$epreuve_response->uuid}}' class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $epreuve_response->uuid }}
                        </td>
                        
                        <td class="px-6 py-4">
                            {{ numberZeroFormattor($epreuve_response->downloaded) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $epreuve_response->user->getFullName() }}
                        </td>
                        
                        <td class="px-6 py-4">
                            {{ __formatDate($epreuve_response->created_at) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span wire:click="deleteResponse('{{$epreuve_response->id}}')" class="bg-red-500 hover:bg-red-700 py-2 px-3 text-gray-100 border rounded-lg cursor-pointer">
                                <span wire:loading.remove wire:target="deleteResponse('{{$epreuve_response->id}}')">
                                    <span class="hidden lg:inline">Suppr.</span>
                                    <span class="fa fa-trash"></span>
                                </span>
                                <span wire:loading wire:target="deleteResponse('{{$epreuve_response->id}}')">
                                    <span>En cours...</span>
                                    <span class="fas fa-rotate animate-spin"></span>
                                </span>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                @else
                    <h4 class="w-full animate-pulse text-center py-4 border rounded-lg bg-red-300 text-red-600 lg:text-lg sm:text-base">
                        <span class="fas fa-trash"></span>
                        <span>Oupps aucune données trouvées!!!</span>
                    </h4>
                @endif
            </table>

            <div class="my-3">
                
            </div>
        </div>
        @else
            @livewire('libraries.epreuve-response-uploader', [
                'epreuve_id' => $epreuve->id, 
                'name' => "Elements-de-réponse-de-" . $epreuve->baseName()
            ])
        @endif
    </div>
</div>
