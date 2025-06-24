@php 
$slug = strtolower($title ?? 'FAQs');
    
    // Remove special characters and replace spaces with hyphens
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    
    // Remove any leading or trailing hyphens
    $slug = trim($slug, '-');
@endphp

<section class="bravo-faq-lists faqpage layout-pt-lg layout-pb-lg" id="{{$slug}}">
    <div class="container">
        <div class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md pt-50">
                    <p class="sectionTitle__title h2 poppins text-dark-1">{{$title ?? 'FAQs'}}</p>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">{{$desc ?? ''}}</p>
                </div>
            </div>
        </div>
        @if(!empty($list_item))
            <div class="row y-gap-30 justify-center pt-40 sm:pt-20">
                <div class="col-xl-8 col-lg-10">
                    
                    <div class="accordion -simple row y-gap-20  ">
                        @foreach($list_item as $item)
                            <div class="col-12">
                                <div class="accordion__item px-20 py-20 border-grayshade rounded-4">
                                    <div class="accordion__button d-flex items-center">
                                        <div class="accordion__icon size-40 flex-center bg-faq-1 rounded-full mr-20">
                                        <i class="fa-solid fa-plus" style="color: #fff;"></i>
                                        <i class="fa-solid fa-minus" style="color: #fff;"></i>                                         
                                        </div>
                                        <div class="button text-dark-1 text-start arial text-16 fw-600">{{$item['title']}}</div>
                                    </div>
                                    <div class="accordion__content">
                                        <div class="pt-20 pl-60">
                                            <p class="arial "> {!! clean($item['sub_title'],'html5-definitions') !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@push('js')
<script>
    // Select all accordion buttons
const accordionButtons = document.querySelectorAll('.accordion__button');

accordionButtons.forEach(button => {
    button.addEventListener('click', () => {
        const accordionItem = button.closest('.accordion__item');

        // Toggle 'is-active' class for the clicked accordion item
        accordionItem.classList.toggle('is-active');

        // Expand or collapse the content
        const content = accordionItem.querySelector('.accordion__content');
        if (accordionItem.classList.contains('is-active')) {
            content.style.maxHeight = content.scrollHeight + 'px'; // Expand
        } else {
            content.style.maxHeight = '0'; // Collapse
        }

        // Optional: close other accordions if only one should be open at a time
        document.querySelectorAll('.accordion__item.is-active').forEach(activeItem => {
            if (activeItem !== accordionItem) {
                activeItem.classList.remove('is-active');
                activeItem.querySelector('.accordion__content').style.maxHeight = '0';
            }
        });
    });
});

</script>
@endpush