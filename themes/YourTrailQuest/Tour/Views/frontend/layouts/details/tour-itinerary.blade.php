
<div class="relative">
    <div class="border-test dimred"></div>
    <div class="accordion -map row y-gap-20 js-accordion">
        @if($translation->itinerary)
        @foreach($translation->itinerary as $key => $item)
        <div class="col-12">
            <div class="accordion__item @if($key == 0) js-accordion-item-active @endif">
                <div class="d-flex">
                    <div class="accordion__icon size-40 flex-center bg-black text-blue-1 rounded-full">
                        <div class="text-22 fw-500 text-white poppins">{{$key+1}}</div>
                    </div>
                    <div class="ml-20 box-accordion accordion__button">
                        <div class="d-flex items-start gap-2">
                            <div class="text-20 lh-15 width-78 fw-600 poppins">{{$item['title']}}:</div>
                          
                            <div class="text-20 lh-15 poppins">{{$item['desc']}}</div>
                        </div>


                        <div class="accordion__content">
                        <div class="row d-flex items-center justify-between">
                            <div class="col-md-6">{{$item['hiking']?:""}}
                             </div>
                            <div class="col-md-6">{{$item['accomodation']?:""}}</div>
                          </div>
                            <div class="pt-15 pb-15">

                                <img src="{{ !empty($item['image_id']) ? get_file_url($item['image_id'],"full") : "" }}"
                                    alt="{{$item['desc']}}" class="rounded-4 mt-15">
                                <div class="text-16 arial text-justify mt-15">{!! clean($item['content']) !!}</div>
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