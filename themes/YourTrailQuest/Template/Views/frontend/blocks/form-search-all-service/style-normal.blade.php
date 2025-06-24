
@push('css')
<style>
    @media screen and (max-width: 786px) {
    .mobile-half {
        width: 20%;
    }
    .mobile-full {
        width: 80%;
    }
}
</style>
@endpush
<section data-anim-wrap class="form-search-all-service masthead -type-1 z-5">
    <div data-anim-child="fade" class="masthead__bg">
        <img src="{{ $bg_image_url }}" alt="image" data-src="{{ $bg_image_url }}" class="js-lazy">
    </div> 
    <div class="container">
        <div class="row">
            <div class="col-auto m-auto">
                <div class="text-center">
                    <h1 data-anim-child="slide-up delay-4" class="text-60 lg:text-40 md:text-30 text-white">{{ $title }}</h1>
                    <p data-anim-child="slide-up delay-5" class="text-white mt-6 md:mt-10">{{ $sub_title }}</p>
                </div>

                @if(empty($hide_form_search))
                    <div data-anim-child="slide-up delay-6" class="tabs -underline js-tabs trailquest-searchbar"> 
                        <div class="tabs__content  js-tabs-content ">
                            @if($service_types)
                                @foreach($service_types as $k => $service_type)
                                @include(ucfirst($service_type).'::frontend.layouts.search.form-search', ['style' => 'normal'])
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
