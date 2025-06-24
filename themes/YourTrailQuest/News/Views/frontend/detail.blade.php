@extends('layouts.app')
@push('css')
<link href="{{ asset('dist/frontend/module/news/css/news.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
<link href="{{ asset('dist/frontend/css/app.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}" />
<link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}" />
<style>
.table-of-contents {
    top: 50px;
    position: relative;
    flex-basis: 260px;
    background: #F5F5F5;
}

.table-of-contents ul {
    position: fixed;
    /* Chrome (asshole)  */
    position: sticky;
    /* Firefox  */
    margin-top: 2em;
    top: 4em;
}

h1:first-child {
    margin-top: 0;
}

.post-content {
    flex-basis: 600px;
    max-width: 100%;
}


/* TOC part */

.table-of-contents svg {
    position: absolute;
    left: 0;
    top: 50%;
    bottom: auto;
    display: none;
    transform: translateY(-50%);
}
.table-of-contents svg {
    stroke: #cc2027;
}

.toc-reading svg {
    display: block;
}

.table-of-contents ul {
    counter-reset: articles;
    padding: 0;
}

.table-of-contents li {
    display: block;
    counter-increment: articles;
}

.table-of-contents li+li {
    margin-top: 2em;
}

.table-of-contents a {
    font-family:Poppins;
    display: block;
    padding: 0 1.1em 0 3.2em;
    position: relative;
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

aside#sidebar {
    background-color: #121212;
}

.table-of-contents p {
    text-transform: uppercase;
    letter-spacing: 0.125em;
    color: #fff;
    font-weight: 700;
    font-family:Poppins;
}

a.toc-reading, a.toc-already-read.toc-reading {
    color: #cc2027;
    opacity: 1;
}

a.toc-already-read {
    opacity: 0.4;
}

.table-of-contents a:before {
    content: counter(articles, decimal);
    position: absolute;
    bottom: auto;
    left: 0;
    top: 50%;
    width: 36px;
    height: 36px;
    line-height: 34px;
    text-align: center;
    transform: translateY(-50%);
    transition: background-color 0.3s ease 0s, color 0.3s ease 0s;
    border-radius: 50%;
    box-shadow: 0 0 0 1px #d9d9d9 inset;
    color: #fff;
}

.col-6.align-center {
    align-items: center;
    display: flex;
}

.sticky {
    position: sticky;   
    height: auto;
    overflow-y: auto;
}

.my-bg {
    background-color: #121212;
    padding: 50px;
}
.text-39 {
    color:#fff;
    font-size:39px;
    line-height:1!important;
    font-family:Poppins!important;
}
.text-15.text-light-1.mt-10 {
    color: #fff;
}
@media (max-width: 575px) {
    .text-39 {
        font-size:30px;
    }
    .news-detail{
        flex-direction:column;
    }
    .my-bg {
    background-color: #121212;
    padding: 30px;
}
}
</style>
@endpush
@section('content')
<div class="bravo-news">
    @include('News::frontend.layouts.details.news-breadcrumb')
    <section data-anim="slide-up" class="my-bg layout-pt-md">
        <div class="container">
            <div class="row y-gap-40 d-flex items-center news-detail">
                <div class="col-md-6 align-center">
                    <div class="title-al">
                        <div class="text-14  text-center color-trailquest-red arial fw-500  mb-8">
                            @php $category = $row->category; @endphp
                            @if(!empty($category))
                            @php $t = $category->translate(); @endphp
                            {{$t->name ?? ''}}
                            @endif
                        </div>
                        <h1 class=" text-center text-white">{{$translation->title}}</h1>
                        <div class="text-14 text-light-1 mt-10"><i class="icon-clock text-14"></i>
                            {{ display_date($row->updated_at)}} | <i class="icon-user text-14"></i>  {{ $translation->author->getDisplayName() }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if($image_url = get_file_url($row->image_id, 'full'))
                    <img src="{{ $image_url  }}" alt="{{$translation->title}}" class="col-12 rounded-8">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section data-anim="slide-up" class=" ">

        <div class="container sidebar-container">
            <div class="row y-gap-30 justify-center">
                <div class="col-xl-4 col-lg-4 pt-20 sm:pt-40">
                    <aside class="table-of-contents my-bg" id="sidebar">
                        <!-- will be generated with JS -->
                    </aside>
                </div>
                <div class="col-xl-8 col-lg-10 pt-40 sm:pt-20">
                    <div class="">
                        <main class="post-content pt-20 sm:pt-0">
                            {!! $translation->content !!}
                        </main>
                        <div class="row y-gap-20 justify-between pt-30">
                            <div class="col-auto">
                                <div class="d-flex items-center">
                                    <div class="fw-500 mr-10">{{ __("Share") }}</div>
                                    <div class="d-flex items-center">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"
                                            target="_blank" original-title="{{__("Facebook")}}"
                                            class="flex-center size-40 rounded-full"><i
                                                class="icon-facebook text-14"></i></a>
                                        <a href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"
                                            target="_blank" original-title="{{__("Twitter")}}"
                                            class="flex-center size-40 rounded-full"><i
                                                class="icon-twitter text-14"></i></a>
                                        <a href="#" class="flex-center size-40 rounded-full"><i
                                                class="icon-instagram text-14"></i></a>
                                        <a href="#" class="flex-center size-40 rounded-full"><i
                                                class="icon-linkedin text-14"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row x-gap-10 y-gap-10">
                                    @if (!empty($tags = $row->getTags()) and count($tags) > 0)
                                    @foreach($tags as $tag)
                                    @php $t = $tag->translate(); @endphp
                                    <div class="col-auto">
                                        <a href="{{ $tag->getDetailUrl(app()->getLocale()) }}"
                                            class="button -blue-1 py-5 px-20 bg-blue-1-05 rounded-100 text-15 fw-500 text-blue-1">
                                            {{$t->name ?? ''}}
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($row->user))
                    <div class="border-top-light border-bottom-light py-30 mt-30">
                        <div class="row y-gap-30">
                            <div class="col-auto">
                                <img src="{{$row->author->avatar_url}}" alt="image" class="size-70 rounded-full">
                            </div>
                            <div class="col-md">
                                <h3 class="text-18 fw-500">{{ $row->author->getDisplayName() }}</h3>
                                <div class="text-14 text-light-1">{{ $row->author->city }}</div>
                                <div class="text-15 mt-10">{{ $row->author->bio }}</div>
                            </div>
                        </div>
                    </div>
                    @endif


                </div>
            </div>
        </div>

    </section>
    @if(!empty($related))
    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{ __("Related content") }}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ __("Get inspiration for your next trip") }}</p>
                    </div>
                </div>
            </div>
            <div class="row y-gap-30 pt-40">
                @foreach( $related as $item)
                <div class="col-lg-3 col-sm-6">
                    @php $item_translation = $item->translate();@endphp
                    <a href="" class="blogCard -type-2 d-block bg-white rounded-4 shadow-4">
                        <div class="blogCard__image">
                            <div class="ratio ratio-1:1 rounded-4">
                                {!! get_image_tag($item->image_id,'medium',['class'=>'img-ratio
                                rounded-4','alt'=>$item_translation->title,'lazy'=>false]) !!}
                            </div>
                        </div>
                        <div class="px-20 py-20">
                            <h4 class="text-dark-1 text-16 lh-18 fw-500">
                                {!! clean($item_translation->title) !!}
                            </h4>
                            <div class="text-light-1 text-15 lh-14 mt-10 text-left">
                                <i class="icon-clock text-14"></i> {{ display_date($item->updated_at)}}
                            </div>
                            <div class="text-15 lh-16 text-light-1 mt-10 md:mt-5">
                                {!! get_exceprt($translation->content,80,'...') !!}
                            </div>

                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection
@push('js')
<script>
var positions = [],
    build_toc = function() {
        var output = '<p>Table of content</p><ul>',
            svg =
            '<svg viewBox="0 0 36 36" height="36px" width="36px" y="0px" x="0px"><circle transform="rotate(-90 18 18)" stroke-dashoffset="100" stroke-dasharray="100 100" r="16" cy="18" cx="18" stroke-width="2" fill="none"/></svg>';

        $('.post-content').find('h2').each(function(i) {
            $(this).attr('id', 'title_' + i)

            output += '<li><a href="#title_' + i + '" class="toc-title_' + i + '">' + svg + $(this).text() +
                '</a></li>';
        });

        return output;
    },
    get_bottom_off_content = function() {
        var $content = $('.post-content'),
            offset = $content.offset();

        return $content.outerHeight() + offset.top;
    },
    get_positions = function() {
        $('.post-content').find('h2').each(function(i) {
            offset = $(this).offset();
            positions['title_' + i] = offset.top;
        });
        return positions;
    },
    set_toc_reading = function() {
        var st = $(document).scrollTop(),
            count = 0;

        for (var k in positions) {
            var n = parseInt(k.replace('title_', ''));
            has_next = typeof positions['title_' + (n + 1)] !== 'undefined',
                not_next = has_next && st < positions['title_' + (n + 1)] ? true : false,
                diff = 0,
                $link = $('.toc-' + k);

            if (has_next) {
                diff = (st - positions[k]) / (positions['title_' + (n + 1)] - positions[k]) * 100;
            } else {
                diff = (st - positions[k]) / (get_bottom_off_content() - positions[k]) * 100;
            }

            $link.find('circle').attr('stroke-dashoffset', Math.round(100 - diff));

            if (st >= positions[k] && not_next && has_next) {
                $('.toc-' + k).addClass('toc-reading');
            } else if (st >= positions[k] && !not_next && has_next) {
                $('.toc-' + k).removeClass('toc-reading');
            } else if (st >= positions[k] && !not_next && !has_next) {
                $('.toc-' + k).addClass('toc-reading');
            }

            if (st >= positions[k]) {
                $('.toc-' + k).addClass('toc-already-read');
            } else {
                $('.toc-' + k).removeClass('toc-already-read');
            }

            if (st < positions[k]) {
                $('.toc-' + k).removeClass('toc-already-read toc-reading');
            }

            count++;
        }
    };

// build our table of content
$('.table-of-contents').html(build_toc());

// first definition of positions
get_positions();

// on resize, re-calc positions
$(window).on('resize', function() {
    get_positions();
});

$(document).on('scroll', function() {
    set_toc_reading();
    var sidebar = document.querySelector('#sidebar');
    var sticky = sidebar.offsetTop;

    if (window.pageYOffset > sticky) {
        sidebar.classList.add("sticky");
    } else {
        sidebar.classList.remove("sticky");
    }
});


const scrollBar = document.querySelector("#dsn-scrollbar")

if (scrollBar.parentElement.classList.contains("overflow-hidden")) {
    scrollBar.parentElement.classList.remove("overflow-hidden")
}
</script>
@endpush