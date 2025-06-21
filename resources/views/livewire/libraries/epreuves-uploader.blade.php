<div class="w-full max-w-[85rem] p-5 sm:text-xs mx-auto  @if(!$uploaded_completed) shadow-3 shadow-sky-500 @endif rounded-lg mt-5">
    @if(!$uploaded_completed)

        <div class="my-2 px-3 font-semibold letter-spacing-1
        flex justify-center items-center text-sm text-center lg:w-3/5 xl:w-4/5 md:w-4/5 mx-auto">
            @if($epreuve_type == 'examen')
                <a class="bg-blue-800 hover:bg-blue-900  text-gray-300 py-3 border border-white rounded-lg px-3 w-full flex items-center justify-center" href="{{route('library.epreuves.uplaoder', ['type' => 'simple'])}}">
                    Cliquer ici pour publier des épreuves simples: DEVOIRS, EPE, EVALUATIONS FORMATIVES, ....
                </a>
            @else
                <a class="bg-blue-800 hover:bg-blue-900  text-gray-300 py-3 border border-white rounded-lg px-3 w-full flex gap-x-1 items-center justify-center" href="{{route('library.epreuves.uplaoder', ['type' => 'examen'])}}">
                    Cliquer ici pour publier des épreuves d'examen: CAP, BAC, DT, ...
                </a>
            @endif
        </div>
        <div class="lg:w-3/5 xl:w-4/5 md:w-4/5 mx-auto px-3 " >
            @if($errors->any())
                <h4 class="w-full letter-spacing-2 p-2 text-xl mb-4 shadow rounded-full  shadow-red-600 bg-red-300 text-red-800 text-center mx-auto">
                    <strong>
                        Le formulaire est incorrect
                    </strong>
                    <div class="flex-wrap gap-x-2 text-xs ">
                        @foreach ($errors->all() as $err_msg)
                            <span> {{ $err_msg }} </span>
                        @endforeach
                    </div>
                </h4>
            @endif
            <div class="bg-gray-900 w-full xs:text-xs pb-3 @if($errors->any()) shadow-3-strong shadow-red-500 @endif ">
                <div class="w-full">
                    <div class="m-0 my-2 p-2 border-b flex justify-between items-center">
                        <h6 class="py-3 text-gray-400">Gestionnaire d'envoi des épreuves
                            @if($epreuve_type == 'examen') d'examen @endif
                        </h6>

                        @if($epreuve_type == 'simple')
                        <a class="border py-2 px-3 rounded-lg bg-blue-500 hover:bg-blue-600 text-gray-50" href="{{route('library.epreuves')}}">
                            <span class="xs:hidden lg:inline">Page de téléchargement</span>
                            <span class="fas fa-download"></span>
                        </a>
                        @elseif($epreuve_type == 'examen')
                        <a class="border py-2 px-3 rounded-lg bg-green-500 hover:bg-blue-600 text-gray-50" href="{{route('library.epreuves.examens')}}">
                            <span class="xs:hidden lg:inline">Page de téléchargement</span>
                            <span class="fas fa-download"></span>
                        </a>
                        @endif

                    </div>

                    @session('epreuve-success')
                    <div class="mx-auto w-full p-3">
                        <h6 class="w-full py-3 px-3 mx-auto text-center letter-spacing-2 rounded-lg shadow-3 shadow-green-500 bg-green-400 text-green-950">
                            {{ session('epreuve-success') }} 
                        </h6>
                    </div>
                    @endsession
                    

                </div>

                <div class="w-full px-3">
                    <div class="m-0 p-2 mb-3">
                        <h6 class="py-1 text-xs font-semibold letter-spacing-1 lg:text-sm text-orange-500 text-right">Veuillez renseigner les infos de votre épreuve pour faciliter les recherches sur la plateforme</h6>
                    </div>

                    <form class="w-full mx-auto">
            
                        <div class="grid md:grid-cols-2 md:gap-6">

                            @if($epreuve_type !== 'examen')
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:model.live="name" type="text" name="name" id="name" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Renseigner un nom à votre épreuve" />
                                <label for="name" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Veuillez renseigner un nom à votre épreuve</label>
                                @error('name')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                            @endif

                            @if($epreuve_type == 'simple')
                            
                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="promotion_id" type="text" name="promotion_id" id="promotion_id" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="La promotion ciblée">
                                    <option class="bg-gray-600 text-gray-950 " value="">Sélectionner la promotion</option>
                                    @foreach ($promotions as  $promotion)
                                        <option class="bg-gray-600 text-gray-950 " value="{{$promotion->id}}">{{ $promotion->name }}</option>
                                    @endforeach
                                </select>
                                <label for="promotion_id" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">La promotion ciblée</label>
                                @error('promotion_id')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>

                            @elseif($epreuve_type == 'examen')

                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="exam_type" type="text" name="exam_type" id="exam_type" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer font-semibold letter-spacing-1 pl-2" placeholder="L'examen ciblé">
                                    <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="">Sélectionner le type d'examen</option>
                                    @foreach ($types as  $type_value => $eptyp)
                                        <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="{{$type_value}}">{{ $eptyp }}</option>
                                    @endforeach
                                </select>
                                <label for="exam_type" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">L'examen</label>
                                @error('exam_type')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="exam_session" type="text" name="exam_session" id="exam_session" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer font-semibold letter-spacing-1 pl-2" placeholder="L'examen ciblé">
                                    <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="">Session normal ou blanc</option>
                                    <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="blanc">Blanc</option>
                                    <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="normal">Normal</option>
                                </select>
                                <label for="exam_session" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Session normal ou blanc</label>
                                @error('exam_session')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>

                            @endif

                        </div>

                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <textarea name="contents_titles" wire:model.live='contents_titles' placeholder="Renseignez les notions ciblées ou évaluées sur cette épreuve..." class="block ucfirst py-2.5 px-0 w-full  opacity-60 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  id="contents_titles" type="text">
                                
                                </textarea>
                                <label for="contents_titles" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Les Contenus notionnels ciblés
                                    <small class="text-orange-600 float-right ml-6 letter-spacing-2 xs:hidden lg:inline">(Veuillez séparer chaque notion par un tiret)</small>
                                </label>
                                @error('contents_titles')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid md:gap-6">
                            @if($epreuve_type !== 'examen')
                            <div class="relative z-0 w-full mb-5 group ">
                                <textarea name="description" wire:model.live='description' placeholder="Renseignez ce que vous voulez faire savoir sur cette épreuve..." class="block ucfirst py-2.5 px-0 w-full  opacity-60 text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  id="description" type="text">
                                
                                </textarea>
                                <label for="description" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Décrivez cette épreuve</label>
                                @error('description')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                            @endif
                        </div>

                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:model.live="file_epreuve" type="file" name="file_epreuve" id="file_epreuve" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Veuillez Sélectionner le fichier" />
                                <label for="file_epreuve" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Sélectionner l'épreuve</label>
                                @error('file_epreuve')
                                    <span class="text-red-600">{{$message}}</span>
                                @elseif($file_epreuve && !$errors->any())
                                    <span class="text-yellow-400 letter-spacing-2 float-right text-right"> Taille du fichier : {{$file_epreuve->getSize() >= 1048580 ? number_format($file_epreuve->getSize() / 1048576, 2) . ' Mo' :  number_format($file_epreuve->getSize() / 1000, 2) . ' Ko'}} </span>
                                @enderror
                            </div>
                        </div>

                        @if($epreuve_type !== 'examen' || ($exam_session && $exam_session == 'blanc'))
                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="lycee_id" type="text" name="lycee_id" id="lycee_id" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer font-semibold letter-spacing-1 pl-2" placeholder="Le Lycée u centre de formation">
                                    <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="">Sélectionner le lycée ou le centre de formation</option>
                                    @foreach ($lycees as  $lycee)
                                        <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="{{$lycee->id}}">{{ $lycee->name }}</option>
                                    @endforeach
                                </select>
                                <label for="lycee_id" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Le Lycée ou centre de formation de provenance</label>
                                @error('lycee_id')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="year" type="text" name="year" id="year" class="block ucfirst py-2.5 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer pr-4" placeholder="L'année de conception">
                                    <option class="bg-gray-600 text-gray-950 text-right" value="">Sélectionner l'année de conception</option>
                                    @foreach (getYears() as  $year_value => $year)
                                        <option class="bg-gray-600 text-gray-950 text-right" value="{{$year}}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <label for="year" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">@if($epreuve_type == 'simple') L'année de conception @elseif($epreuve_type == 'examen') Examen @if($exam_type) {{ Str::upper($exam_type) }} @endif de l'année @endif </label>
                                @error('year')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                            @if($exam_session && $exam_session == 'blanc')
                            <div class="relative z-0 w-full mb-5 group">
                                <select wire:model.live="exam_department" type="text" name="exam_department" id="exam_department" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer font-semibold letter-spacing-1 pl-2" placeholder="L'examen ciblé">
                                    <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="">Sélectionner le département</option>
                                    <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="Examen blanc unique nationnal">Examen blanc unique nationnal</option>
                                    @foreach ($departments as  $dep_value => $department)
                                        <option class="bg-gray-600 text-gray-950 font-semibold letter-spacing-1" value="{{$department}}">{{ $department }}</option>
                                    @endforeach
                                </select>
                                <label for="exam_department" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Le département de l'examen blanc</label>
                                @error('exam_department')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>
                            @endif
                        </div>

                        @if($epreuve_type !== 'examen' )
                        <div class="w-full my-2">
                            <h5 class="my-3 text-gray-500 xs:text-xs lg: w-full">
                                <span>Veuillez sélectionner les filières</span>

                                <span class="float-right text-orange-300"> {{ count($selecteds) }} filières sélectionnées </span>
                            </h5>
                        </div>
                        <div class="mt-3 w-full mb-5 group overflow-y-auto" style="max-height: 300px">

                            <table class="w-full text-center border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400 xs:text-xs lg:text-sm">
                    
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
                                        <th scope="col" class="px-6 py-3 text-right float-right">
                                            Action à effectuer 
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filiars as $key => $filiar)
                                    <tr title="Cliquer pour ajouter ou retirer la filière {{ $filiar->name }}" @if(in_array($filiar->id, $selecteds))  wire:click='retrieveFromSelecteds({{$filiar->id}})' @else wire:click='pushIntoSelecteds({{$filiar->id}})' @endif wire:key="filiar-joined-to-support-{{$filiar->id}}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 cursor-pointer">
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

                    @if($file_epreuve)
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
                    <label for="file_epreuve" wire:loading.remove wire:target='file_epreuve' class="p-3 m-0 mx-auto flex justify-center w-full font-semibold letter-spacing-1">
                        <span  class="text-gray-600 w-full border h6 border-warning-500 rounded bg-gray-400 text-center cursor-pointer py-2 px-3 ">Veuillez sélectionner votre épreuve</span>
                    </label>
                    @endif
                </div>
            </div>
        </div>

    @else
        <div class="my-2 mt-10 px-3 font-semibold letter-spacing-1
        flex flex-col justify-center gap-y-3 items-center text-sm text-center lg:w-3/5 xl:w-4/5 md:w-4/5 mx-auto ">

            <h4 wire:click="$set('uploaded_completed', false)" class="font-semibold uppercase bg-success-500 text-gray-900 py-6 flex flex-col text-center rounded-lg px-8 cursor-pointer border border-green-700 mb-6">
                Bravo, votre épreuve a été envoyée avec succès!

                <span class="text-orange-600 mt-5"> Cliquer pour Envoyer une autre épreuve </span>
            </h4>

            <h4 wire:click="$set('uploaded_completed', false)"  class="font-semibold uppercase hover:bg-blue-900 hover:text-gray-300 bg-blue-500 cursor-pointer text-gray-900 py-6 text-center rounded-lg px-8 border mt-20 border-green-700">
                Publier une autre épreuve
            </h4>

        </div>

    @endif
</div>

