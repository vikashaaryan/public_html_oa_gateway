@extends('admin.layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-breadcrumb">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{__('message.university')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
      <div class="card" >
        <div class="card-header">
            <h4>{{__('message.edit_university')}}</h4>
        </div>
        <div class="card-body">
          <form id="quickForm" method="POST" action="{{ $formAction }}" autocomplete="off">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.name')}}<span class="error">*</span></label>
                      <input type="text" id="name" name="name" placeholder="{{__('message.enter_name')}}" class="form-control"  value="{{$data->name}}" autofocus>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.location')}}<span class="error">*</span></label>
                      <select class="form-control" name="location" id="location">
                        <option value="">{{__('message.select_location')}}</option>
                        @if($locations->isNotEmpty())
                          @foreach ($locations as $location1)
                            <option value="{{$location1->id}}" @if($data->location_id == $location1->id) selected @endif>{{$location1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.description')}}<span class="error">*</span></label>
                      <textarea  id="description2" name="description"  style="height: 400px;">{{$data->description}}</textarea > 
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="name" class="form-label">{{__('message.status')}}<span class="error">*</span></label>
                      <select class="form-select" name="status" id="status">
                        <option value="">{{__('message.select_status')}}</option>
                        <option value="active" @if($data->status == 'active') selected @endif>{{__('message.active')}}</option>
                        <option value="inactive" @if($data->status == 'inactive') selected @endif>{{__('message.inactive')}}</option>
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="name" class="form-label">{{__('message.collaboration')}}</label>
                      <input type="checkbox" value="1" name="collaboration" class="form-check" @if($data->collaboration==1) checked @endif>
                  </div>
                </div>
                <h3>{{__('message.seo')}}</h3>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.meta_title')}}<span class="error">*</span></label>
                      <textarea name="meta_title" id="meta_title" class="form-control" placeholder="{{__('message.enter_meta_title')}}">{{$data->meta_title}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.meta_description')}}<span class="error">*</span></label>
                      <textarea name="meta_description" id="meta_description" class="form-control" placeholder="{{__('message.enter_meta_description')}}">{{$data->meta_description}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.meta_keywords')}}<span clsass="error">*</span></label>
                      <textarea name="meta_keyword" id="meta_keyword" class="form-control" placeholder="{{__('message.enter_meta_keyword')}}">{{$data->meta_keywords}}</textarea>
                  </div>
                </div>
                <div class="col-lg-12">
                  <a href="{{route('university.index')}}"  class="btn btn-secondary">{{__('message.back')}}</a>
                  <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
                </div>
              </div>
          </form>
        </div>
      </div>
  </div>
</div>
@php
	$rules = 'name: {required: true,minlength: 3,maxlength: 150},location:{required:true},meta_title:{required:true},meta_description:{required:true},meta_keyword:{required:true},status:{required:true}';
	$submit_url = $formAction;
	$redirect_url = '';
	echo validation($rules,'quickForm',$submit_url,$redirect_url,'');
@endphp
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
       $('#description2').summernote({
  height: 300,
  toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['table', ['table']],
    ['insert', ['link', 'picture', 'video', 'hr']],
    ['view', ['fullscreen', 'codeview', 'help']],
    ['misc', ['undo', 'redo']]
  ]
});


    });
  </script>
@endsection