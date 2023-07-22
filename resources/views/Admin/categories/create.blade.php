@extends('Admin.layouts.app')
@section('content')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>@lang('langs.categories_add')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title"></h3>
                    <div class="tile-body">
                        <form action="{{route('categories.store')}}" method="POST" enctype="multipart/form-data"
                              id="upload_pdf">
                        @csrf
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.categories_name')</label>

                                <input name="name" type="text" value="{{old('name')}}"
                                       class="form-control @error('name') is-invalid @enderror" id="oldPasswordInput"
                                       placeholder="Enter Category Name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">@lang('langs.categories_icon')</label>

                                <select class="form-control @error('icon') is-invalid @enderror" name="icon">
                                    <option value="">---Select Icon---</option>
                                    @foreach(config('constants.CATEGORY') as $key => $values)
                                        <option
                                            value="{{$values}}" {{ old('icon') == $values ? 'selected' : '' }}>{{$key}}</option>
                                    @endforeach
                                </select>
                                @error('icon')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>


                        <button type="submit" class="btn btn-primary">@lang('langs.save')</button>&nbsp;&nbsp;
                        <a href="{{route('categories.index')}}" class="btn btn-secondary">@lang('langs.back')</a>
                        </form>
                    </div>


                </div>
            </div>


        </div>
    </main>



@endsection
