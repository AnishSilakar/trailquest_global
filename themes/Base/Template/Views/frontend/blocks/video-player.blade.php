
<section class="layout-pt-md">
@switch($style)
    @case('style_2')  
        <div class="container position-relative">
          <h2 class="text-center">{{ $title }}</h2>
          <p class="text-center">{{ $desc }}</p>
  
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($list_item as $item)
              <div class="swiper-slide">
                <div class="card">
                    @if($item['youtube'])
                    <div class="modal fade" id="video-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content p-0">
                                <div class="modal-body">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item bravo_embed_video" src="{{ handleVideoUrl($item['youtube']) }}" allowscriptaccess="always" allow="autoplay"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   @endif
                   @if(!empty($item['title']))
                   <div class="text-25 md:text-22 fw-600 text-white mb-10">{{ $item['title'] }}</div>
                   @endif
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>

    @break
    
    @default 
    <div class="container">
        <h2 class="text-center">{{ $title }}</h2>
          <p class="text-center">{{ $desc }}</p>
        <div class="bravo_gallery mt-20 sm:mt-10">
            @if($youtube)
            <div class="m-auto text-center">
                <iframe class="embed-responsive-item bravo_embed_video m-auto" src="{{ handleVideoUrl($youtube) }}" allowscriptaccess="always" allow="autoplay" height="{{ $videoheight }}" width="{{ $videowidth }}"></iframe>
            </div>
            @endif
        </div>
    </div>
@endswitch
</section>


