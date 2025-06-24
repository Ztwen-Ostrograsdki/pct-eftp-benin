<div class="p-2">
    <div class="m-auto z-bg-secondary-light rounded my-1 min-h-80 p-2">
        <div class="m-auto  p-0 my-3">
            <h1 class="p-4 text-gray-300 flex items-center justify-between border uppercase text-center rounded-sm">
                <span class="text-xs letter-spacing-2">
                    <span class="">
                        Administration :
                    </span>
    
                    <strong class="text-gray-200">
                        Gestion des membres 
                        @if ($members)
                        <br>
                        <small class="text-orange-600"> {{ numberZeroFormattor(count(getMembers())) }} membres inscrits</small>
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
                    <label for="search-from-members-list" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Rechercher</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input wire:model.live="search" type="search" id="search-from-members-list" class="z-bg-secondary-light letter-spacing-1 block w-full p-4 ps-10 text-sm text-sky-300 border border-gray-300 rounded-lg  focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entrer un mot clé, Pseudo, Nom, Prénoms, établissement, contacts, addresse, ville, département..." required />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Rechercher</button>
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
                        
                        <th scope="col" class="px-6 text-center py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $key => $member)
                    <tr class="odd:bg-white admin-member-list-tr odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </th>
                        <td class="px-6 py-2">
                            <span class="flex gap-x-2 items-center">
                                <img class="w-8 h-8 rounded-full" src="{{ user_profil_photo($member->user) }}" alt="Photo de profil de {{ $member->getFullName() }}">
                                <a title="Charger le profil du statut membre de {{$member->getFullName()}}" class="" href="{{ route('member.profil', ['identifiant' => $member->user->identifiant]) }}">
                                    {{$member->getFullName()}} 
                                </a>
                            </span>
                        </td>
                        
                        <td class="px-6 py-2  @if($member->role) uppercase text-sky-500 @else text-orange-400 @endif">
                            @if($member->role)
                                {{$member->user->formatString($member->role->name)}}
                            @else
                                Membre
                            @endif
                        </td>
                        <td class="px-6 py-2">
                            {{$member->user->__getDateAsString($member->created_at)}}
                        </td>
                        
                        <td class="px-6 py-2">
                            <span class="text-white flex justify-center gap-x-2">
                                @if($member->role)
                                <span wire:click="changeTheMemberOfThisRole('{{$member->role->id}}')" class="bg-primary-500 hover:bg-blue-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="changeTheMemberOfThisRole('{{$member->id}}')">
                                        <span title="Choisir un nouveau {{$member->role->name}}" class="hidden lg:inline">Changer</span>
                                        <span class="fa fa-recycle"></span>
                                    </span>
                                    <span wire:loading wire:target="changeTheMemberOfThisRole('{{$member->id}}')">
                                        <span>Chargement</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>
                                @else
                                <span wire:click="changeTheRoleOfThisMember('{{$member->id}}')" class="bg-primary-500 hover:bg-blue-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="changeTheRoleOfThisMember('{{$member->id}}')">
                                        <span title="Definir un nouveau poste pour {{$member->getFullName()}}" class="hidden lg:inline">Changer</span>
                                        <span class="fa fa-recycle"></span>
                                    </span>
                                    <span wire:loading wire:target="changeTheRoleOfThisMember('{{$member->id}}')">
                                        <span>Chargement</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>
                                @endif
                                <span title="Réinitialiser le poste de  {{$member->getFullName()}} au status  'Membre'" wire:click="resetMemberRoleToNull('{{$member->id}}')" class="bg-red-500 hover:bg-red-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="resetMemberRoleToNull('{{$member->id}}')">
                                        <span class="hidden lg:inline">Réinitialiser</span>
                                        <span class="fa fa-rotate"></span>
                                    </span>
                                    <span wire:loading wire:target="resetMemberRoleToNull('{{$member->id}}')">
                                        <span>En cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>

                                <span wire:click="sendMailConfirmationForAdded('{{$member->user->id}}')" class="bg-green-500 hover:bg-green-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="sendMailConfirmationForAdded('{{$member->user->id}}')">
                                        <span class="hidden lg:inline">Message</span>
                                        <span class="fa fa-send "></span>
                                    </span>
                                    <span wire:loading wire:target="sendMailConfirmationForAdded('{{$member->user->id}}')">
                                        <span>En cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>

                                @if(!$member->user->isMaster())
                                <button
                                    wire:click="assignAdminRoles({{$member->user->id}})"
                                    class="bg-zinc-600 border text-white px-4 py-2 rounded-lg hover:bg-zinc-800 hover:text-gray-100 transition"
                                >
                                    <span wire:loading.remove wire:target='assignAdminRoles({{$member->user->id}})'>
                                        <span class="fas fa-user-check"></span>
                                        <span>Attribuer des permissions</span>
                                    </span>
                                    <span wire:target='assignAdminRoles({{$member->user->id}})' wire:loading>
                                        <span>Chargement en cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </button>
                                @endif
                                
                            </span> 
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                @else
                    <h4 class="w-full animate-pulse text-center py-2 border rounded-lg bg-red-300 text-red-600 lg:text-lg sm:text-base">
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