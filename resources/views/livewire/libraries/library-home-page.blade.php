<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 lg:text-lg xl:text-lg md:text-sm sm:text-sm xs:text-xs mx-auto z-bg-secondary-light mt-10 rounded-xl shadow-4 shadow-sky-500">
    <div class="py-2 mb-4 text-center shadow-3 shadow-sky-700 border border-sky-900  rounded-xl w-full my-5 mt-14">
        <div class="w-full px-2 uppercase">
            <h4 class="py-3 font-bold letter-spacing-2 lg:text-4xl xl:text-4xl md:text-lg sm:text-sm xs:text-sm">
                <span class="text-sky-500 library-widget-card">
                    Vous êtes
                </span>
                <span class="text-sky-500 library-widget-card">
                    à la
                </span>
                <span class="text-sky-400 uppercase library-widget-card">
                    Bibliothèque
                    <span class="fas fa-book-open"></span>
                </span>

                
            </h4>
        </div>
    </div>

    <div class="mx-auto my-2 mt-11 w-full">
        <div class=" w-full mt-4 flex flex-col gap-y-4 text-gray-900">
            <div class="w-full rounded-lg library-widget-card hover:shadow-sm hover:shadow-white">
                <a class="bg-blue-300 hover:bg-blue-800 hover:text-white border-white rounded-lg px-2 py-3 w-full flex justify-between" href="{{route('library.epreuves')}}">
                    <span>
                        <span>Visiter les épreuves</span>
                    <span class="fa fa-book"></span>
                    </span>
                    <span class="">
                        {{ numberZeroFormattor($simple_epreuves) }} épreuves(s) disponible(s)
                    </span>
                </a>
            </div>
            <div class="w-full rounded-lg library-widget-card hover:shadow-sm hover:shadow-white">
                <a class="bg-yellow-400 hover:bg-yellow-600 hover:text-white border-white rounded-lg px-2  py-3 w-full flex justify-between" href="{{route('library.epreuves.examens')}}">
                    <span>
                        <span>Visiter les épreuves d'examens</span>
                    <span class="fa fa-book"></span>
                    </span>
                    <span class="">
                        {{ numberZeroFormattor($exam_epreuves) }} épreuves(s) d'examens disponible(s)
                    </span>
                </a>
            </div>
            <div class="w-full rounded-lg library-widget-card hover:shadow-sm hover:shadow-white">
                <a class="bg-orange-400 hover:bg-orange-600 hover:text-white border-white rounded-lg px-2 py-3 w-full flex justify-between " href="{{route('library.fiches')}}">
                    <span>
                        <span>Visiter des fiches de cours</span>
                    <span class="fa fa-book"></span>
                    </span>
                    <span class="">
                        {{ numberZeroFormattor($support_files) }} fiches(s) de cours disponible(s)
                    </span>
                </a>
            </div>

            <div class="w-full rounded-lg library-widget-card hover:shadow-sm hover:shadow-white">
                <a class="bg-green-600 hover:bg-green-700 border-white flex justify-between rounded-lg px-2 py-3 w-full" href="#">
                    <span>
                        <span>Visiter des documents scientifiques publiés</span>
                        <span class="fa fa-book"></span>
                    </span>

                    <span class="text-white">
                        Indisponible pour l'instant
                    </span>
                </a>
            </div>
        </div>
    </div>


    
  </div>
