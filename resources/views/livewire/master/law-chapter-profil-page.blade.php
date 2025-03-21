<div>
    <div class="mx-auto shadow-3 shadow-sky-600 rounded-lg  my-3 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 p-2 m-2 bg-gray-950">
      <h1 class="p-4 flex items-center justify-between text-center">
          <div class="text-xs letter-spacing-2 uppercase">
              <div class="text-sky-400 flex flex-col gap-y-1">
                  <h6 class="">Détails sur le chapitre</h6>
                  <h6>
                    <span class="font-bold text-orange-500">
                        {{ $chapter->chapter }}
                    </span>
                  </h6>
                  <h6 class="letter-spacing-1 text-purple-400 ">
                    de la loi {{ $chapter->law->name }}
                  </h6>
              </div>
          </div>
  
          <div class="flex gap-x-2">
              <span class="flex flex-col">
                <span class="text-purple-500 letter-spacing-1 font-semibold">
                    {{ count($chapter->articles) }} article(s)
                </span>
              </span>
          </div>
      </h1>

      <div class="p-4 shadow-1 shadow-sky-600 rounded-lg my-4">
        <div class="">
            
            <div class="text-sky-600">
                <h6 class="font-bold letter-spacing-1">Description du chapitre :</h6>
                <p class="letter-spacing-1 text-gray-400">
                    {{ $chapter->description }}
                </p>
            </div>
        </div>
      </div>

      <div class="flex flex-wrap justify-between gap-y-2 pt-4 border-t dark:border-gray-700">
        <div class="flex items-center px-6 space-x-1 text-gray-400">
          <div class="flex items-center text-xs">
              <div class="flex gap-x-2 mr-3 float-right justify-end  text-gray-700 dark:text-gray-400">
                  <div class="">
                      <span wire:click="editChapter({{$chapter->id}})" class="border cursor-pointer bg-green-300 text-green-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-green-400 px-3 py-2 rounded ">
                          <span class="fas fa-edit"></span>
                          <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='editChapter({{$chapter->id}})'>Editer</span>
                          <span wire:loading wire:target='editChapter({{$chapter->id}})' class="fas fa-rotate animate-spin"></span>
                      </span>
                  </div>
                  <div class="">
                      <span wire:click="deleteChapter({{$chapter->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-red-400 px-3 py-2 rounded ">
                          <span class="fas fa-trash"></span>
                          <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='deleteChapter({{$chapter->id}})'>Supprimer</span>
                          <span wire:loading wire:target='deleteChapter({{$chapter->id}})' class="fas fa-rotate animate-spin"></span>
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
                Liste des articles du chapitre
                <span class="font-bold text-orange-500 uppercase">
                    {{ $chapter->chapter }}
                </span>
            </h6>
        </div>
        <div class="flex flex-wrap gap-x-2 w-full">
            @foreach ($law->articles as $article)
                <div wire:key="chapter-articles-listing-table-{{$article->id}}" class="shadow-2 shadow-sky-500 rounded-lg pb-2 flex flex-col items-center text-center lowercase cursor-pointer text-gray-300 bg-sky-900 px-3 hover:bg-sky-800">
                    <div class="flex justify-end w-full gap-x-2 m-0">
                        <span wire:click="deleteArticle({{$article->id}})" class=" cursor-pointer text-red-700 hover:shadow-lg hover:text-red-600 hover:scale-110">
                            <span class="fas fa-trash"></span>
                            <span wire:loading wire:target='deleteArticle({{$article->id}})' class="fas fa-rotate animate-spin"></span>
                        </span>

                        <span wire:click="editArticle({{$article->id}})" class=" cursor-pointer text-green-700 hover:shadow-lg hover:text-green-600 hover:scale-110">
                            <span class="fas fa-edit"></span>
                            <span wire:loading wire:target='editArticle({{$article->id}})' class="fas fa-rotate animate-spin"></span>
                        </span>
                    </div>
                    <span  class="text-sm uppercase">
                        {{ $article->name }}
                    </span>
                    <a class="text-xs text-orange-400">
                        {{ $article->content }}
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
