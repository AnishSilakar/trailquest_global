<section class="layout-pt-lg adventuregrowth">
    <div class="container" >
        <div class="row">
            <div class="col"><h2 class="h2 text-dark-1">{{ $title ?? '' }}</h2></div>
        </div>
        <div class="row y-gap-30 justify-between items-start">
            <div class="col-xl-6 col-lg-6"> 
                <p class="pt-10  sm:pt-10 text-justify arial">{{ $desc ?? '' }}</p>

                <div class="d-inline-block pt-20 sm:pt-10 ">

                    @if(!empty($link_title) && !empty($link_more))
                        <a href="{{ $link_more }}" class="button -md fw-600  bg-gold text-white">
                            {{ $link_title }} <div class="ml-15"><i class="fa-solid fa-arrow-up"></i></div>
                        </a>
                    @endif

                </div>
            </div>

            @if(!empty($list_item))
            <div class="col-xl-6 col-lg-6">
                <div class="shadow-4 pt-30 sm:pt-10">
                    <div class="row border-center no-gutter">

                        @foreach($list_item as $key => $val)
                        <div class="col-sm-6">
                            <div class="p-4 sm:p-4 text-center">
                                <div class="smalltitle poppins  text-dark-1 ">{{ $val['number'] }}</div>
                                <div class="smallparagraph arial mt-10">{{ $val['title'] }}</div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
