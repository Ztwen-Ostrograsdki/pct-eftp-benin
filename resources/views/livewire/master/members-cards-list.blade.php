<div class="p-2">
    <div class="m-auto z-bg-secondary-light rounded my-1 min-h-80 p-2">
        <div class="m-auto  p-0 my-3">
            <h1 class="p-4 text-gray-300 flex items-center justify-between border uppercase text-center rounded-sm">
                <span class="text-xs letter-spacing-2">
                    <span class="">
                        Administration :
                    </span>
    
                    <strong class="text-gray-200">
                        Gestion des cartes de membres 
                        @if ($members)
                        <br>
                        <small class="text-orange-600"> {{ numberZeroFormattor(count(getMembers())) }} membres inscrits</small>
                        @endif
                    </strong>
                </span>

                <div class="flex gap-x-2 lg:text-base sm:text-xs xs:text-xs">
                    <span wire:click="generateMembersCards" class="bg-green-500 hover:bg-green-700 py-2 px-3 text-gray-950 border rounded-lg cursor-pointer">
                        <span wire:loading.remove wire:target="generateMembersCards">
                            <span title="Générer les carte des membre" class="">
                                Générer les cartes de membres non disponibles
                            </span>
                            <span class="fa fa-tools"></span>
                        </span>
                        <span class="text-xs" wire:loading wire:target="generateMembersCards">
                            <span>Création des cartes...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </span>
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
                            Poste
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Statut carte
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Impressions
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Dernière Impression
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Expire Le
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Actions
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Envoyé ?
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $key => $member)
                    <tr wire:key='members-cards-listing-page-{{$member->id}}' class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
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
                            {{ $member->role ? $member->user->formatString($member->role->name) : "Membre" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $member->getMemberCardCreationDate() ? "Emise depuis le " . $member->getMemberCardCreationDate() : "Non prête" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $member->getMemberCardPrints() ? $member->getMemberCardPrints() : "Non prête" }}
                        </td>
                        
                        <td class="px-6 py-4">
                            {{ $member->getMemberCardLastDatePrint() ? $member->getMemberCardLastDatePrint() : "Aucune" }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $member->getMemberCardExpirationDate() ? $member->getMemberCardExpirationDate() : "Non prête" }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white flex gap-x-2">
                                <span wire:click="generateCardMember('{{$member->id}}')" class="bg-primary-500 hover:bg-blue-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="generateCardMember('{{$member->id}}')">
                                        <span title="@if($member->card_sent_by_mail)Regénérer @else Générer @endif la carte de membre de {{$member->user->getFullName()}}" class="">
                                            @if($member->card_sent_by_mail)
                                            Regénérer
                                            @else
                                            Générer
                                            @endif
                                        </span>
                                        <span class="fa fa-card"></span>
                                    </span>
                                    <span class="text-xs" wire:loading wire:target="generateCardMember('{{$member->id}}')">
                                        <span>Création de la carte...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>
                                <span wire:click="removeUserFormMembers('{{$member->id}}')" class="bg-red-500 hover:bg-red-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="removeUserFormMembers('{{$member->id}}')">
                                        <span class="hidden lg:inline">Suppr.</span>
                                        <span class="fa fa-trash"></span>
                                    </span>
                                    <span wire:loading wire:target="removeUserFormMembers('{{$member->id}}')">
                                        <span>En cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>
                                <span wire:click="showMemberCard('{{$member->id}}')" class="bg-green-500 hover:bg-green-700 py-2 px-3 border rounded-lg cursor-pointer">
                                    <span wire:loading.remove wire:target="showMemberCard('{{$member->id}}')">
                                        <span class="hidden lg:inline">Lire</span>
                                        <span class="fa fa-book"></span>
                                    </span>
                                    <span wire:loading wire:target="showMemberCard('{{$member->id}}')">
                                        <span>En cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </span>
                            </span> 
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($member->card_sent_by_mail)
                                <span title="Déjà envoyée par mail" class="fas fa-envelope-circle-check text-green-600 font-semibold"></span>
                            @else
                                <span title="Non envoyée par mail">
                                    <span class="fas fa-x text-red-600 font-semibold"></span>
                                    <span class="fas fa-envelope text-red-600 font-semibold"></span>
                                    <span class="fas fa-x text-red-600 font-semibold"></span>
                                </span>
                            @endif
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
