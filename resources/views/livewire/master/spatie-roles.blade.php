<div class="p-6 w-full mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500">
    <style>
      tr{
			border: thin solid white !important;
      }

      tr:nth-child(odd) {
        
      }

      tr:nth-child(even) {
      background: #141b32;
      }
      

      table {
        border-collapse: collapse;
      }

      th, td{
        border: thin solid rgb(177, 167, 167);
      }
    </style>
    <div class="mb-6">
        <div class="flex items-center justify-between flex-col gap-x-2 mb-6 lg:text-lg md:text-lg sm:text-xs xs:text-xs">
            <h2 class="lg:text-lg md:text-lg sm:text-sm w-full flex gap-x-3  font-semibold letter-spacing-1 uppercase text-sky-500">Les roles administrateurs

                <span class="text-yellow-500">
                    {{ numberZeroFormattor(count($roles)) }}
                </span>
            </h2>
            <div class="flex justify-end gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                <button
                    wire:click="toggleSelectionsCases"
                    class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                >
                    <span wire:loading.remove wire:target='toggleSelectionsCases'>
                        <span class="fas fa-check"></span>
                        <span>De/Cocher</span>
                    </span>
                    <span wire:target='toggleSelectionsCases' wire:loading>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <div class="flex items-center">
                    <button
                        wire:click="memberPaymentsManager"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='memberPaymentsManager'>
                            <span class="fas fa-save"></span>
                            <span>Enregistrer un paiement</span>
                        </span>
                        <span wire:target='memberPaymentsManager' wire:loading>
                            <span>Chargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
                <div class="flex gap-x-2 items-center">
                    <button
                        wire:click="printMembersCotisations"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='printMembersCotisations'>
                            <span>Imprimer</span>
                            <span class="fas fa-print"></span>
                        </span>
                        <span wire:target='printMembersCotisations' wire:loading>
                            <span>Impression en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    @if($selected_roles AND count($selected_roles) > 0)
                        <button
                            wire:click="buildAndSendToMembersByMail"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 hover:text-gray-900 transition"
                        >
                            <span wire:loading.remove wire:target='buildAndSendToMembersByMail'>
                                <span>Générer et envoyés en masse</span>
                                <span class="fas fa-envelope"></span>
                            </span>
                            <span wire:target='buildAndSendToMembersByMail' wire:loading>
                                <span>Impression en cours...</span>
                                <span class="fas fa-rotate animate-spin"></span>
                            </span>
                        </button>
                    @endif
                </div>
            </div>

        </div>
        <hr class="border-sky-600 mb-2">

       
        <div class="px-3 mb-4 w-8/12">
            <div class="items-center flex float-end border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">
                

                
            </div>
        </div>
        
    </div>

  <!-- Tableau des paiements -->
  <div class="overflow-x-auto rounded-lg shadow border border-gray-200 z-bg-secondary-light">
    @if (count($roles) > 0)
        @if($selected_roles AND count($selected_roles) > 0)
            <h6 class="w-full text-zinc-400 text-right font-semibold letter-spacing-2 p-2">
                <span class="text-yellow-400">
                    {{ numberZeroFormattor(count($selected_roles)) }}
                </span> roles admins sélectionnés
            </h6>
        @endif
        <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-900 text-gray-300 font-semibold">
            <tr>
                <th class="px-3 py-4 text-center">#N°</th>
                <th class="px-3 py-4 text-left">Roles</th>
                <th class="px-3 py-4 text-left">Nombres de permissions</th>
                <th class="px-3 py-4 text-center">Permissions</th>
                <th class="px-3 py-4 text-center">Actions</th>
                @if($display_select_cases)
                <th class="px-3 py-4 text-center">
                    <button
                            wire:click="toggleSelectAll"
                            class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                        >
                        <span wire:loading.remove wire:target='toggleSelectAll'>
                            <span class="fas fa-check-double"></span>
                            <span>Tout dé/cocher</span>
                        </span>
                        <span wire:target='toggleSelectAll' wire:loading>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </th>
            @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100" id="payments-tbody">
            
                @foreach ($roles as $role)

                    @php
                        $permissions = $role->permissions;
                    @endphp

                        <tr wire:key='list-des-roles-administrations-{{getRand(2999, 8888888)}}'>
                        <td class="px-2 py-2 text-gray-400 text-center @if(in_array($role->id, $selected_roles)) bg-green-500 text-gray-900 border-gray-900 border @endif ">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </td>
                        <td class="px-2 py-2 text-gray-300 font-medium">
                            <a href="{{route('master.admin.role.profil', ['role_id' => $role->id])}}">
                                {{ __translateRoleName($role->name) }}
                            </a>
                        </td>
                        <td class="px-2 py-2 text-center text-gray-400 font-semibold">
                            {{ numberZeroFormattor(count($permissions)) }}
                        </td>
                        <td class="px-2 py-2 text-green-600 font-semibold">
                        <span class="flex flex-wrap gap-2">
                                @foreach ($permissions as $permission)
                                    <span title="cliquer pour Supprimer retirer cette permission de ce role" class="border rounded-lg p-2 cursor-pointer bg-gray-700 hover:bg-gray-800 text-gray-300"> 
                                        <span>
                                            <span>{{ __translatePermissionName($permission->name) }}</span>
                                            <span class="fas fa-trash text-red-400"></span>
                                        </span>
                                    </span>
                                @endforeach
                        </span>
                        </td>
                        <td class="px-2 py-2 text-center">
                            <span class="flex gap-x-3 w-full justify-center items-center">
                                <span wire:click="manageRolePermissions({{$role->id}})" class="hover:bg-blue-500 text-gray-300 border rounded-md bg-blue-600 px-2 py-1" title="Ajouter uen permission au role {{ $role->name }}">
                                    <span class="fas fa-plus"></span>
                                    <span class="hidden lg:inline">Ajouter</span>
                                </span>
                            </span>
                        </td>
                        @if($display_select_cases)
                        <td>
                            <span wire:click="pushOrRetrieveFromSelectedRoles({{$role->id}})" class="w-full mx-auto text-center font-bold inline-block cursor-pointer">
                                @if(in_array($role->id, $selected_roles))
                                    <span class="fas fa-user-check text-green-600"></span>
                                @else
                                    <span class="text-xs text-zinc-500">Cliquer pour ajouter</span>
                                @endif
                            </span>
                        </td>
                    </tr>
                    @endif
                @endforeach
            <!-- Lignes dynamiques -->
        </tbody>
        </table>
    @else
        <div class="w-full text-center py-4 border-none bg-red-300 text-red-600 text-base">
            <span class="fas fa-trash"></span>
            <span>Oupps aucune données trouvées!!!</span>
        </div>
    @endif
  </div>

  <!-- Modal Ajouter / Éditer -->
  
</div>




