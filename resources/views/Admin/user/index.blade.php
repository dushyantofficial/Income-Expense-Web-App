@extends('Admin.layouts.app')
@section('content')
    <div class="content px-3">

        <div class="clearfix"></div>
        @include('Admin.flash-message')
        @include('Admin.user.table')

    </div>


@endsection


