<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="w-4/5 mx-auto px-3" >
        @if($errors->any())
            <h4 class="w-full letter-spacing-2 p-2 text-xl mb-4 shadow rounded-full  shadow-red-600 bg-red-300 text-red-800 text-center mx-auto">
                <strong>
                    Le formulaire est incorrect
                </strong>
            </h4>
        @endif
        <div class="bg-gray-900 w-full pb-3 @if($errors->any()) shadow-3-strong shadow-red-500 @endif ">
            <div class="w-full">
                <div class="m-0 my-2 p-2 border-b">
                    <h6 class="py-3 text-lg text-gray-500">Gestionnaire d'envoi des épreuves</h6>
                </div>

            </div>

            <div class="w-full px-3">
                <div class="m-0 p-2">
                    <h6 class="py-1 text-lg text-orange-500 text-right">Veuillez renseigner les infos de sur votre document</h6>
                </div>

                <form class="w-full mx-auto">
        
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model.live="name" type="text" name="name" id="name" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Renseigner un nom à votre épreuve" />
                            <label for="name" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Veuillez renseigner un nom à votre épreuve</label>
                            @error('name')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="relative z-0 w-full mb-5 group">
                            <input disabled wire:model="author" type="text" name="author" id="author" class="block ucfirst py-2.5 px-0 w-full text-base opacity-60 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Auteur de l'épreuve" />
                            <label for="author" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Auteur de l'épreuve</label>
                            @error('author')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <select wire:model.live="promotion_id" type="text" name="promotion_id" id="promotion_id" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="La promotion ciblée">
                                <option class="bg-gray-600 text-gray-950 " value="">Sélectionner la promotion</option>
                                @foreach ($promotions as  $promotion)
                                    <option class="bg-gray-600 text-gray-950 " value="{{$promotion->id}}">{{ $promotion->name }}</option>
                                @endforeach
                            </select>
                            <label for="promotion_id" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">La promotion ciblée</label>
                            @error('promotion_id')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="grid md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
							<textarea name="contents_titles" wire:model.live='contents_titles' placeholder="Renseignez les notions ciblées ou évaluées sur cette épreuve..." class="block ucfirst py-2.5 px-0 w-full text-base opacity-60 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  id="contents_titles" type="text">
							
							</textarea>
                            <label for="contents_titles" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Les Contenus notionnels ciblés
                                <small class="text-orange-600 float-right ml-6 letter-spacing-2">(Veuillez séparer chaque notion par un tiret)</small>
                            </label>
                            @error('contents_titles')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
							<textarea name="description" wire:model.live='description' placeholder="Renseignez ce que vous voulez faire savoir sur cette épreuve..." class="block ucfirst py-2.5 px-0 w-full text-base opacity-60 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  id="description" type="text">
							
							</textarea>
                            <label for="description" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Décrivez cette épreuve</label>
                            @error('description')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model.live="file_epreuve" type="file" name="file_epreuve" id="file_epreuve" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Veuillez Sélectionner le fichier" />
                            <label for="file_epreuve" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Sélectionner l'épreuve</label>
                            @error('file_epreuve')
                                <span class="text-red-600">{{$message}}</span>
                            @elseif($file_epreuve && !$errors->any())
                                <span class="text-yellow-400 letter-spacing-2 float-right text-right"> Taille du fichier : {{$file_epreuve->getSize() >= 1048580 ? number_format($file_epreuve->getSize() / 1048576, 2) . ' Mo' :  number_format($file_epreuve->getSize() / 1000, 2) . ' Ko'}} </span>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full my-2">
                        <h5 class="my-3 text-gray-500 text-xl w-full">
                            <span>Veuillez sélectionner les filières</span>

                            <span class="float-right text-orange-300"> {{ count($selecteds) }} filières sélectionnées </span>
                        </h5>
                    </div>
                    <div class="mt-3 w-full mb-5 group overflow-y-auto" style="max-height: 300px">

                        <table class="w-full text-sm text-center border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400">
                
                            @if(count($filiars) > 0)
                            <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-blue-900 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left float-left">
                                        N°
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                       Filière
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Option
                                     </th>
                                    <th scope="col" class="px-6 py-3 float-right text-right">
                                        Action à effectuer 
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($filiars as $key => $filiar)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 text-left font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ \App\Helpers\Dater\Formattors\Formattors::numberZeroFormattor($loop->iteration) }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$filiar->name}} 
                                    </td>
                                    <td class="px-6 py-4">
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

                @if($file_epreuve && !$errors->any())
                <div wire:loading.remove wire:target='file_epreuve' class="m-0 p-3 mx-auto flex w-full justify-center">

                    <span wire:click='uploadEpreuve' wire:loading.class='opacity-50' wire:target='uploadEpreuve' class="text-gray-100 hover:bg-blue-600 bg-blue-700 w-full border border-white rounded-lg text-center cursor-pointer py-2 px-3 ">
                        <span wire:loading wire:target='uploadEpreuve'>
                            <span class="fa animate-spin fa-rotate float-end mt-2"></span>
                            <span class="mx-2">Traitement en cours </span>
                        </span>
                        <span wire:loading.remove wire:target='uploadEpreuve'>
                            <span>Envoyer maintenant</span>
                            <span class=" fa fa-upload mx-2"></span>
                        </span>
                    </span>

                </div>
                @else
                <div wire:loading.remove wire:target='file_epreuve' class="p-3 m-0 mx-auto flex justify-center w-full">
                    <strong  class="text-gray-600 w-full border h6 border-warning-500 rounded bg-gray-400 text-center cursor-pointer py-2 px-3 ">Veuillez sélectionner votre épreuve</strong>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
