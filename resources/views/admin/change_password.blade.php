@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('message.change_psw')}}</h3>
                        </div>
                        <form id="quickForm" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label >{{__('message.current_psw')}}<span class="text-danger ml-1">*</span></label>
                                    <input type="password" name="current_password" class="form-control" autocomplete="off" autofocus="true">
                                    
                                </div>
                                @error('old_password')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label >{{__('message.new_psw')}}<span class="text-danger ml-1">*</span></label>
                                    <input type="password" name="new_password" class="form-control"  autocomplete="off" id="new_password">
                                    
                                </div>
                                @error('new_password')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    <label >{{__('message.confirm_psw')}}</label>
                                    <input type="password" name="conifm_password" id="conifm_password" class="form-control"  autocomplete="off">
                                    
                                </div>
                                @error('conirm_password')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="submit">{{__('message.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        $rules = 'current_password:{required: true},new_password:{required:true,minlength:5},conifm_password:{required:true,equalTo:"#new_password"}';
        $submit_url = route('upd_password');
        $redirect_url = '';
        echo validation($rules,'quickForm',$submit_url,$redirect_url,'');
    @endphp
@endsection