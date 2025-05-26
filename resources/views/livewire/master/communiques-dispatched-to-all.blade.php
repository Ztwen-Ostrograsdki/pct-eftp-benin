<div>
    <div>
        <div>
            <div class="swiper MyCommuniquesSwiper max-w-4xl mx-auto">
                <h3 class="font-bold text-center text-3xl flex justify-center items-center letter-spacing-1 py-3 text-gray-800 uppercase mb-5" >Page COMMUNIQués
                    <span class="ml-3 text-base border border-gray-800 rounded-full p-1 text-center px-2 bg-gray-600 text-white">
                        {{ numberZeroFormattor(count($communiques)) }}
                    </span>
                </h3>
                <div class="swiper-wrapper">
                <!-- Slide 1 -->
                @foreach ($communiques as $communique)
                    <div wire:key='defilement-reviews-membre-{{$communique->id}}' class="swiper-slide bg-transparent">
                        @livewire('master.communique-component',['id' => $communique->id, 'slug' => $communique->slug])
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
