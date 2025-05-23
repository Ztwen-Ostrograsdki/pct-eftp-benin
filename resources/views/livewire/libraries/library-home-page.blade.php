<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 lg:text-lg xl:text-lg md:text-sm sm:text-sm xs:text-xs mx-auto z-bg-secondary-light mt-10 rounded-xl shadow-4 shadow-sky-500">
    <div class="py-2 mb-4 text-center shadow-3 shadow-sky-700 border border-sky-900  rounded-xl w-full my-5 mt-14">
        <div class="w-full px-2">
            <h4 class="py-3 font-bold letter-spacing-2">
                <span class="text-sky-400">
                    Vous êtes
                </span>
                <span class="text-sky-600">
                    à la
                </span>
                <span class="text-sky-500 uppercase ml-2">
                    Bibliothèque
                </span>

                <span class="fas fa-book-open text-sky-500 animate-bounce"></span>
            </h4>
        </div>
    </div>

    <div class="mx-auto my-2 mt-11 w-full">
        <div class=" w-full mt-4 text-gray-900">
            <div class="w-full mb-2 library-widget-card">
                <a class="bg-blue-300 border-white rounded-lg px-2 py-3 w-full flex justify-between" href="{{route('library.epreuves')}}">
                    <span>
                        <span>Visiter les épreuves</span>
                    <span class="fa fa-book"></span>
                    </span>
                    <span class="">
                        {{ numberZeroFormattor(count(getEpreuves(null, false))) }} épreuves(s) disponible(s)
                    </span>
                </a>
            </div>

            <div class="w-full mb-2 library-widget-card">
                <a class="bg-orange-400 border-white rounded-lg px-2 py-3 w-full flex justify-between " href="{{route('library.fiches')}}">
                    <span>
                        <span>Visiter des fiches de cours</span>
                    <span class="fa fa-book"></span>
                    </span>
                    <span class="">
                        {{ numberZeroFormattor(count(getSupportFiles())) }} fiches(s) de cours disponible(s)
                    </span>
                </a>
            </div>

            <div class="w-full mb-2 library-widget-card">
                <a class="bg-yellow-400 border-white rounded-lg px-2  py-3 w-full flex justify-between" href="{{route('library.epreuves.examens')}}">
                    <span>
                        <span>Visiter les épreuves d'examens</span>
                    <span class="fa fa-book"></span>
                    </span>
                    <span class="">
                        {{ numberZeroFormattor(count(getEpreuves(null, true))) }} épreuves(s) d'examens disponible(s)
                    </span>
                </a>
            </div>

            <div class="w-full mb-2 library-widget-card">
                <a class="bg-green-600 border-white rounded-lg px-2 py-3 w-full inline-block" href="#">
                    <span>Visiter des documents scientifiques publiés</span>
                    <span class="fa fa-book"></span>
                </a>
            </div>
        </div>
    </div>


    
  </div>
