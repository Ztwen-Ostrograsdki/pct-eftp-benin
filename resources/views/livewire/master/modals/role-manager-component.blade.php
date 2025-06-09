
<!-- Modal toggle -->
  <!-- Main modal -->
  <div wire:ignore.self id="update-role-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white border rounded-lg shadow dark:bg-gray-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edition de la fonction 
                    <span class="text-yellow-400">{{ session('editing_role_name') }}</span>
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
                @if(!$just_to_add_tasks)
                <div class="w-full p-2 mx-auto">
                    @if($name || $ability || $description || $task || $tasks)
                    <span wire:click='resetRoleData' class="bg-orange-300 hover:bg-orange-500 text-gray-50 border cursor-pointer px-3 py-2 block w-full mx-auto rounded-2xl">
                        <span wire:loading.remove wire:target='resetRoleData'>
                            <span class="fas fa-recycle"></span>
                            <span>Rafraichir toutes les données</span>
                        </span>
                        <span wire:loading wire:target='resetRoleData'>
                            <span class="animate-spin fas fa-recycle"></span>
                            <span>Traitement en cours...</span>
                        </span>
                    </span>
                    @endif
                </div>
                @endif
                <div class="grid gap-4 mb-4 grid-cols-2">
                    @if(!$just_to_add_tasks)
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">La fonction</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='saveUpdate' wire:model.live='name' type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Le nom de la fonction">
                        @error('name')
                            <small class="text-xs text-red-600 mt-2" >{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-span-2 hidden">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address mail</label>
                        <input wire:loading.class='disabled opacity-50' wire:target='saveUpdate' wire:model.live='email' disabled type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="L'address mail de l'utilisateur">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="ability" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Le grade relatif</label>
                        <select wire:loading.class='disabled opacity-50' wire:target='saveUpdate' wire:model.live='ability' id="ability" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Sélectionner le rand relatif de cette fonction</option>
                            @foreach ($abilities as $k =>  $a)
                              <option value="{{$a}}">{{ $a }}</option>
                            @endforeach
                        </select>
                        @error('ability')
                            <small class="text-xs text-red-600 mt-2" >{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="is_active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Est active</label>
                        <select wire:loading.class='disabled opacity-50' wire:target='saveUpdate' wire:model.live='is_active' id="is_active" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Est actif</option>
                                <option value="{{true}}">OUI</option>
                                <option value="{{false}}">NON</option>
                        </select>
                        @error('is_active')
                            <small class="text-xs text-red-600 mt-2" >{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <small class="text-yellow-300">Facultative</small> </label>
                        <textarea wire:loading.class='disabled opacity-50' wire:target='saveUpdate' wire:model.live='description' id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Décrivez brièvement cette fonction"></textarea>                    
                        @error('description')
                            <small class="text-xs text-red-600 mt-2" >{{ $message }}</small>
                        @enderror
                    </div>
                    @endif
                    <div class="col-span-2">
                        <div>
                            <label for="task" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tâche ou prérogative </label>
                            <input wire:loading.class='disabled opacity-50' wire:target='saveUpdate' wire:model.live='task' type="text" name="task" id="task" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ajouter une tâche">
                        </div>
                        <div class="flex justify-center mx-auto my-2">
                            @if($task)
                            <span wire:click='pushIntoTasks' wire:loading.remove wire:target='pushIntoTasks' wire:target='removeFromTasks' class="border rounded-xl py-2 px-3 bg-blue-500 text-gray-50 hover:bg-blue-800 cursor-pointer">
                                <span>Ajouter cette tâche</span>
                                <span class="fas fa-plus"></span>
                            </span>
                            @endif
                            <span wire:loading wire:target='pushIntoTasks' wire:target='removeFromTasks' class="border rounded-xl py-2 px-3 bg-green-500 text-gray-50 hover:bg-green-800">
                                <span>En cours...</span>
                                <span class="fas fa-rotate animate-spin"></span>
                            </span>
                        </div>
                        <div class="border-t border-gray-600 w-full">
                            <h5 class="text-orange-600 letter-spacing-2 py-1">Liste des tâches liées au poste de {{ $name }}</h5>
                            <div class="flex gap-2 flex-wrap text-xs text-yellow-300 letter-spacing-2">
                                @if($tasks)
                                    @foreach ($tasks as $k => $t)
                                    <div wire:key="{{$k}}" class="border rounded-lg px-2 py-2"> 
                                        <span wire:click="editTask('{{$t}}')" title="Editer la tâche {{$t}}" class="mr-2 cursor-pointer">{{ $t }} </span>
                                        <span wire:key='{{$k}}' class="">
                                            <span wire:click="removeFromTasks('{{$t}}')" title="Retirer la tâche {{$t}}" class="fas fa-trash mx-2 cursor-pointer text-red-500"></span>
                                        </span>
                                        <span wire:key='{{$k}}'>
                                            <span wire:click="editTask('{{$t}}')" title="Editer la tâche {{$t}}" class="fas fa-edit cursor-pointer text-blue-500"></span>
                                        </span>
                                    </div>
                                    @endforeach
                                @else
                                    <h5>Aucune tâche encore ajoutée!</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <span wire:click="saveUpdate" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                    <span wire:loading.remove wire:target='saveUpdate'>Mettre à jour</span>
                    <span wire:loading wire:target='saveUpdate' class="">Mise à jours en cours...</span>
                    <span wire:loading wire:target='saveUpdate' class="fas fa-rotate animate-spin"></span>
                </span>
            </form>
        </div>
    </div>
</div> 
