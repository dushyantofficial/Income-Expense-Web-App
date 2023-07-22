@extends('Admin.layouts.app')

@section('content')
    <main class="app-content">
        @php
            $user = \Illuminate\Support\Facades\Auth::user();
        @endphp
        @include('Admin.flash-message')
        <div class="row user">
            <div class="col-md-12">
                <div class="profile">
                    <div class="info">
                        @if($user->profile_pic == '')
                            <img class="user-img" src="{{asset('admin/images/dummy_img.png')}}" alt="user">
                        @else
                            <img class="user-img" src="{{asset('storage/images/'.$user->profile_pic)}}">

                        @endif
                        <h4>{{$user->name}}</h4>
                        <p>{{$user->role}}</p>
                    </div>
                    <div class="cover-image"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tile p-0">
                    <ul class="nav flex-column nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#user-timeline"
                                                data-toggle="tab">@lang('langs.profile')</a></li>
                        <li class="nav-item"><a class="nav-link " href="#user-settings" id="password"
                                                data-toggle="tab">@lang('langs.change_password')</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="user-timeline">
                        <div class="tile user-settings">
                            <h4 class="line-head">@lang('langs.profile')</h4>
                            <form action="{{route('profile-update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>Full Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" type="text">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>@lang('langs.user_email')</label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" type="text">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('langs.user_profile')</label>
                                        <input class="form-control" name="profile_pic" type="file">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>@lang('langs.user_mobile')</label>
                                        <input class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{$user->mobile}}"
                                               type="number">
                                        @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('langs.user_gender')</label><br>
                                        <input class="form-check-input" type="radio" name="gender" value="male"
                                            {{old('gender')=="male" ? 'checked='.'"checked"' : '' }}  @if(isset($user)) {{ ($user->gender=="male")? "checked" : "" }} @endif >
                                        <label class="form-check-label" for="male">@lang('langs.male')</label><br>
                                        <input class="form-check-input" type="radio" name="gender" value="female"
                                            {{old('gender')=="female" ? 'checked='.'"checked"' : '' }}  @if(isset($user)) {{ ($user->gender=="female")? "checked" : "" }} @endif>
                                        <label class="form-check-label" for="female">@lang('langs.female')</label>
                                        <span style="color: red">{{$errors->first('gender')}}</span>

                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa fa-fw fa-lg fa-check-circle"></i> @lang('langs.update')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="user-settings">
                        <div class="tile user-settings">
                            <h4 class="line-head">@lang('langs.password_update')</h4>
                            <form action="{{route('change-password')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>@lang('langs.password_old')</label>
                                        <input class="form-control @error('current_password') is-invalid @enderror"
                                             id="current_password"  name="current_password" type="password"
                                               placeholder="Old Password">
                                        @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <input type="checkbox" id="remember" onclick="oldPassword()" {{ old('remember') ? 'checked' : '' }}><i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-8 mb-4">
                                        <label>@lang('langs.password_new')</label>
                                        <input class="form-control @error('new_password') is-invalid @enderror"
                                             id="new_password"  name="new_password" type="password"
                                               placeholder="New Password">
                                        @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <input type="checkbox" id="remember" onclick="newPassword()" {{ old('remember') ? 'checked' : '' }}><i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-8 mb-4">
                                        <label>@lang('langs.password_confirm')</label>
                                        <input class="form-control @error('conform_password') is-invalid @enderror"
                                             id="confirm_passsword"  name="conform_password" type="password"
                                               placeholder="Comfirm Password">
                                        @error('conform_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <input type="checkbox" id="remember" onclick="confirmPassword()" {{ old('remember') ? 'checked' : '' }}><i class="fa fa-eye-slash" aria-hidden="true"></i>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa fa-fw fa-lg fa-check-circle"></i> @lang('langs.update')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('page_scripts')
    @php
        $doc = request('document');
    @endphp
    <script>
        function oldPassword() {
            var x = document.getElementById("current_password");
            var span = document.querySelector('.label-text');
            if (x.type === "password") {
                x.type = "text";
                span.classList.add('check_color_name')
            } else {
                x.type = "password";
                span.classList.remove('check_color_name')
            }
        }
    </script>
    <script>
        function newPassword() {
            var x = document.getElementById("new_password");
            var span = document.querySelector('.label-text');
            if (x.type === "password") {
                x.type = "text";
                span.classList.add('check_color_name')
            } else {
                x.type = "password";
                span.classList.remove('check_color_name')
            }
        }
    </script>
    <script>
        function confirmPassword() {
            var x = document.getElementById("confirm_passsword");
            var span = document.querySelector('.label-text');
            if (x.type === "password") {
                x.type = "text";
                span.classList.add('check_color_name')
            } else {
                x.type = "password";
                span.classList.remove('check_color_name')
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            var password = '<?php echo $doc; ?>';
            if (password == 'password') {
                $('#password').trigger('click');
            }
        });
    </script>
@endpush
