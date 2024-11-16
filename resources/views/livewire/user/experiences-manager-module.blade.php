<div class="mt-2 w-full px-2 border rounded-lg bg-gray-900">
    <h5 class="text-white text-lg uppercase mb-4 text-right">
        <span class="fas fa-graduation-cap"></span>
        <span>{{ $experiences_title }}</span>
        <span title="Afficher les données de la section {{$experiences_title}}" wire:click='toggleExperiencesSection' class="fas fa-eye @if(!$hidden_experiences) hidden @endif cursor-pointer"></span>
        <span title="Masquer les données de la section {{$experiences_title}}" wire:click='toggleExperiencesSection' class="fas fa-eye-slash @if($hidden_experiences) hidden @endif cursor-pointer"></span>
        @if($user->id == auth()->user()->id)
            @if(!$hidden_experiences)
            <span title="Editer les données de la section {{$experiences_title}}" wire:click='startExperiencesEdition' class="fas fa-edit cursor-pointer @if($editing_experiences) hidden @endif text-blue-500"></span>
            <span title="Annuler les données de la section {{$experiences_title}}" wire:click='cancelExperiencesEdition' class="fas @if(!$editing_experiences) hidden @endif fa-ban cursor-pointer text-red-400"></span>
            @endif
        @endif
    </h5>
    @if(!$hidden_experiences)
        @if($editing_experiences && $errors->any())
            <h4 class="bg-red-300 border py-1 text-red-700 w-full text-center text-lg rounded-lg shadow-sm">
                <strong class="mx-3"> Oupps!!! Le formulaire est incorrect</strong>
            </h4>
        @endif
    <div class="w-full mx-auto mt-5 mb-2">
        
        <form class="w-full mx-auto">
        
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="grade" @if(!$editing_experiences) disabled @endif type="text" name="grade" id="grade" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre grade" />
                    <label for="grade" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre grade</label>
                    @error('grade')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="matricule" @if(!$editing_experiences) disabled @endif type="text" name="matricule" id="matricule" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre matricule" />
                    <label for="matricule" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre Matricule</label>
                    @error('matricule')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="teaching_since" @if(!$editing_experiences) disabled @endif type="date" name="teaching_since" id="teaching_since" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Première prise de fonction en tant que Enseignant" />
                    <label for="teaching_since" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Enseigne depuis</label>
                    @error('teaching_since')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="job_city" @if(!$editing_experiences) disabled @endif type="text" name="job_city" id="job_city" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Ville ou commune de travail" />
                    <label for="job_city" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Ville ou commune de travail</label>
                    @error('job_city')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="school" @if(!$editing_experiences) disabled @endif type="text" name="school" id="school" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Etablissement" />
                    <label for="school" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Etablissement</label>
                    @error('school')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="years_experiences" @if(!$editing_experiences) disabled @endif type="text" name="years_experiences" id="years_experiences" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Année d'expériences" />
                    <label for="years_experiences" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Année d'expériences</label>
                    @error('years_experiences')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
            </div>

            @if($user->id == auth()->user()->id)
            <div class="flex justify-between">
                <div wire:target='updateUserExperiencesData' wire:loading class="flex my-4 text-xl mx-auto justify-center w-full">
                    <span class="animate-spin fas fa-spinner text-5xl text-orange-500 text-center"></span>
                    <span class="text-orange-500 text-lg text-right float-right mx-3">Veuillez patienter, traitement en cours...</span>
                </div>
    
                @if(!$editing_experiences)
                <span wire:target='updateUserExperiencesData' wire:loading.remove wire:click='startExperiencesEdition' class="cursor-pointer text-white bg-blue-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                    <span class="fas fa-edit"></span>
                    Mettre à jour
                </span>
                @endif
    
                <div wire:target='updateUserExperiencesData' wire:loading.remove class="grid grid-cols-2 gap-3">
                    @if($editing_experiences)
                    <span wire:click.prevent='updateUserExperiencesData' class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Valider
                    </span>
    
                    <span wire:click='cancelExperiencesEdition' class="cursor-pointer text-white bg-blue-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-blue-800">
                        <span  class="fas fa-ban"></span>
                        Annuler
                    </span>
                    @endif
                </div>
            </div>
            @endif
        </form>
    </div>
    @endif
</div>