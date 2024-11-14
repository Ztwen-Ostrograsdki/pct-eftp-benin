<div class="mt-2 w-full px-2 border rounded-lg bg-gray-900">
    <h5 class="text-white text-lg uppercase mb-4 text-right">
        <span class="fas fa-graduation-cap"></span>
        <span>{{ $graduate_title }}</span>
        <span title="Afficher les données de la section {{$graduate_title}}" wire:click='toggleGraduateSection' class="fas fa-eye @if(!$hidden_graduate) hidden @endif cursor-pointer"></span>
        <span title="Masquer les données de la section {{$graduate_title}}" wire:click='toggleGraduateSection' class="fas fa-eye-slash @if($hidden_graduate) hidden @endif cursor-pointer"></span>
        @if(!$hidden_graduate)
        <span title="Editer les données de la section {{$graduate_title}}" wire:click='startGraduateEdition' class="fas fa-edit cursor-pointer @if($editing_graduate) hidden @endif text-blue-500"></span>
        <span title="Annuler les données de la section {{$graduate_title}}" wire:click='cancelGraduateEdition' class="fas @if(!$editing_graduate) hidden @endif fa-ban cursor-pointer text-red-400"></span>
        @endif
    </h5>
    @if(!$hidden_graduate)
    <div  class="w-full mx-auto mt-5 mb-2">
        <form class="w-full mx-auto">
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="graduate" @if(!$editing_graduate) disabled @endif type="text" name="graduate" id="graduate" class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre dipôme le plus haut" />
                <label for="graduate" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre diplôme</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="graduate_type" @if(!$editing_graduate) disabled @endif type="text" name="graduate_type" id="graduate_type" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Le type de dipôme le plus haut" />
                <label for="graduate_type" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Le type de diplôme</label>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="graduate_deliver" @if(!$editing_graduate) disabled @endif type="text" name="graduate_deliver" id="graduate_deliver" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="L'instance ayant délivrée le diplôme" />
                    <label for="graduate_deliver" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Délivré par</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="graduate_year" @if(!$editing_graduate) disabled @endif type="text" name="graduate_year" id="graduate_year" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="L'année d'obtention" />
                    <label for="graduate_year" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Obtenu en</label>
                </div>
            </div>
            <div class="flex justify-between">
                @if(!$editing_graduate)
                <span wire:click='startGraduateEdition' class="cursor-pointer text-white bg-blue-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                    <span class="fas fa-edit"></span>
                    Mettre à jour
                </span>
                @endif
    
                <div class="grid grid-cols-2 gap-3">
                    @if($editing_graduate)
                    <span class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Valider
                    </span>
    
                    <span wire:click='cancelGraduateEdition' class="cursor-pointer text-white bg-blue-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-blue-800">
                        <span  class="fas fa-ban"></span>
                        Annuler
                    </span>
                    @endif
                </div>
            </div>
        </form>
    </div>
    @endif
</div>
