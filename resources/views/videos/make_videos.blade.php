@extends('layouts.app')
@push('styles')

@endpush
@section('content')


@if (Session::has('message'))
    <div id="success_message" class="alert alert-success" role="alert" style="text-align: center;">
      {{ Session::get('message') }}
    </div>
@endif



<div id="alert_modal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog confirmation_modal" role="document">
    <div class="modal-content">
      <div class="modal-header bg-green">
        <img src="{{ asset('images/logo_inner.png')}}" alt="INFORCE911" width="40%;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text_white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="warning_text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-green btn-sm text_white" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>


    <div class="sec-search-top" id="createvideos"></div>

    <div class="clearfix"></div>
    <div class="container-fluid mr-top">


      <div class="completed_response_box shw_message_box completedResponse"></div>

      <input type="hidden" id="categorys" value="{{ $categories }}">


      <div class="page-wrapper">
        <div class="row user-content">
            
            <div class="col-lg-7 col-xl-7">
                <div class="user-content-left">
                  <div style="text-align: center;">
                    <label style="display: none;" for="file-3" class="error" id="error_empty_video">Add at least one video</label>
                  </div>
                    <form enctype="multipart/form-data" id="video_upload">

                        <ul>
                            <li>
                          <div class="file-upload-wrap">
                            <input type="file" name="file_upload" id="file-3" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" accept="video/*" />
                            <label for="file-3">
                              <figure>

                              <img src="{{ asset('images/file_upload_icn.png')}}">
                              </figure>
                              <div>ADD VIDEO</div>
                              <span></span>
                            </label>

                            <!--<button type="button" class="btn add-video-btn">ADD VIDEO</button>-->
                          </div>
                            <div class="validation text-center">
                              <label id="video_upload_validation" class="add_video_validation error dnone" style="display: none;">Select a video</label>
                            </div>
                            </li>
                            <li>
                          <div class="add-video-details">
                            <h2>Add Video Details</h2>
                            <label for="FieldTitle">Title</label>
                            <input type="text" class="form-control form-right" value="" id="title" name="FieldTitle" placeholder="Enter Video Title" required="" autofocus="" />
                            <label style="display: none;" class="error" id="error_empty_title">Enter Video Title.</label>
                          </div>
                            </li>
                        </ul>

                        <input type="hidden" id="uploaded_file_name">
                        <input type="hidden" id="source_file_name">

                    </form>
                 
                 </div> 
            </div>
             
            <div class="col-lg-5 col-xl-5">
              <div class="row">
                <div class="video-btns-wrap">
                  <button type="button" class="btn green-btn" id="add_category">SELECT CATEGORIES</button>
                  <button id="add_more_videos" type="button" class="btn green-btn">ADD MORE VIDEOS</button>
                </div>
              </div>
              <div class="row">
                  <label style="display: none;" class="error" id="error_empty_category">Select at least one category.</label>
              </div>
            </div>
             
        </div>
        <hr class="content-block">
        <div class="clearfix"></div>
        <div class="row user-content">
          
          <div id="file_list" style="width:100%">

          </div>

          <div id="new_file_selected" style="width:100%">
            
          </div>

        </div>
      </div>
  
      <button  type="button" class="btn float-right btn-green-bottom" id="upload">UPLOAD</button>
    
      <a type="button" class="btn float-right btn-grey-bottom" href="{{ route('admin.list_videos') }}">CANCEL</a>
       
      <div class="modal modal-width fade modal-popup" id="AddCategoreis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel1">Select Categories</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body pad-adjust">
              <form>
                <div class="form-group" id="category_contents">
                </div>
              </form>
            </div>
            <div class="modal-footer text-center">
                  
              <button class="btn btn-primary" type="button" data-dismiss="modal">DONE</button>

            </div>
          </div>
        </div>
      </div>

    </div>

@endsection
@push('scripts')

<script src="{{ asset('admin/js/create_video.js?20-07-2020') }}"></script>


 <!-- <script src=" asset('admin/js/videos.js') }}"></script> -->

@endpush