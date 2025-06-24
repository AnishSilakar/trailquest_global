@php
    $translation = $row->translate();
    $layout_style = $layout_style ?? '';
@endphp
<div class="tourCard -type-1 rounded-4 ">
    <div class="tourCard__image">
        <div class="cardImage ratio ratio-1:1">
            <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl()}}">
                <div class="cardImage__content">
                    @if($row->image_url)
                        @if(!empty($disable_lazyload))
                            <img  src="{{$row->image_url}}" class="img-responsive rounded-4 col-12 js-lazy" alt="">
                        @else
                            {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive rounded-4 col-12 js-lazy','alt'=>$translation->title]) !!}
                        @endif
                    @endif
                    
                </div>
            </a>
            <div class="service-wishlist {{$row->isWishList()}}" data-id="{{ $row->id }}" data-type="{{ $row->type }}">
                <div class="cardImage__wishlist">
                    <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                        <i class="icon-heart text-12"></i>
                    </button>
                </div>
            </div>
            <div class="cardImage__leftBadge">
                @if($row->is_featured == "1")
                    <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-yellow-1 text-dark-1">
                        {{__("Featured")}}
                    </div>
                @endif
                @if($row->discount_percent)
                    <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-blue-1 text-white mt-5">
                        {{__("Sale off :number",['number'=>$row->discount_percent])}}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="tourCard__content mt-10">
        
        <h3 class="tourCard__title text-dark-1 lh-1 fw-500">
            <a class="text-dark-1-i" @if(!empty($blank)) target="_blank" @endif href="{{ $row->getDetailUrl() }}"> <span>{{ $translation->title }}</span></a>
        </h3>
        <div class="row align-items-center justify-between pt-10">
            <div class="col-auto">
            @if(!empty($row->location->name))
            @php $location = $row->location->translate() @endphp
            <p class="text-light-1 lh-14 text-14 "> <i class="icon-location-2 text-12"></i> {{$location->name}}</p>
            @endif
            </div>
            <div class="col-auto">
                <div class="d-flex items-center lh-1 ">
                    <div class="text-14 text-light-1"><i class="icon-clock text-12"></i> {{duration_format($row->duration,true)}}</div>
                </div>
            </div>
        </div>
     
        <div class="row justify-between items-center pt-10">
            <div class="col-auto d-none">
                @if(setting_item('tour_enable_review'))
                        <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
                    <div class="d-flex items-center">
                        @include('Layout::common.rating',['score_total'=>$score_total])
                        <div class="text-14 text-light-1 ml-10">
                            @if($reviewData['total_review'] > 1)
                                {{ __(":number Reviews",["number"=>$reviewData['total_review'] ]) }}
                            @else
                                {{ __(":number Review",["number"=>$reviewData['total_review'] ]) }}
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-auto">
                <div class="d-flex items-center gap-20 ">  
                   
                        <div class="tourcat-card text-dark-1 text-14 arial d-flex items-center">
                            <i class="icon-check text-12"></i>
                            <span> Best Prices</span>
                        </div>
                        <div class="tourcat-card text-dark-1 text-14 arial d-flex items-center">
                            <i class="icon-check text-12 "></i>
                            <span> EASY REFUND</span>
                        </div> 
                 
           
                </div>
                
            </div>
            <div class="col-12">
                <div class="mt-20 text-14 text-light-1">
                    {{ __('from') }}
                    <span class="text-14 text-red-1 line-through d-inline-flex">{{ $row->display_sale_price }}</span>
                    <span class="fw-500 text-dark-1 d-inline-flex">{{ $row->display_price }}</span>
                </div>
              
            </div>
        </div>
    </div>
</div>
@push('css')
<style>
    .gap-20{
        gap: 20px;
    }
</style>
@endpush