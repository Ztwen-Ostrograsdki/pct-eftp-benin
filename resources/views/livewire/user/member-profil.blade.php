<div>
    @if($user && $member && $member->role)
    <div class="w-full py-2 my-3">
        <div class="w-full mx-auto max-w-lg my-2 bg-blue-900 border border-gray-100 rounded-lg shadow dark:bg-blue-900 dark:border-gray-100">
            <h4 class="text-lg letter-spacing-2 w-full text-gray-200 p-3 uppercase font-semibold text-center">
                {{ $member->role->name }}
            </h4>
        </div>
        <div class="w-full mx-auto max-w-lg bg-blue-900 border border-gray-100 rounded-lg shadow dark:bg-blue-900 dark:border-gray-100">
            <div class="flex justify-end px-4 pt-4">
                <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-56 dark:bg-gray-700">
                    <ul class="py-2" aria-labelledby="dropdownButton">
                        @if(__selfUser($user))
                            <li>
                                <a href="{{route('user.profil.edition', ['identifiant' => $user->identifiant, 'auth_token' => $user->auth_token])}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editer</a>
                            </li>
                            <li>
                                <a data-modal-target="user-profil-photo-edition" data-modal-toggle="user-profil-photo-edition" type="button" title="Changer votre photo de profil" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Changer photo de profil</a>
                            </li>
                        @endif
                        <li>
                            <a data-modal-target="user-profil-photo-zoomer" data-modal-toggle="user-profil-photo-zoomer" type="button" title="Zoomer la photo de profil" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Zoomer la photo de profil</a>
                        </li>
                        @if($user->member)
                        <li>
                            <a href="{{route('user.profil', ['identifiant' => $user->identifiant])}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil utilisateur</a>
                        </li>
                        @endif
                        @if(__isAdminAs() && $user->member)
                            <li>
                                <a href="#" wire:click="$dispatch('OpenMemberModalForEditEvent', {member_id: {{$user->member->id}}})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Choisir un nouveau membre</a>
                            </li>
                            <li>
                                <a wire:click='removeUserFormMembers' href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Supprimer</a>
                            </li>
                            <li>
                                <a wire:click='confirmedUserBlockOrUnblocked' href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    {{ $user->blocked ? "DéBloquer" : "Bloquer" }}
                                </a>
                            </li>
                            @if(!$user->confirmed_by_admin)
                            <li>
                                <a wire:click='confirmedUserIdentification' href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Confirmer l'identification</a>
                            </li>
                            @endif
                            <li>
                                <a wire:click='confirmedUserEmailVerification' href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    {{ $user->email_verified_at ? "Marquer email non vérifié" : "Marquer email vérifié" }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                
            </div>
            <div class="flex flex-col items-center pb-10 px-2">
                <img class="w-24 h-24 mb-3 border border-gray-100 rounded-full shadow-lg" src="{{user_profil_photo($user)}}" alt="Photo de profil de {{ $user->getFullName() }}"/>
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                    {{ $user->getFullName(true) }}
                </h5>
                <span class="text-sm text-yellow-500 letter-spacing-2 dark:text-yellow-400">
                    <span class="fas fa-envelope"></span>
                    <span>{{ $user->email }}</span>
                </span>
                <span class="text-sm text-yellow-800 letter-spacing-2 dark:text-yellow-400">
                    <span class="fas fa-phone"></span>
                    <span>{{ $user->contacts }}</span>
                </span>
                <span class="text-sm text-green-300 dark:text-green-300">
                    <span class="fas fa-user"></span>
                    <span>{{ $member->role->name }}</span>
                </span>
                <div class="m-0 p-0 mx-auto mt-4 mb-2">
                    @if($user->member)
                        <h6 wire:click="downloadMyCard" class="m-0 p-0 font-semibold letter-spacing-1 cursor-pointer">
                            <span class=" px-4 py-2 bg-green-600 text-gray-900 hover:bg-green-500">
                                <span wire:loading wire:target='downloadMyCard'>
                                    <span>Téléchargement en cours...</span>
                                    <span class="fas fa-rotate animate-spin"></span>
                                </span>
                                <span wire:loading.remove wire:target='downloadMyCard'>
                                    <span class="mr-2 fa fa-download"></span>
                                    <span>Télécharger ma carte</span>
                                </span>
                            </span>
                        </h6>
                    @endif
                </div>
                <div class="mt-2 md:mt-2 w-full mx-auto">
                    <h4 class="text-orange-400 py-2 letter-spacing-2 text-center border-t border-b">Prérogatives</h4>
                    <div class="flex w-full items-center text-center mx-auto">
                        <ul class="flex w-full flex-col gap-y-2">
                            @foreach ($member->tasks as $task)
                            <li class="ucfirst text-lg w-full text-center text-orange-200"> 
                                <span class="fas fa-check"></span>
                                <span>{{ $task }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="flex mt-4 md:mt-6 justify-center gap-x-2">
                    <a href="{{route('member.payments', ['identifiant' => auth_user()->identifiant])}}" class="inline-flex  border items-center px-4 py-2 text-sm font-medium text-center text-white bg-green-800 rounded-lg hover:bg-green-700 ">
                        Mes cotisations
                    </a>
                    <a href="{{route('member.quotes', ['identifiant' => auth_user()->identifiant])}}" class="inline-flex  border items-center px-4 py-2 text-sm font-medium text-center text-white  bg-purple-900 rounded-lg hover:bg-purple-700 ">
                        Mes citations
                    </a>
                    <a href="#" class="inline-flex  border items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 ">
                        Notifier
                    </a>
                    <a wire:click='removeUserFormMembers' href="#" class="py-2 px-4 text-sm font-medium focus:outline-none rounded-lg border border-gray-200 hover:bg-red-100 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-red-600 dark:text-gray-100 dark:border-white-600 dark:hover:text-white dark:hover:bg-red-700">
                        <span wire:loading.remove wire:target='removeUserFormMembers'>Supprimer</span>
                        <span wire:loading wire:target='removeUserFormMembers'>
                            <span>En cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div>
        @livewire('user.profil-photo-zoomer', ['user' => $user])
        @livewire('user.profil-photo-editor', ['user' => $user])
    </div>
    @endif
</div>