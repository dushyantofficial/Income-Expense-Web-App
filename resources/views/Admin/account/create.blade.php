@extends('Admin.layouts.app')
@section('content')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>@lang('langs.bank_add')</h1>
            </div>
        </div>
        @php
            $user = \Illuminate\Support\Facades\Auth::user();
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title"></h3>
                    <div class="tile-body">
                        <form action="{{route('account.store')}}" method="POST" enctype="multipart/form-data"
                              id="upload_pdf">
                        @csrf
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.accout_name')</label>
                                <input name="name" type="text" value="{{old('name')}}"
                                       class="form-control @error('name') is-invalid @enderror" id="oldPasswordInput"
                                       placeholder="Enter Bank Name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.accout_user_name')</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                                    @if($user->role == config('constants.ROLE.ADMIN'))
                                        <option value="">---Select User Name---</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="{{$user->id}}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                    @endif
                                </select>
                                @error('user_id')
                                <span class="text-danger">The user name field is required.</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.accout_type')</label><br>
                                <label for="male">@lang('langs.cash')</label>
                                <input type="radio" id="html" name="type"
                                       value="cash" {{old('type')=="cash" ? 'checked='.'"checked"' : '' }}>
                                <label for="female">@lang('langs.bank')</label>
                                <input type="radio" id="css" name="type"
                                       value="bank" {{old('type')=="bank" ? 'checked='.'"checked"' : '' }}>
                                <span style="color: red">{{$errors->first('type')}}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.amount')</label>
                                <input class="form-control @error('amount') is-invalid @enderror" type="number"
                                       name="amount" min="1" value="{{old('amount')}}"
                                       placeholder="Enter Amount">
                                @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>


                        <button type="submit" class="btn btn-primary">@lang('langs.save')</button>&nbsp;&nbsp;
                        <a href="{{route('account.index')}}" class="btn btn-secondary">@lang('langs.back')</a>
                        </form>
                    </div>


                </div>
            </div>


        </div>
    </main>



@endsection
