@extends('Admin.layouts.app')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-calendar"></i> Calendar</h1>
                <p>Full Calendar page for managing events</p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Calendar</a></li>
            </ul>
        </div>
        <style>
            .pointer {
                cursor: not-allowed;
            }
        </style>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="get">
                    <div class="row">
                        @if(request()->birth_year || request()->current_year || request()->year)
                            <div class="col-lg-2">
                                <label><b>Birth Year</b></label>
                                <input type="number"
                                       class="form-control datepicker @error('birth_year') is-invalid @enderror"
                                       name="birth_year"
                                       value="{{old('birth_year', request()->birth_year)}}"
                                       id="datepicker"/>
                                @error('birth_year')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-2">
                                <label><b>Current Year</b></label>
                                <input type="number"
                                       class="form-control datepicker @error('current_year') is-invalid @enderror"
                                       name="current_year"
                                       value="{{old('current_year', request()->current_year)}}"
                                       id="datepicker"/>
                                @error('current_year')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="col-lg-2">
                                <label class="text-danger"><b>Age</b></label>
                                <input type="number"
                                       class="form-control"
                                       name="year"
                                       value="{{$age}}"
                                       id="datepicker" readonly></div>
                        @else
                            <div class="col-lg-2">
                                <label><b>Birth Year</b></label>
                                <input type="number" maxlength="4"
                                       class="form-control datepicker @error('birth_year') is-invalid @enderror"
                                       name="birth_year"
                                       value="{{old('birth_year',date('Y'))}}"
                                       id="datepicker"/></div>
                            @error('birth_year')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="col-lg-2">
                                <label><b>Current Year</b></label>
                                <input type="number"
                                       class="form-control datepicker @error('current_year') is-invalid @enderror"
                                       name="current_year"
                                       value="{{old('current_year',date('Y'))}}"
                                       id="datepicker"/></div>
                            @error('current_year')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="col-lg-2">
                                <label class="text-danger pointer"><b>Age</b></label>
                                <input type="number" maxlength="4"
                                       class="form-control"
                                       name="year"
                                       value="{{0}}"
                                       id="datepicker" readonly></div>
                        @endif
                        <div class="col-lg-6">
                            <br>
                            <button type="submit" class="btn btn-info">Year
                            </button>
                            <a class="btn btn-danger"
                               href="{{route('calendar')}}">Reset</a>
                        </div>
                    </div>
                </form>
                <br>
                <div class="tile row">
                    <div class="col-md-12">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('page_scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css"
          rel="stylesheet">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        $(".datepicker").datepicker({
            format: "yyyy",
            startView: "years",
            minViewMode: "years"
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#external-events .fc-event').each(function () {

                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true,      // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function() {
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                }
            });


        });
    </script>
@endpush
