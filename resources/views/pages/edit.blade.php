@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    $(document).ready(function () {

        $("form[name='form-validate']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                category_name: "required",
            },
            // Specify validation error messages
            messages: {
                category_name: "The category name cannot be empty."
            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                form.submit();

            }


        });

        tinymce.init({
            selector: 'textarea',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            content_css: '//www.tinymce.com/css/codepen.min.css'
        });

        
        });



</script>   

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            
            @if ($object->homepage == 1)
                            
            Edit Page <small>{{ $object->title }} [ Homepage ]</small> 
   
            @else
            
            Edit Page <small>{{ $object->title }}</small> 
            
            @endif
            
            
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Edit Page
            </li>
        </ol>
    </div>
</div>

<form method="POST" id="form-validate" name="form-validate" action="{{ url('pages/edit') }}/{{ $object->id }}">

    {{ csrf_field() }}
    
            Slug
            <div class="spacer">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope-o"></i> 
                    </div>
                    <input class="form-control inline" name="slug" id="slug" value="{{ $object->slug }}" placeholder="SEO Url" type="text"/>
                </div>
            </div>


    <ul class="nav nav-tabs">
        <li><a class="active" data-toggle="tab" href="#content">Content</a></li>
        <li><a data-toggle="tab" href="#seo">SEO Properties</a></li>
    </ul>

    <div class="tab-content">
        <div id="content" class="tab-pane fade in active">

            <h3>Content and Features</h3>

            Page Title
            <div class="spacer">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope-o"></i> 
                    </div>
                    <input class="form-control inline" name="title" id="title" placeholder="Page Title" type="text" value="{{ $object->title }}"/>
                </div>
            </div>

            Page Content
            <div class="spacer">
                <textarea type="text" class="form-control spacer" name="content" id="content" placeholder="Product Content" value="">{{ $object->content }}</textarea>
            </div>

        </div>

        <div id="seo" class="tab-pane fade in">

            <h3>SEO Properties</h3>

            Meta Title
            <div class="spacer">
                <div class="input-group">
                    
                    <div class="input-group-addon">
                        <i class="fa fa-envelope-o"></i> 
                    </div>
                    
                    <input class="form-control inline" name="meta_title" id="meta_title" placeholder="Meta Title" type="text" value="{{ $object->meta_title }}"/>
                    
                </div>
            </div>

            Meta Title
            <div class="spacer">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope-o"></i> 
                    </div>
                    <input class="form-control inline" name="meta_description" id="meta_description" placeholder="Meta Description" type="text" value="{{ $object->meta_description }}"/>
                </div>
            </div>

        </div>


        <button type="submit" class="btn btn-success btn-lg btn-block">Save all Tabs</button>
        <div class="spacer"></div>
    </div>



    @endsection
