<style>
    .dataTables_paginate paging_simple_numbers {
        display: none;
    }

    .page1 {
        margin-bottom: 30px;
    }

    .pagination {
        float: right;
        /*margin-bottom: 32px;*/
    }
</style>

<main class="app-content">
    <div class="app-title">

        <div>
            <h1><i class="fa fa-th-list"></i> @lang('langs.users')</h1>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 float-right mb-5">
            <span class="pull-right float-right">&nbsp;&nbsp;
 <a class="btn btn-primary" href="{{ route('user.create') }}" style="float: right">
                + @lang('langs.add')
            </a>

                <!-- Modal -->
        </div>
        <div class="col-md-12">
            <div class="tile">
                <div class="box-tools">
                    <form method="GET" action="">
                        <div class="input-group input-group-sm float-right" style="width: 200px;">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control pull-right" placeholder="Searching ...">
                            <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default btn-flat"><span
                                                    class="fa fa-search" style="margin-bottom: 10px;"></span>
                                            </button>
                            <a href="{{route('user.index')}}" class="btn btn-default btn-flat"><span
                                    class="fa fa-refresh" style="margin-bottom: 10px;"></span>
                                            </a>
                                        </span>
                        </div>
                    </form>
                </div>
                <br><br>
                <div class="tile-body sortableTable__container" id="my_report">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead class="sortableTable">
                        <tr class="sortableTable__header">
                            <th class="value" data-col="no">@lang('langs.user_no') </th>
                            <th class="value" data-col="name">@lang('langs.user_name') </th>
                            <th class="value" data-col="mobile">@lang('langs.user_mobile') </th>
                            <th class="value" data-col="email">@lang('langs.user_email') </th>
                            <th class="value" data-col="status">@lang('langs.user_status') </th>
                            <th class="value" data-col="action">@lang('langs.user_action') </th>

                        </tr>
                        </thead>
                        <tbody class="sortableTable__body">
                        @foreach ($users as $user)
                            <tr>

                                    <td data-col="no">{{ $loop->iteration }}</td>
                                    <td data-col="name">{{ $user->name }}</td>
                                    <td data-col="mobile">{{$user->mobile}}</td>
                                    <td data-col="email">{{$user->email}}</td>
                                <td data-col="status">
                                    <input data-id="{{$user->id}}" class="toggle-class statuss" type="checkbox"
                                           onclick="on();"
                                           data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                           data-on="Active"
                                           data-off="Block" {{ $user->status=='active' ? 'checked' : '' }}>
                                </td>
                                <td data-col="action">
                                    {!! Form::open(['route' => ['user.destroy', $user->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a href="{{ route('user.edit', [$user->id]) }}" class='btn btn-info btn-xs'>
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                        <a href="{{ route('user.show', [$user->id]) }}" class='btn btn-info btn-xs'>
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
{{--                                        <a href="{{route('login')}}" class='btn btn-info btn-xs'>--}}
{{--                                            User Login--}}
{{--                                        </a>--}}
                                    </div>
                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="page1">
                        {!! $users->appends(request()->all())->render('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('page_scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        ////////////////
        // ONREADY SETUP
        ////////////////

        $(function () {
            $(".sortableTable__header > th").dblclick(function (event) {
                dehydrateColumn(event);
            });

            $(".sortableTable__header")
                .sortable({
                    placeholder: "placeholder",
                    items: "> .value",
                    helper: "clone",
                    revert: 150,
                    axis: "x",
                    start: function (event, ui) {
                        ui.placeholder.width(ui.item.width());
                    },
                    stop: function (event, ui) {
                        sortcells(ui.item);
                    }
                })
                .disableSelection();
        });

        ////////////////
        // COLUMN HIDING
        ////////////////

        function dehydrateColumn(event) {
            // Store column data in a button and remove column from the sortable table.
            var tar = $(event.target);
            var colData = tar.data("col");

            if (!colData) {
                return;
            }

            var matchingCells = orderedValuesOfCol(colData);
            var store = {
                header: colData,
                values: matchingCells.map(function (elem) {
                    return elem.clone(true);
                })
            };
            var btn = $("<button>")
                .text(title(colData))
                .data("column", store)
                .appendTo($(".sortableTable__discard"))
                .click(function (event) {
                    hydrateColumn(event);
                });

            tar.remove();
            $(matchingCells).each(function (idx, elem) {
                elem.remove();
            });
        }

        function hydrateColumn(event) {
            var dat = $(event.target).data();
            var values = dat.column.values;
            var head = dat.column.header;
            var th = $("<th>")
                .text(title(head))
                .attr("data-col", head)
                .addClass("value")
                .addClass("ui-sortable-handle")
                .dblclick(function (event) {
                    dehydrateColumn(event);
                });
            $(".sortableTable__header").append(th);
            event.target.remove();

            tableRows().each(function (idx) {
                $(this).append(values[idx]);
            });
        }

        function orderedValuesOfCol(colName) {
            // Return all td elements matching a given th element.
            var ret = [];
            tableRows().each(function (idx, row) {
                var cellValue = getMatchingCell($(this), colName);
                ret.push(cellValue);
            });
            return ret;
        }

        /////////////////
        // COLUMN SORTING
        /////////////////

        function sortcells(item) {
            // Move tds matching associated sorted th to the same index as the th.
            var newIndex = $(".sortableTable__header").children().index(item);
            var column = item.data("col");

            tableRows().each(function (idx, row) {
                var matchingDataCol = getMatchingCell($(this), column);
                moveTo($(this), newIndex, $(matchingDataCol));
            });
        }

        function getMatchingCell(container, columnData) {
            // Retrieve elment from a collection matching certain data attribute.
            var ret = container
                .children()
                .filter(function () {
                    return $(this).data("col") === columnData;
                })
                .first();
            return ret;
        }

        function moveTo(container, index, element) {
            // Move an element to a certin index within a container.
            // Element is first removed from children(), then then inserted.
            // The length of children() may change in between.
            var movingLeft = index < element.index();
            elementAtGivenIndex = container.children().eq(index);
            if (movingLeft) {
                elementAtGivenIndex.before(element);
            } else {
                elementAtGivenIndex.after(element);
            }
        }

        //////////////
        // UTILITY FNS
        //////////////

        function tableRows() {
            // Return all tr elements of the sortable table.
            return $(".sortableTable__body > tr");
        }

        function title(str) {
            // Capitalize first letter of a string.
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

    </script>
    <script>

        $(function () {
            $("#sampleTable").DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": true,
                "searching": false,
                "scrollX": false,
                "bPaginate": false,
                //  "paging": true,
                "buttons": ["copy", "csv", "excel", "pdf",]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        $('.statuss').change(function () {
            var status = $(this).prop('checked') == true ? 'active' : 'Block';
            var user_id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('userStatus') }}',
                data: {'status': status, 'user_id': user_id},
                success: function (data) {
                    //alert(data.success)
                    console.log(data.success)
                }
            });
        })
    </script>


@endpush
