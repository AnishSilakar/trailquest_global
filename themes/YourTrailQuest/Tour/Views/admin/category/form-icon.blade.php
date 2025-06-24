<div class="form-group">
    <label>{{ __('Category Icon Class') }}</label>
    <input type="text" value="{{$row->cat_icon}}" placeholder="{{__("Category icon")}}" name="cat_icon" class="form-control">
</div>
 <div class="panel">
                                <div class="panel-body">
                                    <h3 class="panel-body-title">{{ __('Category Image')}}</h3>
                                    <div class="form-group">
                                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
                                    </div>
                                </div>
                            </div>