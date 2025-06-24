@push('css')
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .activities .swiper-slide .card img.card-img-top {
            height: 300px !important;
        }

        .activities .swiper-button-next,
        .swiper-button-prev {
            color: #fff !important;
        }

        .activities .swiper-button-prev {
            left: 0;
            font-size: 28px;
            width: 40px;
            height: 40px;
            background-color: #ba7d22 !important;
            background-size: 16px;
            border-radius: 50%;
        }

        .activities .swiper-button-next {
            right: 0;
            width: 40px;
            height: 40px;
            background-color: #ba7d22 !important;
            background-size: 16px;
            border-radius: 50%;
        }


        .activities .swiper-slide,
        .card,
        .card .ctaCard__image,
        .card .ctaCard__image img {
            border-radius: 10px;
        }

        .activities .swiper-slide {
            margin: 0 !important;
            padding: 10px;
        }

        .swiper-button-next:after,
        .swiper-rtl .swiper-button-prev:after {
            content: ''!important;
        }

        .swiper-button-prev:after,
        .swiper-rtl .swiper-button-next:after {
            content: '' !important;
        }
    </style>
@endpush
<section class="layout-pt-lg">

    <div class="activities">
        <div data-anim-wrap class="container">
            @if(!empty($title))
                <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
                    <div class="col-auto">
                        <div class="sectionTitle -md">
                            <h2 class="sectionTitle__title text-center">{{ $title ?? '' }}</h2>
                            <p class=" sectionTitle__text mt-5 sm:mt-10 text-center">{{ $desc ?? '' }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="position-relative" data-anim-child="slide-up delay-2">
                <div class="swiper mySwiperActivities mt-20 sm:mt-10">
                    <div class="swiper-wrapper">
                        @foreach($list_item as $key => $item)
                            <div class="swiper-slide ">
                                <a href="{{$item['link_more']}}">
                                <div class="card -type-1 ">
                                    <div class="ctaCard__image ratio ratio-41:35">
                                        <img class="img-ratio js-lazy" src="#"
                                            data-src="{{ get_file_url($item['image'], 'full') ?? "" }}" alt="image">
                                    </div>
                                    <div class="ctaCard__content mt-15 sm:mt-10 ">

                                        <h4 class="text-16 text-center text-dark">{!! clean($item['title']) !!}</h4>

                                        {{-- <div class="d-inline-block mt-30">
                                            <a href="{{$item['link_more']}}"
                                                class="button px-48 py-15 -blue-1 -min-180  text-white">{{$item['link_title']}}</a>
                                        </div> --}}
                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="swiper-button-next "></div>
                <div class="swiper-button-prev "></div>
            </div>
        </div>

    </div>

</section>
@push('js')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiperActivities", {
            slidesPerView: 1, // Default for mobile
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                500: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
    </script>

@endpush