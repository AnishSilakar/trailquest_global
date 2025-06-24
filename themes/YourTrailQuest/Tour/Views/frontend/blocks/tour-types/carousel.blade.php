<section class="layout-pt-lg   adventure2">
    <div class="section-bg py-40 sm:py-20 bg-dark-1">
        @if(!empty($bg_image_1) || !empty($bg_image_2))
        @php
        $image_url1 = get_file_url($bg_image_1, 'full');
        $image_url2 = get_file_url($bg_image_2, 'full');
        $class = 'col-sm-6';
        if(empty($image_url1) || empty($image_url2)){
        $class = 'col-sm-12';
        }
        @endphp
        <div class="section-bg__item -video-left container">
            <div class="row y-gap-30 trailquest-s2">
                @if($image_url1)
                <div class="{{ $class }} pr-0">
                    <img src="{{ $image_url1 }}" alt="image">
                </div>
                @endif

                @if($image_url2)
                <div class="{{ $class }}">
                    <img src="{{ $image_url2 }}" alt="image">
                </div>
                @endif
            </div>
        </div>
        @endif
        <div class="container">
            <div class="row y-gap-30">
                <div class="offset-xl-5 col-xl-7 col-lg-7 col-md-12 col-sm-12">
                    <h2 class="h2 text-white sm:text-center">{{ $title ?? '' }}</h2>
                    @if(!empty($desc))
                    <p class="text-white mt-20  text-16 sm:mt-15 text-justify">{{ $desc }}</p>
                    @endif
                    @if(!empty($link_title))
                    <div class="btn-learnmore1 mt-20  sm:mt-15">
                        <a href="{{ $link_more ?? '' }}" class="button -md bg-gold text-white">
                            {{ $link_title }} <div class="icon-arrow-top-right ml-15"></div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>


       
    </div>
</section>
@push('css')
<style>
.section-bg__item.-video-left{
    padding:20px
}

@media (max-width: 1999px) {
.section-bg__item.-video-left{
    padding:20px
}
.section-bg__item.-video-left{
   left:0!important
} 

}
.trailquest-s2{
    flex-direction: row;
}
.trailquest-s2 .col-sm-6{
width:50%
}
.btn-learnmore1{
    width:fit-content;
    margin: 20px auto 0;
}
</style>
@endpush