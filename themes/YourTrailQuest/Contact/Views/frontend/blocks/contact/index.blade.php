@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>


.mt {
    margin-top: 40px;
}

.container {
    max-width: 1200px;
}

.contact-left {
    background-color: #121212;
    color: #fff;
    padding: 30px;
}
.contact-left p{
    color: #fff;
}

.section-title h6 {
    font-size: 14px;
    font-weight: 500;
    color: var(--primary-color);
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    display: inline-block;
}

.contact_form .col-xl-6 {
    margin: 10px 0;
}

.contact_form .col-xl-6 input {
    width: 100%;
    padding: 10px;
    border: 1px solid lightgray;
}

.form-group {
    margin-bottom: 1rem;
}

.contact_form .main-btn {
    width: fit-content;
    padding: 10px 24px;
    background-color: #000;
    color: white;
    border: none;
    outline: none;
    transition: 0.3s;
    margin-top: 20px;
}

.contact-us-info span {
    color: #cc2027!important;
}

.contact-us-info {
    line-height: 1;
    margin-bottom: 20px;
}

.contact-single-info {
    gap: 10px;
    align-items:center;
    font-family:Ariel;
}

.contact_form .col-xl-12 div {
    width: 100%;

}

.contact_form .col-xl-12 textarea {
    margin:20px auto 0;
    width: 100%;
    height:100%;
    padding: 10px;
    border: 1px solid lightgray;
}
.contact_form .col-xl-12 input {
    margin:20px auto 0;
    width: 100%;
    padding: 10px;
    border: 1px solid lightgray;
}
.contact_form .col-xl-12 .button{
    margin-top:40px;
    background-color:#ba7d22;
    color:#fff;
    font-size:16px;
}


.contact-single-info div p {
    line-height: 1;
    padding: 20px;
}

.mb {
    margin-bottom: 70px;
}

.contact-meta-info {
    margin-top: 20px;
}
.contact-headline p{
    line-height:1.3;
}
.textarea{
    width:100%;
    height:72%
}
.trailquest-contact .ratio-16\:9::before {
    padding-bottom: 40%;
}
.trailquest-contact .map-ratio {
  max-height: 550px!important;
}
</style>
@endpush

<div class="bravo-contact-block">

    <section>
        <div class="container mt mb trailquest-contact">
            <div class="row">
                <div class="col-lg-4 contact-left">
                    <div class="contact-wrap">
                        <div class="contact-inner">
                            <div class="contact-headline">
                                <h2 class="contact-us-info text-white arial">
                                    {!! setting_item_with_lang("page_contact_title") !!}
                                </h2>
                                <p class="arial">
                                    {{ setting_item_with_lang("page_contact_sub_title") }}
                                </p>
                            </div>
                            <div class="contact-meta-info arial">
                                @if(!empty($contact_lists = setting_item_with_lang("page_contact_lists")))
                                @php $contact_lists = json_decode($contact_lists,true) @endphp

                                @foreach( $contact_lists as $item)
                                <div class="contact-single-info d-flex arial">
                                    <div>
                                        <i class="{{ $item['title'] }}"></i>
                                    </div>
                                    <div>
                                        <p class="arial">{!! clean($item['content'] ?? "") !!}</p>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <div class="section-title">
                        <p>
                            {!! setting_item_with_lang("page_contact_desc") !!}
                        </p>
                    </div>
                    <div class="contact_form">
                        <form method="post" action="{{ route("contact.store") }}" class="bravo-contact-block-form">
                            {{csrf_field()}}
                            <div style="display: none;">
                                <input type="hidden" name="g-recaptcha-response" value="">
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div>
                                        <input type="text" name="name" value="" placeholder="Your Name*" required="" />
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div>
                                        <input type="email" name="email" value="" placeholder="Email*" required="" />
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="textarea">
                                        <textarea name="message" placeholder="Your Message*"></textarea>
                                    </div>
                                    <button type="submit" class="button px-24 h-50">
                                        {{ __("SEND US A MESSEGE") }}
                                    </button>
                                </div>

                            </div>


                            <div class="col-12">
                                {{recaptcha_field('contact')}}
                            </div>


                    </div>


                    <div class="col-sm-12">
                        <div class="form-mess"></div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
</div>
</section>
<!-- <div class="container p-0 mt">
<div class="ratio ratio-16:9">
    <div class="map-ratio">
        <div class="iframe_map">
            {!! ( setting_item("page_contact_iframe_google_map")) !!}
        </div>
    </div>
</div>
</div> -->


@if(!empty( $page_contact_why_choose_us = setting_item_with_lang('page_contact_why_choose_us')))
@php $page_contact_why_choose_us = json_decode($page_contact_why_choose_us,true) @endphp
<section class="layout-pt-lg layout-pb-lg bg-blue-2">
    <div class="container">
        <div class="row justify-center text-center">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{ setting_item_with_lang('page_contact_why_choose_us_title') }}
                    </h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0">
                        {{ setting_item_with_lang('page_contact_why_choose_us_desc') }}</p>
                </div>
            </div>
        </div>
        <div class="row y-gap-40 justify-between pt-50">
            @foreach($page_contact_why_choose_us as $key=>$item)
            <div class="col-lg-3 col-sm-6">
                <div class="featureIcon -type-1 ">
                    <div class="d-flex justify-center">
                        <img src="{{ get_file_url($item['image_id'],'full') }}" alt="{{$item['title']}}">
                    </div>
                    <div class="text-center mt-30">
                        <h3 class=" fw-500">{{$item['title']}}</h3>
                        <p class="text-14 mt-10">{{$item['desc']}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
</div>