<x-admin.header/>
<div class="flapt-page-wrapper">
    <x-admin.side_bar/>
    <div class="flapt-page-content">
        <x-admin.top_header/>
        <div class="main-content">
            <div class="content-wraper-area">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <x-admin.footer/>
        </div>
    </div>
</div>
<style>
    .datepicker{
        z-index: 9999 !important;
    }
</style>
<x-admin.script />