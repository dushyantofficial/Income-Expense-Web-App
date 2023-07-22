@extends('Admin.layouts.app')
@section('content')
{{--@dd(decrypt($users->password))--}}
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>@lang('langs.user_update')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title"></h3>
                    <div class="tile-body">
                        <form action="{{route('user.update',$users->id)}}" method="POST" enctype="multipart/form-data"
                              id="upload_pdf">
                        @csrf
                        @method('patch')

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_name')</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                       value="{{$users->name}}"
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
                                <img src="{{asset('storage/images/'.$users->profile_pic)}}" width="50px">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_mobile')</label>
                                <input name="mobile" id="phone" type="number" value="{{$users->mobile}}"
                                       class="form-control @error('mobile') is-invalid @enderror"
                                       placeholder="Enter User Mobile Number" maxlength="10">
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_email')</label>

                                <input name="email" type="text" value="{{$users->email}}"
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
                                       value="male" {{old('gender')=="male" ? 'checked='.'"checked"' : '' }} @if(isset($users)) {{ ($users->gender=="male")? "checked" : "" }} @endif>
                                <label for="female">@lang('langs.female')</label>
                                <input type="radio" id="css" name="gender"
                                       value="female" {{old('gender')=="female" ? 'checked='.'"checked"' : '' }} @if(isset($users)) {{ ($users->gender=="female")? "checked" : "" }} @endif>
                                <span style="color: red">{{$errors->first('gender')}}</span>
                            </div>
                        </div>

                    </div>
                    <br>


                    <button type="submit" class="btn btn-primary">@lang('langs.user_update')</button>
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
