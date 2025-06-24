@php $headerAlign = '';
if ($header_align == 'center') $headerAlign = 'justify-center text-center';
if ($header_align == 'right') $headerAlign = 'justify-content-end text-right';
@endphp
@switch($style)
@case("style_3")
@include('News::frontend.blocks.list-news.style_3')
@break
@case('style_4')
@include('News::frontend.blocks.list-news.style_4')
@break
@case('style_5')
@include('News::frontend.blocks.list-news.style_5')
@break
@case('style_6')
@include('News::frontend.blocks.list-news.style_6')
@break
@default
<section class="layout-pt-lg layout-pb-md bravo-list-news">
    <div data-anim-wrap class="container">
        <div data-anim-child="slide-up delay-1" class="row {{$headerAlign}}">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title text-36"> {{$title}}</h2>
                    @if(!empty($desc))
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc}}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row y-gap-30 pt-40">
            @foreach($rows as $key => $row)
            <div data-anim-child="{{$style != 'style_2' ? 'slide-right delay-1' : 'slide-up delay-'.($key+3)}}"
                class="{{$style != 'style_2' ? 'col-lg-4' : 'col-lg-3'}} col-sm-6 ">
                @include('News::frontend.blocks.list-news.loop', ['style' => $style])
            </div>
            @endforeach
        </div>

    </div>
    @if(!empty($link_more))
        <div class="text-center news-blog-alltext-center w-fit pt-20 sm:pt-10" style="margin: 10px auto 0;">
                <a href="{{$link_more}}" class="button -md text-14  bg-gold text-white arial fw-600">{{$link_title}}</a>
</div>
            @endif
</section>

@endswitch