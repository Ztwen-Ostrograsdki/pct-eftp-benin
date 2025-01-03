
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="new-member-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    @if($for_update) Edition du statut "<span class="text-yellow-300">{{ $member->role->name }}</span> "

                    @else

                    Ajouter un nouveau membre

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
                @if($for_update && $member)
                    <h5 class="text-sm mx-auto w-full mb-4 text-sky-300 text-center border bg-gray-700 rounded-lg py-2 px-2 shadow-2 shadow-sky-300">
                        <span>{{$member->role->name}} actuel:</span>
                        <span class="text-sky-500">
                            {{ $member->user->getFullName(true) }}
                        </span>
                    </h5>
                @endif
                <div class="grid mt-2 gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2 hidden">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address mail</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='email' disabled type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="L'address mail de l'utilisateur">
                    </div>

                    <div class="col-span-2">
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> @if($for_update) Veuillez choisir le nouveau {{ $member->role->name }} @else L'utilisateur @endif </label>
                        <select wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='user_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg cursor-pointer focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected=""> @if($for_update) Veuillez choisir le nouveau {{ $member->role->name }} @else Sélectionnez l'utilisateur @endif</option>
                            @foreach ($users as $user)
                              <option @if($user->member) disabled title="{{$user->getFullName()}} exerce déjà en tant que {{$user->member->role->name}} de l'association" @endif  value="{{$user->id}}">{{ $user->getFullName() }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="role_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">La Fonction</label>
                        <select @if($for_update) disabled @endif wire:model.live='role_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Sélectionner le role ou la Fonction</option>
                            @foreach ($roles as $role)
                              <option  @if(!$for_update) @if($role->member) disabled title="Le poste {{$role->name}} est déjà occupé par {{$role->member->user->getFullName()}}"  @endif  @endif value="{{$role->id}}">{{ $role->name }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    
                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <small class="text-yellow-300">Facultative</small> </label>
                        <textarea @if($for_update) disabled @endif wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='description' rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Décrivez brièvement cette fonction"></textarea>                    
                        @error('description')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <span wire:click="insert" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                    <span wire:loading.remove wire:target='insert'>
                        @if($for_update)
                            Mettre à jour
                        @else
                            Valider
                        @endif
                    </span>
                    <span wire:loading wire:target='insert' class="">@if($for_update) Mise à jour @else Traitement @endif en cours...</span>
                    <span wire:loading wire:target='insert' class="fas fa-rotate animate-spin"></span>
                </span>
            </form>
        </div>
    </div>

   
</div> 
