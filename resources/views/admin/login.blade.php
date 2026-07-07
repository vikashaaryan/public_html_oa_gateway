<!doctype html>
<html lang="en">
    @php 
$setting = setting();
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$setting->title}}</title>
    <link rel="icon" href="{{ asset($setting->logo)?? asset('img/core-img/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{ asset('style.css')}}">
</head>
<body class="login-area">
    <div id="preloader">
        <div class="item">
            <i class="loader --8"></i>
        </div>
    </div>
    <div class="main-content- h-100vh bg-img" style="background-image: url({{ asset('img/bg-img/bg-3.jpg')}} );">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-sm-10 col-md-7 col-lg-5">
                    <div class="middle-box">
                        <div class="card-">
                            <div class="card-body p-4 py-5">
                                <div class="log-header-area mb-5 text-center">
                                
                                <div><a class="logo" href="#">
                                <img class="img-fluid for-light m-auto" src="{{ asset($setting->logo)}}" alt="looginpage" style="width:100px;height:100px"></a></div>
                                <h5>Welcome Back !</h5>
                                <p class="mb-0">{{__('message.sign_in_continue')}}</p>
                                </div>
                                <form action="" id="login_form">
                                    @csrf
                                    <div class="alert alert-danger" id="invalid_login_data">
            Invalid email or password
        </div>
                                    <div class="form-group mb-3">
                                        <label class="text-muted" for="emailaddress">{{__('message.email')}}</label>
                                        <input class="form-control" type="text" id="emailaddress" placeholder="{{__('message.enter_email')}}" name="email">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="text-muted" for="password">{{__('message.password')}}</label>
                                        <input class="form-control" type="password" id="password" placeholder="{{__('message.enter_password')}}" name="password">
                                    </div>

                                    <div class="form-group mb-3">
                                        <button class="btn btn-primary btn-lg w-100" type="submit">{{__('message.sign_in')}}</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/default-assets/active.js')}}"></script>
    <script src="{{ asset('js/backend/app.js') }}"></script>
  <?php
	$rules = 'email: {required: true,email: true},password: {required: true,minlength: 5}';
	$login_url = route('admin_login');
	$redirect_url = route('setting');
	echo validation($rules,'login_form',$login_url,$redirect_url,'invalid_login_data');
	?>
	<style>
		#invalid_login_data{
			color:red;
			display:none;
		}
	</style>
</body>
</body>
</html>