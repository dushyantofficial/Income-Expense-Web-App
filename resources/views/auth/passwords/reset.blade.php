<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Income Expense App</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    @include('Admin.languages')
    <div class="logo">
        <h1>Income Expense App</h1>
    </div>
    @include('Admin.flash-message')
    {{--    <div class="login-box">--}}
    <div class="col-md-4">
        <div class="card">
            <h2 class="card-header text-center"><i class="fa fa-lg fa-fw fa-lock" aria-hidden="true"></i>Forgot Password</h2>

            <div class="card-body">
                <form class="login-form" action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ $email ?? old('email') }}" placeholder="Enter Email">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label">Confirm Password</label>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Enter Confirm Password">
                        @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                       </div>
                    <div class="form-group">
                        <div class="utility">
                            <p class="semibold-text mb-2"><a href="{{route('login')}}">Not Forgot Password</a></p>
                        </div>
                    </div>
                    <div class="form-group btn-container">
                        <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN UP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Essential javascripts for application to work-->
<script src="{{asset('admin/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('admin/js/popper.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('admin/js/plugins/pace.min.js')}}"></script>
<script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
    });
</script>
</body>
</html>

