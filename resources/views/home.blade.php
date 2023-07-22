@extends('Admin.layouts.app')

@section('content')

    @include('Admin.flash-message')
    <main class="app-content">
        @php
            $user =  \Illuminate\Support\Facades\Auth::user();
        @endphp
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> @lang('langs.dashboard')</h1>
                <p>@lang('langs.welcome') {{\Illuminate\Support\Facades\Auth::user()->name}}</p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">@lang('langs.dashboard')</a></li>
            </ul>
        </div>
        <div class="row">
            @if($user->role == config('constants.ROLE.ADMIN'))
                <div class="col-md-6 col-lg-3">
                    <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                        <div class="info">
                            <h4><a href="{{route('user.index')}}" class="text-dark">@lang('langs.users')</a></h4>
                            <p><b>{{$users}}</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
                        <div class="info">
                            <h4><a href="{{route('categories.index')}}" class="text-dark">@lang('langs.categories')</h4>
                            <p><b>{{$categories}}</b></p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
                    <div class="info">
                        <h4><a href="{{route('account.index')}}" class="text-dark">@lang('langs.total_account')</a></h4>
                        <p><b>{{$accounts}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
                    <div class="info">
                        <h4><a href="#" class="text-dark">@lang('langs.balance')</a></h4>
                        <p><b>{{get_rupee_currency($amounts)}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4><a href="{{route('incomes.index')}}" class="text-dark">@lang('langs.incomes_amount')</a>
                        </h4>
                        <p><b style="color: green">{{get_rupee_currency($incomes_amounts)}}</b></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4><a href="{{route('expenses.index')}}" class="text-dark">@lang('langs.expenses_amount')</a>
                        </h4>
                        <p><b style="color: red">-{{get_rupee_currency($expenses_amounts)}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4><a href="{{route('transfer.index')}}" class="text-dark">@lang('langs.transfer_amount')</a>
                        </h4>
                        <p><b style="color: darkred">{{get_rupee_currency($transfer_amounts)}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4><a href="#" class="text-dark">@lang('langs.available_balance')</a></h4>
                        <p><b style="color: green">{{get_rupee_currency($total_amount)}}</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <div class="row">
                        <h3 class="tile-title">@lang('langs.cate_income')</h3>&emsp; &emsp;
                        <span class="mt-1"></span>
                    </div>
                    @if($income_categories_data == null)
                        <div class="row">
                            <div class="col-sm-12">
                                <div style="font-size: 40px; opacity: 0.5;">
                                    <center>
                                        <i class="fa fa-exclamation-circle fa-5x"></i>
                                        <br>
                                        No data yet<br>
                                    </center>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="embed-responsive embed-responsive-16by9">
                            <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="tile">
                    <div class="row">
                        <h3 class="tile-title">@lang('langs.cate_expenses')</h3>&emsp; &emsp;
                        <span class="mt-1"></span>
                    </div>
                    @if($expenses_categories_data == null)
                        <div class="row">
                            <div class="col-sm-12">
                                <div style="font-size: 40px; opacity: 0.5;">
                                    <center>
                                        <i class="fa fa-exclamation-circle fa-5x"></i>
                                        <br>
                                        No data yet<br>
                                    </center>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="embed-responsive embed-responsive-16by9">
                            <canvas class="embed-responsive-item" id="pieChartDemo1"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
@push('page_scripts')

    <script type="text/javascript">
        var idata = <?php echo json_encode($income_categories_data); ?>;


        var ctxp = $("#pieChartDemo").get(0).getContext("2d");
        var pieChart = new Chart(ctxp).Pie(idata);


        //Expenses Category Graph
        var edata = <?php echo json_encode($expenses_categories_data); ?>;

        var ctxp = $("#pieChartDemo1").get(0).getContext("2d");
        var pieChart = new Chart(ctxp).Pie(edata);

    </script>

@endpush
