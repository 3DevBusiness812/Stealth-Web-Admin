@extends('layouts.app')
@push('styles')

@endpush
@section('content')


@if (Session::has('message'))
    <div id="success_message" class="alert alert-success" role="alert" style="text-align: center;">
      {{ Session::get('message') }}
    </div>
@endif

<div class="sec-search-top" id="allcategories">
    <form>
        <div class="form-row">
            

           
            <a class="btn-green" href="{{ url('admin/create_category') }}">ADD CATEGORY</a>

        </div>
    </form>
</div>
    
<div class="clearfix"></div>


<div class="page-wrapper ste-page-wrapper">
    
    <div class="table-responsive table-shadow">
        
        <table class="table categorystyle" id="allCategoryList" style="width:100%">
            
            <thead>

                <tr>
                   
                    <th>CATEGORY NAME</th>
                    

                    <th></th>

                    <th></th>


                </tr>

            </thead>

        </table>

    </div>

</div>

<input type="hidden" id="category_count" value="{{$category_count}}">

@endsection
@push('scripts')
 <script src="{{ asset('admin/js/category.js') }}"></script>
@endpush