@php
    $classes = ' form-search-all-service mainSearch   px-10 py-10 sm:mt-20 rounded-4 mt-30';
    $button_classes = " -dark-1 py-15 col-12 bg-blue-1 text-white w-100 rounded-4";
    if($style == 'sidebar'){
        $classes = ' form-search-sidebar';
        $button_classes = " -dark-1 py-15 col-12 bg-blue-1 h-20 text-white w-100 rounded-4";
    }
    if($style == 'normal'){
        $classes = ' px-10 py-10 sm:mt-20 rounded-100 form-search-all-service mainSearch -w-800  ';
        $button_classes = " -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white w-100";
    }
    if($style == 'normal2'){
        $classes = 'mainSearch  pr-20 py-20 sm:mt-20 rounded-4 shadow-1';
        $button_classes = " -dark-1 py-15 h-20 col-12 rounded-100 bg-blue-1 text-white w-100";
    }
    if($style == 'carousel_v2'){
        $classes = " w-100";
        $button_classes = " -dark-1 py-15 px-35 h-20 col-12 rounded-4 bg-yellow-1 text-dark-1";
    }
    if($style == 'map'){
        $classes = " w-100";
        $button_classes = " -dark-1 size-40 col-12 rounded-4 bg-blue-1 text-white";
    }
@endphp
<form action="{{ route("tour.search") }}" class="yourtrailquest_form_search bravo_form form {{ $classes }} bg-white" method="get">
    @php $tour_search_fields = setting_item_array('tour_search_fields');
            $tour_search_fields = array_values(\Illuminate\Support\Arr::sort($tour_search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
    @endphp
    @if( !empty(request()->input('_layout')) )
        <input type="hidden" name="_layout" value="{{ request()->input('_layout') }}">
    @endif
    <div class="field-items trailquest-search">
        <div class="row d-flex items-center justify-between w-100 m-0">
            @if(!empty($tour_search_fields))
                @foreach($tour_search_fields as $field)
                    <div class="col-lg-11 align-self-center w-90 mobile-full">
                        @php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" @endphp
                        @switch($field['field'])
                            @case ('service_name')
                                @include('Layout::common.search.fields.service_name')
                                @break
                            @case ('location')
                                @include('Layout::common.search.fields.location')
                                @break
                            @case ('date')
                                @include('Layout::common.search.fields.date')
                                @break
                            @case ('attr')
                                @include('Layout::common.search.fields.attr')
                                @break
                        @endswitch
                    </div>
                @endforeach
                <div class="col-1 w-10 mobile-half">
                <div class="button-item">
        <button  style="background:#ba7d22!important" class="mainSearch__submit button {{ $button_classes }}" type="submit">
            <i class="icon-search text-20 "></i> 
        </button>
    </div>
                </div>
            @endif
        </div>
    </div>
  
</form>
