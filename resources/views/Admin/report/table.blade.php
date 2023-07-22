<main class="app-content">
    <div class="app-title">

        <div>
            <h1><i class="fa fa-th-list"></i> @lang('langs.report')</h1>
        </div>

    </div>
    <style>
        .col-4 {
            flex: 0 0 15%;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <form method="GET" action="{{route('report.index')}}" class="form-inline">
                    <div class="row">
                        <div class="col-1 mt-4 ml-2">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar filter"></i>&nbsp;
                            <span id="dates"></span> <b class="caret"></b>
                        </div>
                        <div class="form-group col-4">
                            <div>
                                <input id="reportrange" name="date"
                                       @if(request('date') != 'null') value="{{request('date')}}"
                                       @endif class="pull-left form-control daterange"
                                       style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;" placeholder="Select Date">
                            </div>
                        </div>
                    </div>
                    <div class="ml-2">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                            <select class="form-control " name="user_id" id="users" required>
                                <option value="">---Select User---</option>
                                @foreach($users as $user)
                                    <option
                                        value="{{$user->id}}" {{ request()->user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="ml-3">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                            <select class="form-control" name="bank_id" id="bank_append"
                                    style="background: #fff; cursor: pointer; padding: 0px 1px; border: 1px solid #ccc;">
                                <option value="">---Select Bank---</option>
                                @foreach( $banks as $bank)
                                    <option
                                        value="{{$bank->id}}" {{ request()->bank_id == $bank->id ? 'selected' : '' }}>{{$bank->name}}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control" name="bank_id" id="bank_append"
                                    style="background: #fff; cursor: pointer; padding: 0px 1px; border: 1px solid #ccc;" required>
                                <option value="">---Select Bank---</option>
                                @foreach( $accounts as $account)
                                    <option
                                        value="{{$account->id}}" {{ request()->bank_id == $account->id ? 'selected' : '' }}>{{$account->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <button href="#" class="btn btn-primary ml-3" id="filter">@lang('langs.filter')</button>
                    <a href="{{route('report.index')}}" class="btn btn-dark ml-3">@lang('langs.reset')</a>
                    <div class="ml-3">
                        <button type="button" class="btn btn-danger"
                                onclick="pdfreport()">@lang('langs.pdf_file')</button>&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary"
                                onclick="ExportToExcel('xlsx')">@lang('langs.excel_file')</button>

                    </div>
                </form>

                <div class="tile-body" id="my_report">
                    @if(isset($reports))
                        <table class="table table-hover" id="sampleTable">
                            <thead>
                            <tr>

                                <th>@lang('langs.user_name') </th>
                                <th>@lang('langs.accout_name') </th>
                                <th>@lang('langs.incomes_date') </th>
                                <th>@lang('langs.amount') </th>
                                <th>@lang('langs.incomes_amount') </th>
                                <th>@lang('langs.expenses_amount') </th>
                                <th>@lang('langs.transfer_amount') </th>
                                <th>@lang('langs.balance') </th>
                                <th>@lang('langs.incomes_remarks') </th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $balance=$user_account->amount;
                                $Amount=0;
                                $total=0;
                            @endphp
                            @php
                                $balance = $user_account->amount;
                            @endphp

                            @foreach ($reports as $report)

                                @foreach($report as $repo)
                                    <tr>

                                        <td>{{ $user_account->users->name }}</td>
                                        <td>{{ $user_account->name }}</td>
                                        <td>{{ date_formate($repo->date) }}</td>

                                        <td style="color: green">{{ get_rupee_currency($balance)}}</td>

                                        <td style="color: green">@if($repo->type == 'incomes'){{ get_rupee_currency($repo->amount) }}@endif</td>
                                        <td style="color: red">@if($repo->type == 'expenses'){{ get_rupee_currency($repo->amount) }}@endif</td>
                                        <td>
                                            @if($repo->type == 'transfer')
                                                @if($repo->from_account_id == request()->bank_id)
                                                    <span
                                                        style="color: darkred">{{ get_rupee_currency($repo->amount) }}</span>
                                                    <br> <span style="color: green">{{ get_rupee_currency(0) }}</span>
                                                @else
                                                    <span style="color: darkred">{{ get_rupee_currency(0) }}</span><br>
                                                    <span
                                                        style="color: green">@if($repo->to_account_id == request()->bank_id){{ get_rupee_currency($repo->amount) }} @endif</span>
                                                @endif<br>


                                            @endif

                                        </td>
                                        <td style="color: green">
                                            @php
                                                if($repo->type == 'incomes'){
                                                $balance=$balance+$repo->amount;
                                                }
                                            if($repo->type == 'expenses'){
                                                $balance=$balance-$repo->amount;
                                                }
                                            if($repo->type == 'transfer'){
                                                if($repo->from_account_id == request()->bank_id){
                                                $balance=$balance-$repo->amount;

                                                }
                                                if($repo->to_account_id == request()->bank_id){
                                                $balance= $balance+$repo->amount;
                                                }

                                                }
                                                $total = $total+$balance;

                                            @endphp

                                            {{get_rupee_currency($balance)}}
                                        </td>
                                        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
                                            <td>@if(isset($repo->remark)){{ translateToGujarati($repo->remark) }} @endif</td>
                                        @else
                                            <td>{{ $repo->remark }}</td>
                                        @endif

                                    </tr>

                                @endforeach
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>

                                <th></th>

                                <th></th>

                                <th></th>

                                <th></th>

                                <th style="color: red;">@lang('langs.income_balance'):</th>

                                <th style="color: red">@lang('langs.expenses_balance'):</th>

                                <th style="color: red">@lang('langs.transfer_balance'):</th>

                                <th style="color: red">@lang('langs.available_balance'):</th>
                                <th></th>

                            </tr>
                            <tr>

                                <td></td>

                                <td></td>

                                <td></td>

                                <td></td>

                                <td style="color: green">{{get_rupee_currency($user_account->Total)}}</td>

                                <td style="color: red">{{get_rupee_currency($user_account->ExpensesAmount)}}</td>

                                <td>
                                    <span
                                        style="color: darkred">{{get_rupee_currency($user_account->FromTransfer)}}</span><br>
                                    <span style="color: green"> {{get_rupee_currency($user_account->ToTransfer)}}</span>

                                </td>

                                <td style="color: green">{{get_rupee_currency($balance)}}</td>
                                <td></td>

                            </tr>
                            </tfoot>
                        </table>
                    @else
                        <table class="table table-hover table-responsive" id="sampleTable">
                            <thead>
                            <tr>
                                <th>@lang('langs.user_name') </th>
                                <th>@lang('langs.accout_name') </th>
                                <th>@lang('langs.incomes_date') </th>
                                <th>@lang('langs.amount') </th>
                                <th>@lang('langs.incomes_amount') </th>
                                <th>@lang('langs.expenses_amount') </th>
                                <th>@lang('langs.transfer_amount') </th>
                                <th>@lang('langs.balance') </th>
                                <th>@lang('langs.incomes_remarks') </th>

                            </tr>
                            </thead>
                        </table>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@push('page_scripts')


    <script type="text/javascript">
        $(function () {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('.daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('.daterange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>


    @php
        $user = request()->user_id;
        if (isset($user)){
        $user_report = \App\Models\User::findOrfail($user);
        }
    @endphp

    <script>

        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('my_report')
            var wb = XLSX.utils.table_to_book(elt, {sheet: "sheet1"});
            return dl ?
                XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
                @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                XLSX.writeFile(wb, fn || ('<?php if (isset($user_report)) {
                    echo $user_report->name;
                } ?>_Reports.' + (type || 'xlsx')));
            @else
            XLSX.writeFile(wb, fn || ('<?php if (isset(Auth::user()->name)) {
                echo Auth::user()->name;
            } ?>_Reports.' + (type || 'xlsx')));
            @endif
        }

        function pdfreport() {

            html2canvas($('#my_report')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    @if(\Illuminate\Support\Facades\Auth::user()->role == config('constants.ROLE.ADMIN'))
                    pdfMake.createPdf(docDefinition).download('<?php if (isset($user_report)) {
                        echo $user_report->name;
                    } ?>_Reports.pdf');
                    @else
                    pdfMake.createPdf(docDefinition).download('<?php if (isset(Auth::user()->name)) {
                        echo Auth::user()->name;
                    } ?>_Reports.pdf');
                    @endif
                }
            });

        }

    </script>


    <script type="text/javascript">
        $('#users').trigger('change');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

                        $('#bank_append').empty();
                        $.each(response.data, function (key, value) {

                            //    console.log(response)
                            $('#bank_append').append('<option value=' + value['id'] + '>' + value['name'] + '</option>');


                        });


                    }
                })
            });
        });
    </script>
@endpush
