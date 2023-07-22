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

                        @if($users->profile_pic == '')
                            <img class="user-img" src="{{asset('admin/images/dummy_img.png')}}" alt="user">
                        @else
                            <img class="user-img" src="{{asset('storage/images/'.$users->profile_pic)}}">

                        @endif
{{--                        <img class="user-img" src="{{asset('storage/images/'.$users->profile_pic)}}">--}}
                        <h4>{{$users->name}}</h4>
                        <p>{{$users->role}}</p>
                    </div>
                    <div class="cover-image"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tile p-0">
                    <ul class="nav flex-column nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#user-timeline"
                                                data-toggle="tab">@lang('langs.profile')</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="user-timeline">
                        <div class="tile user-settings">
                            <h4 class="line-head">@lang('langs.profile')</h4>
                            <form action="#" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label>@lang('langs.user_name')</label>
                                        <input class="form-control" name="name" value="{{$users->name}}" type="text"
                                               disabled>
                                        <span style="color: red">{{$errors->first('name')}}</span>

                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>@lang('langs.user_email')</label>
                                        <input class="form-control" name="email" value="{{$users->email}}" type="text"
                                               disabled>
                                        <span style="color: red">{{$errors->first('email')}}</span>

                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label>@lang('langs.user_mobile')</label>
                                        <input class="form-control" name="mobile" value="{{$users->mobile}}"
                                               type="number" disabled>
                                        <span style="color: red">{{$errors->first('mobile')}}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label>@lang('langs.user_gender')</label><br>
                                        <input class="form-check-input" type="radio" name="gender" value="male"
                                               {{old('gender')=="male" ? 'checked='.'"checked"' : '' }}  @if(isset($users)) {{ ($users->gender=="male")? "checked" : "" }} @endif  disabled>
                                        <label class="form-check-label" for="male">@lang('langs.male')</label><br>
                                        <input class="form-check-input" type="radio" name="gender" value="female"
                                               {{old('gender')=="female" ? 'checked='.'"checked"' : '' }}  @if(isset($users)) {{ ($users->gender=="female")? "checked" : "" }} @endif disabled>
                                        <label class="form-check-label" for="female">@lang('langs.female')</label>
                                        <span style="color: red">{{$errors->first('gender')}}</span>

                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <a href="{{route('user.index')}}"
                                           class="btn btn-primary">@lang('langs.back')</a>
                                        {{--                                        <button class="btn btn-primary" type="submit" disabled><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>--}}
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
