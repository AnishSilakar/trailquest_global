<section class="layout-pt-lg">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title text-dark-1">{{ $title ?? '' }}</h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-10">{{ $sub_title ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="row y-gap-40 justify-evenly pt-40 sm:pt-20">
            @if(!empty($list_item))
                @foreach($list_item as $k => $item)
                    <?php $image_url = get_file_url($item['icon_image'], 'full') ?>

                        <div data-anim-child="slide-up delay-{{ ($k + 2) }}" class="col-lg-3 col-sm-6">

                            <div class="featureIcon -type-1 -hover-shadow ">
                                <div class="d-flex justify-center">
                                    <img src="{{$image_url}}" alt="{{$item['title'] ?? ''}}">
                                </div>

                                <div class="text-center mt-30">
                                    <h3 class="h3 text-dark-1">{{$item['title'] ?? ''}}</h3>
                                    <p class=" p-3 cursor text-center text-14 mt-10">{{$item['sub_title'] ?? ''}}</p>
                                </div>
                            </div>

                        </div>
@if($k==3) @break @endif
                @endforeach
            @endif

        </div>
    </div>
    <div class="text-center w-fit pt-20 sm:pt-10" style="margin: 0px auto 0;">
    @if(!empty($link_title) && !empty($link_more))
                        <a href="{{ $link_more }}" class="button -md text-14 fw-600 bg-gold text-white arial">
                            {{ $link_title }}
                        </a>
                    @endif</div>
</section>
