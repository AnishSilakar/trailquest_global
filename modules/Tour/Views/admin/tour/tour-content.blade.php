<div class="panel">
    <div class="panel-title"><strong>{{__("Tour Content")}}</strong></div>
    <div class="panel-body">

        <div class="form-group">
            <label>{{__("Title")}}</label>
            <input type="text" value="{!! clean($translation->title) !!}" placeholder="{{__("Tour title")}}" name="title" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label">{{__("Content")}}</label>
            <div class="">
                <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->content}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{__("Important Information")}}</label>
            <div class="">
                <textarea name="important_information" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->important_information}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{__("Map image")}}</label>
            <div class="">
            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('map_image',$row->map_image) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{__("Highlights")}}</label>
            <div class="">
                <textarea name="short_desc" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->short_desc}}</textarea>
            </div>
        </div>
      <div class="form-group-item">
            <label class="control-label">{{__("After Completing")}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-5">{{__("Title")}}</div>
                    <div class="col-md-5">{{__('Content')}}</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="g-items">
                @if(!empty($translation->aftercompleting))
                    @php if(!is_array($translation->aftercompleting)) $translation->aftercompleting = json_decode($translation->aftercompleting); @endphp
                    @foreach($translation->aftercompleting as $key=>$aftercomplete)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="aftercompleting[{{$key}}][title]" class="form-control" value="@if(!empty($aftercomplete['title'])){{$aftercomplete['title']}}@endif" placeholder="{{__('Eg: When and where does the tour end?')}}">
                                </div>
                                <div class="col-md-6">
                                      <textarea name="aftercompleting[{{$key}}][content]" class="d-none has-ckeditor" cols="30" rows="10"> @if(!empty($aftercomplete['title'])){{$aftercomplete['content']}}@endif</textarea>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-right">
                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            </div>
            <div class="g-more hide">
                <div class="item" data-number="__number__">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" __name__="aftercompleting[__number__][title]" class="form-control" placeholder="{{__('Eg: When and where does the tour end?')}}">
                        </div>
                        <div class="col-md-6">
                            
                            <textarea __name__="aftercompleting[__number__][content]"  class="d-none has-ckeditor" class="form-control full-h" placeholder="..."></textarea>
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
      <div class="form-group-item">
            <label class="control-label">{{__("Who For")}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-5">{{__("Title")}}</div>
                    <div class="col-md-5">{{__('Content')}}</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="g-items">
           
                @if(!empty($translation->whofor))
                
                    @php if(!is_array($translation->whofor)) $translation->whofor = json_decode($translation->whofor); @endphp
                    @foreach($translation->whofor as $key=>$whofo)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="whofor[{{$key}}][title]" class="form-control" value="@if(!empty($whofo['title'])){{$whofo['title']}}@endif" placeholder="{{__('Eg: When and where does the tour end?')}}">
                                </div>
                                <div class="col-md-6">
                                    <textarea  class="d-none has-ckeditor" name="whofor[{{$key}}][content]" class="form-control full-h" placeholder="...">@if(!empty($whofo['title'])){{$whofo['content']}}@endif</textarea>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-right">
                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            </div>
            <div class="g-more hide">
                <div class="item" data-number="__number__">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" __name__="whofor[__number__][title]" class="form-control" placeholder="{{__('Eg: When and where does the tour end?')}}">
                        </div>
                        <div class="col-md-6">
                            <textarea  class="" __name__="whofor[__number__][content]" class="form-control full-h" placeholder="..."></textarea>
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
            
      <div class="form-group-item">
            <label class="control-label">{{__("Who Not For")}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-5">{{__("Title")}}</div>
                    <div class="col-md-5">{{__('Content')}}</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="g-items">
                @if(!empty($translation->whonotfor))
                    @php if(!is_array($translation->whonotfor)) $translation->whonotfor = json_decode($translation->whonotfor); @endphp
                    @foreach($translation->whonotfor as $key=>$whonotfo)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="whonotfor[{{$key}}][title]" class="form-control" value="@if(!empty($whonotfo['title'])){{$whonotfo['title']}}@endif" placeholder="{{__('Eg: When and where does the tour end?')}}">
                                </div>
                                <div class="col-md-6">
                                    <textarea  class="d-none has-ckeditor" name="whonotfor[{{$key}}][content]" class="form-control full-h" placeholder="...">@if(!empty($whonotfo['title'])){{$whonotfo['content']}}@endif</textarea>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-right">
                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            </div>
            <div class="g-more hide">
                <div class="item" data-number="__number__">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" __name__="whonotfor[__number__][title]" class="form-control" placeholder="{{__('Eg: When and where does the tour end?')}}">
                        </div>
                        <div class="col-md-6">
                            <textarea  class="" __name__="whonotfor[__number__][content]" class="form-control full-h" placeholder="..."></textarea>
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="form-group d-none">
            <label class="control-label">{{__("Description")}}</label>
            <div class="">
                <textarea name="short_desc" class="form-control" cols="30" rows="4">{{$translation->short_desc}}</textarea>
            </div>
        </div> -->


        <div class="form-group">
            <label for="duration">{{__("Trek Zone ")}}</label>
            <input type="text" class="form-control" name="trek_zone" id="" value="{{$translation->trek_zone}}">
        </div>
        <div class="form-group">
            <label for="max_altitude"> {{__("Max Altitude ")}}</label>
            <input type="text" class="form-control" name="max_altitude" id="" value="{{$translation->max_altitude}}">
        </div>
        <div class="form-group">
            <label for="best_season">{{__("Best Season")}}</label>
            <input type="text" class="form-control" name="best_season" id="" value="{{$translation->best_season}}">
        </div>
        <div class="form-group">
            <label for="difficulty">{{__("Difficulty")}}</label>
            <input type="text" class="form-control" name="difficulty" id="" value="{{$translation->difficulty}}">
        </div>
        <div class="form-group">
            <label for="distance">{{__("Distance")}}</label>
            <input type="text" class="form-control" name="distance" id="" value="{{$translation->distance}}">
        </div>

        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Category")}}</label>
                <div class="">
                    <select name="category_id" class="form-control">
                        <option value="">{{__("-- Please Select --")}}</option>
                        <?php
                        $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
                            foreach ($categories as $category) {
                                $selected = '';
                                if ($row->category_id == $category->id)
                                    $selected = 'selected';
                                printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                                $traverse($category->children, $prefix . '-');
                            }
                        };
                        $traverse($tour_category);
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">{{__("Youtube Video")}}</label>
                <input type="text" name="video" class="form-control" value="{{$row->video}}" placeholder="{{__("Youtube link video")}}">
            </div>

            @if(is_default_lang())
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">{{__("Minimum advance reservations")}}</label>
                            <input type="number" name="min_day_before_booking" class="form-control" value="{{$row->min_day_before_booking}}" placeholder="{{__("Ex: 3")}}">
                            <i>{{ __("Leave blank if you dont need to use the min day option") }}</i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">{{__("Duration")}}</label>
                            <div class="input-group mb-3">
                                <input type="text" name="duration" class="form-control" value="{{$row->duration}}" placeholder="{{__("Duration")}}"  aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">{{__('hours')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Tour Min People")}}</label>
                        <input type="text" name="min_people" class="form-control" value="{{$row->min_people}}" placeholder="{{__("Tour Min People")}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{{__("Tour Max People")}}</label>
                        <input type="text" name="max_people" class="form-control" value="{{$row->max_people}}" placeholder="{{__("Tour Max People")}}">
                    </div>
                </div>
            </div>

        @endif
        <?php do_action(\Modules\Tour\Hook::FORM_AFTER_MAX_PEOPLE,$row) ?>
        <div class="form-group-item">
            <label class="control-label">{{__('FAQs')}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-5">{{__("Title")}}</div>
                    <div class="col-md-5">{{__('Content')}}</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="g-items">
                @if(!empty($translation->faqs))
                    @php if(!is_array($translation->faqs)) $translation->faqs = json_decode($translation->faqs); @endphp
                    @foreach($translation->faqs as $key=>$faq)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="faqs[{{$key}}][title]" class="form-control" value="{{$faq['title']}}" placeholder="{{__('Eg: When and where does the tour end?')}}">
                                </div>
                                <div class="col-md-6">
                                    <textarea name="faqs[{{$key}}][content]" class="form-control full-h" placeholder="...">{{$faq['content']}}</textarea>
                                </div>
                                <div class="col-md-1">
                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="text-right">
                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
            </div>
            <div class="g-more hide">
                <div class="item" data-number="__number__">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" __name__="faqs[__number__][title]" class="form-control" placeholder="{{__('Eg: When and where does the tour end?')}}">
                        </div>
                        <div class="col-md-6">
                            <textarea __name__="faqs[__number__][content]" class="form-control full-h" placeholder="..."></textarea>
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('Tour::admin/tour/include-exclude')
        @include('Tour::admin/tour/itinerary')
        @if(is_default_lang())
            <div class="form-group">
                <label class="control-label">{{__("Banner Image")}}</label>
                <div class="form-group-image">
                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('banner_image_id',$row->banner_image_id) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">{{__("Gallery")}}</label>
                {!! \Modules\Media\Helpers\FileHelper::fieldGalleryUpload('gallery',$row->gallery) !!}
            </div>
        @endif
    </div>
</div>
