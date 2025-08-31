@push('css')
    <style>
        ul.tabs{
            margin: 0px;
            padding: 0px;
            list-style: none;
            text-align: center;
        }
        ul.tabs li{
            background: none;
            color: #222;
            display: inline-block;
            padding: 10px 15px;
            cursor: pointer;
        }

        ul.tabs li.current{
            background: #ededed;
            color: #222;
        }

        .tab-content{
            display: none;
            background: #ededed;
            padding: 15px;
        }

        .tab-content.current{
            display: block;
        }
</style>
@endpush

<ul class="tabs">
    @foreach($by_category as $key => $tours)
        @php
            $tabId = 'tab-' . \Illuminate\Support\Str::slug($key, '-');
        @endphp
        <li class="tab-link {{ $loop->first ? 'current' : '' }}" data-tab="{{ $tabId }}">
            {{ $key }}
        </li>
    @endforeach
</ul>

@foreach($by_category as $key => $tours)
    @php
        $tabId = 'tab-' . \Illuminate\Support\Str::slug($key, '-');
    @endphp
    <div id="{{ $tabId }}" class="tab-content {{ $loop->first ? 'current' : '' }}">
        @include('Tour::frontend.layouts.search.grid-item', ['rows' => $tours['tours']])
    </div>
@endforeach



{{--    <ul class="tabs">--}}
{{--        <li class="tab-link current" data-tab="tab-1">tab1</li>--}}
{{--        <li class="tab-link" data-tab="tab-2">tab2</li>--}}
{{--        <li class="tab-link" data-tab="tab-3">tab3</li>--}}
{{--    </ul>--}}

{{--    <div id="tab-1" class="tab-content current">tab content1</div>--}}
{{--    <div id="tab-2" class="tab-content">tab content2</div>--}}
{{--    <div id="tab-3" class="tab-content">tab content3</div>--}}


@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.tab-link').click(function(){
                var tab_id = $(this).data('tab');

                // remove current from all
                $('.tab-link').removeClass('current');
                $('.tab-content').removeClass('current');

                // add current to clicked tab + matching content
                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            });
        });
    </script>
@endpush