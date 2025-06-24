@push('css')
    <style>
        .swiper-pagination {
            bottom: -10%;
            left: 50%;
            transform: translate(-50% ,50%)
        }
        .testino {
            overflow: hidden;
        }
        .size-60 {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
        }

    </style>
@endpush
@if(!empty($list_item))

    <section class="layout-pt-lg">
        <div class="bg-dark-1 layout-pt-md layout-pb-md">
            <div data-anim-wrap class="container ">
                <div data-anim-child="slide-up delay-1" class="row  text-center items-center">
                    <div class="col-md-5 sm:mb-20">
                        <div class="sectionTitle -md">
                            <h2 class="sectionTitle__title text-white">{{ $title ?? '' }}</h2>
                            <p class=" sectionTitle__text text-white mt-5 sm:mt-0">{{ $subtitle ?? '' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 testino">
                        <div class="relative swiper mySwiperCards">
                            <div class="swiper-wrapper">
                                @foreach($list_item as $item)
                                    <div class="swiper-slide">
                                        <div class="testimonials -type-1 rounded pt-40 pb-30 px-40 bg-light-2">
                                            <h4 class="text-18 fw-500 text-dark-1 mb-20">{{$item['title']}}</h4>
                                            <p class="testimonials__text line-clamp fw-500 text-dark-1">{{$item['desc']}}</p>

                                            <div class="pt-20 mt-28 border-top-light">
                                                <div class="row x-gap-20 y-gap-20 items-center">
                                                    <div class="col-auto">
                                                        <img class="size-60" src="{{get_file_url($item['avatar'])}}"
                                                            alt="{{$item['name']}}">
                                                    </div>
                                                    
                                                    <div class="col-auto">
                                                    @if(!empty($item['number_star']))
                            <div class="d-flex x-gap-5 items-center pb-10">
                                @for($i = 1; $i <= $item['number_star']; $i++)
                                    <div class="icon-star text-gold text-10"></div>
                                @endfor
                            </div>
                        @endif
                                                        <div class="text-15 fw-500 lh-14">{{$item['name']}}</div>
                                                        <div class="text-14 lh-14 text-dark-1 mt-5">{{$item['job']}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                           
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@push('js')

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>

        var swiper = new Swiper(".mySwiperCards", {
            spaceBetween: 30,
            slidesPerView: 1,
            centeredSlides: true,
            loop:true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },



        });

    </script>
@endpush