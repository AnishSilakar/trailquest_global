@php
    if(!empty($translation->include)){
        $title = __("Included");
    }
    if(!empty($translation->exclude)){
        $title = __("Excluded");
    }
    if(!empty($translation->exclude) and !empty($translation->include)){
        $title = __("Included/Excluded");
    }
@endphp
@if(!empty($title))
<div class="">

    <div class=" row x-gap-40 y-gap-40 d-flex flex-col">
    

        @if($translation->include)
            <div class="col-12 include ">
            <h3 class="text-30">Tour Price Includes</h3>
            <div class="border-bottom-red pb-20"></div>

                @foreach($translation->include as $item)
                    <div class="text-dark-1 text-16 arial d-flex items-center gap-10">
                        <i class="icon-check text-10  mr-10"></i>
                        <span> {{$item['title']}} </span>
                    </div>
                @endforeach
            </div>
        @endif

     
        @if($translation->exclude)
            <div class="col-12 exclude">
            <h3 class=" text-30 ">Tour Price Excludes</h3>
            <div class="border-bottom-red pb-20"></div>

                @foreach($translation->exclude as $item)
                    <div class="text-dark-1 text-16 d-flex arial items-center gap-10">
                        <i class="icon-close text-10 mr-10"></i>
                        <span>{{$item['title']}}</span> 
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    </div>
@endif

