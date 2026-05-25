@extends('admin.layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-breadcrumb">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{__('message.social_media_link')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class ="d-flex">
                    <div class="w-50">
                        <h4 class="card-title">{{__('message.social_media_link')}}</h4>
                    </div>
                    <div class="w-50">
                        <a href="{{route('social_media.create')}}" class="float-end no-underline">
                            <i class="mdi mdi-library-plus" aria-hidden="true"></i> {{ __('message.add_social_media_link')}}
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap data-table-area"  id="social_media_table">
                        <thead>
                            <tr>
                                <th >{{__('message.sort')}}</th>
                                <th >{{__('message.name')}}</th>
                                <th >{{__('message.image')}}</th>
                                <th >{{__('message.link')}}</th>
                                <th>{{__('message.status')}}</th>
                                <th>{{__('message.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
        </div>
    </div>
</div>
@php
$view_data = '{ data: "sort" },{ data: "name" },{ data: "image" },{ data: "link" },{ data: "status" },{ data: "action" }';
$url = get_admin_url('social_media_list');
echo data_table('social_media_table',$view_data,$url,'');
$url = get_admin_url('social_media_status');
echo change_status(__('message.change_status'),$url);
@endphp
@endsection