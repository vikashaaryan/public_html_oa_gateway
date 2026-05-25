@extends('admin.layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-breadcrumb">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{__('message.banner')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
      <div class="card" >
        <div class="card-header">
            <h4>{{__('message.edit_banner')}}</h4>
        </div>
        <div class="card-body">
          <form id="quickForm" method="POST" action="{{ $formAction }}" autocomplete="off">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.title')}}<span class="error">*</span></label>
                      <input type="text" id="title" name="title" placeholder="{{__('message.enter_title')}}" class="form-control" autofocus value="{{$data->title}}">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.description')}}<span class="error">*</span></label>
                      <textarea type="text" id="description" name="description" placeholder="{{__('message.enter_description')}}" class="form-control" autofocus>{{$data->description}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.link')}}<span class="error">*</span></label>
                      <input type="text" id="link" name="link" placeholder="{{__('message.enter_link')}}" class="form-control" autofocus value="{{$data->link}}">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.button_name')}}<span class="error">*</span></label>
                      <input type="text" id="button_name" name="button_name" placeholder="{{__('message.enter_button_name')}}" class="form-control" autofocus value="{{$data->button_name}}">
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
                  <a href="{{route('banner.index')}}"  class="btn btn-secondary">{{__('message.back')}}</a>
                  <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
                </div>
              </div>
          </form>
        </div>
      </div>
  </div>
</div>
@php
	$rules = 'name: {required: true,minlength: 3,maxlength: 150},status:{required:true}';
	$submit_url = $formAction;
	$redirect_url = '';
	echo validation($rules,'quickForm',$submit_url,$redirect_url,'');
@endphp
@endsection