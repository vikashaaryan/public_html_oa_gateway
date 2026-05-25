@extends('admin.layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-breadcrumb">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{__('message.footer_link')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
      <div class="card" >
        <div class="card-header">
            <h4>{{__('message.edit_footer_link')}}</h4>
        </div>
        <div class="card-body">
          <form id="quickForm" method="POST" action="{{ $formAction }}" autocomplete="off">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.name')}}<span class="error">*</span></label>
                      <input type="text" class="form-select" name="name" id="name" autofocus placeholder="{{__('message.enter_name')}}" autofocus value="{{$data->name}}">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">{{__('message.footer_category')}}<span class="error">*</span></label>
                      <select class="form-select" name="footer_category" id="footer_category">
                        <option value="">{{__('message.select_footer_category')}}</option>
                        @if($categories->isNotEmpty())
                          @foreach ($categories as $category_1)
                            <option value="{{$category_1->id}}" @if($category_1->id == $data->footer_category) selected @endif>{{$category_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.link')}}</label>
                      <input type="text" class="form-select" name="footer_link" id="footer_link" autofocus placeholder="{{__('message.enter_footer_link')}}" autofocus value="{{$data->footer_link}}">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.sort')}}<span class="error">*</span></label>
                      <input type="text" class="form-select" name="sort" id="sort" autofocus placeholder="{{__('message.enter_sort')}}" value="{{$data->sort}}">
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
                <div class="col-lg-12">
                  <a href="{{route('footer_link.index')}}"  class="btn btn-secondary">{{__('message.back')}}</a>
                  <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
                </div>
              </div>
          </form>
        </div>
      </div>
  </div>
</div>
@php
	$rules = 'name: {required: true,minlength: 3,maxlength: 150},footer_category:{required:true},footer_link:{required:false,url:true},sort: {required: true,number: true},status:{required:true}';
	$submit_url = $formAction;
	$redirect_url = '';
	echo validation($rules,'quickForm',$submit_url,$redirect_url,'');
@endphp
@endsection