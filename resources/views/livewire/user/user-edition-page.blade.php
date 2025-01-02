<div class="mx-auto p-2 min-h-90">
    <div class="m-auto w-3/4 bg-gray-500 mt-3 p-0">
        <h1 class="p-4 text-orange-400 border text-left rounded-sm bg-slate-600">
            <span class=" ml-2">
                Profil de: 
            </span>

            <strong class="text-orange-600 uppercase">
                @if($user)  {{ $user->getUserNamePrefix() . ' ' . $user->getFullName(true) }} @endif
            </strong>
            
            <strong class="text-gray-200 uppercase float-right">
                
                @if($user)  {{ $user->status }} @endif

                @if($user && $user->grade)  {{ " - " . $user->grade }} @endif

            </strong>
            
        </h1>
    </div>
    <div class="m-auto w-3/4 bg-gray-500 mt-3 p-0">
        @auth
        <div class="m-auto lg:flex xl:flex 2xl:flex justify-between bg-gray-500 min-h-80">
            <div class="lg:w-5/12 xl:w-5/12 2xl:w-5/12 sm:w-full m-0 p-0 border-r border-r-gray-900">
                <div class="w-full p-0 m-0">
                    <img class="w-full border-b z-10" src="{{ url('storage', $user->profil_photo) }}" alt="Photo de profil de {{ $user->getFullName() }}" >
                </div>

                <div class="pl-2 py-2 w-full m-0">
                    <table class="text-gray-800 w-full m-0 p-0">
                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="py-1">
                                <span class="fas fa-envelope"></span>
                                <span>
                                    Mail:
                                </span>
                            </td>
                            <td class="py-1">
                                <strong>{{ $user->email}}</strong>
                            </td>
                        </tr>
                        <tr class="hover:text-gray-300 cursor-pointer w-full">
                            <td class="py-1">
                                <span class="fas fa-user"></span>
                                <span>
                                    Nom:
                                </span>
                            </td>
                            <td class="py-1">
                                <strong>{{ $user->firstname }}</strong>
                            </td>
                        </tr>

                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="">
                                <span class="fas fa-user text-gray-500"></span>
                                <span>
                                    Prénoms:
                                </span>
                            </td>
                            <td>
                                <strong class="">{{ $user->lastname }}</strong>
                            </td>
                        </tr>

                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="py-1">
                                <span class="fas fa-genderless"></span>
                                <span>
                                    Sexe:
                                </span>
                            </td>
                            <td class="py-1">
                                <strong class=""> {{ $user->getGender() }} </strong>
                            </td>
                        </tr>

                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="py-1">
                                <span class="fas fa-person-chalkboard"></span>
                                <span>
                                    Né le:
                                </span>
                            </td>
                            <td class="py-1">
                                <strong class="">{{ $user->__getDateAsString($user->birth_date) }}</strong> @if($user->birth_date && $user->birth_city) <small class="text-gray-900 float-right mr-2 mt-1 italic"> <b> à {{ $user->birth_city }}</b> </small> @endif
                            </td>
                        </tr>

                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="py-1">
                                <span class="fas fa-phone"></span>
                                <span>
                                    Contacts:
                                </span>
                            </td>
                            <td class="py-1">
                                <strong class="">{{ $user->contacts }}</strong>
                            </td>
                        </tr>

                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="py-1">
                                <span class="fas fa-person-chalkboard"></span>
                                <span>
                                    Statut:
                                </span>
                            </td>
                            <td class="py-1">
                                <strong class="">Enseignant {{ Str::upper($user->status) }}</strong>
                            </td>
                        </tr>

                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="py-1">
                                <span class="fas fa-home"></span>
                                <span>
                                    Adresse:
                                </span>
                            </td>
                            <td class="py-1">
                                Résidant à <strong class=""> {{ Str::upper($user->address) }}</strong>
                            </td>
                        </tr>

                        <tr class="hover:text-gray-300 cursor-pointer w-full border-b border-gray-700">
                            <td class="py-1">
                                <span class="fas fa-children"></span>
                                <span>
                                    Statut matrimonial:
                                </span>
                            </td>
                            <td class="py-1">
                                <strong class=""> {{ Str::ucfirst($user->marital_status) }}</strong>
                            </td>
                        </tr>
                    </table>

                    @if($user->id == auth()->user()->id)
                    <div class="flex justify-between my-2">
                        @if(!$show_perso)
                        <span wire:click.prevent='startPersoEdition' class="cursor-pointer border text-white bg-blue-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                            <span class="fas fa-edit"></span>
                            Mettre à jour
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="lg:w-7/12 xl:w-7/12 2xl:w-7/12 sm:w-full bg-gray-800">
                <div class="mt-2 w-full px-2 pb-4">

                    @livewire('user.graduate-manager-module', 
                        [
                            'user' => $user, 
                            'hidden_graduate' => $hidden_graduate, 
                            'editing_graduate' => $editing_graduate, 
                        ]
                    )

                    @livewire('user.experiences-manager-module', 
                        [
                            'user' => $user, 
                            'hidden_experiences' => $hidden_experiences, 
                            'editing_experiences' => $editing_experiences, 
                        ]
                    )

                    @if($show_perso)
                    
                    <div wire:transition.scale class="border px-2 bg-gray-950 rounded-lg my-2">
                        @livewire('user.perso-data-manager-module', 
                            [
                                'user' => $user, 
                                'show_perso' => $show_perso, 
                                'editing_perso' => $editing_perso, 
                            ]
                        )
                    </div>
                    
                    @endif
                    <div class="w-full mx-auto my-3">
                        <span wire:click='confirmedData' class="cursor-pointer block border text-white bg-blue-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-success-600 dark:hover:bg-success-700 dark:focus:ring-blue-800">
                            <span  class="fas fa-recycle"></span>
                            Réinitiliser mes données
                        </span>
                    </div>

                    <div class="w-full mx-auto my-3">
                        <a href="{{route('user.profil', ['identifiant' => $user->identifiant])}}" class="cursor-pointer block border text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span  class="fas fa-user"></span>
                            Retour à la page de profil
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        @endauth
    </div>
</div>