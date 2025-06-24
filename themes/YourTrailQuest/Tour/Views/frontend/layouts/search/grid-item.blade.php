<section class="pt-20">
    <div class="container">
        <div class="row">
    
            <div class="col-xl-12 col-lg-12">
                <div class="row y-gap-10 items-center justify-between">
                    <div class="col-auto">
                        <div class="text-16">
                            <!-- <span class="fw-500">
                                @if($rows->total() > 1)
                                    {{ __(":count tours found",['count'=>$rows->total()]) }}
                                @else
                                    {{ __(":count tour found",['count'=>$rows->total()]) }}
                                @endif
                            </span> -->
                        </div>
                    </div>
               
                </div>
                <!-- <div class="border-top-light mt-30 mb-30"></div> -->
                <div class="row y-gap-30">
                    @if($rows->total() > 0)
                        @foreach($rows as $row)
                        <div class="col-md-3">
                        @include('Tour::frontend.layouts.search.loop-grid')
                        </div>

                        @endforeach
                    @else
                        <div class="col-lg-12">
                            {{__("Tour not found")}}
                        </div>
                    @endif
                </div>
                <div class="bravo-pagination">
                    {{$rows->appends(request()->query())->links()}}
                    @if($rows->total() > 0)
                        <div class="text-center mt-30 md:mt-10">
                            <div class="text-14 text-light-1">{{ __("Showing :from - :to of :total Tours",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
