<div>
    <section class="pb-14 font-poppins {{ $is_included ? '' : 'bg-gray-800' }}">
        <div class="max-w-6xl px-4 py-6 mx-auto lg:py-4 md:px-6">
          <div class="w-full my-3 mb-6 mx-auto">
            <div class="text-center ">
              <div class="relative flex flex-col items-center">
                <h1 class="text-xl font-bold letter-spacing-1 font-mono dark:text-gray-200 flex flex-col gap-2 ">
                    <span class="text-blue-500 text-2xl border-b border-sky-500">{{env('APP_NAME')}}</span> 
                    <span class="my-3">
                        {{ env('APP_FULL_NAME') }}
                    </span>
                </h1>
                <div class="flex w-full mt-2 mb-0 overflow-hidden rounded">
                  <div class="flex-1 h-2 bg-blue-200"></div>
                  <div class="flex-1 h-2 bg-blue-300"></div>
                  <div class="flex-1 h-2 bg-blue-400"></div>
                  <div class="flex-1 h-2 bg-blue-500"></div>
                  <div class="flex-1 h-2 bg-blue-600"></div>
                  <div class="flex-1 h-2 bg-blue-700"></div>
                  <div class="flex-1 h-2 bg-blue-800"></div>
                  <div class="flex-1 h-2 bg-blue-900"></div>
                </div>
              </div>
              <p class=" my-0 text-center text-gray-200">
                <div class="my-3 text-lg letter-spacing-2 py-2 text-sky-500 shadow-2 shadow-sky-400 rounded-2xl association-objectives-card">
                    <span>NOS OBJECTIFS</span>
                </div>
                <div class="text-gray-100 text-left py-3">
                    @include('pdftemplates.aesp-objectives-template')
                </div>
              </p>
            </div>
          </div>
          <div class="flex w-full flex-row-reverse mt-2 mb-0 overflow-hidden rounded">
            <div class="flex-1 h-2 bg-blue-200"></div>
            <div class="flex-1 h-2 bg-blue-300"></div>
            <div class="flex-1 h-2 bg-blue-400"></div>
            <div class="flex-1 h-2 bg-blue-500"></div>
            <div class="flex-1 h-2 bg-blue-600"></div>
            <div class="flex-1 h-2 bg-blue-700"></div>
            <div class="flex-1 h-2 bg-blue-800"></div>
            <div class="flex-1 h-2 bg-blue-900"></div>
          </div>
        </div>
    </section>
</div>
