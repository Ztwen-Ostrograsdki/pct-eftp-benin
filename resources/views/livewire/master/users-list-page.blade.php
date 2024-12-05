<div>
    <div class="m-auto border rounded my-1 w-4/5 z-bg-secondary-light-opac min-h-80 p-2">
        <div class="m-auto bg-gray-700 p-0 my-3">
            <h1 class="p-4 text-orange-400 border uppercase text-center rounded-sm">
                <span class="">
                    Administration :
                </span>

                <strong class="text-orange-600">
                    Gestion des Utilisateurs 
                </strong>
                
            </h1>
        </div>

        <div class="relative w-full overflow-x-auto p-2 shadow-md border sm:rounded-lg">
            <div class="m-auto  w-full py-1 my-3">
                <form class="w-full mx-auto">   
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input wire:model.live="search" type="search" id="default-search" class="cursive text-cursive block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entrer un mot clé, Pseudo, Nom, Prenoms, Email, grade, établissemnt, contacts,..." required />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Rechercher</button>
                    </div>
                </form>
            </div>
            
            <table class="w-full text-sm text-left border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400">
                
                @if(count($users) > 0)
                <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-blue-900 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            N°
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Nom et Prénoms
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Etablissement
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fonction
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Inscrit depuis
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email confirmé le
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Utilisateur
                        </th>
                        <th scope="col" class="px-6 py-3">
                            De/Bloquer
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ \App\Helpers\Dater\Formattors\Formattors::numberZeroFormattor($loop->iteration) }}
                        </th>
                        <td class="px-6 py-4">
                            <a title="Charger le profil de {{$user->getFullName()}}" class="" href="{{ route('user.profil', ['id' => $user->id]) }}">
                                {{$user->getFullName()}} 
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <a title="Charger le profil de {{$user->getFullName()}}" class="" href="{{ route('user.profil', ['id' => $user->id]) }}">
                                {{$user->email}} 
                            </a>
                        </td>
                        <td class="px-6 py-4 @if(!$user->school) text-orange-400 @endif">
                            {{ $user->formatString($user->school) }}

                            <small class="text-orange-500 @if(!$user->job_city) hidden @endif">
                                ( {{ $user->job_city }} )
                            </small>
                        </td>
                        <td class="px-6 py-4  @if($user->status) uppercase @else text-orange-400 @endif">
                            {{$user->formatString($user->status)}}
                        </td>
                        <td class="px-6 py-4 ">
                            {{$user->formatString($user->current_function)}}
                        </td>
                        <td class="px-6 py-4">
                            {{$user->__getDateAsString($user->created_at)}}
                        </td>
                        <td class="px-6 py-4 ">
                            @if($user->email_verified_at)
                            <span>
                                <strong class="fas fa-user-check text-green-700 mr-2"></strong>
                                {{ $user->__getDateAsString($user->email_verified_at) }}
                            </span>
                            @else
                                <span wire:click.prevent="confirmedUserEmailVerification({{$user->id}})" class="text-red-600" title="{{ $user->getFullName() }} n'a pas encore confirmé son addresss mail. Cliquer pour lancer manuellement la confirmation de ce compte.">
                                    <strong class="fas fa-user-xmark text-red-700 mr-2"></strong>
                                    <span>Nom confirmé</span>
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4">
                            <span wire:click.prevent="confirmedUserIdentification({{$user->id}})" @if(!$user->confirmed_by_admin) title="Cliquer pour confirmer l'identification de {{ $user->getFullName() }}" @endif>
                                <span class=" @if($user->confirmed_by_admin) fas fa-user-check text-green-600 @else fas fa-user-slash text-red-500 @endif"></span>
                                <span class="@if($user->confirmed_by_admin) text-green-600 @else text-red-500 @endif">{{$user->confirmed_by_admin ? 'identifié' : 'non identifié'}}</span>
                            </span>
                        </td>

                        <td title="Cliquer pour exécuter l'action" class="px-6 py-4">
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
                        
                        <td class="px-6 py-4">
                            
                            <div class="hs-dropdown [--strategy:static] md:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover] md:py-4">
                                <button type="button" class="flex items-center w-full text-gray-500 hover:text-gray-400 font-medium dark:text-gray-400 dark:hover:text-gray-500">
                                    <span>
                                        <span class="fas fa-layer-group"></span>
                                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Options</a>
                                    </span>
                                </button>
                  
                              <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] md:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 md:w-48 hidden z-10 bg-white md:shadow-md rounded-lg p-2 dark:bg-gray-800 md:dark:border dark:border-gray-700 dark:divide-gray-700 before:absolute top-full md:border before:-top-5 before:start-0 before:w-full before:h-5">
                                @if($user)
                                <a class="rounded-full p-0 m-0 px-3 mx-auto text-center" href="#">
                                    <strong class="w-full block text-center text-sm">Effectuer des actions sur</strong>
                                    <hr class="my-2 bg-slate-500 text-gray-700">
                                    <span class="text-orange-600 block my-1 text-left px-2"> 
                                        <span class="fas fa-user"></span>
                                        <b>{{ $user->pseudo }}</b>
                                        <small class="text-orange-400">{{ $user->email }}</small>
                                    </span>
                                </a>
                                <hr class="bg-slate-500 m-0 mb-1 p-0 text-gray-700">
                                @endif
                                <a  href="#" title="Bloquer {{$user->getFullName()}}" class=" @if($user->blocked) hidden @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <span class="fas fa-user-lock hover:scale-125 cursor-pointer text-red-400"></span>
                                    Bloquer
                                </a>
                                <a  href="#" title="identifier et authoriser {{$user->getFullName()}}" class="@if($user->confirmed_by_admin) hidden @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <span  class="text-left  fas fa-user-check hover:scale-125 cursor-pointer text-green-700"></span>
                                    identifier
                                </a>
                                <a  href="#" title="Débloquer {{$user->getFullName()}}" class="@if(!$user->blocked) hidden @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <span  class="fas  fas fa-unlock hover:scale-125 cursor-pointer text-red-400"></span>
                                    Débloquer
                                </a>
                                <a  href="#" title="Marquer {{$user->getFullName()}} comme non confirmé" class=" @if(!$user->email_verified_at) hidden @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <span  class="text-left fas fa-person-circle-question hover:scale-125 cursor-pointer text-red-500"></span>
                                    Confirmé
                                </a>

                                <a  href="#" title="Promouvoir comme administrateur {{$user->getFullName()}}" class=" @if($user->ability == "admin") hidden @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <span  class="text-left  fas fa-user-secret hover:scale-125 cursor-pointer text-blue-400"></span>
                                    Promouvoir
                                </a>

                                <a  href="#" title="Retirer des administrateurs {{$user->getFullName()}}" class=" @if($user->ability !== "admin") hidden @endif flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <span  class="text-left  fas fa-user-minus hover:scale-125 cursor-pointer text-yellow-400"></span>
                                    Retirer des admin
                                </a>

                                <a  href="#" title="Supprimer {{$user->getFullName()}}" class=" flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <span  class="text-left fas fa-user-xmark hover:scale-125 cursor-pointer text-red-700"></span>
                                    Supprimer
                                </a>
                                <a  href="#" title="Supprimer {{$user->getFullName()}}" class=" flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                                    <div class="flex items-center">
                                        <input checked id="checkbox-item-2" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="checkbox-item-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Checked state</label>
                                    </div>
                            
                                </a>

                              </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                @else
                    <h4 class="w-full animate-pulse text-center py-4 border rounded-lg bg-red-300 text-red-600 text-3xl text-cursive">
                        <span class="fas fa-trash"></span>
                        <span>Oupps aucune données trouvées!!!</span>
                    </h4>
                @endif
            </table>

            <div class="my-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>


    
</div>