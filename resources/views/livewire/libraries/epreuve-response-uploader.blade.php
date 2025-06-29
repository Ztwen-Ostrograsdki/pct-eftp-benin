<div class="w-full  p-5 mx-auto  @if(!$uploaded_completed)  @endif rounded-lg mt-5">
    @if(!$uploaded_completed)
        <div class="border border-sky-400 p-0 shadow-md shadow-sky-600" >
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
            <div class="bg-gray-900 w-full lg:text-base xl:text-base md:text-sm sm:text-sm xs:text-xs pb-3 @if($errors->any()) shadow-3-strong shadow-red-500 @endif ">
                <div class="w-full">
                    <div class="m-0 my-2 p-2 border-b flex-col flex w-full">
                        <h6 class="py-3 text-purple-400 flex justify-start uppercase text-lg font-semibold letter-spacing-1">Gestionnaire d'envoi des éléments de réponses d'une épreuve
                        </h6>
                        <div class="w-full flex gap-x-3 justify-end">
                            <a class="border py-2 px-3 rounded-lg bg-blue-500 hover:bg-blue-600 text-gray-50" href="{{route('library.epreuves')}}">
                                <span class="xs:hidden lg:inline">Page de téléchargement</span>
                                <span class="fas fa-download"></span>
                            </a>
                            <a class="border py-2 px-3 rounded-lg bg-green-500 hover:bg-blue-600 text-gray-50" href="{{route('library.epreuves.examens')}}">
                                <span class="xs:hidden lg:inline">Page de téléchargement épreuves d'examen</span>
                                <span class="fas fa-download"></span>
                            </a>
                        </div>

                    </div>

                    @session('epreuve-success')
                    <div class="mx-auto w-full p-3">
                        <h6 class="w-full py-3 px-3 mx-auto text-center letter-spacing-2 rounded-lg shadow-3 shadow-green-500 bg-green-400 text-green-950">
                            {{ session('epreuve-success') }} 
                        </h6>
                    </div>
                    @endsession
                </div>

                <div class="w-full px-3 mt-5">
                    <form class="w-full mx-auto">

                        <div class="grid md:grid-cols-2 md:gap-6">

                            <div class="relative z-0 w-full mb-5 group">
                                <input disabled wire:model.live="name" type="text" name="name" id="name" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer opacity-45" placeholder="Renseigner un nom à votre fichier" />
                                <label for="name" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Le nom de votre fichier</label>
                                @error('name')
                                    <span class="text-red-600">{{$message}}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="grid md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input wire:model.live="the_file" type="file" name="the_file" id="the_file" class="block ucfirst py-2.5 px-0 w-full  text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-green-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Veuillez Sélectionner le fichier" />
                                <label for="the_file" class=" peer-focus:font-medium absolute  text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Sélectionner le fichier</label>
                                @error('the_file')
                                    <span class="text-red-600">{{$message}}</span>
                                @elseif($the_file && !$errors->any())
                                    <span class="text-yellow-400 letter-spacing-2 float-right text-right"> Taille du fichier : {{$the_file->getSize() >= 1048580 ? number_format($the_file->getSize() / 1048576, 2) . ' Mo' :  number_format($the_file->getSize() / 1000, 2) . ' Ko'}} </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>

                <div class="my-3 mx-auto px-2">

                    <div class="bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='the_file'>
                        <span class=" text-orange-400 text-center letter-spacing-2">
                            <span class="fas fa-rotate animate-spin"></span>
                            Chargement fichier en cours... Veuillez patientez!
                        </span>
                    </div>

                    @if($the_file)
                    <div wire:loading.remove wire:target='the_file' class="m-0 p-3 mx-auto flex w-full justify-center">

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
                    <label for="the_file" wire:loading.remove wire:target='the_file' class="p-3 m-0 mx-auto flex justify-center w-full font-semibold letter-spacing-1">
                        <span  class="text-gray-600 w-full border h6 border-warning-500 rounded bg-gray-400 text-center cursor-pointer py-2 px-3 ">Veuillez sélectionner votre épreuve</span>
                    </label>
                    @endif
                </div>
            </div>
        </div>

    @else
        <div class="my-2 mt-10 px-3 font-semibold letter-spacing-1
        flex flex-col justify-center gap-y-3 items-center text-lg text-center w-full mx-auto ">

            <h4 wire:click="$set('uploaded_completed', false)" class="font-semibold uppercase bg-green-700 text-gray-900 py-6 flex flex-col text-center rounded-lg px-8 cursor-pointer border border-green-700 mb-6 w-5/6">
                Bravo, votre fichier a été envoyée avec succès!

                <span class="text-blue-300 mt-5"> Cliquer pour Envoyer une autre fichier </span>
            </h4>

        </div>

    @endif
</div>


