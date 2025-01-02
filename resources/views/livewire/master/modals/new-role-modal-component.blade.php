
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="new-role-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Ajouter un nouveau role
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="new-role-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:ignore.self class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">La fonction</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='name' type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Le nom de la fonction">
                        @error('name')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-span-2 hidden">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address mail</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='email' disabled type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="L'address mail de l'utilisateur">
                    </div>

                    <div class="col-span-2">
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">L'utilisateur</label>
                        <select wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='user_id' id="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Sélectionner l'utilisateur</option>
                            @foreach ($users as $user)
                              <option @if($user->member) disabled title="{{$user->getFullName()}} exerce déjà en tant que {{$user->member->role->name}} de l'association"  @endif  value="{{$user->id}}">{{ $user->getFullName() }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="ability" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Le grade relatif</label>
                        <select wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='ability' id="ability" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Sélectionner le rand relatif de cette fonction</option>
                            @foreach ($abilities as $k =>  $a)
                              <option value="{{$a}}">{{ $a }}</option>
                            @endforeach
                        </select>
                        @error('ability')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="is_active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Est active</label>
                        <select wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='is_active' id="is_active" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Est actif</option>
                                <option value="{{true}}">OUI</option>
                                <option value="{{false}}">NON</option>
                        </select>
                        @error('is_active')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <small class="text-yellow-300">Facultative</small> </label>
                        <textarea wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='description' id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Décrivez brièvement cette fonction"></textarea>                    
                        @error('description')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="tasks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tâches ou prérogatives <small class="text-yellow-300">Séparer les tâches par un point virgule ; </small> </label>
                        <textarea wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.live='tasks' id="tasks" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="listez les tâches ou les prérogatives liées à cette fonction"></textarea>                    
                        @error('tasks')
                            <small class="text-xs text-red-600 mt-2" id="email_verify_key-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <span wire:click="insert" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                    <span wire:loading.remove wire:target='insert'>Insérer</span>
                    <span wire:loading wire:target='insert' class="">Traitement en cours...</span>
                    <span wire:loading wire:target='insert' class="fas fa-rotate animate-spin"></span>
                </span>
            </form>
        </div>
    </div>
</div> 
