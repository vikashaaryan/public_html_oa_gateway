@extends('admin.layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-breadcrumb">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{__('message.editor')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
      <div class="card" >
        <div class="card-header">
            <h4>{{__('message.add_editor')}}</h4>
        </div>
        <div class="card-body">
          <form id="quickForm" method="POST"  autocomplete="off" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.name')}}<span class="error">*</span></label>
                      <input type="text" id="name" name="name" placeholder="{{__('message.enter_name')}}" class="form-control" autofocus>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.image')}}<span class="error">*</span></label>
                      <input type="file" id="image" name="image" class="form-control">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.email')}}<span class="error">*</span></label>
                      <input type="text" id="email" name="email" placeholder="{{__('message.enter_email')}}" class="form-control" autofocus>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.location')}}<span class="error">*</span></label>
                      <select name="location" id="location" class="form-control" autofocus>
                        <option value="">{{__('message.select_location')}}</option>
                        @if($locations->isNotEmpty())
                          @foreach ($locations as $location_1)
                            <option value="{{$location_1->id}}">{{$location_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.job')}}<span class="error">*</span></label>
                      <select name="job" id="job" class="form-control" autofocus>
                        <option value="">{{__('message.select_job')}}</option>
                        @if($jobs->isNotEmpty())
                          @foreach ($jobs as $job_1)
                            <option value="{{$job_1->id}}">{{$job_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.university')}}<span class="error">*</span></label>
                      <select name="university" id="university" class="form-control" autofocus>
                        <option value="">{{__('message.select_university')}}</option>
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.description')}}<span class="error">*</span></label>
                      <textarea  id="description2" name="description"  style="height: 400px;"></textarea > 

                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.sort')}}<span class="error">*</span></label>
                      <input type="text" class="form-select" name="sort" id="sort" autofocus placeholder="{{__('message.enter_sort')}}" >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="name" class="form-label">{{__('message.status')}}<span class="error">*</span></label>
                      <select class="form-select" name="status" id="status">
                        <option value="">{{__('message.select_status')}}</option>
                        <option value="active">{{__('message.active')}}</option>
                        <option value="inactive">{{__('message.inactive')}}</option>
                      </select>
                  </div>
                </div>
                <div class="col-lg-12">
                <a href="{{route('author.index')}}"  class="btn btn-secondary">{{__('message.back')}}</a>

                  <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
                </div>
              </div>
          </form>
        </div>
      </div>
  </div>
</div>
@php
	$rules = 'name: {required: true,minlength: 3,maxlength: 150},image:{required:true},email:{required:true,email:true},location:{required:true},job:{required:true},university:{required:true},description:{required:true},sort:{required:true,number:true},status:{required:true}';
	$submit_url = route('author.store');
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
    $('#location').on('change', function () {
        var location = this.value;
        $('#university').html('<option>{{__('message.select_university')}}</option>');

        $.ajax({
            url: "{{route('get_university')}}" ,
            data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'location':location
            },
            type: "POST",
            success: function (res) {
                $.each(res, function (key, value) {
                    $('#university').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    });
  </script>
@endsection