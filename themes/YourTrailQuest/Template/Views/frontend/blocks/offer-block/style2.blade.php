@push('css')
<style>
.swiper.mySwiperOffer {
    margin: 2px auto;
    width: 100%;
    height: 100%;
    position: relative;
    padding: 10px;
}

.swiper-slide.offer-package {
    background-position: center;
    background-size: cover;
    width: 100%;
    height: 100%;
}

.swiper-slide.offer-package img {
    display: block;
    width: 100%;
}

.swiper-pagination-bullet-active {
    background-color: #ba7d22!important;
}


.swiper-pagination-bullet {
    margin-right: 20px;
    background: #ba7d22;
}

.swiper-pagination {
    left: 50%;
}

.swiper-button-next {
    right: 0px;
}
.swiper-button-next, .swiper-container-rtl .swiper-button-prev {
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%2027%2044'%3E%3Cpath%20d%3D'M27%2C22L27%2C22L5%2C44l-2.1-2.1L22.8%2C22L2.9%2C2.1L5%2C0L27%2C22L27%2C22z'%20fill%3D'%23ffffff'%2F%3E%3C%2Fsvg%3E");
}
.swiper-button-prev,.swiper-container-rtl .swiper-button-next {
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%2027%2044'%3E%3Cpath%20d%3D'M0%2C22L22%2C0l2.1%2C2.1L4.2%2C22l19.9%2C19.9L22%2C44L0%2C22L0%2C22L0%2C22z'%20fill%3D'%23ffffff'%2F%3E%3C%2Fsvg%3E");
}
</style>
@endpush
<div class="bravo-offer layout-pt-md">
    <div data-anim-wrap class="container">
        @if(!empty($title))
        <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title text-center">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-10 text-center">{{ $subtitle ?? '' }}</p>
                </div>
            </div>
        </div>
        @endif
        @if(!empty($list_item))
        <div class="row noswiperOffer sm:d-none y-gap-20 pt-40">
            @foreach($list_item as $key=>$item)

            <div class="col-lg-4 col-sm-6">
                <div class="ctaCard -type-1 rounded-4">
                    <div class="ctaCard__image ratio ratio-23:18">
                        <img class="img-ratio js-lazy" src="#"
                            data-src="{{ get_file_url($item['background_image'],'full') ?? "" }}" alt="image">
                    </div>
                    <div
                        class="ctaCard__content py-50 px-50 lg:py-30 lg:px-30  d-flex flex-column justify-content-end ">
                        @if(!empty($item['featured_text']))
                        <h4 class="text-30 lg:text-24 text-white text-center">{{ $item['featured_text'] }}</h4>
                        @endif
                        <h4 class="text-30 lg:text-24 text-white text-center">{!! clean($item['title']) !!}</h4>

                        <div class="d-inline-block mt-30">
                            <a href="{{$item['link_more']}}"
                                class="button px-48 py-15 -blue-1 -min-180 bg-gold text-white">{{$item['link_title']}}</a>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        @endif

        <div class="swiper mySwiperOffer pt-20 d-none sm:d-block">
            <div class="swiper-wrapper offers">
                @foreach($list_item as $key=>$item)
                <div class="swiper-slide offer-package">



                    <div class="ctaCard -type-1 rounded-4">
                        <div class="ctaCard__image ratio ratio-41:45">
                            <img class="img-ratio js-lazy" src="#"
                                data-src="{{ get_file_url($item['background_image'],'full') ?? "" }}" alt="image">
                        </div>
                        <div
                            class="ctaCard__content py-50 px-50 lg:py-30 lg:px-30  d-flex flex-column justify-content-end ">
                            @if(!empty($item['featured_text']))
                            <h4 class="text-30 lg:text-24 text-white">{{ $item['featured_text'] }}</h4>
                            @endif
                            <h4 class="text-30 lg:text-24 text-white">{!! clean($item['title']) !!}</h4>

                            <div class="d-inline-block mt-30">
                                <a href="{{$item['link_more']}}"
                                    class="button px-48 py-15 -blue-1 -min-180 bg-gold text-white">{{$item['link_title']}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next offer-package-next"></div>
            <div class="swiper-button-prev offer-package-prev"></div>
            <!-- <div class="swiper-pagination offer-pagination"></div> -->
        </div>

    </div>

</div>
@push('js')
<script>
var swiper = new Swiper(".mySwiperOffer", {
    effect: "flip",
    grabCursor: true,
    pagination: {
        el: ".swiper-pagination",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
</script>
@endpush