@extends('layouts.app')
@section('content')
<style>
    .check_color_name{
        color: red;
    }
</style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> @lang('langs.user_add')</h1>
                {{-- <p>Sample forms</p> --}}
            </div>
            {{-- <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
            </ul> --}}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title"></h3>
                    <div class="tile-body">
                        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data"
                              id="upload_pdf">
                        @csrf


                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_name')</label>
                                <input name="name" type="text" value="{{old('name')}}"
                                       class="form-control @error('name') is-invalid @enderror" id="oldPasswordInput"
                                       placeholder="Enter Full Name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_profile')</label>
                                <input class="form-control" type="file" name="profile_pic">
                                <span style="color: red">{{$errors->first('profile_pic')}}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_mobile')</label>

                                <input name="mobile" id="phone" type="number" value="{{old('mobile')}}"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       placeholder="Enter User Mobile Number">
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_email')</label>

                                <input name="email" type="text" value="{{old('email')}}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Enter User Email">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_gender')</label><br>
                                <label for="male">@lang('langs.male')</label>
                                <input type="radio" id="html" name="gender"
                                       value="male" {{old('gender')=="male" ? 'checked='.'"checked"' : '' }}>
                                <label for="female">@lang('langs.female')</label>
                                <input type="radio" id="css" name="gender"
                                       value="female" {{old('gender')=="female" ? 'checked='.'"checked"' : '' }}>
                                <span style="color: red">{{$errors->first('gender')}}</span>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_pass')</label>

                                <input name="password" type="password" value="{{old('password')}}"
                                    id="password"   class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Enter User Password">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <input type="checkbox" id="remember" onclick="myFunction()" name="remember" {{ old('remember') ? 'checked' : '' }}>&nbsp;&nbsp;
                                <span class="label-text"><b id="hide_show">Show Password</b></span>
                            </div>
                        </div>
                    </div>

                   <br>


                    <button type="submit" class="btn btn-primary">@lang('langs.user_add')</button>
                    <a href="{{route('user.index')}}" class="btn btn-secondary">@lang('langs.back')</a>
                    </form>
                </div>


            </div>
        </div>


        </div>
    </main>



@endsection
@push('page_scripts')
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var span = document.querySelector('.label-text');
            var passwordText = document.getElementById("hide_show");
            if (x.type === "password") {
                x.type = "text";
                span.classList.add('check_color_name')
                passwordText.innerText = "Hide Password";
            } else {
                x.type = "password";
                span.classList.remove('check_color_name')
                passwordText.innerText = "Show Password";
            }
        }
    </script>
    <script>
        $("#phone").keydown(function (event) {
            k = event.which;
            if ((k >= 96 && k <= 105) || k == 8) {
                if ($(this).val().length == 10) {
                    if (k == 8) {
                        return true;
                    } else {
                        event.preventDefault();
                        return false;

                    }
                }
            } else {
                event.preventDefault();
                return false;
            }

        });
    </script>
@endpush
