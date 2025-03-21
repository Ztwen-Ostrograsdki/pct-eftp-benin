<div>
    <div class="mx-auto shadow-3 shadow-sky-600 rounded-lg  my-3 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 p-2 m-2 z-bg-secondary-light">
      <h1 class="p-4 flex items-center justify-between text-center">
          <div class="text-xs letter-spacing-2 uppercase">
              <div class="text-sky-400 flex flex-col">
                  <h6 class="pb-2">Détails sur la loi</h6>
                  <h6>
                    <span class="font-bold text-orange-500">
                        {{ $law->name }}
                      </span>
                  </h6>
              </div>
          </div>
  
          <div class="flex gap-x-2">
              <span class="flex flex-col">
                <span class="text-orange-500 letter-spacing-1 font-semibold">
                    {{ count($law->chapters) }} chapitre(s)
                </span> 
                <span class="text-purple-500 letter-spacing-1 font-semibold">
                    {{ count($law->articles) }} article(s)
                </span>
              </span>
          </div>
      </h1>

      <div class="p-4 shadow-1 shadow-sky-600 rounded-lg my-4">
        <div class="">
            <h2 class="uppercase text-center mx-auto fa-1x border-b border-purple-500">
                <span class="text-sky-800"></span>
                <span class="letter-spacing-2 font-semibold text-purple-500">
                    {{ $law->name }}
                </span>
            </h2>

            <div class="text-sky-600">
                <h6 class="font-bold letter-spacing-1">Description:</h6>
                <p class="letter-spacing-1 text-gray-300">
                    {{ $law->description }}
                </p>
            </div>
        </div>
      </div>

      <div class="flex flex-wrap justify-between gap-y-2 pt-4 border-t dark:border-gray-700">
        <div class="flex items-center px-6 space-x-1 text-gray-400">
          <div class="flex items-center text-xs">
              <div class="flex gap-x-2 mr-3 float-right justify-end  text-gray-700 dark:text-gray-400">
                  <div class="">
                      <span wire:click="editLaw({{$law->id}})" class="border cursor-pointer bg-green-300 text-green-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-green-400 px-3 py-2 rounded ">
                          <span class="fas fa-edit"></span>
                          <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='editLaw({{$law->id}})'>Editer</span>
                          <span wire:loading wire:target='editLaw({{$law->id}})' class="fas fa-rotate animate-spin"></span>
                      </span>
                  </div>
                  <div class="">
                      <span wire:click="deleteLaw({{$law->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-red-400 px-3 py-2 rounded ">
                          <span class="fas fa-trash"></span>
                          <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='deleteLaw({{$law->id}})'>Supprimer</span>
                          <span wire:loading wire:target='deleteLaw({{$law->id}})' class="fas fa-rotate animate-spin"></span>
                      </span>
                  </div>

                <div class="">
                    <span wire:click="addNewChapter({{$law->id}})" class="border cursor-pointer bg-primary-300 text-primary-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-primary-400 px-3 py-2 rounded ">
                        <span class="fas fa-plus"></span>
                        <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='addNewChapter({{$law->id}})'>Chapitre</span>
                        <span wire:loading wire:target='addNewChapter({{$law->id}})' class="fas fa-rotate animate-spin"></span>
                    </span>
                </div>

                <div class="">
                    <span wire:click="addNewArticle({{$law->id}})" class="border cursor-pointer bg-success-300 text-success-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-success-400 px-3 py-2 rounded ">
                        <span class="fas fa-plus"></span>
                        <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='addNewArticle({{$law->id}})'>Article</span>
                        <span wire:loading wire:target='addNewArticle({{$law->id}})' class="fas fa-rotate animate-spin"></span>
                    </span>
                </div>
              </div>
          </div>
        </div>
      </div>

      <div class="w-full p-2 mx-auto my-2 px-6">

        <div class="text-sky-400 my-2">
            <h6 class="py-3 border-t border-b border-sky-400 text-center">
                Liste des chapitres de la loi
                <span class="font-bold text-orange-500 uppercase">
                    {{ $law->name }}
                </span>
            </h6>
        </div>
        <div class="flex flex-wrap gap-x-2 w-full">
            @foreach ($law->chapters as $chter)
                <div wire:key="law-chapters-listing-table-{{$chter->id}}" class="shadow-2 shadow-sky-500 rounded-lg pb-2 flex flex-col items-center text-center lowercase cursor-pointer text-gray-300 bg-sky-900 px-3 hover:bg-sky-800">
                    <div class="flex justify-end w-full gap-x-2 m-0">
                        <span wire:click="deleteChapter({{$chter->id}})" class=" cursor-pointer text-red-700 hover:shadow-lg hover:text-red-600 hover:scale-110">
                            <span class="fas fa-trash"></span>
                            <span wire:loading wire:target='deleteChapter({{$chter->id}})' class="fas fa-rotate animate-spin"></span>
                        </span>

                        <span wire:click="editChapter({{$chter->id}})" class=" cursor-pointer text-green-700 hover:shadow-lg hover:text-green-600 hover:scale-110">
                            <span class="fas fa-edit"></span>
                            <span wire:loading wire:target='editChapter({{$chter->id}})' class="fas fa-rotate animate-spin"></span>
                        </span>
                    </div>
                    <a href="{{route('law.profil.chapter', ['slug' => $chter->law->slug, 'chapter_slug' => $chter->slug])}}"  class="text-sm uppercase">
                        {{ $chter->chapter }}
                    </a>
                    <a href="{{route('law.profil.chapter', ['slug' => $chter->law->slug, 'chapter_slug' => $chter->slug])}}" class="text-xs text-orange-400">
                        {{ $chter->description }}
                    </a> 
                </div>
            @endforeach
        </div>
      </div>

      <div class="p-4 text-right">
        <p class="text-xs text-gray-600 dark:text-gray-400"> Instaurée depuis, {{ $law->__getDateAsString($law->created_at) }}
        </p>
      </div>
    </div>
</div>
