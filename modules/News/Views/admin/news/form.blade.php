<div class="form-group magic-field" data-id="title" data-type="title">
    <label class="control-label">{{ __('Title')}}</label>
    <input type="text" value="{{ $translation->title ?? 'New Post' }}" placeholder="News title" name="title" class="form-control">
</div>
<div class="form-group magic-field" data-id="content" data-type="content" data-editor="1">
    <label class="control-label">{{ __('Content')}} </label>
    <div class="">
        <textarea name="content" class="d-none has-ckeditor" id="content" cols="30" rows="10">{{$translation->content}}</textarea>
    </div>
</div>
<div class="form-group-item">
            <label class="control-label">{{__('Table of Content')}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-5">{{__("Title")}}</div>
                    <div class="col-md-5">{{__('Content')}}</div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="g-items">
                @if(!empty($translation->table_of_content))
                    @php if(!is_array($translation->table_of_content)) $translation->table_of_content = json_decode(old('table_of_content',$translation->table_of_content)); @endphp
                    @foreach($translation->table_of_content as $key=>$table_of_contenta)
                        <div class="item" data-number="{{$key}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" name="table_of_content[{{$key}}][title]" class="form-control" value="{{$table_of_contenta['title']}}">
                                </div>
                                <div class="col-md-6">
                                    <textarea name="table_of_content[{{$key}}][content]" class="d-none has-ckeditor" placeholder="...">{{$table_of_contenta['content']}}</textarea>
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
                            <input type="text" __name__="table_of_content[__number__][title]" class="form-control" placeholder="">
                        </div>
                        <div class="col-md-6">
                            <textarea __name__="table_of_content[__number__][content]" class="form-control full-h" class="d-none has-ckeditor"  placeholder="..."></textarea>
                        </div>
                        <div class="col-md-1">
                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>