@extends('Admin.layouts.app')
@section('content')
    <style>
        select option {
            padding-left: 25px; /* Add space for the icon */
            background-repeat: no-repeat;
            background-position: left center;
        }

        .icon-user::before {
            content: "\f007"; /* Font Awesome user icon */
            font-family: 'Font Awesome';
        }


    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>@lang('langs.transfer_add')</h1>
            </div>
        </div>
        @php
            $user = \Illuminate\Support\Facades\Auth::user();
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title"></h3>
                    @include('Admin.flash-message')
                    <div class="tile-body">
                        <form action="{{route('transfer.store')}}" method="POST" enctype="multipart/form-data"
                              id="upload_pdf">
                        @csrf
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.user_name')</label>
                                <select class="form-control  @error('user_id') is-invalid @enderror" name="user_id"
                                        id="users">
                                    @if($user->role == config('constants.ROLE.ADMIN'))
                                        <option value="">---Select User Name---</option>
                                        @foreach($users as $user)
                                            <option
                                                value="{{$user->id}}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{$user->name}}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                </select>
                                @error('user_id')
                                <span class="text-danger">The user name field is required.</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.transfer_from_account')</label>
                                <select class="form-control bank_append @error('from_account_id') is-invalid @enderror"
                                        name="from_account_id" id="bank_append">
                                    <option value="">---Select Bank Account---</option>
                                    @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                                        @foreach($accounts as $account)
                                            <option
                                                value="{{$account->id}}" {{ old('from_account_id') == $account->id ? 'selected' : '' }}>{{$account->name}}</option>
                                        @endforeach
                                    @else
                                        @foreach($user_accounts as $user_account)
                                            <option
                                                value="{{$user_account->id}}" {{ old('from_account_id') == $user_account->id ? 'selected' : '' }}>{{$user_account->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('from_account_id')
                                <span class="text-danger">The from account name field is required.</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.transfer_to_account')</label>
                                <select class="form-control bank_append @error('to_account_id') is-invalid @enderror"
                                        name="to_account_id" id="bank_append">
                                    <option value="">---Select Bank Account---</option>
                                @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                                        @foreach($accounts as $account)
                                            <option
                                                value="{{$account->id}}" {{ old('to_account_id') == $account->id ? 'selected' : '' }}>{{$account->name}}</option>
                                        @endforeach
                                    @else
                                        @foreach($user_accounts as $user_account)
                                            <option
                                                value="{{$user_account->id}}" {{ old('to_account_id') == $user_account->id ? 'selected' : '' }}>{{$user_account->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('to_account_id')
                                <span class="text-danger">The to account name field is required.</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.incomes_date')</label>
                                @php
                                    $date = now()->format('Y-m-d');
                                @endphp
                                <input class="form-control" type="date" name="date"
                                       value="{{old('date',Carbon\Carbon::today()->format('Y-m-d')),}}"
                                       placeholder="Enter Date">
                                <span style="color: red">{{$errors->first('date')}}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.transfer_amount')</label>
                                <input class="form-control @error('amount') is-invalid @enderror" type="number"
                                   min="1"    name="amount" value="{{old('amount')}}"
                                       placeholder="Enter Amount">
                                @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.incomes_remarks')</label>
                                <textarea class="form-control" name="remark"
                                          placeholder="Enter Remarks">{{old('amount')}}</textarea>

                                <span style="color: red">{{$errors->first('remark')}}</span>
                            </div>
                        </div>
                        <br>


                        <button type="submit" class="btn btn-primary">@lang('langs.save')</button>&nbsp;&nbsp;
                        <a href="{{route('transfer.index')}}" class="btn btn-secondary">@lang('langs.back')</a>
                        </form>
                    </div>


                </div>
            </div>


        </div>
    </main>



@endsection
@push('page_scripts')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[project_name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $('#users').on('change', function (e) {
                var cat_id = e.target.value;
                $.ajax({
                    url: "{{ route('get_user') }}",
                    type: "get",
                    data: {
                        cat_id: cat_id
                    },
                    success: function (response) {
                        console.log(response.data)

                        $('.bank_append').empty();
                        $.each(response.data, function (key, value) {

                            //    console.log(response)
                            $('.bank_append').append('<option value=' + value['id'] + '>' + value['name'] + '</option>');


                        });


                    }
                })
            });
        });
    </script>
@endpush
