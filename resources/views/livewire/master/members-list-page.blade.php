<div>
    <div class="m-auto rounded my-1 min-h-80 p-2">
        <div class="m-auto bg-gray-700 p-0 my-3">
            <h1 class="p-4 text-gray-300 flex items-center justify-between border uppercase text-center rounded-sm">
                <span class="text-xs letter-spacing-2">
                    <span class="">
                        Administration :
                    </span>
    
                    <strong class="text-gray-200">
                        Gestion des membres 
                        @if ($members)
                        <br>
                        <small class="text-orange-600"> {{ numberZeroFormattor(count($members)) }} membres inscrits</small>
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
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white fas fa-search"></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" id="default-search" class="cursive text-cursive block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entrer un mot clé, Pseudo, Nom, Prenoms, Email, grade, établissemnt, contacts,..." required />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 fas fa-search"></button>
                    </div>
                </form>
            </div>
            
            <table class="w-full xs:text-xs text-left border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400">
                
                @if(count($members) > 0)
                <thead class="text-gray-900 uppercase bg-gray-50 dark:bg-blue-900 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            N°
                        </th>
                        <th scope="col" class="px-6 py-3">

                           Nom et Prénoms
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Statut membre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Membre depuis
                        </th>
                        
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $key => $member)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </th>
                        <td class="px-6 py-4">
                            <span class="flex gap-x-2 items-center">
                                <img class="w-8 h-8 rounded-full" src="{{ user_profil_photo($member->user) }}" alt="Photo de profil de {{ $member->user->getFullName() }}">
                                <a title="Charger le profil du statut membre de {{$member->user->getFullName()}}" class="" href="{{ route('member.profil', ['identifiant' => $member->user->identifiant]) }}">
                                    {{$member->user->getFullName()}} 
                                </a>
                            </span>
                        </td>
                        
                        <td class="px-6 py-4  @if($member->user->status) uppercase @else text-orange-400 @endif">
                            {{$member->user->formatString($member->role->name)}}
                        </td>
                        <td class="px-6 py-4">
                            {{$member->user->__getDateAsString($member->created_at)}}
                        </td>
                        
                        <td class="px-6 py-4">
                            <span class="text-white flex gap-x-2">
                                <span wire:click="editRole('{{$member->id}}')" class="bg-primary-500 hover:bg-blue-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="editRole('{{$member->id}}')">
                                        <span>Editer</span>
                                        <span class="fa fa-edit"></span>
                                    </span>
                                    <span wire:loading wire:target="editRole('{{$member->id}}')">
                                        <span>Chargement</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>
                                <span wire:click="removeUserFormMembers('{{$member->id}}')" class="bg-red-500 hover:bg-red-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="removeUserFormMembers('{{$member->id}}')">
                                        <span>Suppr.</span>
                                        <span class="fa fa-trash"></span>
                                    </span>
                                    <span wire:loading wire:target="removeUserFormMembers('{{$member->id}}')">
                                        <span>En cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>
                                
                            </span> 
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                @else
                    <h4 class="w-full animate-pulse text-center py-4 border rounded-lg bg-red-300 text-red-600 lg:text-lg sm:text-base">
                        <span class="fas fa-trash"></span>
                        <span>Oupps aucune données trouvées!!!</span>
                    </h4>
                @endif
            </table>

            <div class="my-3">
                
            </div>
        </div>
    </div>
</div>