<div class="p-2">
    <div class="m-auto my-1 w-full z-bg-secondary-light min-h-80 p-2">
        <div class="m-auto bg-gray-700 p-0 my-3">
            <h1 class="p-4 text-gray-300 flex items-center justify-between border uppercase text-center rounded-sm">
                <span class="text-xs letter-spacing-2">
                    <span class="">
                        Administration :
                    </span>
    
                    <strong class="text-gray-200">
                        Gestion des enseignants 
                        @if ($users)
                        <br>
                        <small class="text-orange-600"> {{ numberZeroFormattor(count(getTeachers())) }} enseignants inscrits</small>
                        @endif
                    </strong>
                </span>

                <div class="flex gap-x-2">
                    
                </div>
            </h1>
        </div>

        <div class="relative w-full overflow-x-auto p-2 shadow-md border sm:rounded-lg">
            <div class="m-auto  w-full py-1 my-3">
                <form class="w-full mx-auto">   
                    <label for="search-from-users-list" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Rechercher</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input wire:model.live="search" type="search" id="search-from-users-list" class="z-bg-secondary-light letter-spacing-1 block w-full p-4 ps-10 text-sm text-sky-300 border border-gray-300 rounded-lg  focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entrer un mot clé, Pseudo, Nom, Prenoms, Email, grade, établissement, contacts, addresse, ville, département..." required />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Rechercher</button>
                    </div>
                </form>
            </div>
            
            <table class="w-full xs:text-xs text-left border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400">
                
                @if(count($users) > 0)
                <thead class="text-xs text-gray-900 lg:uppercase md:uppercase sm:lowercase bg-gray-50 dark:bg-blue-900 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            N°
                        </th>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                           Nom et Prénoms
                           (Email)
                        </th>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            Lycée
                        </th>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            Statut
                        </th>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            CEG de provénance
                        </th>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            Inscrit depuis
                        </th>
                        
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            Utilisateur
                        </th>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            De/Bloquer
                        </th>
                        <th scope="col" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-3 md:py-1">
                            Options
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr wire:key="list-users-admin-{{$user->id}}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </th>
                        <td class="px-6 py-4">
                            <span class="flex gap-x-2 items-center">
                                <img class="w-8 h-8 rounded-full" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}">
                                <a title="Charger le profil de {{$user->getFullName()}}" class="" href="{{ route('user.profil', ['identifiant' => $user->identifiant]) }}">
                                    {{$user->getFullName()}} 
                                </a>
                            </span>
                        </td>
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1 @if(!$user->school) text-orange-400 @endif">
                            {{ $user->formatString($user->school) }}

                            <small class="text-orange-500 letter-spacing-2 @if(!$user->job_city) hidden @endif">
                                ({{ $user->job_city }})
                            </small>
                        </td>
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1  @if($user->status) uppercase @else text-orange-400 @endif">
                            {{$user->formatString($user->status)}}
                        </td>
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1 ">
                            @if($user->from_general_school)
                                <span>Vient du CEG</span>
                                {{ 
                                    $user->general_school ? $user->user->general_school : 'Non renseigné'
                                }}
                            @else
                                <span>Ne vient pas du CEG</span>
                            @endif
                        </td>
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1">
                            <span>
                                <span class="flex flex-col">
                                    <span>
                                        <small class="fas fa-circle mr-1"></small>
                                        Inscrit le
                                    </span>
                                    <span>
                                        {{$user->__getDateAsString($user->created_at)}}
                                    </span>
                                </span>
                            </span>
                            
                            <span>
                                <span>
                                    @if($user->email_verified_at)
                                    <span class="flex flex-col">
                                        <span>
                                            <small class="fas fa-circle mr-1"></small>
                                            <span>Email confirmé </span>
                                        </span>
                                        <span>
                                            le {{ $user->__getDateAsString($user->email_verified_at) }}
                                        </span>
                                    </span>
                                    @else
                                        <span wire:click.prevent="confirmedUserEmailVerification({{$user->id}})" class="text-red-600" title="{{ $user->getFullName() }} n'a pas encore confirmé son addresss mail. Cliquer pour lancer manuellement la confirmation de ce compte.">
                                            <strong class="fas fa-user-xmark text-red-700 mr-2"></strong>
                                            <span>Nom confirmé</span>
                                        </span>
                                    @endif
                                </span>
                            </span>
                        </td>
                        
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1">
                            <span wire:click.prevent="confirmedUserIdentification({{$user->id}})" @if(!$user->confirmed_by_admin) title="Cliquer pour confirmer l'identification de {{ $user->getFullName() }}" @endif>
                                <span class=" @if($user->confirmed_by_admin) fas fa-user-check text-green-600 @else fas fa-user-slash text-red-500 @endif"></span>
                                <span class="@if($user->confirmed_by_admin) text-green-600 @else text-red-500 @endif">{{$user->confirmed_by_admin ? 'identifié' : 'non identifié'}}</span>
                            </span>
                        </td>

                        <td title="Cliquer pour exécuter l'action" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1">
                            <span wire:click.prevent="confirmedUserBlockOrUnblocked({{$user->id}})">
                                @if($user->blocked)
                                    <span class=" fas fa-unlock text-green-700"></span>
                                    <span> Débloquer {{ $user->getFilamentName() }} </span>
                                @else
                                    <span class=" fas fa-user-lock text-red-700"></span>
                                    <span> Bloquer {{ $user->getFilamentName() }} </span>
                                @endif
                            </span>
                        </td>
                        
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1">
                            
                            <div class="flex justify-end px-4 pt-4">
                                <button id="dropdownButton-{{$user->id}}" data-dropdown-toggle="dropdown-{{$user->id}}" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg p-1.5" type="button">
                                    <span class="sr-only">Open dropdown</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown-{{$user->id}}" class="z-10 hidden lg:text-sm sm:text-xs md:text-xs xs:text-xs list-none bg-white divide-y divide-gray-100 rounded-lg shadow-2 shadow-sky-500 w-56 z-bg-secondary-light border border-sky-500">
                                    <ul class="py-2" aria-labelledby="dropdownButton-{{$user->id}}">
                                        <li>
                                            <a href="#" class="block px-4 py-2  text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                <span class="fas fa-user"></span>
                                                <b>{{ $user->getFilamentName() }}</b>
                                                <br>
                                                <small class="text-orange-400">
                                                    {{ $user->email }}
                                                </small>
                                            </a>
                                        </li>
                                        
                                        <li class="hidden">
                                            <a href="#" class="block px-4 py-2  text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white text-wrap">
                                                Opérations sur
                                                <br>
                                                <span class="fas fa-user"></span>
                                                <b>{{ $user->pseudo }}</b>
                                                <br>
                                                <small class="text-orange-400">
                                                    {{ $user->email }}
                                                </small>
                                            </a>
                                        </li>
                                        @if(__selfUser($user))
                                            <li>
                                                <a href="{{route('user.profil.edition', ['identifiant' => $user->identifiant, 'auth_token' => $user->auth_token])}}" class="block px-4 py-2  text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editer</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a wire:click="$dispatch('OpenUserProfilPhotoEvent', {user_id: {{$user->id}}})" type="button" title="Zoomer la photo de profil" href="#" class="block px-4 py-2  text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Zoomer la photo de profil</a>
                                        </li>
                                        @if($user->member)
                                        <li>
                                            <a href="{{route('member.profil', ['identifiant' => $user->identifiant])}}" class="block px-4 py-2  text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil membre</a>
                                        </li>
                                        @endif
                                        @if(__isAdminAs() && !__selfUser($user))
                                            <li>
                                                <a href="#" class="block px-4 py-2  text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Supprimer</a>
                                            </li>
                                            <li>
                                                <a wire:click='confirmedUserBlockOrUnblocked' href="#" class="block px-4 py-2  text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                    {{ $user->blocked ? "DéBloquer" : "Bloquer" }}
                                                </a>
                                            </li>
                                            @if(!$user->confirmed_by_admin)
                                            <li>
                                                <a wire:click='confirmedUserIdentification' href="#" class="block px-4 py-2  text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Confirmer l'identification</a>
                                            </li>
                                            @endif
                                            @if(!$user->email_verified_at)
                                            <li>
                                                <a wire:click='confirmedUserEmailVerification' href="#" class="block px-4 py-2  text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                    {{ $user->email_verified_at ? "Marquer email non vérifié" : "Marquer email vérifié" }}
                                                </a>
                                            </li>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                
                @else
                    <h5 class="w-full animate-pulse text-center py-4 border rounded-lg bg-red-300 text-red-600 letter-spacing-2 font-semibold">
                        <span class="fas fa-trash"></span>
                        <span>Oupps aucune données trouvées!!!</span>
                    </h5>
                @endif
            </table>

            <div class="my-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>


    
</div>