@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('Quiz Management')}}</h1>
            <div class="title-actions">
                <a href="{{route('core.admin.quiz.create')}}" class="btn btn-primary">{{__("Add new")}}</a>
            </div>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{route('core.admin.quiz.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            <option value="delete">{{__(" Delete ")}}</option>
                        </select>
                        <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            <div class="col-left">

            </div>
        </div>
        <div class="panel">
            <div class="panel-title">{{__('All Quiz')}}</div>
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="60px"><input type="checkbox" class="check-all"></th>
                            <th>{{__('Title')}}</th>
                            <th>{{__("Description")}}</th>
                            <th>{{__("Actions")}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td><input type="checkbox" name="ids[]" class="check-item" value="{{$row['id']}}">
                                </td>
                                <td>
                                    <a href="{{route('core.admin.quiz.edit',['id'=>$row['id']])}}">{{$row['title']}}</a>
                                </td>
                                <td>
                                    {{$row['description']}}
                                </td>
                                <td>
                                    <a href="{{ route('core.admin.quiz.show', ['id' => $row['id']]) }}" class="btn btn-sm btn-info" title="{{ __('View Details') }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
