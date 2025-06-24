<div class="p-2">
    <div class="m-auto my-1 w-full z-bg-secondary-light min-h-80 p-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
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
                    <tr wire:key="list-users-admin-{{$user->id}}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 admin-user-list-tr">
                        <th scope="row" class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </th>
                        <td class="px-6 py-4">
                            <span class="flex gap-x-2 items-center">
                                <img title="Cliquez pour zoomer sur l'image de profil"  @click="currentImage = '{{ user_profil_photo($user) }}'; userName = '{{ $user->getFullName(true) }}'; email = '{{ $user->email }}'; show = true" class="w-8 h-8 rounded-full" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}">
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
                                {{ 
                                    $user->general_school ? $user->general_school : 'Non renseigné'
                                }}
                            @else
                                <span>Aucun</span>
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
                                        @if(!(auth_user()->id !== $user->id && $user->isMaster()))
                                            <span wire:click.prevent="confirmedUserEmailVerification({{$user->id}})" class="text-red-600" title="{{ $user->getFullName() }} n'a pas encore confirmé son addresss mail. Cliquer pour lancer manuellement la confirmation de ce compte.">
                                                <strong class="fas fa-user-xmark text-red-700 mr-2"></strong>
                                                <span>Nom confirmé</span>
                                            </span>
                                        @endif
                                    @endif
                                </span>
                            </span>
                        </td>
                        
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1">
                            <span>
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
                                    @if(!$user->isMaster())
                                        <span class=" fas fa-user-lock text-red-700"></span>
                                        <span> Bloquer {{ $user->getFilamentName() }} </span>
                                    @endif
                                @endif
                            </span>
                        </td>
                        
                        <td class="lg:px-6 md:px-4 sm:px-3 xs:px-3  lg:py-4 md:py-1">
                            @if(!$user->isMaster())
                                <span class="text-white flex gap-x-2">
                                    <span wire:click="marksUserAsIdentifiedOrNot({{$user->id}})" wire:target="marksUserAsIdentifiedOrNot({{$user->id}})" @if(!$user->confirmed_by_admin) title="Cliquer pour confirmer l'identification de {{ $user->getFullName() }}" @endif class="@if(!$user->confirmed_by_admin) bg-orange-500 hover:bg-orange-700 @else  bg-blue-500 hover:bg-blue-700 @endif py-2 px-3 border rounded-lg cursor-pointer">
                                        <span wire:loading.remove wire:target="marksUserAsIdentifiedOrNot('{{$user->id}}')">
                                            @if(!$user->confirmed_by_admin)
                                            <span class="fa fa-user-check"></span>
                                            <span title="Marquer {{$user->getFullName()}} comme identifié" class="lg:inline">
                                                Identifié
                                            </span>
                                            @else
                                                <span class="fa fa-user-xmark"></span>
                                                <span title="Marquer {{$user->getFullName()}} comme non identifié" class="lg:inline">
                                                    Non Identifié
                                                </span>
                                            
                                            @endif
                                        </span>
                                        <span wire:loading wire:target="marksUserAsIdentifiedOrNot('{{$user->id}}')">
                                            <span>Chargement</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </span>
                                    @if(!$user->isMaster())
                                        <span wire:click="deleteUserAccount('{{$user->id}}')" wire:target="deleteUserAccount('{{$user->id}}')" class="bg-red-500 hover:bg-red-700 py-2 px-3 border rounded-lg cursor-pointer">
                                            <span wire:loading.remove wire:target="deleteUserAccount('{{$user->id}}')">
                                                <span class="hidden lg:inline">Suppr.</span>
                                                <span class="fa fa-trash"></span>
                                            </span>
                                            <span wire:loading wire:target="deleteUserAccount('{{$user->id}}')">
                                                <span>Suppr. compte...</span>
                                                <span class="fas fa-rotate animate-spin"></span>
                                            </span>
                                        </span>
                                    @endif
                                    
                                </span> 
                            @endif
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
        <div 
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-75"
            class="fixed inset-0 bg-black bg-opacity-80 flex flex-col items-center justify-center z-50"
            style="display: none;"
            @click="show = false"
        >
            <h5 class="mx-auto flex flex-col gap-y-1 text-lg w-auto text-center py-3 font-semibold letter-spacing-1 bg-gray-950 my-3" >
                <span class=" text-sky-500 uppercase" x-text="userName"></span>
                <span class=" text-yellow-500" x-text="email"></span>
            </h5>
            <img :src="currentImage" alt="Zoom" class="max-w-4xl max-h-[90vh] rounded shadow-xl border-2 border-white" @click.stop>
            
        </div>
    </div>
</div>