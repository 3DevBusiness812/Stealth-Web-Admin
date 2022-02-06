@extends('layouts.app')
@push('styles')

@endpush
@section('content')


@if (Session::has('message'))
    <div id="success_message" class="alert alert-success" role="alert" style="text-align: center;">
      {{ Session::get('message') }}
    </div>
@endif



@if (Session::has('error_message'))
    <input type="hidden" id="error_message" value="{{ Session::get('error_message') }}">
@endif

        <div class="sec-search-top" id="addcategories">
        </div>
        <div class="clearfix"></div>
        <div class="mr-top">

            <form id="add_category" action="{{ route('admin.store_category') }}" method="post">

            @csrf

            <div class="page-wrapper pd25">

                <div class="col-lg-4">
                    <div class="form-group">
                        <h5>Add Category Details</h5>
                        <label for="exampleInputPassword1">Category Name</label>
                        <input type="text" class="form-control form-right" value="{{ old('categoryname') }}" name="categoryname" placeholder="Enter category name here" id="category_name" maxlength="50" required="" autofocus="">

                        <label id="category_name-error" class="error" for="category_name"></label>

                    </div>


                </div>
            </div>
            <button type="submit" class="btn float-right btn-green-bottom">SAVE</button>

            <a type="button" class="btn float-right btn-grey-bottom" href="{{ route('admin.list_category') }}">CANCEL</a>

            </form>

        </div>

@endsection
@push('scripts')
 <script src="{{ asset('admin/js/validation/jquery.validate.min.js') }}"></script>
 <script src="{{ asset('admin/js/category.js') }}"></script>
@endpush