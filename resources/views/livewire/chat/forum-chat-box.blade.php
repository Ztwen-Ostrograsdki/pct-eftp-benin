<div>
    <div class="lg:text-lg md:text-base sm:text-sm xs:text-xs">
        <div class="border mx-auto rounded-lg my-1 w-4/5 z-bg-secondary-light p-0">
            <div class="m-0 p-3 w-full">
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
                        <div class="letter-spacing-1 text-gray-500 shadow-1 shadow-sky-500 rounded-xl p-2 mt-3">
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
                    <span class="ml-2 text-green-600 cursor-pointer letter-spacing-1 font-semibold">
                        <span>
                            <span class="fas fa-circle text-green-500 animate-pulse"></span>
                            {{ $onlines_users }}
                            <span class=""> en ligne(s)</span>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="m-auto border rounded-xl my-1 w-4/5 z-bg-secondary-light p-2">
            <div class="p-2">
                <div class="flex flex-col">
                    @foreach ($chats as $chat)
                        @if($chat->notHiddenFor(auth_user()->id))
                            <div wire:key="forum-chat-{{$chat->id}}" class="w-full lg:text-sm  md:text-sm sm:text-xs xs:text-xs ">
                                <div x-on:dblclick="$wire.likeMessage('{{$chat->id}}')" class="rounded-xl group shadow-2 p-2 mb-3 lg:w-3/5 md:w-4/5 sm:w-4/5 xs:w-4/5 cursor-pointer @if($chat->user_id == auth_user()->id) float-end  shadow-purple-400 @else shadow-sky-400  @endif">
                                    <div class="flex items-center gap-x-3 rounded-full md:p-2 sm:p-1 xs:p-1 shadow-2 @if($chat->user_id == auth_user()->id) shadow-purple-400 @else shadow-sky-400 @endif">
                                        <img class="md:w-8 md:h-8 sm:h-4 sm:w-4 xs:h-4 xs:w-4 rounded-full @if($chat->user_id == auth_user()->id) float-right text-right @endif"  src="{{ user_profil_photo($chat->user) }}" alt="user photo">
                                        <h6 class="text-gray-300  md:block xs:hidden sm:hidden letter-spacing-2 float-right text-right">
                                            {{ $chat->user->getFullName() }}
                                        </h6>

                                        <h6 class="text-gray-300 md:hidden sm:block letter-spacing-2 float-right text-right">
                                            {{ $chat->user->firstname }}
                                        </h6>
                                    </div>
                                    <div class="text-gray-400 letter-spacing-2">
                                        <p class="p-2">
                                            {{ $chat->message }}
                                        </p>
                                    </div>

                                    <div class="w-full flex-col">
                                        <div class="w-full transition translate-x-5 ease-out  float-start text-start invisible group-hover:visible group-hover:translate-x-0">
                                            <div class="flex gap-x-2">
                                                <span wire:click="deleteMessage({{$chat->id}})" title="supprimer ce message" class="fas fa-trash text-red-500 hover:scale-125 p-2"></span>

                                                <label for="epreuve-message-input" wire:click="replyToMessage({{$chat->id}})" title="Répondre à ce message" class="fas cursor-pointer fa-reply text-blue-500 hover:scale-125 p-2"></label>

                                                <span wire:click="likeMessage({{$chat->id}})" title="Liker ce message" class="fas fa-heart text-success-500 hover:scale-125 p-2"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex w-full justify-end text-xs">
                                            
                                            @if($chat->likes)
                                            <div class="mr-2">
                                                <span>
                                                    <span  class="text-green-600"> {{ count($chat->likes) }}  </span>
                                                    <span title="{{count($chat->likes)}} personnes ont aimé ce message" class="fas transition ease-in-out fa-heart text-success-500 "></span>
                                                </span>
                                            </div>
                                            @endif
                                            <div class="m-0 p-0">
                                                <small class="text-orange-500 letter-spacing-2 transition translate-x-5 ease-out inline group-hover:hidden group-hover:translate-x-0">
                                                    {{$chat->getDateAgoFormated(true)}}
                                                </small>
                                                <small class="text-orange-500 letter-spacing-2 transition translate-x-5 ease-out hidden group-hover:inline group-hover:translate-x-0">
                                                    Posté le {{$chat->__getDateAsString($chat->created_at, 3, true)}}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="w-full py-1 my-3 px-3 lg:text-sm md:text-sm sm:text-xs">
                <form @submit.prevent class="w-full mx-auto">   
                    <label for="default-message" class="mb-2 font-medium text-gray-900 sr-only dark:text-white">Envoyer</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <span class="w-4 h-4 text-gray-500 fas fa-message dark:text-gray-400" aria-hidden="true" >
                            </span>
                        </div>
                        <input wire:keydown.enter="sendMessage" wire:model.live="message" type="message" id="epreuve-message-input" class=" block w-full p-4 ps-10 letter-spacing-2 border border-gray-300 rounded-lg bg-transparent focus:ring-blue-500 focus:border-blue-500 dark:bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 letter-spacing-1 focus text-gray-400 font-semibold" placeholder="Tapez votre message..." />
                        @if($message !== '' && $message !== null)
                        <span class="gap-x-1 items-center text-white md:inline lg:inline absolute end-2.5 bottom-2.5 focus:ring-4 mb-2 focus:outline-none focus:ring-blue-300 font-medium  ">
                            <span wire:click="sendMessage" class=" bg-blue-700 hover:bg-blue-800 cursor-pointer focus:ring-4 focus:outline-none  px-4 py-2 dark:bg-blue-600 rounded-lg dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">
                                
                                <span class="sm:hidden xs:hidden md:hidden lg:inline xl:inline mr-1">Envoyer</span>
                                <span class="fas fa-paper-plane"></span>
                            </span>
                            <span wire:click="resetMessage" class="ml-1 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg  px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800 cursor-pointer ">
                                <span class="fas fa-trash"></span>
                                <span class="sm:hidden xs:hidden md:hidden lg:inline xl:inline ml-1">Effacer</span>
                            </span>
                        </span>
                        @endif
                    </div>
                </form>
              </div>
        </div>
    </div>
</div>
