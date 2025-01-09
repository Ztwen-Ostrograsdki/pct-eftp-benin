<div>
    <div class="lg:text-lg md:text-base sm:text-sm xs:text-xs">
        <div class="m-auto border rounded-full my-1 w-4/5 z-bg-secondary-light-opac p-0">
            <div class="m-0 p-3 w-full">
                <h4 class="text-lg text-gray-400 border shadow-2 shadow-sky-400 rounded-full p-3 border-gray-400">
                    <span class="fa fa-message text-sky-500"></span>
                    Forum de discussion et d'échanges
                </h4>
            </div>
        </div>

        <div class="m-auto border rounded-xl my-1 w-4/5 z-bg-secondary-light-opac  p-2">
            <div class="p-2">
                <div class="flex flex-col">
                    <div class="w-full lg:text-sm  md:text-sm sm:text-xs xs:text-xs">
                        <div class="rounded-xl p-2 mb-3 lg:w-3/5 md:w-4/5 sm:w-4/5 xs:w-4/5 float-start shadow-2 shadow-sky-400">
                            <div class="flex items-center gap-x-3 rounded-full p-2 shadow-2 shadow-sky-400">
                                <img class="w-8 h-8 rounded-full" src="{{ user_profil_photo(auth_user()) }}" alt="user photo">
                                <h6 class="text-gray-300 letter-spacing-2 ">
                                    {{ auth_user_fullName() }}
                                </h6>
                            </div>
                            <div class="text-gray-400 letter-spacing-2">
                                <p class="p-2">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aspernatur commodi officiis voluptate delectus in perspiciatis optio id eaque aliquid et asperiores tempore at qui accusantium aperiam, voluptatem laudantium ad.
                                </p>
                            </div>
                            <div class="flex justify-end text-xs">
                                <span class="text-orange-500 letter-spacing-2">
                                    Envoyé le 02 Jan 2025 à 12H 45'
                                </span>
                            </div>

                        </div>

                        <div class="rounded-xl p-2 lg:w-3/5 md:w-4/5 sm:w-4/5 xs:w-4/5 float-end shadow-2 mb-3  shadow-purple-400">
                            <div class="flex items-center justify-end gap-x-3 rounded-full p-2 shadow-2 shadow-purple-400">
                                <h6 class="text-gray-300 letter-spacing-2 float-right text-right">
                                    {{ auth_user_fullName() }}
                                </h6>
                                <img class="w-8 h-8 rounded-full float-right text-right" src="{{ user_profil_photo(auth_user()) }}" alt="user photo">
                            </div>
                            <div class="text-gray-400 letter-spacing-2">
                                <p class="p-2">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aspernatur commodi officiis voluptate delectus in perspiciatis optio id eaque aliquid et asperiores tempore at qui accusantium aperiam, voluptatem laudantium ad.
                                </p>
                            </div>
                            <div class="flex justify-end text-xs">
                                <span class="text-orange-500 letter-spacing-2">
                                    Envoyé le 02 Jan 2025 à 12H 45'
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full py-1 my-3 px-3 lg:text-sm md:text-sm sm:text-xs">
                <form class="w-full mx-auto">   
                    <label for="default-message" class="mb-2 font-medium text-gray-900 sr-only dark:text-white">Envoyer</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <span class="w-4 h-4 text-gray-500 fas fa-message dark:text-gray-400" aria-hidden="true" >
                            </span>
                        </div>
                        <input wire:model.live="message" type="message" id="epreuve-message" class=" block w-full p-4 ps-10 letter-spacing-2 text-gray-900 border border-gray-300 rounded-lg bg-transparent focus:ring-blue-500 focus:border-blue-500 dark:bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 focus" placeholder="Tapez votre message..." />
                        @if(!$message)
                        <span wire:click="sendMessage" class="text-white md:inline lg:inline absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ">
                            Envoyer
                            <span class="ml-2 fas fa-paper-plane"></span>
                        </span>
                        @else
                        <span wire:click="resetMessage" class="text-white md:inline lg:inline absolute end-2.5 bottom-2.5 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800 cursor-pointer ">Effacer</span>
                        @endif
                    </div>
                </form>
              </div>
        </div>
    </div>
</div>
