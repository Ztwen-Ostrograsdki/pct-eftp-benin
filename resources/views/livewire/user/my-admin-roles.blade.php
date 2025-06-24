<div class="p-6 max-w-6xl mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500">
    <div class="mb-6">
        <div class="flex items-center justify-between gap-x-2 mb-6">
            <h2 class="lg:text-lg md:text-lg sm:text-sm  font-semibold letter-spacing-1 uppercase text-sky-500">
                <span> @if($user->id == auth_user()->id) Mes @else Les @endif  rôles administrateurs</span>
                <span class="ml-5 text-yellow-500 text-sm">
                   ({{ numberZeroFormattor(count($admin_roles)) }} rôles accordés)
                </span>
            </h2>
            <div class="flex justify-end gap-x-2">
                @if(auth_user()->isAdminsOrMaster())
                <div class="flex items-center">
                    @if(!$user->isMaster() || auth_user()->isMaster())
                        <button
                            wire:click="assignAdminRoles"
                            class="bg-blue-600 border text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:text-gray-900 transition"
                        >
                            <span wire:loading.remove wire:target='assignAdminRoles'>
                                <span class="fas fa-user-check"></span>
                                <span>Assigner des rôles</span>
                            </span>
                            <span wire:target='assignAdminRoles' wire:loading>
                                <span>Chargement en cours...</span>
                                <span class="fas fa-rotate animate-spin"></span>
                            </span>
                        </button>
                    @endif
                </div>
                @endif
                
            </div>
        </div>
        <div class="flex items-center w-full justify-center">
              <h6 class="w-full items-center flex justify-center gap-x-9 py-3 font-semibold letter-spacing-1 text-yellow-400">
                <span>
                    <span class="text-gray-300">Membre : </span>
                    <span>{{ $member->user->getFullName() }}</span>
                </span>
              </h6>
            </div>
        <hr class="border-sky-600 mb-2">

        <div class="w-full flex justify-between items-center">
            
        <div class="px-3 mb-4 w-8/12">
            <div class="items-center flex float-end border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">

            </div>
        </div>
        
    </div>

    <div class="">

        @if (count($admin_roles) > 0)

            <div class="w-full p-3 mx-auto flex flex-col gap-y-3">
                @foreach ($admin_roles as $role)
                    <div wire:key="mes-roles-admins-{{$member->id}}-{{$role->id}}" class="border p-3 z-bg-secondary-light rounded-lg library-widget-card">
                        <div class="flex w-full justify-between">
                            <h6 class="uppercase letter-spacing-1 text-sky-400 py-2">
                                <span>
                                    Rôle administrateur N° {{ $loop->iteration }} : 
                                </span>
                                <a href="{{route('master.admin.role.profil', ['role_id' => $role->id])}}" class="font-semibold letter-spacing-1 text-yellow-500">
                                    {{ __translateRoleName($role->name) }}
                                </a>
                            </h6>
                            @if($user->isAdminsOrMaster())
                                @if(!$user->isMaster() || auth_user()->isMaster())
                                <div class="flex items-center justify-between gap-x-2">
                                    <button wire:target='removeUserFromRole({{$role->id}})'  wire:click="removeUserFromRole({{$role->id}})" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 hover:text-gray-100 transition">
                                        <span wire:loading.remove wire:target='removeUserFromRole({{$role->id}})'>
                                            Supprimer ce rôle
                                        </span>
                                        <span wire:target='removeUserFromRole({{$role->id}})' wire:loading>
                                            <span>Suppression en cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </button>
                                </div>
                                @endif
                            @endif
                        </div>
                        <hr class="border border-sky-600 my-2">

                        <div class="flex flex-col border border-zinc-500 p-2">
                            <h6 class="text-gray-400 font-semibold letter-spacing-1">
                                <h6 class="text-center w-full mx-auto font-semibold uppercase text-zinc-400 letter-spacing-1"> Les privilèges accordés au rôle administrateur 
                                    <span class="text-orange-400">{{ __translateRoleName($role->name) }}</span> 
                                    (<span class="text-orange-600">{{numberZeroFormattor(count($role->permissions))}}</span>)
                                </h6>
                                <hr class="border border-sky-600 my-2">
                                @if(count($role->permissions))
                                    <span class="flex flex-wrap gap-2">
                                    @foreach ($role->permissions as $permission)
                                        <span class="border border-gray-400 px-2 py-1 cursor-pointer bg-gray-800 hover:bg-gray-900 text-gray-400 hover:text-gray-100 text-xs"> 
                                            <span>
                                                <span>{{ __translatePermissionName($permission->name) }}</span>
                                            </span>
                                        </span>
                                    @endforeach
                                    </span>
                                @else
                                <h6 class="w-full py-5 bg-red-400 text-center text-red-800 font-semibold letter-spacing-1">
                                    Le rôle <span class="underline text-gray-900">{{ __translateRoleName($role->name) }}</span> ne possède pour l'instant auncune permission ou privilège !
                                </h6>
                                @endif
                            </h6>
                        </div>

                        <p class="text-right text-xs mt-2 text-yellow-400 letter-spacing-1">
                            Promu à ce rôle depuis le
                            @php
                                $user_role = $user->userRoles()->where('role_id', $role->id)->first();
                            @endphp
                            {{ $user_role ? __formatDateTime($user_role->created_at) : 'Date non renseignée' }}

                            @if($user_role)
                            <span class="text-yellow-600 text-xs ml-3">
                                ( {{ $user_role->created_at->diffForHumans() }} ) 
                            </span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
            
        @endif
    </div>

</div>






