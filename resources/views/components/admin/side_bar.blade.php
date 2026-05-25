@php
    $setting = setting();
@endphp
<div class="flapt-sidemenu-wrapper">
    <div class="flapt-logo">
        <a href="{{route('article.index')}}">
          <img class="desktop-logo" src="{{ asset($setting->logo)}}" />
            <img class="small-logo" src="{{ asset($setting->logo)}}"/>
          </a>
    </div>
    <div class="flapt-sidenav" id="flaptSideNav">
        <!-- Side Menu Area -->
        <div class="side-menu-area">
            <nav>
                <ul class="sidebar-menu" data-widget="tree">
                    @php
                        $isActive = false;
                        if (request()->is('*/article') || request()->is('*/article/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('article.index')}}"><i class="bx bx-book"></i><span>{{__('message.article')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/article_type') || request()->is('*/article_type/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('article_type.index')}}"><i class="bx bx-line-chart"></i><span>{{__('message.article_type')}}</span></a>
                    </li>
                     @php
                        $isActive = false;
                        if (request()->is('*/submit_article') || request()->is('*/submit_article/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('submit_article')}}"><i class="bx bxs-file-pdf"></i><span>{{__('message.submit_article')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/faq') || request()->is('*/faq/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('faq.index')}}"><i class="bx bx-bell-plus"></i><span>{{__('message.faq')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/volume') || request()->is('*/volume/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('volume.index')}}"><i class="bx bx-volume"></i><span>{{__('message.volume')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/issue') || request()->is('*/issue/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('issue.index')}}"><i class="bx bx-link-alt"></i><span>{{__('message.issue')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/topic') || request()->is('*/topic/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('topic.index')}}"><i class="bx bxl-audible"></i><span>{{__('message.topic')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/university') || request()->is('*/university/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('university.index')}}"><i class="bx bx-home-circle"></i><span>{{__('message.university')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/subject') || request()->is('*/subject/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('subject.index')}}"><i class="bx bx-book"></i><span>{{__('message.subject')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/location') || request()->is('*/location/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('location.index')}}"><i class="bx bx-map"></i><span>{{__('message.location')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/job') || request()->is('*/job/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('job.index')}}"><i class="bx bx-info-circle"></i><span>{{__('message.job')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/author') || request()->is('*/author/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('author.index')}}"><i class="bx bx-user"></i><span>{{__('message.editor')}}</span></a>
                    </li>
                     @php
                        $isActive = false;
                        if (request()->is('*/page') || request()->is('*/page/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('page.index')}}"><i class="bx bx-last-page"></i><span>{{__('message.pages')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/banner') || request()->is('*/banner/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('banner.index')}}"><i class="bx bx-image"></i><span>{{__('message.banner')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/footer_category') || request()->is('*/footer_category/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('footer_category.index')}}"><i class="bx bx-duplicate"></i><span>{{__('message.footer_category')}}</span></a>
                    </li>
                    @php
                        $isActive = false;
                        if (request()->is('*/footer_link') || request()->is('*/footer_link/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('footer_link.index')}}"><i class="bx bx-link-external"></i><span>{{__('message.footer_link')}}</span></a>
                    </li>
                     @php
                        $isActive = false;
                        if (request()->is('*/social_media') || request()->is('*/social_media/*') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('social_media.index')}}"><i class="bx bx-world"></i><span>{{__('message.social_media_link')}}</span></a>
                    </li>
                     @php
                        $isActive = false;
                        if (request()->is('journal_admin/change_password') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('change_password')}}"><i class="bx bx-lock"></i><span>{{__('message.change_psw')}}</span></a>
                    </li>
                     @php
                        $isActive = false;
                        if (request()->is('journal_admin/setting') ) {
                            $isActive = true;
                        }            
                    @endphp
                    <li class="@if($isActive) active @endif">
                        <a href="{{route('setting')}}"><i class="bx bx-list-ul"></i><span>{{__('message.setting')}}</span></a>
                    </li>
                    <li>
                        <a href="{{route('admin_logout')}}"><i class="bx bx-lock"></i><span>{{__('message.logout')}}</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>