@extends('admin.layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-breadcrumb">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{__('message.submit_article')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class ="d-flex">
                    <div class="w-50">
                        <h4 class="card-title">{{__('message.submit_article')}}</h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap data-table-area"  id="article_table">
                        <thead>
                            <tr>
                                <th >{{__('message.first_name')}}</th>
                                <th >{{__('message.last_name')}}</th>
                                <th >{{__('message.email')}}</th>
                                <th>{{__('message.institution_affiliation')}}</th>
                                <th>{{__('message.manuscript_title')}}</th>
                                <th>{{__('message.article_type')}}</th>
                                <th>{{__('message.article_topic')}}</th>
                                <th>{{__('message.subject')}}</th>
                                <th>{{__('message.abstract')}}</th>
                                <th>{{__('message.manuscript_document')}}</th>
                                <th>{{__('message.comments')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
        </div>
    </div>
</div>
@php
$view_data = '{ data: "first_name" },{ data: "last_name" },{ data: "email_address" },{ data: "institution" },{ data: "title" },{ data: "article_type" },{ data: "article_topic" },{ data: "subject" },{ data: "abstract" },{ data: "document" },{ data: "comments" }';
$url = get_admin_url('submit_article_list');
echo data_table('article_table',$view_data,$url,'');
@endphp
@endsection