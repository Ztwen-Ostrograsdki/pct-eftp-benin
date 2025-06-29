<div class="p-2">
    <div class="flex flex-col">
        @foreach($allMessages as $date => $chats)

            @if(\Carbon\Carbon::parse($date)->isToday())
                <h6 class="text-center py-1 text-xs my-2 border-y-2 border-y-gray-600 letter-spacing-2"> Aujourd'hui </h6>
            @elseif(\Carbon\Carbon::parse($date)->isYesterday())
                <h6 class="text-center py-1 text-xs my-2 border-y-2 border-y-gray-600 letter-spacing-2"> Hier </h6>
            @else
                <h6 class="text-center py-1 text-xs my-2 border-y-2 border-y-gray-600 letter-spacing-2">  {{__formatDate($date)}} </h6>
            @endif

            @foreach ($chats as $chat)
                @if($chat->notHiddenFor(auth_user()->id))
                    <div wire:key="forum-chat-{{$chat->id}}" class="w-full lg:text-sm  md:text-sm sm:text-xs xs:text-xs mb-4">
                        <div x-on:dblclick="$wire.likeMessage('{{$chat->id}}')" class="flex items-start @if($chat->user_id == auth_user()->id) float-end chat-message-of-self @else chat-message-of-other  @endif cursor-pointer gap-2.5 gap-y-3 ">
                            <img class="w-8 h-8 rounded-full" src="{{user_profil_photo($chat->user)}}" alt="Jese image">
                            <div class="flex flex-col gap-1 w-full max-w-[320px]">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $chat->user->getFullName() }}
                                    </span>
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    
                                    </span>
                                </div>
                                <div class="flex flex-col leading-1.5 p-4 border-gray-200 rounded-e-xl rounded-es-xl @if($chat->user_id == auth_user()->id) bg-indigo-700  @else bg-gray-500  @endif ">
                                    <p class="text-sm font-normal text-gray-900 dark:text-white"> 
                                        {{ $chat->message }}
                                        @if($chat->hasFile())
                                            <div class="flex mt-2 justify-end">
                                                <div class="flex cursor-pointer items-center justify-between bg-gray-800 text-white rounded-xl p-3 w-full max-w-md ">
                                                    <div class="flex items-center gap-3">
                                                        @if(is_image($chat->file_extension))
                                                            <a title="Cliquer sur l'image pour la Télécharger" href="{{forum_image($chat)}}" download class="flex flex-col">
                                                                <img  class="border transition-transform duration-300 hover:scale-150 rounded shadow object-cover" src="{{forum_image($chat)}}" alt="{{$chat->file}}">
                                                                <div class="flex flex-col text-center">
                                                                    <p class="font-semibold text-sm truncate">
                                                                        {{ $chat->file . '' . $chat->file_extension }} 
                                                                    </p>
                                                                    <p class="text-xs text-gray-400"> {{ $chat->file_size }} • Image • ({{ str_replace('.', '', $chat->file_extension) }})</p>
                                                                </div>
                                                            </a>
                                                        @else
                                                            <div class="flex gap-x-2" title="Télécharger le document" wire:click='downloadTheFile({{$chat->id}})'>
                                                                @if(strtoupper(str_replace('.', '', $chat->file_extension)) == 'PDF')
                                                                <img src="{{asset('images/pdf-ico.png')}}" alt="PDF" class="w-6 h-6 mt-1">
                                                                @elseif(strtoupper(str_replace('.', '', $chat->file_extension)) == 'DOCX')
                                                                <img src="{{asset('images/docx-ico-3.png')}}" alt="DOCX" class="w-6 h-6 mt-1">
                                                                @endif
                                                                <div>
                                                                    <p class="font-semibold text-sm truncate">
                                                                        {{ $chat->file }} 
                                                                    </p>
                                                                    <p class="text-xs text-gray-400"> {{ $chat->file_pages }} Page(s) • {{ $chat->file_size }} • {{ $chat->file_extension }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs font-normal text-gray-500 dark:text-gray-400 text-right float-right">
                                    @if($chat->likes)
                                    <div class="mr-2">
                                        <span class="">
                                            <span  class="text-green-600"> {{ count($chat->likes) }}  </span>
                                            <span title="{{count($chat->likes)}} personnes ont aimé ce message" class="fas transition ease-in-out fa-heart text-success-500 "></span>
                                        </span>
                                    </div>
                                    @endif
                                    {{ __formatDateTime($chat->created_at) }}
                                </span>
                            </div>
                            <button id="dropdownMenuIconButton{{$chat->id}}" data-dropdown-toggle="dropdownDots{{$chat->id}}" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600" type="button">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                </svg>
                            </button>
                            <div id="dropdownDots{{$chat->id}}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-40 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton{{$chat->id}}">
                                    <li>
                                        <span for="epreuve-message-input" wire:click="replyToMessage({{$chat->id}})" title="Répondre à ce message" class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Repondre</span>
                                    </li>
                                    <li>
                                        <span  class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copié</span>
                                    </li>
                                    <li>
                                        <span  class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Signaler</span>
                                    </li>
                                    <li>
                                        <span  wire:click="deleteMessage({{$chat->id}})" title="supprimer ce message"   class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Supprimer</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
    @if ($pdfPreviewPath)
        @php
            $file_size = "0 Ko";

            $ext = strtoupper($file->extension());

            $name = string_cutter(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 30);

            if($file->getSize() >= 1048580){

                $file_size = number_format($file->getSize() / 1048576, 2) . ' Mo';

            }
            else{

                $file_size = number_format($file->getSize() / 1000, 2) . ' Ko';

            }
        @endphp 
        <div class="flex justify-end">
            <div class="flex items-center justify-between bg-gray-800 text-white rounded-xl p-3 w-full max-w-md ">
                @if(!is_image($ext))
                <div class="flex items-center gap-3">
                    @if($file->getClientOriginalExtension() === 'pdf')
                    <img src="{{asset('images/pdf-ico.png')}}" alt="PDF" class="w-6 h-6 mt-1">
                    @elseif($file->getClientOriginalExtension() === 'docx')
                    <img src="{{asset('images/docx-ico-3.png')}}" alt="DOCX" class="w-6 h-6 mt-1">
                    @endif
                    
                    <div>
                        <p class="font-semibold text-sm truncate">
                            {{ $name }} 
                        </p>
                        <p class="text-xs text-gray-400"> {{ $total_pages }} Page(s) • {{ $file_size }} • {{ $ext }}</p>
                    </div>
                </div>
                @else
                <div class="flex items-center flex-col gap-y-2">
                    <img class="border h-40 w-52" src="{{$file->temporaryUrl()}}" alt="">
                    <div class="text-center">
                        <p class="font-semibold text-sm truncate">
                            {{ $name }} 
                        </p>
                        <p class="text-xs text-gray-400">{{ $file_size }} • {{ $ext }}</p>
                    </div>
                </div>
                @endif
                <span class="flex gap-x-3">
                    <span wire:click='sendMessage' title="Envoyez" class="fas fa-upload cursor-pointer hover:bg-gray-900 p-2 rounded-lg"></span>
                    <span wire:click='deleteFile' title="Annuler" class="fas fa-trash text-red-500 cursor-pointer hover:bg-gray-900 p-2 rounded-lg"></span>
                </span>
            </div>
        </div>
    @endif

    <div class="text-sm flex justify-end w-full" wire:loading wire:target='file'>
        <div class=" bg-gray-800 text-white w-auto float-right rounded-xl p-3">
            <span>Chargement du fichier en cours...</span>
            <span class="fas fa-rotate animate-spin"></span>
        </div>
    </div>
</div>