@extends('layouts.app')
@push('styles')

@endpush
@section('content')


@if (Session::has('message'))
    <div id="success_message" class="alert alert-success" role="alert" style="text-align: center;">
      {{ Session::get('message') }}
    </div>
@endif





    <div class="sec-search-top" id="editvideos"></div>

    <div class="clearfix"></div>
    <div class="container-fluid mr-top">

      <div class="completed_response_box shw_message_box completedResponse"></div>

      <div class="page-wrapper">
        <div class="row user-content">
          <div class="col-lg-4 col-xl-4">
                  <div class="long-video-wra user-content-left">
                    <!-- <img src="images/edit_video_img.png"> -->

                    <video class="video_border" style="width: 100%;" controls="controls" preload="metadata">
                      <source src="{{ config('app.s3_video_folder').$video->videourl }}">
                    </video>

                  </div>
          </div>
          <div class="col-lg-4 col-xl-4">
            <div class="user-content-left">

              <ul>
                <!--<li>                
                </li> -->
                <li>
                  <div class="add-video-details">
                    <h2>Edit Video Details</h2>

                    <label for="FieldTitle">Title</label>
                    <input type="text" class="form-control form-right" value="{{ $video->title }}" name="FieldTitle" required="" autofocus="" id="title" />
                    <label style="display: none;" id="title_error_msg" class="error">Enter Video Title.</label>
                    <input type="hidden" id="video_id" value="{{ $video->videoid }}">


          
                  </div>
                </li>
              </ul>
                   
            </div> 
          </div>
                              
          <div class="col-lg-4 col-xl-4">
            <div class="editvideo-btns-wrap">
               
              <button id="show_categories" type="button" class="btn green-btn" data-toggle="modal" data-target="#AddCategoreis">EDIT CATEGORIES</button>
              <label style="display: none;" id="category_error_msg" class="error pull-right">Select at least one category.</label>

            </div>
          
          </div>
               
        </div>
            
      </div>
        
        
      <button type="button" class="btn float-right btn-green-bottom" id="save_video">SAVE</button>
      <a type="button" class="btn float-right btn-grey-bottom" href="{{ route('admin.list_videos') }}">CANCEL</a>
                                
    </div>




    <div class="modal modal-width fade modal-popup" id="AddCategoreis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">Edit Categories</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body pad-adjust">
              <form id="categories">
                <div class="form-group">

                  <?php

                    $row_bit = 1;

                  ?>
                    @foreach($categoyies as $category)


                      @if($row_bit==1)
                        <div class='row ml-0 mr-0'>
                      @endif

                      @if((isset($category->videoid)) && ($category->videoid != ''))

                        <?php
                          
                          $checked = "checked='checked'";

                        ?>

                      @else

                        <?php
                          
                          $checked = "";

                        ?>

                      @endif

                        <div class='col-sm-4 col-md-4 pl-0 pr-0'>
                          <div style="max-width: unset;" title="{{$category->categoryname}}" class='tag-container fright-div clearfix'>
                            <div class='pretty p-svg p-round'>
                              <input class='category_check' type='checkbox' value='{{$category->categoryid}}' name="category[]" {{$checked}}>
                                <div class='state p-success'>
                                  <svg class='svg svg-icon' viewBox='0 0 20 20'>
                                    <path d='M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z' style='stroke: white;fill:white;'></path>
                                  </svg>
                                  <label>

                                    @if((strlen($category->categoryname)) > 15)

                                      
                                      <?php

                                        $cut_string = substr($category->categoryname,0, 14).'..';

                                      ?>

                                      {{$cut_string}}

                                    @else

                                      {{$category->categoryname}}

                                    @endif

                                  
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>

                      @if($row_bit == 6)
                          </div>
                          <?php
                            $row_bit = 0;
                          ?>
                      @endif

                      <?php

                        $row_bit = $row_bit+1;

                      ?>




                    @endforeach

                    @if($row_bit<1)
                      </div>
                    @endif

                </div>
              </form>
          </div>
          <div class="modal-footer text-center">
              
              <button class="btn btn-primary" type="button" data-dismiss="modal">SAVE</button>

          </div>
        </div>
      </div>
    </div>




@endsection
@push('scripts')

 <script src="{{ asset('admin/js/edit_video.js') }}"></script>

@endpush