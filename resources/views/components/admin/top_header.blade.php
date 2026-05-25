<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8TZW208949"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8TZW208949');
</script>

@php
        $settings = setting();
    @endphp
<header class="top-header-area d-flex align-items-center justify-content-between">
    <div class="left-side-content-area d-flex align-items-center">
        <!-- Mobile Logo -->
        <div class="mobile-logo">
            <a href="{{url('/admin/home')}}"><img src="{{ asset($settings->logo)}}" alt="Mobile Logo" /></a>
        </div>

        <!-- Triggers -->
        <div class="flapt-triggers">
            <div class="menu-collasped" id="menuCollasped">
                <i class="zmdi zmdi-dns"></i>
            </div>
            <div class="mobile-menu-open" id="mobileMenuOpen">
                <i class="zmdi zmdi-dns"></i>
            </div>
        </div>
    </div>

    <div class="right-side-navbar d-flex align-items-center justify-content-end">
        <!-- Mobile Trigger -->
        <div class="right-side-trigger" id="rightSideTrigger">
            <i class="bx bx-menu-alt-right"></i>
        </div>

        <!-- Top Bar Nav -->
        <ul class="right-side-content d-flex align-items-center">
            <li class="nav-item dropdown">
                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img src="img/bg-img/person_1.jpg" alt="" />
                </button>
                <div class="dropdown-menu profile dropdown-menu-right">
                    <!-- User Profile Area -->
                    <div class="user-profile-area">
                        <a href="#" class="dropdown-item"><i class="bx bx-user font-15"
                                aria-hidden="true"></i> My
                            profile</a>
                        <a href="#" class="dropdown-item"><i class="bx bx-wrench font-15"
                                aria-hidden="true"></i>
                            settings</a>
                        <a href="#" class="dropdown-item"><i class="bx bx-power-off font-15"
                                aria-hidden="true"></i>
                            Sign-out</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>