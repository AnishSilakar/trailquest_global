@push('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<style>
.photos-grid-container {
    width: 100%;
    height: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr;
    grid-gap: 10px;
    align-items: start;
}

@media (max-width: 580px) {
    .photos-grid-container {
        grid-template-columns: 1fr;
    }
}

.photos-grid-container .img-box {
    border: 1px solid #ffffff;
    position: relative;
}

.photos-grid-container .img-box:hover .transparent-box {
    background-color: rgba(0, 0, 0, 0.6);
}

.photos-grid-container .img-box:hover .caption {
    transform: translateY(-5px);
}

.photos-grid-container img {
    width: 100%;
    display: block;
    height: 100%;
    object-fit: cover;
}

.photos-grid-container .caption {
    color: white;
    transition: transform 0.3s ease, opacity 0.3s ease;
    font-size: 1.5rem;
}

.photos-grid-container .transparent-box {
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    position: absolute;
    top: 0;
    left: 0;
    transition: background-color 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
}

.photos-grid-container .main-photo {
    grid-row: 1;
    grid-column: 1;
}

.photos-grid-container .sub {
    display: grid;
    grid-template-areas: "a b"
        "c c";

    grid-gap: 10px;
}

.photos-grid-container .sub .img-box:nth-child(0) {
    grid-column: 1;
    grid-row: 1;
    grid-area: a;
}

.photos-grid-container .sub .img-box:nth-child(1) {
    grid-column: 2;
    grid-row: 1;
    grid-area: b;

}

.photos-grid-container .sub .img-box:nth-child(2) {
    grid-column: 2;
    grid-row: 2;
    grid-area: c;
    width: 100%;
}

.hide-element {
    border: 0;
    clip: rect(1px, 1px, 1px, 1px);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
}

.gap-20 {
    gap: 20px;
}

.toursmallbg {
    padding: 20px;
    border-radius: 20px;
    background-color: #7f7f7f;
}

i.icon-route.text-blue-1.mr-10,
i.icon-customer.text-blue-1.mr-10 {
    font-size: 40px;
}

.photos-grid-container .main-photo.img-box {
    height: 80vh;
    width: 100%
}

.photos-grid-container .sub .img-box {
    width: 100%;
    height: 39.3vh;
}

.img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Sticky navbar styling */
.sticky-navbar {
    position: Sticky;
    top: 0;
    background-color: #333;
    padding: 10px 0;
    z-index: 1000;
}

.sticky-navbar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
}

.sticky-navbar ul li {
    margin: 0 15px;
}

.sticky-navbar ul li a {
    font-family: Arial;
    color: white;
    text-decoration: none;
    font-size: 16px;
}

.sticky-navbar ul li a.active {
    border-bottom: 2px solid red;
    color: #fff;
}
.sticky-navbar ul li a:hover{
   color:#fff!important;
}
@media (max-width: 575px) {
    .photos-grid-container .sub .img-box { 
        width: 100%;
        height: 16vh;
    }
    .photos-grid-container .main-photo.img-box {
        height: 40vh;
        width: 100%
    }
}
</style>
@endpush
<section class="pt-6">

    <div class="container">

        <div class="row y-gap-15 justify-between items-end">
            <div class="col-auto">
                <h1 class="h1">{!! clean($translation->title) !!}</h1>
            </div>

            <div class="col-auto">
                <div class="row x-gap-10 y-gap-10">
                <div class="col-auto">
                        <div class="dropdown">
                            <button class="button px-15 text-white py-10 bg-gold dropdown-toggle" type="button"
                                id="dropdownMenuShare" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-share mr-10"></i>
                                {{__('Share')}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuShare">
                                <a class="dropdown-item facebook"
                                    href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"
                                    target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                                    <i class="fa fa-facebook  pr-5"></i> {{ __('Facebook') }}
                                </a>
                                <a class="dropdown-item twitter"
                                    href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"
                                    target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                                    <i class="fa fa-twitter pr-5"></i> {{ __('Twitter') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <!-- <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}"
                            data-type="{{$row->type}}">
                            <button class="button px-15 py-10 -blue-1 bg-light-2">
                                <i class="icon-heart mr-10"></i>
                                {{__('Save')}}
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        @include('Layout::parts.bc')
    </div>

</section>

<section class="mt-10 mb-20">
    <div class="container">
        @if($row->getGallery())
        @php
        $gallery = $row->getGallery();
        $total_images = count($gallery);
        $remaining_images = $total_images - 4;
        @endphp
        <div id="gallery" class="photos-grid-container gallery pt-10 pb-10 pl-10 pr-10 ">
            @foreach($row->getGallery() as $key => $item)
            @if($key < 1) <div class="main-photo img-box">
                <a href="{{ $item['large'] }}" class="glightbox" data-glightbox="type: image"><img
                        src="{{ $item['large'] }}" alt="image" /></a>
        </div>

        @break
        @endif

        @endforeach
        <div>
            <div class="sub">
                @foreach($row->getGallery() as $key => $item)

                @if($key >= 1 && $key <= 3) <!-- First 3 images -->

                    <div @if($key==2) id="multi-link" @endif class="img-box">
                        <a href="{{ $item['large'] }}" class="glightbox" data-glightbox="type: image"><img
                                src="{{ $item['large'] }}" alt="image" />
                            @if($key==2)
                            <div class="transparent-box">
                                <div class="caption">{{ $remaining_images }}+</div>
                            </div>
                            @endif

                        </a>
                    </div>

                    @endif
                    @endforeach

            </div>

        </div>
        <div id="more-img" class="extra-images-container hide-element">
            @if($remaining_images > 0)
            @foreach($row->getGallery() as $key => $item)

            @if($key>5)
            <a href="{{ $item['large'] }}" class="glightbox" data-glightbox="type: image"><img
                    src="{{ $item['large'] }}" alt="image" />
                @endif
                @endforeach
                @endif
        </div>
    </div>

    </div>
    @endif

    </div>
</section>
<nav class="sticky-navbar sm:d-none">
    <div  class="container">
       <div class="d-flex items-center justify-between m-auto">
           <ul>
            <li>
                <a href="#intro" class="nav-link poppins text-16" data-section="nav-intro">Intro</a>
            </li>
            <li>
                <a href="#knowbeforeyouGo" class="nav-link poppins text-16" data-section="nav-knowbeforeyougo">KBYG</a>
            </li>
            <li>
                <a href="#hightlights" class="nav-link poppins text-16" data-section="nav-hightlights">Hightlights</a>
            </li>
            <li>
                <a href="#whotrekfor" class="nav-link poppins text-16" data-section="nav-whotrekfor">Who For</a>
            </li>
            <li>
                <a href="#whotreknotfor" class="nav-link poppins text-16" data-section="nav-whotreknotfor">Who Not For</a>
            </li>
            <li>
                <a href="#itinerary" class="nav-link poppins text-16" data-section="nav-itinerary">Itinerary</a>
            </li>
            <li>
                <a href="#includexclude" class="nav-link poppins text-16" data-section="nav-includexclude">Includes/Excludes</a>

            <li>
                <a href="#importantinfo" class="nav-link poppins text-16" data-section="nav-importantinfo">Imp Info</a>
            </li>
            <li>
                <a href="#faqss" class="nav-link text-white poppins text-16" data-section="nav-faqss">FAQS</a>
            </li>
           </ul>
           <div class="text-center w-fit ">
               <a href="/contact" class="button -md bg-gold text-13 fw-600 text-center text-white arial">
                NEED HELP? REACH OUT
               </a>
            </div>
        </div>
    </div>   
</nav>

<section class="pt-30 js-pin-container">

    <div class="container">
        <div class="row y-gap-30">

            <div class="col-lg-8">
                <!-- intro -->
                <div class="row x-gap-40 y-gap-40 yourtrailquest-overview " id="nav-intro">
                    <div class="col-12">

                        <h3 class="text-dark-1">{{__('')}}</h3>

                        <div class="text-dark-1 p">
                            {!! clean($translation->content) !!}
                        </div>
                    </div>
                </div>
                <!-- knowbefore you go -->
                <div class="row x-gap-40 y-gap-40" id="nav-knowbeforeyougo">
                    <div class="col-12">
                        <h2 class="text-dark-1 ">{{__('Know Before You Go')}}</h2>
                        <div class="border-bottom-red"></div>
                        <div class="row y-gap-30 justify-between p-20 gap-24 mt-10 knowbeforeyougo">
                            @if($row->duration)
                            <div class="col-md-3  toursmallbg">
                                <div class="d-flex items-center">
                                    <i class="icon icon-calendar iconsize-30 text-white mr-10"></i>
                                    <div class="text-15 lh-15  text-white arial">
                                        <span> {{__('Duration')}}</span>
                                        <br> {{duration_format($row->duration,true)}}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($translation->distance)
                            <div class="col-md-3  toursmallbg">
                                <div class="d-flex items-center">
                                    <i class="icon icon-speedometer iconsize-30 text-white mr-10"></i>
                                    <div class="text-15 lh-15  text-white arial"><span> {{__('Distance')}}</span> <br />
                                        {!! ($translation->distance) !!}</div>
                                </div>
                            </div>
                            @endif
                            @if($translation->trek_zone)
                            <div class="col-md-3  toursmallbg">
                                <div class="d-flex items-center">
                                    <i class="icon icon-location-2 iconsize-30 text-white mr-10"></i>
                                    <div class="text-15 lh-15  text-white arial"><span> {{__('Trek Zone')}}</span>
                                        <br />{!! ($translation->trek_zone) !!}</div>
                                </div>
                            </div>
                            @endif
                            @if($translation->best_season)
                            <div class="col-md-3  toursmallbg">
                                <div class="d-flex items-center">
                                    <i class="fa-solid fa-cloud-sun-rain iconsize-30 text-white mr-10"></i>
                                    <div class="text-15 lh-15  text-white arial"><span> {{__('Best Season')}}</span>
                                        <br /> {!! ($translation->best_season) !!}</div>
                                </div>
                            </div>
                            @endif
                            @if($translation->difficulty)
                            <div class="col-md-3  toursmallbg">
                                <div class="d-flex items-center">
                                    <i class="icon icon-hiking-2 iconsize-30 text-white mr-10"></i>
                                    <div class="text-15 lh-15  text-white arial"><span> {{__('Difficulty')}}</span>
                                        <br />{!! ($translation->difficulty) !!}</div>
                                </div>
                            </div>
                            @endif
                            @if($translation->max_altitude)
                            <div class="col-md-3  toursmallbg">
                                <div class="d-flex items-center">
                                    <i class="icon icon-camping iconsize-30 text-white mr-10"></i>
                                    <div class="text-15 lh-15  text-white arial"><span> {{__('Max Altitude')}}</span>
                                        <br /> {!! ($translation->max_altitude) !!}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- hightlights-->
                <div class="row x-gap-40 y-gap-40" id="nav-hightlights">
                    <div class="col-12">
                        <h2 class="text-dark-1 mt-10">{{__('Highlights')}}</h2>
                        <div class="border-bottom-red"></div>
                        <div class="text-dark-1 text-22 pt-30">

                            <div class="relative">
                                <div class="border-test"></div>
                                <div class=" row y-gap-20 ">
                                    <div class="col-12">
                                        <div class="pb-15 ml-20">
                                            <div class="text-dark-1 text-22 "> {!!$translation->short_desc !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Who Is This Trek For -->
                <div class="row x-gap-40 y-gap-40" id="nav-whotrekfor">
                    <div class="col-12">
                        <h2 class="text-30">{{__('Who Is This Trek For')}}</h2>
                        <div class="border-bottom-red"></div>

                        <div class="text-dark-1 text-dark-1 mt-20">
                            <div class="relative">
                                <div class="border-test"></div>
                                <div class=" -map row y-gap-20 ">
                                    @if($translation->whofor)
                                    @foreach($translation->whofor as $key => $item)
                                    <div class="col-12">
                                        <div class="">
                                            <div class="d-flex">

                                                <div class="ml-20">
                                                    <div class="d-flex items-start gap-2">
                                                        <div class="text-22 lh-15 fw-600 poppins">
                                                            {{$item['title']}}
                                                        </div>
                                                    </div>
                                                    <div class="pt-15 pb-15">
                                                        <div class="text-16 lh-17 mt-15">{!! clean($item['content']) !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Who Is This Trek For -->
                <div class="row x-gap-40 y-gap-40" id="nav-whotreknotfor">
                    <div class="col-12">

                        <h2 class="text-30">{{__('Who Is This Trek Not For')}}</h2>
                        <div class="border-bottom-red"></div>

                        <div class="text-dark-1 text-dark-1 mt-20">
                            <div class="relative">
                                <div class="border-test"></div>
                                <div class=" -map row y-gap-20 ">
                                    @if($translation->whonotfor)
                                    @foreach($translation->whonotfor as $key => $item)
                                    <div class="col-12">
                                        <div class="">
                                            <div class="d-flex">

                                                <div class="ml-20">
                                                    <div class="d-flex items-start gap-2">
                                                        <div class="text-22 lh-15 fw-600 poppins">
                                                            {{$item['title']}}:
                                                        </div>
                                                    </div>
                                                    <div class="pt-15 pb-15">
                                                        <div class="text-16 lh-17 mt-15">{!! clean($item['content'])
                                                            !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Itinerary -->
                <div class="row x-gap-40 y-gap-40" id="nav-itinerary">
                    <div class="col-lg-12">
                        <h2 class="text-dark-1 mt-30">{{__('Itinerary')}}</h2>
                        <div class="border-bottom-red"></div>
                        <div class="row y-gap-30 pt-20">
                            <div class="col-lg-12"> @include('Tour::frontend.layouts.details.tour-itinerary')</div>
                        </div>
                    </div>
                </div>
                <!--tour-include-exclude -->
                <div class="row x-gap-40 y-gap-40" id="nav-includexclude">
                    <div class="col-lg-12">
                        @include('Tour::frontend.layouts.details.tour-include-exclude')

                    </div>
                </div>
                <!-- Route Map -->
                <div class="row x-gap-40 y-gap-40">
                    <div class="col-lg-12">
                        <h2 class="text-dark-1  p-0">{{__('Route Map')}}</h2>
                        <div class="border-bottom-red"></div>
                        <div class="map-image">
                            <img src="{{ !empty($row->map_image) ? get_file_url($row->map_image,"full") : "" }}"
                                alt="map" class="rounded-4">
                        </div>
                    </div>
                </div>
                <!-- Important Information -->
                <div class="row x-gap-40 y-gap-40" id="nav-importantinfo">
                    <div class="col-lg-12">
                        <h2 class="text-dark-1 ">{{__('Important Information')}}</h2>
                        <div class="border-bottom-red"></div>
                        <div class="important-information">
                            <div class="text-dark-1 text-22 "> {!!$translation->important_information !!}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- book form  -->
            <div class="col-lg-4">
                @include('Tour::frontend.layouts.details.tour-form-book')
            </div>

        </div>
    </div>

</section>

<section class="pt-40">
    <div class="container">
        <div class=" ">


            <div class="row x-gap-40 y-gap-40 pt-20">
                @include('Tour::frontend.layouts.details.tour-attributes')
            </div>
        </div>
    </div>
</section>

<div class="container mt-40 mb-40">
</div>


<section>
    <div class="container">
        <div class="row y-gap-20" id="nav-faqss">
            <div class="col-lg-4">
                <h2 class="text-dark-1 ">{{__('FAQs')}}</h2>
                <div class="border-bottom-red"></div>

            </div>

            <div class="col-lg-8">
                @include('Tour::frontend.layouts.details.tour-faqs')

            </div>
        </div>
    </div>
</section>



{{--video banner modal--}}
<div class="container">
    <div class="video_popup_modal">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item bravo_embed_video" src="" allowscriptaccess="always"
                                allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('div[id]'); // Select sections with IDs
    const navLinks = document.querySelectorAll('.nav-link');

    const highlightSection = () => {
        const scrollPosition = window.scrollY;

        sections.forEach((section) => {
            const sectionTop = section.offsetTop - 100; // Adjust for sticky navbar height
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                // Highlight the navigation link with matching data-section
                navLinks.forEach((link) => link.classList.remove('active'));
                const activeLink = document.querySelector(`[data-section="${sectionId}"]`);
                if (activeLink) activeLink.classList.add('active');
            }
        });
    };

    // Smooth scrolling for navigation links
    navLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const targetId = link.getAttribute('data-section');
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop -
                    80, // Adjust for sticky navbar height
                    behavior: 'smooth',
                });
            }
        });
    });

    // Event listener for scroll
    window.addEventListener('scroll', highlightSection);
});

//External JS: https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js, see settings

const lightbox = GLightbox({
    touchNavigation: true,
    loop: true,
    width: "90vw",
    height: "90vh",
});
</script>
@endpush