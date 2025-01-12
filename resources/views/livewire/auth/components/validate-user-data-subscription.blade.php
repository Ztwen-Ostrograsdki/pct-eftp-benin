<div class="w-full mx-auto">
    <div class="flex h-full items-center">
        <div class="w-full">
            <div class="w-full py-2 mt-3">
                <div class="w-full  my-2 bg-transparent border border-gray-200 rounded-lg shadow dark:border-gray-700">
                    <h4 class="text-sm letter-spacing-2 w-full text-gray-200 p-3">
                        Les informations renseignées sur vous
                    </h4>
                </div>
                
                <div class="w-full mx-auto bg-transparent border border-gray-200 rounded-lg shadow dark:border-gray-700">
                    
                    <div class="flex flex-col items-center pb-10 px-2">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{url('storage', $photo_path)}}" alt="Photo de profil de {{ $firstname . ' ' . $lastname}}"/>
                        <h5 class="mb-1 text-xl border-b font-medium text-gray-900 dark:text-white">
                            {{ $firstname . ' ' . $lastname}}
                        </h5>
                        <span class="text-sm text-yellow-500 letter-spacing-2 dark:text-yellow-400">
                            <span class="fas fa-envelope"></span>
                            <span>{{ $email }}</span>
                        </span>
                        <span class="text-sm text-yellow-800 letter-spacing-2 dark:text-yellow-400">
                            <span class="fas fa-phone"></span>
                            <span> 
                                @if($contacts)
                                    {{ $contacts }}
                                @else
                                    <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                @endif
                            </span>
                        </span>
                        <span class="text-sm text-green-300 dark:text-green-300">
                            <span class="fas fa-user"></span>
                            <span>
                                {{ $current_function }}
                                <span class="text-orange-500">
                                    @if($grade) ({{ $grade }}) @endif
                                </span>
                            </span>
                        </span>
        
                        <div class="w-full p-2 xl:text-base lg:text-base md:text-sm sm:text-xs xs:text-xs">
                            <div class=" px-3 my-3 text-blue-500" >
                                <div class="">
                                    <div class="py-5 border rounded-xl px-3 mt-1 border-gray-200 dark:border-gray-700 z-bg-secondary-light-opac">
                                        <h5 class="text-gray-300 text-center pb-2 border-b  letter-spacing-2">
                                            Détails civilités
                                        </h5>
                                        <table class="text-gray-100 w-full m-0">
                                            <tr class=" cursor-pointer w-full border-b border-gray-700">
                                                <td class="py-1">
                                                    <span class="fas fa-envelope"></span>
                                                    <span>
                                                        Mail:
                                                    </span>
                                                </td>
                                                <td class="py-1">
                                                    <span>{{ $email}}</span>
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
                                                    <span class=""> {{ $gender }} </span>
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
                                                    <span class="">{{ $birth_date }}</span> @if($birth_date && $birth_city) <small class="text-yellow-200 float-right mr-2 mt-1 italic"> <b> à {{ $birth_city }}</b> </small> @endif
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
                                                        @if($contacts)
                                                            {{ $contacts }}
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
                                                    @if($status)
                                                        Enseignant {{ Str::upper($status) }}
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
                                                    @if($address)
                                                        Résidant à {{ Str::upper($address) }}
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
                                                    @if($marital_status)
                                                        {{ Str::ucfirst($marital_status) }}
                                                    @else
                                                        <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                    @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="mx-auto w-full mt-3 flex justify-center" wire:click="$dispatch('UpdateSectionInsertion', {section: 'perso'})" >
                            
                                            <a href="#" class="py-2 px-4 ms-2 xl:text-sm lg:text-sm md:text-sm sm:text-xs xs:text-xs font-medium focus:outline-none rounded-lg border border-gray-200 hover:bg-red-100 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-success-600 dark:text-gray-100 dark:border-white-600 dark:hover:text-white dark:hover:bg-success-700">
                                                <span class="fas fa-edit"></span>
                                                Editer ces informations
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div>
                                    <div class="py-5 border rounded-xl px-3 mt-1 border-gray-200 dark:border-gray-700 z-bg-secondary-light-opac">
                                        <h5 class="text-gray-300 text-center pb-2 border-b  letter-spacing-2">
                                            Détails Diplôme
                                        </h5>
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
                                                    @if($graduate)
                                                        {{ $graduate }} 
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
                                                    @if($graduate_type)
                                                        {{ $graduate_type }} 
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
                                                        @if($graduate_year)
                                                            {{ $graduate_year }}
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
                                                        @if($graduate_deliver)
                                                            {{ $graduate_deliver }} 
                                                        @else
                                                            <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="mx-auto w-full mt-3 flex justify-center" wire:click="$dispatch('UpdateSectionInsertion', {section: 'graduate'})" >
                            
                                            <a href="#" class="py-2 px-4 ms-2 xl:text-sm lg:text-sm md:text-sm sm:text-xs xs:text-xs font-medium focus:outline-none rounded-lg border border-gray-200 hover:bg-red-100 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-success-600 dark:text-gray-100 dark:border-white-600 dark:hover:text-white dark:hover:bg-success-700">
                                                <span class="fas fa-edit"></span>
                                                Editer ces informations
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div >
                                    <div class="py-5 border rounded-xl px-3 mt-1 border-gray-200 dark:border-gray-700 z-bg-secondary-light-opac">
                                        <h5 class="text-gray-300 text-center pb-2 border-b  letter-spacing-2">
                                            Détails Professionnels
                                        </h5>
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
                                                        @if($grade)
                                                            {{ $grade }} 
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
                                                        @if($matricule)
                                                            {{ $matricule }} 
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
                                                        @if($teaching_since)
                                                            {{ $teaching_since }} 
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
                                                        @if($job_city)
                                                            {{ $job_city }} 
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
                                                        @if($school)
                                                            {{ $school }} 
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
                                                        @if($from_general_school)
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
                                                        @if($general_school)
                                                            {{ $general_school }} 
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
                                                        @if($years_experiences)
                                                            {{ $years_experiences }} ans
                                                        @else
                                                            <small class="text-gray-500 letter-spacing-2">Non renseigné</small>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="mx-auto w-full mt-3 flex justify-center" wire:click="$dispatch('UpdateSectionInsertion', {section: 'professionnal'})" >
                            
                                            <a href="#" class="py-2 px-4 ms-2 xl:text-sm lg:text-sm md:text-sm sm:text-xs xs:text-xs font-medium focus:outline-none rounded-lg border border-gray-200 hover:bg-red-100 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-success-600 dark:text-gray-100 dark:border-white-600 dark:hover:text-white dark:hover:bg-success-700">
                                                <span class="fas fa-edit"></span>
                                                Editer ces informations
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(session()->has('perso_data_is_ok') && session()->has('graduate_data_is_ok') && session()->has('professionnal_data_is_ok') && session()->has('email_data_is_ok'))
            <div class="mx-auto w-full mt-3 flex justify-center" wire:click="register" >
                <a href="#" class="py-3 w-full px-4 xl:text-sm lg:text-sm md:text-sm sm:text-xs xs:text-xs font-medium focus:outline-none rounded-xl border  focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 bg-blue-800 hover:bg-blue-600 text-gray-200 text-center hover:text-white">
                    <span class="fas fa-user-check mr-2"></span>
                    Valider mon inscription
                    <span>
                    <span class=" fas fa-chevron-down ml-3"></span>
                    </span>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
