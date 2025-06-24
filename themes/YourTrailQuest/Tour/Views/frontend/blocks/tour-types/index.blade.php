@push('css')

<!-- Include Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
<style>
  .home-slider .slider {
    width: 100%;
    overflow: hidden;
  }

  .home-slider img {
    width: 100%;
    height: 280px;
  }

  /* Item */
  .home-slider .slider__item {
    background-color: #121212;
    display: inline-flex;
    margin-right: 20px;
    color: #fff;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
  }



  ul.slick-dots {
    position: relative;
    top: 0;
    bottom: 0;
  }

  .slick-dots li button:before {
    font-size: 12px;
  }

  .slick-dotted.slick-slider {
    margin-bottom: 0px;
  }

  .w-fit {
    width: fit-content !important;
  }
  .tourTypeCard.-type-1 {
    width:100%;
  }
  @media only screen and (max-width: 600px) {
    .home-slider img {
      height: 210px;
    }

  }
</style>
@endpush
<section class="layout-pt-md">
  <div data-anim-wrap class="container">
    <div data-anim-child="slide-up delay-1" class="row y-gap-20 justify-between items-end">

      <div class="col-auto m-auto">
        <div class="sectionTitle -md">
          <h2 class="sectionTitle__title text-dark-1 text-36 text-center sm:mt-10">{{ $title ?? '' }}</h2>
          <p class=" sectionTitle__text text-center mt-5 sm:mt-10 ">{{ $desc ?? '' }}</p>
        </div>
      </div>

      <div class="col-auto m-auto w-fit">

        <div class="d-flex x-gap-15 items-center m-auto w-fit ">

          <div class="col-auto">
            <button class="d-flex items-center text-24 arrow-left-hover js-tour-prev"><i
                class="icon icon-arrow-left"></i></button>
          </div>



          <div class="col-auto js-tour-dot ">
            <div class="slider-dots"></div>
          </div>



          <div class="col-auto">
            <button class="d-flex items-center text-24 arrow-right-hover js-tour-next"><i
                class="icon icon-arrow-right"></i> </button>
          </div>

        </div>

        <div class="home-slider mt-20 sm:mt-10">
          <div class="slider">
            @if(!empty($rows))
            @php $delay = 2; @endphp
            @foreach($rows as $row)
            @php $translation = $row->translate(); @endphp
            <div class="slider__item">
              <a href="{{ route('tour.search',['cat_id[]' => $row->id]) }}"
                class="tourTypeCard -type-1 d-block rounded-4 bg-dark-1">
                <div class="tourTypeCard__content text-center rounded-4   ">
                  @php $img_url = get_file_url($row->image_id,'full') @endphp
                  <img src="{{ $img_url }}" class="rounded-4 " alt="image">
                  <p class="text-white text-16 fw-700 pt-1">{{$translation->name}}</p>
                  @if($row->tour_count)
                  <p class="text-white text-14 pb-1">{{ __(':count Tours',['count' => $row->tour_count])
                    }}</p>
                  @endif
                </div>
              </a>
            </div>
            @php $delay++ @endphp
            @endforeach
            @endif
          </div>

        </div>


      </div>
    </div>



</section>
@push('js')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Slick JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
  $(document).ready(function () {
    /* Initialize the Slick Slider */
    $(".home-slider .slider").slick({
      arrows: true,
      prevArrow: $(".js-tour-prev"),
      nextArrow: $(".js-tour-next"),
      dots: true,
      appendDots: $(".js-tour-dot .slider-dots"),
      infinite: false,
      slidesToScroll: 1,
      slidesToShow: 4, // Default setting
      responsive: [
        {
          breakpoint: 1200, // Desktops
          settings: { slidesToShow: 4 },
        },
        {
          breakpoint: 992, // Tablets
          settings: { slidesToShow: 3 },
        },
        {
          breakpoint: 768, // Small tablets
          settings: { slidesToShow: 2 },
        },
        {
          breakpoint: 480, // Mobile devices
          settings: { slidesToShow: 1 },
        },
      ],
    });

    /* Mouse Wheel Scrolling */
    const slider = $(".home-slider .slider");
    let scrollTimeout;

    slider.on("wheel", function (e) {
      e.preventDefault();
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        if (e.originalEvent.deltaY < 0) {
          slider.slick("slickPrev");
        } else {
          slider.slick("slickNext");
        }
      }, 100);
    });
  });

</script>


@endpush