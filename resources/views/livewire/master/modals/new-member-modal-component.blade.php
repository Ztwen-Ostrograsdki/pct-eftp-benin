
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="new-member-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    @if($role) Edition du statut 
                        "<span class="text-yellow-300">{{ $role->name }}</span> "
                    @elseif(!$role && $member)
                        Edition du poste de 
                        "<span class="text-yellow-300">{{ $member->user->getFullName() }}</span> "
                    @else
                        Edition de statut de membre
                    @endif
                </h3>
                <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:ignore.self class="p-4 md:p-5">
                @if($role)
                    <h5 class="text-sm mx-auto w-full mb-4 text-sky-300 text-center border bg-gray-700 rounded-lg py-2 px-2 shadow-2 shadow-sky-300">
                        <span>{{$role->name }} actuel:</span>
                        <span class="text-sky-500">
                            {{ $role->member ? $role->member->user->getFullName(true) : "Le poste est vaquant" }}
                        </span>
                    </h5>
                @endif
                @if($member)
                    <h5 class="text-sm mx-auto w-full mb-4 text-sky-300 text-center border bg-gray-700 rounded-lg py-2 px-2 shadow-2 shadow-sky-300">
                        <span>Poste actuel de </span>
                        <span class="text-sky-500">
                            {{ $member->user->getFullName(true) }}
                        </span> : 
                        <span class="text-yellow-500">
                            {{ $member->role ? $member->role->name : 'Membre' }}
                        </span>
                    </h5>
                @endif
                <div class="grid mt-2 gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2 hidden">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address mail</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='email' disabled type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="L'address mail de l'utilisateur">
                    </div>

                    <div class="col-span-2">
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> @if($role) Veuillez choisir le nouveau {{ $role->name }}  @else Le Membre   @endif </label>
                        <select @if($member) disabled @endif wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='user_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg cursor-pointer focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected=""> @if($role) Veuillez choisir le nouveau {{ $role->name }} @else Sélectionnez le membre  @endif</option>
                            @foreach ($users as $user)
                              <option @if($user->member && $user->member->role) disabled @endif  value="{{$user->id}}">{{ $user->getFullName() }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="text-xs text-red-600 mt-2" >{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="role_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            @if($member)
                                Veuillez sélectionner le nouveau poste de {{ $member->user->getFullName() }}
                            @else
                                Le Poste
                            @endif
                        </label>
                        <select  @if($role) disabled @endif wire:model.live='role_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">
                                Sélectionner le poste
                            </option>
                            <option value="{{$default_role}}">Membre</option>
                            @foreach ($roles as $r)
                            <option @if($role && $role->id == $r->id) selected  @endif  @if(!$role) @if($r->member) disabled title="Le poste {{$r->name}} est déjà occupé par {{$r->member->user->getFullName()}}"  @endif  @endif value="{{$r->id}}">{{ $r->name }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    
                    <div class="col-span-2 @if($role) hidden @endif">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <small class="text-yellow-300">Facultative</small> </label>
                        <textarea @if($role) disabled @endif wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='description' rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Décrivez brièvement cette fonction"></textarea>                    
                        @error('description')
                            <small class="text-xs text-red-600 mt-2" >{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <span wire:click="insert" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                    <span wire:loading.remove wire:target='insert'>
                        Mettre à jour
                    </span>
                    <span wire:loading wire:target='insert' class="">Mise à jour en cours...</span>
                    <span wire:loading wire:target='insert' class="fas fa-rotate animate-spin"></span>
                </span>
            </form>
        </div>
    </div>

   
</div> 
