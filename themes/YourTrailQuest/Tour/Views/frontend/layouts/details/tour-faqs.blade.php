@if($translation->faqs)
    <div class="accordion -simple row y-gap-20 js-accordion tours-faqs">
        @foreach($translation->faqs as $item)
            <div class="col-12">
                <div class="accordion__item px-20 py-20 border-grayshade rounded-4">
                    <div class="accordion__button d-flex items-center">
                        <div class="accordion__icon size-40 flex-center bg-faq-1 text-white rounded-full mr-20">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-minus"></i>
                        </div>

                        <div class="button text-dark-1 text-start text-17 fw-600">{{$item['title']}}</div>
                    </div>

                    <div class="accordion__content w-fit">
                        <div class="pt-20 pl-60">
                            <p class="text-justify lh-14">{!! clean($item['content']) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
