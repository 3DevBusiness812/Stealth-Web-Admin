@extends('layouts.app')
@push('styles')

@endpush
@section('content')


@if (Session::has('message'))
    <div id="success_message" class="alert alert-success" role="alert" style="text-align: center;">
      {{ Session::get('message') }}
    </div>
@endif

<!-- <div class="col-md-12">
<video class="video_border" style="width: 100%;" controls="controls" preload="metadata"><source src="https://stealthgo.s3.us-west-2.amazonaws.com/temp_videos/1593603286404sample-mp4-file.mp4"></video>
</div> -->

<input type="hidden" id="video_path" value="{{ config('app.video_folder') }}">

<div class="modal modal-width fade modal-popup" id="DeleteVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Delete Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            <div class="modal-body pad-adjust">

                <form>

                    <div class="form-group">

                        <div class="row ml-0 mr-0">
                        
                            <div class="col-md-12 pl-0 pr-0">

                                <p>Are you sure you want to delete this video?</p>

                            </div>
                        
                        </div>

                    </div>

                </form>

            </div>

            <div class="modal-footer text-center">
                
                <button id="confirm_delete" video_id="" class="btn btn-primary" type="button">YES</button>

            </div>
        </div>
    </div>
</div>


<div class="modal modal-width fade modal-popup" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="video_title">Push Ups</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body pad-adjust h100">
                <div class="push-img-container" id="play_videos">
                    <!-- <img src="images/push_up_image.png"/> -->
                </div>    
            </div>
            
        </div>
    </div>
</div>

<div class="modal modal-width fade modal-popup" id="AddCategoreis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>

            <div class="modal-body pad-adjust">
                <form>

                    <div class="form-group" id="category_contents">

                    </div>

                </form>

            </div>

            <div class="modal-footer text-center">
                
                <button class="btn btn-primary" type="button" data-dismiss="modal">OK</button>

            </div>

        </div>

    </div>

</div>


<input type="hidden" id="category_search" value="@if($category_select != '') {{ $category_select->categoryid }} @endif ">
<div class="sec-search-top" id="allvideos">
    <form>
        <div class="form-row">
            <div class="dropdown sample">
                <button type="button" class="btn btn-select-menu btn-primary dropdown-toggle" data-toggle="dropdown">
                    
                    @if($category_select)

                        {{ $category_select->categoryname }}

                    @else

                        Category

                    @endif


                </button>
                <div class="dropdown-menu select-dropdown custom_category_dropdown">

                    <a class="dropdown-item" href="{{ route('admin.list_videos') }}">All</a>
                    @foreach($categories as $category)
                        <a title="{{$category->categoryname}}" class="dropdown-item" href="{{ route('admin.list_videos').'/'.$category->categoryid }}">

                            @if((strlen($category->categoryname)) > 20)

                              
                              <?php

                                $cut_string = substr($category->categoryname,0, 19).'...';

                              ?>

                              {{$cut_string}}

                            @else

                              {{$category->categoryname}}

                            @endif

                        </a>

                    @endforeach

                </div>
            </div>
            <a href="{{ route('admin.create_video') }}" class="btn-green">ADD VIDEO</a>

            

        </div>
    </form>
</div>
    
<div class="clearfix"></div>

<div class="completed_response_box shw_message_box completedResponse"></div>

<div class="page-wrapper ste-page-wrapper">
    
    <div class="table-responsive">
        
                <table class="table table-hover" id="allVideosList" style="width:100%">
                    <thead>
                        <tr>                            
                            <th>VIDEOS </th>
                            <th>TITLE </th>
                            <th>CATEGORIES </th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                </table>

    </div>
    <input type="hidden" id="s3_video_folder" value="{{ Config::get('app.s3_video_folder') }}">
    <input type="hidden" id="video_count" value="{{$video_count}}">
</div>

@endsection
@push('scripts')
 <script src="{{ asset('admin/js/videos.js') }}"></script>
@endpush