@auth
<div>
    <div class="w-full py-2 px-3 my-3">
        <div class="w-full mx-auto max-w-xl my-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h4 class="text-lg letter-spacing-2 w-full text-gray-200 p-3">
                Profil utilisateur
            </h4>
        </div>
        
        <div class="w-full mx-auto max-w-xl bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
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
                            <a href="{{route('member.profil', ['identifiant' => $user->identifiant])}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil membre</a>
                        </li>
                        @endif
                        @if(__isAdminAs() && !__selfUser($user))
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Supprimer</a>
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
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}"/>
                <h5 class="mb-1 text-xl border-b font-medium text-gray-900 dark:text-white">
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
                    <span>
                        {{ $user->current_function }}
                        <span class="text-orange-500">
                            @if($user && $user->grade) ({{ $user->grade }}) @endif
                        </span>
                    </span>
                </span>
                <div class="mt-2 md:mt-2 w-full mx-auto">
                    <h4 class="text-orange-400 py-2 letter-spacing-2 text-center border-t border-b">
                        {{ $details[$public_section] }}
                    </h4>
                    <div class="flex w-full items-center text-center mx-auto">
                        
                    </div>
                </div>
                <div class="pl-2 py-2 w-full m-0">

                    @if($public_section == 'personnel')

                        <table class="text-gray-100 w-full m-0 p-0">
                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-envelope"></span>
                                    <span>
                                        Mail:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span>{{ $user->email}}</span>
                                </td>
                            </tr>


                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-genderless"></span>
                                    <span>
                                        Sexe:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class=""> {{ $user->getGender() }} </span>
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-person-chalkboard"></span>
                                    <span>
                                        Né le:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->__getDateAsString($user->birth_date) }}</span> @if($user->birth_date && $user->birth_city) <small class="text-yellow-200 float-right mr-2 mt-1 italic"> <b> à {{ $user->birth_city }}</b> </small> @endif
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-phone"></span>
                                    <span>
                                        Contacts:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->contacts }}</span>
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-person-chalkboard"></span>
                                    <span>
                                        Statut:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">Enseignant {{ Str::upper($user->status) }}</span>
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-home"></span>
                                    <span>
                                        Adresse:
                                    </span>
                                </td>
                                <td class="py-1">
                                    Résidant à <span class=""> {{ Str::upper($user->address) }}</span>
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-children"></span>
                                    <span>
                                        Statut matrimonial:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class=""> {{ Str::ucfirst($user->marital_status) }}</span>
                                </td>
                            </tr>
                        </table>
                    
                    @elseif($public_section == 'diplome')

                        <table class="text-gray-100 w-full m-0 p-0">
                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-person-chalkboard"></span>
                                    <span>
                                        Diplôme:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span>{{ $user->graduate}}</span>
                                </td>
                            </tr>


                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-genderless"></span>
                                    <span>
                                        Type:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class=""> {{ $user->graduate_type }} </span>
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-person-chalkboard"></span>
                                    <span>
                                        Obtenu en:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->graduate_year }}</span> 
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-home"></span>
                                    <span>
                                        Délivré par:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->graduate_deliver }}</span>
                                </td>
                            </tr>
                        </table>

                    @elseif($public_section == 'professionnel')

                        <table class="text-gray-100 w-full text-left m-0 p-0">
                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-person-chalkboard"></span>
                                    <span>
                                        Grade:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span>{{ $user->grade}}</span>
                                </td>
                            </tr>


                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-person-circle-check"></span>
                                    <span>
                                        Matricule:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class=""> {{ $user->matricule }} </span>
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-clock"></span>
                                    <span>
                                        Enseignant depuis:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->teaching_since }}</span> 
                                </td>
                            </tr>

                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-home"></span>
                                    <span>
                                        Lieu de travail:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->job_city }}</span>
                                </td>
                            </tr>
                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-school-flag"></span>
                                    <span>
                                        Etablissement:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->school }}</span>
                                </td>
                            </tr>
                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                <td class="py-1">
                                    <span class="fas fa-network-wired"></span>
                                    <span>
                                        Années d'expériences:
                                    </span>
                                </td>
                                <td class="py-1">
                                    <span class="">{{ $user->years_experiences }}</span>
                                </td>
                            </tr>
                        </table>

                    @endif
                </div>
                <div class="flex mt-4 gap-x-2 " wire:loading.remove wire:target="makePublicSection">
                    @foreach ($details as $sec => $name)
                        <div class="@if($sec == $public_section) hidden @endif " wire:click="makePublicSection('{{$sec}}')">
                            <a href="#" class="inline-flex border items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-{{$loop->iteration + 4}}00 rounded-lg hover:bg-blue-{{$loop->iteration + 4}}00 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-{{$loop->iteration + 4}}00 dark:hover:bg-blue-{{$loop->iteration + 4}}00 dark:focus:ring-blue-800">
                                {{ $name }}
                            </a>
                        </div>
                    @endforeach
                    @if($user->id == auth_user()->id)
                        <a href="{{route('user.profil.edition', ['identifiant' => $user->identifiant, 'auth_token' => $user->auth_token])}}" class="py-2 px-4 ms-2 text-sm font-medium focus:outline-none rounded-lg border border-gray-200 hover:bg-red-100 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-success-600 dark:text-gray-100 dark:border-white-600 dark:hover:text-white dark:hover:bg-success-700">
                            <span class="fas fa-edit"></span>
                            Editer
                        </a>
                    @endif
                </div>
                <span wire:loading wire:target="makePublicSection" class="text-center letter-spacing-2 text-yellow-300">
                    <span class="fas fa-rotate animate-spin"></span>
                    <span>Chargement en cours...</span>
                </span>

            </div>
        </div>
    </div>
    @livewire('user.profil-photo-zoomer', ['user' => $user])
    @livewire('user.profil-photo-editor', ['user' => $user])
</div>
@endauth
