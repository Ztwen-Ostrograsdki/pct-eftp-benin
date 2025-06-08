<div>
    @php use Illuminate\Support\Str; @endphp

    <div class="lg:text-lg md:text-base sm:text-sm xs:text-xs">
        <div class="border mx-auto rounded-lg my-1 max-w-6xl z-bg-secondary-light p-0">
            <div class="m-0 p-3 w-full max-w-6xl">
                <h4 class="text-gray-400 letter-spacing-2 shadow-2 p-3 border-b border-sky-500 flex justify-between items-center">
                    <span>
                        <span class="fa fa-message text-sky-500 "></span>
                        Forum de discussion et d'échanges
                    </span>

                    @if(session()->has('typing'))
                        <div class="">
                            <h6 class="text-xs letter-spacing-1 text-yellow-500 float-right text-right font-semibold animate-pulse"> {{session('typing')}} est entrain d'écrire... </h6>
                        </div>
                    @endif
                </h4>
                @if($active_chat_subject)
                    <div class="mx-auto p-2">
                        <h6 wire:click='toggleSubject' class="text-sky-500 letter-spacing-2 font-semibold cursor-pointer mb-4">
                            Sujet de discussion en cours 

                            @if($subject_show)
                            <span wire:click='toggleSubject' title="Masquer le sujet de discussion" class="p-2 cursor-pointer">
                                <span class="fas fa-eye-slash"></span>
                            </span>
                            @else
                            <span wire:click='toggleSubject' title="Afficher le sujet de discussion" class="p-2 cursor-pointer">
                                <span class="fas fa-eye"></span>
                            </span>
                            @endif

                            <span wire:click='deleteSubject' title="Fermer cette discussion" class="ml-2 shadow-2 shadow-sky-500 text-orange-400 p-1 px-4 group  rounded-lg cursor-pointer">
                                <span wire:loading.remove wire:target='deleteSubject' class="fas fa-lock inline transition ease-in-out group-hover:hidden"></span>
                                <span wire:loading.remove wire:target='deleteSubject' class="fas fa-unlock hidden transition ease-in-out group-hover:inline"></span>
                                <span wire:loading wire:target='deleteSubject' class="fas fa-rotate animate-spin"></span>
                                <span wire:loading.remove wire:target='deleteSubject' class="text-xs md:inline lg:inline xl:inline sm:hidden xs:hidden">Fermer cette discussion</span>

                            </span>
                        </h6>
                        @if($subject_show)
                        <div class="letter-spacing-1 text-gray-500 shadow-1 shadow-sky-500 rounded-xl p-2 mt-3 ">
                            <div title="Double-cliquez pour aimer ce topic" x-on:dblclick="$wire.likeSubject" class="mb-2 group cursor-pointer">
                                <div class="flex justify-between">
                                    <span class="text-sky-300">
                                        {{ $active_chat_subject->subject }}
                                    </span>

                                    @if($active_chat_subject->likes)
                                    <div class="mr-2">
                                        <span>
                                            <span  class="text-green-600"> {{ count($active_chat_subject->likes) }}  </span>
                                            <span title="{{count($active_chat_subject->likes)}} personnes ont aimé ce message" class="fas transition ease-in-out fa-heart text-success-500 "></span>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                <div class="transition translate-x-5 ease-out text-start invisible group-hover:visible group-hover:translate-x-0">
                                    <div class="flex gap-x-2">
                                        <span wire:click="likeSubject" title="Liker ce topic" class="fas fa-heart text-orange-500 hover:scale-125 p-2"></span>
                                    </div>
                                </div>
                            </div>
                            <hr class="w-full m-0 p-0 border-sky-700 bg-sky-700 text-sky-700">
                            <div class="flex justify-between gap-x-2 letter-spacing-1 font-semibold ">
                                <div class="flex justify-end gap-x-2 letter-spacing-1 font-semibold ">
                                    <small class="text-sky-500">
                                        Ce sujet sera fermé le 
                                    </small>
                                    <small class="text-sky-600">
                                        {{ $active_chat_subject->__getDateAsString($active_chat_subject->updated_at, 3, true); }}
                                    </small>
                                </div>
                                <div>
                                    <small class="text-orange-500 ">
                                        Posté par:
                                    </small>
                                    <small class="text-yellow-600">
                                        {{ $active_chat_subject->user->getFullName() }}
                                    </small>
                                </div>
                            </div>
                            
                        </div>
                        @endif
                    </div>
                @else
                <div class="mx-auto p-2">
                    <h6 title="Créer un sujet de discussion sur le forum, attirer l'attention de tous sur une préoccupation et fermer votre discussion à tout moment!" wire:click='addNewChatSubject' class="text-sky-700 rounded-lg letter-spacing-2 font-semibold inline-block px-3 py-2 shadow-2 shadow-sky-600 cursor-pointer hover:text-sky-400 hover:bg-sky-900">
                        Lancer un sujet de discussion

                        <span class="fas fa-plus"></span>
                        
                    </h6>
                </div>
                @endif
                <div class="flex justify-end " title="Cliquer pour voir la liste de ceux qui sont connectés présentement">
                    <a href="#" title="Afficher les enseignants ou membres connectés"  class="ml-2 lg:text-sm xl:text-sm md:text-sm sm:text-xs xs:text-xs text-green-600 letter-spacing-1 font-semibold" data-drawer-target="drawer-online-users" data-drawer-hide="drawer-online-users" data-drawer-show="drawer-online-users" aria-controls="drawer-online-users" data-drawer-backdrop="false" data-drawer-placement="right" data-drawer-body-scrolling="true" type="button">
                        <span>
                            <span class="fas fa-circle text-green-500 animate-pulse"></span>
                            Voir ceux qui sont
                            <span class=""> en ligne(s)</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        @php
            // dd($allMessages);
        @endphp

        <div class="m-auto border rounded-xl my-1 max-w-6xl z-bg-secondary-light p-2">
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
            
            <div class="w-full py-1 my-3 px-3 lg:text-sm md:text-sm sm:text-xs">
                @if($targeted_message_id)
                    <div class="bg-gray-400 letter-spacing-1 font-semibold text-sm xs:text-xs px-4 z-50 mb-1 rounded-lg inline-block py-1 w-auto">
                        <span class="text-yellow-300 flex items-center gap-x-3">
                            <span class="fas fa-reply"></span>
                            Répondre au message envoyé par {{ Str::substr($targeted_message->user->getFullName(), 0, 8) }} ...
                            <span wire:click='cancelReply' title="Annuler la réponse au message" class="p-2 text-white border bg-red-500 rounded-md hover:bg-red-300 mr-5 cursor-pointer">Annuler</span>
                        </span>
                        <span class="px-3">
                            {{ Str::substr($targeted_message->message, 0, 200) }} ...
                        </span>
                        
                    </div>
                @endif

                <form @submit.prevent class="w-full mx-auto">   
                    <label for="default-message" class="mb-2 font-medium text-gray-900 sr-only dark:text-white">Envoyer</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <span class="w-4 h-4 text-gray-500 fas fa-message dark:text-gray-400" aria-hidden="true" >
                            </span>
                        </div>
                        <input
                            type="file"
                            wire:model.live="file"
                            class="hidden bg-transparent"
                            id="fileInput"
                        >
                        <input wire:keydown.enter="sendMessage" wire:model.live="message" type="message" id="epreuve-message-input" class=" block w-full p-4 ps-10 letter-spacing-2 border border-gray-300 rounded-lg bg-transparent focus:ring-blue-500 focus:border-blue-500 dark:bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 letter-spacing-1 focus text-gray-400 font-semibold sm:pr-32 md:pr-32 xs:pr-32 lg:pr-60" placeholder="Tapez votre message..." />
                       
                        <span class="gap-x-1 items-center text-white md:inline lg:inline absolute end-2.5 bottom-2.5 focus:ring-4 mb-2 focus:outline-none focus:ring-blue-300 font-medium ">
                            <span class="">
                                <label title="Envoyez un fichier" for="fileInput" class="ml-1 bg-transparent hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg  px-4 py-2  cursor-pointer">
                                    <span class="fa-solid fa-paperclip text-gray-400 font-semibold"></span>
                                </label>
                            </span>
                            @if($message !== '' && $message !== null)
                            <span wire:click="sendMessage" class=" bg-blue-700 hover:bg-blue-800 cursor-pointer focus:ring-4 focus:outline-none  px-4 py-2 dark:bg-blue-600 rounded-lg dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">
                                
                                <span class="sm:hidden xs:hidden md:hidden lg:inline xl:inline mr-1">Envoyer</span>
                                <span class="fas fa-paper-plane"></span>
                            </span>
                            <span wire:click="resetMessage" class="ml-1 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg  px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800 cursor-pointer ">
                                <span class="fas fa-trash"></span>
                                <span class="sm:hidden xs:hidden md:hidden lg:inline xl:inline ml-1">Effacer</span>
                            </span>
                            @endif
                        </span>
                    </div>
                </form>
              </div>
        </div>
    </div>
</div>
