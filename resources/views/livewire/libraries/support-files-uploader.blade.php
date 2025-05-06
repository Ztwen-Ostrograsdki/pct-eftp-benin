<div class="w-full p-5 sm:text-xs mx-auto pb-14">
    <div class="z-bg-secondary-light rounded-xl mx-auto pt-2 pb-8">
        <div class="sm:w-4/5 xs:w-4/5 lg:w-3/5 xl:w-3/5 mx-auto px-3 mt-9 z-bg-secondary-light shadow-3 shadow-sky-500 rounded-lg border border-sky-600" >
            @if($errors->any())
                <h4 class="w-full letter-spacing-2 p-2 text-xl mb-4 shadow rounded-full  shadow-red-600 bg-red-300 text-red-800 text-center mx-auto">
                    <strong>
                        Le formulaire est incorrect
                    </strong>
                </h4>
            @endif
            <div class="z-bg-secondary-light w-full xs:text-xs lg:text-base pb-3 @if($errors->any()) shadow-3-strong shadow-red-500 @endif ">
                <div class="w-full">
                    <div class="m-0 my-2 p-2 border-b flex justify-between items-center">
                        <h6 class="py-3 text-gray-400">Gestionnaire d'envoi des fiches de cours</h6>
    
                        <a class="border py-2 px-3 rounded-lg bg-blue-500 hover:bg-blue-600 text-gray-50" href="{{route('library.fiches')}}">
                            <span class="xs:hidden lg:inline">Page de téléchargement</span>
                            <span class="fas fa-download"></span>
                        </a>
                    </div>
    
                    @session('support-file-success')
                    <div class="mx-auto w-full p-3">
                        <h6 class="w-full py-3 px-3 mx-auto text-center letter-spacing-2 rounded-lg shadow-3 shadow-green-500 bg-green-400 text-green-950">
                            {{ session('support-file-success') }} 
                        </h6>
                    </div>
                    @endsession
                    
    
                </div>
    
                <div class="w-full px-3">
                    <div class="m-0 p-2">
                        <h6 class="py-1 xs:text-xs lg:text-base text-orange-500 text-right">Veuillez renseigner les infos de sur votre document</h6>
                    </div>
    
                    <form class="w-full mx-auto">
            
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:model.live="name" type="text" name="name" id="support-name" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Renseigner un nom à votre fiche de cours" />
                                <label for="support-name" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Renseigner un nom à votre fiche</label>
                                @error('name')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                            
                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="promotion_id" type="text" name="promotion_id" id="support-promotion_id" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="La promotion ciblée">
                                    <option class="bg-gray-600 text-gray-950 " value="">Sélectionner la promotion</option>
                                    @foreach ($promotions as  $promotion)
                                        <option class="bg-gray-600 text-gray-950 " value="{{$promotion->id}}">{{ $promotion->name }}</option>
                                    @endforeach
                                </select>
                                <label for="support-promotion_id" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">La promotion ciblée</label>
                                @error('promotion_id')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <textarea name="contents_titles" wire:model.live='contents_titles' placeholder="Renseignez les notions ciblées ou devéloppées dans votre document..." class="block ucfirst py-2.5 px-0 w-full text-base opacity-60 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  id="support-contents_titles" type="text">
                                
                                </textarea>
                                <label for="support-contents_titles" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Les contenus notionnels devéloppées
                                    <small class="text-orange-600 float-right ml-6 letter-spacing-2 xs:hidden lg:inline">(Veuillez séparer chaque notion par un tiret)</small>
                                </label>
                                @error('contents_titles')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <textarea name="description" wire:model.live='description' placeholder="Renseignez ce que vous voulez faire savoir sur ce document..." class="block ucfirst py-2.5 px-0 w-full text-base opacity-60 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  id="support-description" type="text">
                                
                                </textarea>
                                <label for="support-description" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Décrivez votre fiche</label>
                                @error('description')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:model.live="support_file" type="file" name="support_file" id="support-support_file" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Veuillez Sélectionner le fichier" />
                                <label for="support-support_file" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Sélectionner la fiche de cours</label>
                                @error('support_file')
                                    <span class="text-red-600">{{$message}}</span>
                                @elseif($support_file && !$errors->any())
                                    <span class="text-yellow-400 letter-spacing-2 float-right text-right"> Taille du fichier : {{$support_file->getSize() >= 1048580 ? number_format($support_file->getSize() / 1048576, 2) . ' Mo' :  number_format($support_file->getSize() / 1000, 2) . ' Ko'}} </span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="w-full my-2">
                            <h5 class="my-3 text-gray-500 xs:text-xs lg:text-base w-full">
                                <span>Veuillez sélectionner les filières</span>
    
                                <span class="float-right text-orange-300"> {{ count($selecteds) }} filières sélectionnées </span>
                            </h5>
                        </div>
                        <div class="mt-3 w-full mb-5 group overflow-y-auto" style="max-height: 300px">
    
                            <table class="w-full text-sm text-center border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400 xs:text-xs lg:text-base">
                    
                                @if(count($filiars) > 0)
                                <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-blue-900 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left">
                                            N°
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                           Filière
                                        </th>
                                        <th scope="col" class="px-6 py-3 xs:hidden lg:inline-block">
                                            Option
                                         </th>
                                        <th scope="col" class="px-6 py-3 float-right text-right">
                                            Action à effectuer 
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filiars as $key => $filiar)
                                    <tr wire:key="filiar-joined-to-epreuve-{{$filiar->id}}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 text-left font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ numberZeroFormattor($loop->iteration) }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{$filiar->name}} 
                                        </td>
                                        <td class="px-6 py-4 xs:hidden lg:inline-block">
                                            {{$filiar->option}} 
                                        </td>
                                        <td class="px-6 py-4 float-right">
                                            @if(!in_array($filiar->id, $selecteds))
                                            <span wire:click='pushIntoSelecteds({{$filiar->id}})' class="bg-blue-500 text-gray-950 cursor-pointer border rounded-lg py-2 px-3">
                                                <span>Ajouter</span>
                                                <span class="fas fa-plus"></span>
                                            </span>
                                            @endif
    
                                            @if(in_array($filiar->id, $selecteds))
                                            <span wire:click='retrieveFromSelecteds({{$filiar->id}})' class="bg-red-500 cursor-pointer text-gray-950 border rounded-lg py-2 px-3">
                                                <span>Retirer</span>
                                                <span class="fas fa-trash"></span>
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif 
                                </tbody>
                            </table>
                            
                        </div>
                        @if($selecteds == [])
                            <div class="w-full my-2">
                                <span class="text-red-600">Veuiller selectionner les filières</span>
                            </div>
                        @endif
                    </form>
                </div>
    
                <div class="my-3 mx-auto px-2">
    
                    <div class="bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='file_epreuve'>
                        <span class=" text-orange-400 text-center letter-spacing-2">
                            <span class="fas fa-rotate animate-spin"></span>
                            Chargement fichier en cours... Veuillez patientez!
                        </span>
                    </div>
    
                    @if($support_file && !$errors->any())
                    <div wire:loading.remove wire:target='support_file' class="m-0 p-3 mx-auto flex w-full justify-center">
    
                        <span wire:click='uploadSupportFile' wire:loading.class='opacity-50' wire:target='uploadSupportFile' class="text-gray-100 hover:bg-blue-600 bg-blue-700 w-full border border-white rounded-lg text-center cursor-pointer py-2 px-3 ">
                            <span wire:loading wire:target='uploadSupportFile'>
                                <span class="fa animate-spin fa-rotate float-end mt-2"></span>
                                <span class="mx-2">Traitement en cours </span>
                            </span>
                            <span wire:loading.remove wire:target='uploadSupportFile'>
                                <span>Publier maintenant</span>
                                <span class=" fa fa-upload mx-2"></span>
                            </span>
                        </span>
    
                    </div>
                    @else
                    <div wire:loading.remove wire:target='support_file' class="p-3 m-0 mx-auto flex justify-center w-full">
                        <strong  class="text-gray-600 w-full border h6 border-warning-500 rounded bg-gray-400 text-center cursor-pointer py-2 px-3 ">Veuillez sélectionner votre document à publier</strong>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

