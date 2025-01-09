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
                            @if(!$user->email_verified_at)
                            <li>
                                <a wire:click='confirmedUserEmailVerification' href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    {{ $user->email_verified_at ? "Marquer email non vérifié" : "Marquer email vérifié" }}
                                </a>
                            </li>
                            @endif
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
                    <span> 
                        @if($user->contacts)
                            {{ $user->contacts }}
                        @else
                            <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                        @endif
                    </span>
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

                <div class="w-full p-2">
                    <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 rounded-full px-3 my-3 text-blue-500" data-inactive-classes="text-gray-500 dark:text-gray-400">
                        <h2 id="accordion-flush-heading-1 px-3 ">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium  text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-1" aria-expanded="false" aria-controls="accordion-flush-body-1">
                                <span>Détails civilités</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                            <div class="py-5 border rounded-xl px-3 mt-1 border-gray-200 dark:border-gray-700">
                                <table class="text-gray-100 w-full m-0">
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
                                            <span class="">
                                                @if($user->contacts)
                                                    {{ $user->contacts }}
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">
                                                        Non renseigné
                                                    </small>
                                                @endif
                                            </span>
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
                                            <span>
                                            @if($user->status)
                                                Enseignant {{ Str::upper($user->status) }}
                                            @else
                                                <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                            @endif
                                            </span>
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
                                            <span>
                                            @if($user->address)
                                                Résidant à {{ Str::upper($user->address) }}
                                            @else
                                                <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                            @endif
                                            </span>
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
                                            <span>
                                            @if($user->marital_status)
                                                {{ Str::ucfirst($user->marital_status) }}
                                            @else
                                                <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                            @endif
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h2 id="accordion-flush-heading-2">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                                <span>Détails Diplôme</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                            <div class="py-5 border rounded-xl px-3 mt-1 border-gray-200 dark:border-gray-700">
                                <table class="text-gray-100 w-full m-0 p-0">
                                    <tr class=" cursor-pointer w-full border-b border-gray-700">
                                        <td class="py-1">
                                            <span class="fas fa-person-chalkboard"></span>
                                            <span>
                                                Diplôme:
                                            </span>
                                        </td>
                                        <td class="py-1">
                                            <span>
                                            @if($user->graduate)
                                                {{ $user->graduate }} 
                                            @else
                                                <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                            @endif
                                            </span>
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
                                            <span>
                                            @if($user->graduate_type)
                                                {{ $user->graduate_type }} 
                                            @else
                                                <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                            @endif
                                            </span>
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
                                            <span>
                                                @if($user->graduate_year)
                                                    {{ $user->graduate_year }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
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
                                            <span>
                                                @if($user->graduate_deliver)
                                                    {{ $user->graduate_deliver }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h2 id="accordion-flush-heading-3">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                                <span>Détails professionnel</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                            <div class="py-5 border rounded-xl px-3 mt-1 border-gray-200 dark:border-gray-700">
                                <table class="text-gray-100 w-full text-left m-0 p-0">
                                    <tr class=" cursor-pointer w-full border-b border-gray-700">
                                        <td class="py-1">
                                            <span class="fas fa-person-chalkboard"></span>
                                            <span>
                                                Grade:
                                            </span>
                                        </td>
                                        <td class="py-1">
                                            <span>
                                                @if($user->grade)
                                                    {{ $user->grade }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
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
                                            <span>
                                                @if($user->matricule)
                                                    {{ $user->matricule }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
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
                                            <span>
                                                @if($user->teaching_since)
                                                    {{ $user->teaching_since }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span> 
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
                                            <span>
                                                @if($user->job_city)
                                                    {{ $user->job_city }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class=" cursor-pointer w-full border-b border-gray-700 text-sky-500">
                                        <td class="py-1">
                                            <span class="fas fa-school-flag"></span>
                                            <span>
                                                Lycée:
                                            </span>
                                        </td>
                                        <td class="py-1">
                                            <span>
                                                @if($user->school)
                                                    {{ $user->school }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class=" cursor-pointer w-full border-b border-gray-700">
                                        <td class="py-1 text-yellow-400">
                                            <span class="fas fa-school-flag"></span>
                                            <span>
                                                Vient de l'enseignement général (CEG)
                                            </span>
                                        </td>
                                        <td class="py-1">
                                            <span>
                                                @if($user->from_general_school)
                                                    <span class="fas fa-check text-success-600 mr-2"></span> {{ 'OUI' }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non</small>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class=" cursor-pointer w-full border-b border-gray-700 text-yellow-500">
                                        <td class="py-1">
                                            <span class="fas fa-school-flag"></span>
                                            <span>
                                                CEG de provénance:
                                            </span>
                                        </td>
                                        <td class="py-1">
                                            <span>
                                                @if($user->general_school)
                                                    {{ $user->general_school }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
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
                                            <span>
                                                @if($user->years_experiences)
                                                    {{ $user->years_experiences }} 
                                                @else
                                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
  
                <div class="flex mt-4 gap-x-2 " wire:loading.remove wire:target="makePublicSection">
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
    <div>
        @livewire('user.profil-photo-zoomer', ['user' => $user])
        @livewire('user.profil-photo-editor', ['user' => $user])
    </div>
</div>
@endauth
