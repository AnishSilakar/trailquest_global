<?php
return [
    'blocks'=>[
        "list_all_service"=>ListAllService::class,
        'subscribe'=>Subscribe::class,
        'download_app' => DownloadApp::class,
        'login_register' => LoginRegister::class,
        'list_terms'=>Terms::class,
        'faqs'=>FaqList::class,
        'about_text'=>AboutText::class,
        'form_search_all_service' => FormSearchAllService::class,
        'text_featured_box' => TextFeaturedBox::class,
        'text_image' => TextImage::class,
        //hide block for BC
        'form_search_tour' => null,   
        'list_tours' => null,
        'box_category_tour' => null,  
        'offer_block' => OfferBlock::class
    ]
];
