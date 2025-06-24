<section class="section-bg layout-pt-lg layout-pb-lg">
    @if(!empty($bg_image_url))
        <div class="section-bg__item col-12">
            <img src="{{ $bg_image_url }}" alt="{{$title}}">
        </div>
    @endif

    <div class="container">
        <div class=" row  text-left justify-content-between">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <h1 class="text-40 md:text-25 fw-600 text-white">
                    {!! $title !!}
                </h1>
                <div class="text-white mt-15"> {{$sub_title}}</div>
                <p>{{$desc}}</p>
            </div>
            <div class="col-md-2">
            @if($link_title)
                    <div class="d-inline-block">
                        <a href="{{$link_more}}"
                            class="button -md text-14  bg-gold text-white arial fw-600">{{$link_title}}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@push('css')
    <style>
        .section-bg__item img {
            opacity: 0.2;
        }



    </style>
@endpush