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
            <h2 class="lg:text-lg md:text-lg sm:text-sm w-full gap-x-3  font-semibold flex justify-between letter-spacing-1 uppercase text-sky-500">
                <span>
                    Profil roles administrateurs
                    <span class="text-yellow-500">
                        {{ __translateRoleName($role->name) }}
                    </span>
                </span>
                
                <span class="text-yellow-500">
                    {{ numberZeroFormattor(count($role->permissions)) }} permissions accordées à ce rôle
                </span>
            </h2>
            <div class="flex justify-end gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                <button
                    wire:click="joinUserToRole"
                    class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                >
                    <span wire:loading.remove wire:target='joinUserToRole'>
                        <span class="fas fa-user-check"></span>
                        <span>Assigner ce rôle</span>
                    </span>
                    <span wire:target='joinUserToRole' wire:loading>
                        <span>Chargement en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <div class="flex items-center">
                    <button
                        wire:click="manageRolePermissions"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:text-gray-900 transition"
                    >
                        <span wire:loading.remove wire:target='manageRolePermissions'>
                            <span class="fas fa-plus"></span>
                            <span>Ajouter une permission</span>
                        </span>
                        <span wire:target='manageRolePermissions' wire:loading>
                            <span>Chargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
            </div>

        </div>
        <hr class="border-sky-600 mb-2">
    </div>

  <!-- Tableau des paiements -->
  <div class=" rounded-lg shadow border border-gray-200 z-bg-secondary-light p-3">
    @if ($role)
        @php
            
            $users = \App\Models\User::role($role->name)->get();

            $permissions = $role->permissions;

        @endphp
        <div class="mt-4 p-3 border mx-auto">
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-gray-900 uppercase border bg-zinc-500 border-b-zinc-500">
                Liste des utilisateurs ayant ce role et ses privilèges

                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($users)) }}) </span>
            </h6>
            @if(count($users) > 0)
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                
                <thead class="bg-gray-900 text-gray-300 font-semibold">
                    <tr>
                        <th class="px-3 py-4 text-center">#N°</th>
                        <th class="px-3 py-4 text-left">Utilisateurs</th>
                        <th class="px-3 py-4 text-left">Emails</th>
                        <th class="px-3 py-4 text-left"> {{ __translateRoleName($role->name) }} depuis </th>
                        <th class="px-3 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="payments-tbody">
                    @foreach ($users as $user)
                        <tr wire:key='list-des-utilisateurs-administrations-{{getRand(2999, 8888888)}}-de-ce-role'>
                            <td class="px-2 py-2 text-gray-400 text-center">
                                {{ numberZeroFormattor($loop->iteration) }}
                            </td>
                            <td class="px-2 py-2 text-gray-300 font-medium">
                                <span class="flex gap-x-2 items-center">
                                    <img class="w-8 h-8 rounded-full" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}">
                                    <a title="Charger le profil de {{$user->getFullName()}}" class="" href="{{ route('user.profil', ['identifiant' => $user->identifiant]) }}">
                                        {{$user->getFullName()}} 
                                    </a>
                                </span>
                            </td>
                                
                            <td class="px-2 py-2 text-center text-gray-400 font-semibold">
                                {{ $user->email }}
                            </td>

                            <td class="px-2 py-2 text-gray-600 font-semibold">
                                @php
                                    $user_role = $user->userRoles()->where('role_id', $role->id)->first();
                                @endphp
                                {{ $user_role ? __formatDateTime($user_role->created_at) : 'Date non renseignée' }}

                                @if($user_role)
                                <span class="text-yellow-600 text-xs ml-3">
                                    ( {{ $user_role->created_at->diffForHumans() }} ) 
                                </span>
                                @endif
                            </td>

                            <td class="px-2 py-2 text-center">
                                <span wire:click="removeUserFromRole({{$user->id}})" class="flex hover:bg-red-700 text-gray-300 border rounded-md bg-red-600 gap-x-3 w-full justify-center items-center">
                                    <span class=" px-2 py-1" title="Retirer lz rôle {{ $role->name }} à {{$user->getFullName()}}">
                                        <span wire:target="removeUserFromRole({{$user->id}})" wire:loading.remove>
                                            <span class="fas fa-trash"></span>
                                            <span class="hidden lg:inline">Retirer le rôle</span>
                                        </span>
                                        <span wire:target="removeUserFromRole({{$user->id}})" wire:loading>
                                            <span>Traitement en cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </span>
                                </span>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-sky-500">
                Aucun utilisateurs liés à ce rôle 
                <span class="text-yellow-500">
                    {{ __translateRoleName($role->name) }}
                </span>
            </h6>
            @endif
        </div>
        <h2 class="p-3 mx-auto border border-yellow-600 bg-sky-800 my-5 shadow-2 shadow-sky-500"></h2>
        <div class="p-3 mx-auto border">
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-gray-900 uppercase border bg-zinc-500 border-b-zinc-500">
                Liste des privilèges liés à ce role

                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-300"> ({{ numberZeroFormattor(count($permissions)) }}) </span>
            </h6>
            @if(count($permissions) > 0)
                <table class="min-w-full divide-y divide-gray-200 text-sm border">
                    
                    <thead class="bg-gray-900 text-gray-300 font-semibold">
                        <tr>
                            <th class="px-3 py-4 text-center">#N°</th>
                            <th class="px-3 py-4 text-left">Privilèges</th>
                            <th class="px-3 py-4 text-left">Autres rôles liés</th>
                            <th class="px-3 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="payments-tbody">
                        @foreach ($permissions as $permission)
                            <tr wire:key='list-des-privilèges-administrations-{{getRand(2999, 8888888)}}-de-ce-role'>
                                <td class="px-2 py-2 text-gray-400 text-center">
                                    {{ numberZeroFormattor($loop->iteration) }}
                                </td>
                                <td class="px-2 py-2 text-gray-300 font-medium">
                                    {{ __translatePermissionName($permission->name) }}
                                <td class="px-2 py-2 text-center text-gray-400 font-semibold">
                                    
                                </td>
                                <td class="px-2 py-2 text-center">
                                    <span wire:click="deletePermission({{$permission->id}})" class="flex hover:bg-red-700 text-gray-300 border rounded-md bg-red-600 gap-x-3 w-full justify-center items-center">
                                        <span class=" px-2 py-1" title="Retirer cette permission des privilèges de {{ $role->name }}">
                                            <span wire:target="deletePermission({{$permission->id}})" wire:loading.remove>
                                                <span class="fas fa-trash"></span>
                                                <span class="hidden lg:inline">Supprimer ce privilège</span>
                                            </span>
                                            <span wire:target="deletePermission({{$permission->id}})" wire:loading>
                                                <span>Chargement en cours...</span>
                                                <span class="fas fa-rotate animate-spin"></span>
                                            </span>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h6 class="text-center py-2 letter-spacing-1 font-semibold text-sky-500">
                    Aucun privilèges liés à ce rôle 
                    <span class="text-yellow-500">
                        {{ __translateRoleName($role->name) }}
                    </span>
                </h6>
            @endif
        </div>
    @endif
  </div>
</div>




