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
            <h2 class="lg:text-lg md:text-sm sm:text-sm xs:text-xs w-full flex gap-x-3 justify-center items-center border-b border-b-sky-600 my-3 pb-3 font-semibold letter-spacing-1 text-sky-500">
                <span class="uppercase">
                    Détails de l'épreuve
                </span>
                <span class="text-yellow-500 flex flex-col">
                    <span>{{ $epreuve->name }}</span>
                    <span class="text-purple-400">{{ $epreuve->baseName() }}
                        <span class="text-xs text-yellow-600">
                            {{$epreuve->school_year}}
                        </span>
                    </span>
                    <span class="text-xs text-orange-600 uppercase"> {{ $epreuve->uuid }} </span>
                </span>
            </h2>

            <div class="flex justify-center gap-x-2">
                @if($epreuve->is_exam)
                    <span class="text-yellow-500">
                        <span>Epreuve d'examen du</span> 
                        <span>{{ $epreuve->exam_type }}</span>
                        <span>{{ $epreuve->school_year }}</span>
                    </span>
                    @if(!$epreuve->is_normal_exam)
                    <div class="w-full flex gap-x-2 font-semibold letter-spacing-1">
                        <span class="text-cyan-300">
                            <strong>Département :</strong> 
                            {{ $epreuve->exam_department }}
                        </span>
                    </div>
                    @endif
                    @if($epreuve->is_normal_exam)
                        <span class="ml-2 text-green-500 letter-spacing-1">(Session normal)</span>
                    @else
                        <span class="ml-2 text-green-200 letter-spacing-1">(Examen blanc)</span>
                    @endif
                @endif
            </div>
            <div class="w-full flex items-center justify-between px-2">
                <div>
                    <div class=" items-center justify-between gap-2 mb-2">
                        <div class="flex items-center">
                            <img class="hidden" width="50" src="{{asset('images/icons/dark-file.png') }}" alt="">
                            <span class="text-gray-400 letter-spacing-1 mr-3">
                                Type de fichier : 
                            </span> 
                            <span style="font-size: 2rem;" class="{{$epreuve->getExtensionIcon()}}"></span>
                        </div>
                            
                        <div class="w-full">
                            <span class="text-gray-300">
                                <strong>Filières :</strong> 
                                @foreach ($epreuve->getFiliars() as $f)
                                <small wire:key="epreuve-filiars-list-{{$f->id}}" class="mx-2">{{ $f->name }}</small> 
                                @endforeach
                            </span>
                        </div>
                        <div class="w-full">
                            <span class="text-cyan-300">
                                <strong>Promotion :</strong> 
    
                                @php
    
                                $promotion = $epreuve->getPromotion();
    
                                if($promotion) $names = __getSimpleNameFormated($promotion);
    
                                else $names = null;
                                    
                                @endphp
    
                                @if($names)
    
                                {{ $names['root'] }}<sup>{{ $names['sup'] }} </sup> {{ $names['idc'] }}
    
                                @else
                                Non précisée
                                @endif
                                
                            </span>
                        </div>
                        <div class="w-full">
                            <span class="text-yellow-300">
                                <strong>Contenus :</strong> 
                                {{ $epreuve->contents_titles }}
                            </span>
                        </div>
                    </div>
                    <p class=" w-full">
                        <span class="text-green-600 dark:text-green-600">
                        Taille : {{ $epreuve->file_size ? $epreuve->file_size : 'inconnue' }}
                        </span>
                        <span class="text-xs ml-3 text-sky-600">
                        ({{$epreuve->getTotalPages()}} Page(s))
                        </span>
    
                        @if($epreuve->lycee_id)
                            <br>
                            <small class="text-sky-400 text-right">Lycée ou Centre :  
                            {{$epreuve->getLycee() ? $epreuve->getLycee()->name : 'Non renseigné'}}
                            </small>
                        @endif
                        <br>
                        <small class="text-gray-400 text-right">Publié le 
                        {{ __formatDate($epreuve->created_at) }}
                        </small>
                        <br>
                        @auth
                            @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole('epreuves-manager'))
                            <small class="text-sky-200 pt-2 opacity-60 text-xs">Par 
                            {{$epreuve->user ? $epreuve->user->getFullName() : ' Non renseigné'}}
                            </small>
                            @endif
                        @endauth
                    </p>
                </div>
                <div class="flex justify-end gap-x-3 items-center text-center">
                    <div class=" flex flex-col items-center justify-center gap-y-3">
                        @if(!$epreuve->is_exam)
                            <a class="bg-blue-500 hover:bg-blue-800 text-white gap-x-2 border-white rounded-lg px-2 py-3 w-full flex justify-center text-center" href="{{route('library.epreuves')}}">
                                <span>
                                    <span>Page des épreuves</span>
                                    <span class="fa fa-book"></span>
                                </span>
                            </a>
                        @else
                            <a class="bg-blue-500 hover:bg-blue-800 text-white gap-x-2 border-white rounded-lg px-2 py-3 w-full flex justify-center text-center" href="{{route('library.epreuves.examens')}}">
                                <span>
                                    <span>Page des épreuves</span>
                                    <span class="fa fa-book"></span>
                                </span>
                            </a>
                        @endif
                        <span title="Ce fichier a été téléchargé {{$epreuve->downloaded}} fois" class="text-orange-300 p-2 rounded-full cursor-pointer float-right text-right bg-gray-900 border-gray-400 border">
                            {{ $epreuve->downloaded }}
                            <span class="fas fa-download"></span> 
                        </span>
                        @auth
                            @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole('epreuves-manager'))
                                @if(!$epreuve->authorized)
                                    <button title="Approuver cette épreuve pour qu'elle soit accessible et visible sur la plateforme"
                                    wire:click="approveEpreuve"
                                    class="bg-green-600 w-full text-white px-4 py-2 rounded-lg hover:bg-green-800 hover:text-gray-900 transition">
                                        <span wire:loading.remove wire:target='approveEpreuve'>
                                            <span>Approuver</span>
                                            <span class="fas fa-check-double"></span>
                                        </span>
                                        <span wire:target='approveEpreuve' wire:loading>
                                            <span>En cours d'approbation...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </button>
                                @endif
                            @endif
                            <span title="Télécharger cette épreuve" class="text-center w-full bg-blue-600 text-gray-950 hover:bg-blue-800 cursor-pointer py-2 px-3 inline-block"  wire:loading.class='bg-green-400' wire:click='downloadTheFile({{$epreuve->id}})' wire:target='downloadTheFile({{$epreuve->id}})' >
                                <span wire:loading wire:target='downloadTheFile({{$epreuve->id}})'>
                                    <span class="fa animate-spin fa-rotate float-end mt-2"></span>
                                    <span class="mx-2">téléchargement en cours... </span>
                                </span>
                                <span wire:loading.remove wire:target='downloadTheFile({{$epreuve->id}})'>
                                    <span>Télécharger</span>
                                    <span class="fa fa-download mx-2"></span>
                                </span>
                            </span>
                        @else
                            <span class="text-center w-full bg-orange-300 text-gray-950 cursor-pointer py-2 px-3 inline-block">
                            <span>
                                Connectez-vous pour télécharger ce fichier
                            </span>
                            </span>
                        @endauth
                    </div>
                    
                </div>
            </div>
            <div class="flex justify-end gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                @if($epreuve->extension == ".pdf")
                    <a href="{{ $epreuve->readerRoute() }}" title="Lire le fichier" class="text-gray-300 p-2 rounded-full cursor-pointer bg-gray-950 border-gray-400 border mr-2">
                        <span class="fas fa-eye"></span> 
                        <span>Lire ce fichier</span>
                    </a>
                @endif
                @auth
                    <div class="flex items-center">
                        @if(count($epreuve->answers) < env('EPREUVE_MAX_ANSWERS'))
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
                        @endif
                    </div>
                    <div class="flex gap-x-2 items-center">
                        @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole('epreuves-manager'))
                            @if($epreuve->hidden)
                                <button
                                    wire:click="unHidde"
                                    class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-800 hover:text-gray-900 transition"
                                >
                                    <span wire:loading.remove wire:target='unHidde'>
                                        <span>Rendre accessible</span>
                                        <span class="fas fa-eye"></span>
                                    </span>
                                    <span wire:target='unHidde' wire:loading>
                                        <span>Processus en cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </button>
                            @else
                                <button
                                wire:click="hidde"
                                class="bg-yellow-300 text-dark px-4 py-2 rounded-lg hover:bg-yellow-600 hover:text-gray-900 transition"
                            >
                                    <span wire:loading.remove wire:target='hidde'>
                                        <span>Masquer cette épreuve</span>
                                        <span class="fas fa-eye-slash"></span>
                                    </span>
                                    <span wire:target='hidde' wire:loading>
                                        <span>Processus en cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </button>
                            @endif
                            @if($epreuve && count($epreuve->answers))
                                <button
                                    wire:click="deleteAllResponses"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 hover:text-gray-900 transition"
                                >
                                    <span wire:loading.remove wire:target='deleteAllResponses'>
                                        <span>Suppr. les propositions</span>
                                        <span class="fas fa-trash"></span>
                                    </span>
                                    <span wire:target='deleteAllResponses' wire:loading>
                                        <span>Suppression en cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </button>

                                @if(!$epreuve->assetAllResponsesHasBeenApproved())
                                    <button
                                        wire:click="approvedAllResponses"
                                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-800 hover:text-gray-900 transition"
                                    >
                                        <span wire:loading.remove wire:target='approvedAllResponses'>
                                            <span>Approuver tout</span>
                                            <span class="fas fa-check-double"></span>
                                        </span>
                                        <span wire:target='approvedAllResponses' wire:loading>
                                            <span>approbations en cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </button>
                                @endif
                            @endif
                        @endif
                    </div>
                @endauth
            </div>
        </div>
        @guest
            <span class="text-orange-600 font-semibold letter-spacing-1 animate-pulse px-2 flex items-center my-2 lg:text-sm md:text-sm sm:text-xs xs:text-xs">
                <span class="fas fa-triangle-exclamation"></span>
                <span>Veuillez vous connecter si vous souhaitez proposer des éléments de réponses!</span>
            </span>
        @endguest
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
                        <th scope="col" class="px-3 py-3">
                            N°
                        </th>
                        <th scope="col" class="px-3 py-3">

                            Eléments de réponses (Taille)
                        </th>
                        <th scope="col" class="px-3 py-3">
                            Téléchargements
                        </th>
                        <th scope="col" class="px-3 py-3">
                            Proposé par
                        </th>
                        @auth
                            @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole('epreuves-manager'))
                                <th scope="col" class="px-3 py-3">
                                    Actions
                                </th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($epreuve->answers as $epreuve_response)
                    <tr wire:key='epreuve-response-listing-page-{{$epreuve_response->uuid}}' class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td scope="row" class="px-3 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </td>
                        <td class="px-3 py-4">
                            @auth
                            <span title="Cliquer pour télécharger ce fichier" wire:click="downloadTheAnswer({{$epreuve_response->id}})" class="hover:underline">
                                {{ $epreuve_response->uuid }}
                                <span class="text-green-600">
                                    ({{ $epreuve_response->getFileSize() ? $epreuve_response->getFileSize() : 'inconnue' }})
                                </span>
                                <span wire:loading wire:target="downloadTheAnswer('{{$epreuve_response->id}}')">
                                    <span>Téléchargement en cours...</span>
                                    <span class="fas fa-rotate animate-spin"></span>
                                </span>
                            </span>
                            @else
                            <span title="Connectez-vous et cliquer pour télécharger ce fichier" class="hover:underline text-orange-500">
                                {{ $epreuve_response->uuid }}
                                <span class="text-green-600">
                                    ({{ $epreuve_response->getFileSize() ? $epreuve_response->getFileSize() : 'inconnue' }})
                                </span>
                            </span>
                            @endauth
                        </td>
                        
                        <td class="px-3 py-4">
                            {{ numberZeroFormattor($epreuve_response->downloaded) }}
                        </td>
                        <td class="px-3 py-4">
                            {{ $epreuve_response->user ? $epreuve_response->user->getFullName() : 'Non renseigné' }}
                        </td>
                        
                        @auth
                            @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole('epreuves-manager'))
                            <td class="px-1 py-2 text-center">
                                <span class="flex justify-start gap-x-2">
                                    @if(!$epreuve_response->authorized)
                                    <span wire:click="approvedResponse('{{$epreuve_response->id}}')" class="bg-green-500 hover:bg-green-700 py-2 px-3 text-gray-100 border rounded-lg cursor-pointer">
                                        <span wire:loading.remove wire:target="approvedResponse('{{$epreuve_response->id}}')">
                                            <span class="hidden lg:inline">Approuver</span>
                                            <span class="fa fa-check-double"></span>
                                        </span>
                                        <span wire:loading wire:target="approvedResponse('{{$epreuve_response->id}}')">
                                            <span>En cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </span>
                                    @endif
                                    @if($epreuve_response->hidden)
                                    <span title="Rendre cet élément de réponses accessible" wire:click="unHiddeResponse('{{$epreuve_response->id}}')" class="bg-cyan-500 hover:bg-cyan-700 py-2 px-3 text-gray-100 border rounded-lg cursor-pointer">
                                        <span wire:loading.remove wire:target="unHiddeResponse('{{$epreuve_response->id}}')">
                                            <span class="hidden lg:inline">Rendre acc.</span>
                                            <span class="fas fa-eye"></span>
                                        </span>
                                        <span wire:loading wire:target="unHiddeResponse('{{$epreuve_response->id}}')">
                                            <span>En cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </span>
                                    @else
                                    <span title="Masquer cet élément de réponses" wire:click="hiddeResponse('{{$epreuve_response->id}}')" class="bg-yellow-600 hover:bg-yellow-800 py-2 px-3 text-gray-100 border rounded-lg cursor-pointer">
                                        <span wire:loading.remove wire:target="hiddeResponse('{{$epreuve_response->id}}')">
                                            <span class="hidden lg:inline">Masquer</span>
                                            <span class="fas fa-eye-slash"></span>
                                        </span>
                                        <span wire:loading wire:target="hiddeResponse('{{$epreuve_response->id}}')">
                                            <span>En cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </span>
                                    @endif
                                    <span wire:click="deleteFile('{{$epreuve_response->id}}')" class="bg-red-500 hover:bg-red-700 py-2 px-3 text-gray-100 border rounded-lg cursor-pointer">
                                        <span wire:loading.remove wire:target="deleteFile('{{$epreuve_response->id}}')">
                                            <span class="hidden lg:inline">Suppr.</span>
                                            <span class="fa fa-trash"></span>
                                        </span>
                                        <span wire:loading wire:target="deleteFile('{{$epreuve_response->id}}')">
                                            <span>En cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </span>
                                </span>
                            </td>
                            @endif
                        @endauth
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
