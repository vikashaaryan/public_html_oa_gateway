@extends('admin.layouts.app')
@section('content')
    <main class="content">
		<div class="container-fluid p-0">
			<div class="mb-3">
				<h1 class="h3 d-inline align-middle">{{__('message.settings')}}</h1>
			</div>
			<div class="row">
			    <div class="col-12 col-lg-12">
                    <form id="setting_form" method="POST" action="{{ route('update_setting') }}" autocomplete="off"  enctype="multipart/form-data">
                    @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{__('message.settings')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">{{__('message.site_title')}}</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="{{__('message.enter_site_title')}}" autocomplete="off" value="{{$settings->title}}">
                                </div>
                                <div class="mb-3">
                                    <label >{{__('message.logo')}} </label>
                                    <input type="file"  id="logo" name="logo">
                                    @if($settings->logo)
                                        <img src="{{ asset($settings->logo)}}" style="width:75px;">
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{__('message.mobile_number')}} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="mobile_number" placeholder="{{__('message.enter_mobile_number')}}" name="mobile_number" autocomplete="off" value="{{$settings->mobile_number}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{__('message.email')}}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="{{__('message.enter_email')}}" autocomplete="off" value="{{$settings->email}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{__('message.editorial_board')}}<span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="editorial_board" name="editorial_board" placeholder="{{__('message.enter_editorial_board')}}" autocomplete="off" required> {{$settings->editorial_board}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{__('message.editorial_process')}}<span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="editorial_process" name="editorial_process" placeholder="{{__('message.enter_editorial_process')}}" autocomplete="off" required> {{$settings->editorial_process}}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{__('message.submit_article_text')}}<span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="submit_article_text" name="submit_article_text" placeholder="{{__('message.submit_article_text')}}" autocomplete="off" required> {{$settings->submit_article_text}}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">{{__('message.copy_right')}}<span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="copy_right" name="copy_right" placeholder="{{__('message.enter_copy_right')}}" autocomplete="off" required> {{$settings->copy_right}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</main>
    @php
$rules = 'title:{required:true,minlength: 3,maxlength: 200},mobile_number:{required:true,number:true},email:{required:true,email:true},editorial_board:{required:true},editorial_process:{required:true},copy_right:{required:true}';
$submit_url = route('update_setting');
$redirect_url = '';
echo validation($rules,'setting_form',$submit_url,$redirect_url,'');
@endphp
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
       $('#submit_article_text').summernote({
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