@extends('layouts.app')
@push('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

<style>
   
       .grid-body{
        display: grid;
        place-items: center;
      }

      .gallery-tour {
        width: 90vw;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 200px;
        gap: 0.25rem;
      }

      .gallery-tour img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .gallery-tour .hero-tour {
        grid-column: span 2;
        grid-row: span 2;
      }

      .gallery-tour img:not(.hero-tour) {
        cursor: pointer;
      }

      @media (max-width: 700px) {
        .gallery-tour {
          grid-template-columns: repeat(2, 1fr);
          grid-auto-rows: 175px;
        }
      }
    </style>
@endpush
@section('content')
@if(!empty($page_category[0])) 
<section class="mt-10 ">
    <div class="container grid-body">
    @if(isset($page_category[2]))
    @php
        $gallery_ids = explode(",", rtrim($page_category[2], ','));
        $total_images = count($gallery_ids);
        $remaining_images = $total_images - 4;
    @endphp
    <div class="gallery-tour">
        {{-- Display the Main Photo --}}
        @foreach($gallery_ids as $key => $item)
             @if($key >= 0 && $key < 1)
                
                    <img src="{{get_file_url($item)}}" alt="image" class="hero-tour"/>
                @break
            @endif
        @endforeach

    
            @foreach($gallery_ids as $key => $item)
                @if($key >= 1 && $key < 5)
                <img src="{{get_file_url($item)}}" alt="image" />
                @endif
            @endforeach
        </div>

    </div>
    @endif
    </div>
</section>
 

<div class="bravo_search bravo_search_tour">
    <section class="pt-20 pb-40 ">
        <div class="container">
            <div class="row"> 
                <div class="col-12">
                    <div class="text-center">
                    <h1 class=" h1 text-dark-1 fw-600">{{$page_category[0]}}</h1>
                    <p>{!!$page_category[1]!!}</p>
                        
                    </div>
                </div>

                @if (!empty($page_category[4]))
                <h2 class="text-dark-1 mt-40 text-center mb-20">{{ $page_category[4] }}</h2>
                @endif

                @include('Tour::frontend.layouts.search.grid-item')
            </div>
        </div>
    </section>
</div> 
@foreach($by_category as $category_name => $category_data)

<div class="bravo_search bravo_search_tour">
    <section class="pt-20 pb-40 ">
        <div class="container">
            <div class="row"> 
                <div class="col-12"> 
                    <div class="text-center">
                    <h1 class=" h1 text-dark-1 fw-600">{{ $category_name }}</h1>
                    <p>{!! $category_data['description'] !!}</p>
                        
                    </div>
                </div> 
               @include('Tour::frontend.layouts.search.grid-item', ['rows' => $category_data['tours']])
            </div>
        </div>
    </section>
</div>
@endforeach
@else 
<div class="bravo_search bravo_search_tour">
    @if($layout == 'normal')
    <section   class="pt-40 pb-40 bg-light-2">
        <div class="container">
            <div class="row"> 
                <div class="col-12"> 
                    <div class="text-center">
                        <h2 class="h2 text-dark-1">  {{setting_item_with_lang("tour_page_search_title")}}</h2>
                    </div> 
                    @include('Tour::frontend.layouts.search.form-search', ['style' => 'default'])
                </div>
            </div>
        </div>
    </section>
    @endif
    @include('Tour::frontend.layouts.search.list-item')
</div>
@endif
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('module/tour/js/tour.js?_ver='.config('app.asset_version')) }}"></script>
    <script>
      const hero = document.querySelector(".hero-tour");

      function activate(e) {
        if (e.target.matches(".hero-tour") || !e.target.matches("img")) return;
        [hero.src, e.target.src] = [e.target.src, hero.src];
      }

      window.addEventListener("click", activate, false);
    </script>
@endpush
