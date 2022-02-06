@extends('layouts.app')
@push('styles')

@endpush
@section('content')


@if (Session::has('message'))
    <div id="success_message" class="alert alert-success" role="alert" style="text-align: center;">
      {{ Session::get('message') }}
    </div>
@endif

        <div class="sec-search-top" id="addcategories">
        </div>
        <div class="clearfix"></div>
        <div class="mr-top">

            <form id="add_category" action="{{ route('admin.update_category', $category->categoryid) }}" method="post">

            @csrf

            <input name="_method" type="hidden" value="PUT">

            <div class="page-wrapper pd25">

                <div class="col-lg-4">
                    <div class="form-group">
                        <h5>Edit Category Details</h5>
                        <label for="exampleInputPassword1">Category Name</label>
                        <input id="category_name" type="text" class="form-control form-right" value="{{ $category->categoryname }}" name="categoryname" placeholder="Enter category name here" required="" autofocus="" >
                        <label id="category_name-error" class="error" for="categoryname"></label>
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