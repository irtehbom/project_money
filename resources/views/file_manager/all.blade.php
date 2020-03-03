@extends('layouts.app')
@section('content')

<script src="{{ asset('js/dropzone.js') }}"></script>
<script>



$(document).ready(function () {

    $(".identifyingClass").click(function () {
        
        var image_id = $(this).data('id');
        var image_url = $(this).data('image');
        var filename = $(this).data('filename');
        var filetype = $(this).data('filetype');
        var url = $(this).data('url');
        var alt = $(this).data('alt');
        var updated = $(this).data('modified');
        var created = $(this).data('created');

        $('#image-left').css('background-image', 'url("' + image_url + '")');
        $('#filename').text(filename);
        $('#filetype').text(filetype);
        $('#url').text(url);
        $('#altTag').val(alt);
        $('#modified').text(updated);
        $('#created').text(created);
        
        $('#image_id').val(image_id);
        $('#file_name').val(filename);


        $("#save_button").click(function () {

            var altTag = $('#altTag').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ url('/file_manager/update') }}",
                dataType: 'json',
                data: {image_id: image_id, altTag: altTag},
                success: function (data) {



                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });

});
</script>   
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            All Files <small>Manage files</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Manage Files
            </li>
        </ol>
    </div>
</div>

@foreach ($all as $media)

<div class="gallery">
    <a href="#" data-target="#my_modal" data-toggle="modal" class="identifyingClass" 
       data-id="{{$media->id}}" 
       data-image="{{ url('/') }}{{$media->path}}" 
       data-filename="{{$media->originalName}}"
       data-filetype="{{$media->mimeType}}"
       data-url="{{ url('/') }}{{$media->path}}"
       data-alt="{{$media->altTag}}"
       data-modified="{{$media->updated_at}}"
       data-created="{{$media->created_at}}"

       >
        <div class="image-gallery-single" style="background-image:url('{{ url('/') }}{{$media->path}}')"></div>
    </a>
    <div class="desc">{{$media->altTag}}</div>
</div>
@endforeach



<div id="modal-large">
    <div class="modal fade" id="my_modal" tabindex="-1" role="dialog" aria-labelledby="my_modalLabel">
        <div class="modal-dialog" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">File Details</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-6">
                        <div id="image-left"></div>
                    </div>

                    <div class="col-sm-6" style="background:#F1F1F1">
                        <div id="details-right">

                            <h4>File Details</h4>

                            <ul>
                                <li>
                                    <strong>Filename:</strong> <span id="filename"></span>
                                </li>
                                <li>
                                    <strong>File Type:</strong> <span id="filetype"></span>
                                </li>
                                <li>
                                    <strong>URL:</strong> <span id="url"></span>
                                </li>
                                <li>
                                    <strong>Last Edited:</strong> <span id="modified"></span>
                                </li>
                                <li>
                                    <strong>Uploaded At:</strong> <span id="created"></span>
                                </li>
                            </ul>

                            <div class="spacer">
                            </div>

                            <h4>Edit File</h4>


                            <table class="table">

                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Alt Tag</strong>
                                        </td>
                                        <td>
                                            <input class="form-control inline" name="altTag" id="altTag" value="" type="text"/> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <form method="POST" id="form-validate" name="form-validate" action="{{ url('/file_manager/delete') }}">

                                {{ csrf_field() }}

                                <input name="image_id" id="image_id" value="" type="hidden"/> 
                                <input name="file_name" id="file_name" value="" type="hidden"/> 
                                <button type="submit" style="margin-bottom:20px" class="btn btn-danger pull-right">Delete Image</button>
                                
                            </form>
                        </div>
                    </div>
                    <input type="hidden" name="hiddenValue" id="hiddenValue" value="" />
                </div>
                <div class="modal-footer" style="clear:both; margin-top:20px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                    <button type="button" id="save_button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    @endsection
