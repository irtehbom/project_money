@extends('layouts.app')
@section('content')

<script src="{{ asset('js/image-picker.js') }}"></script>
<script>



jQuery(function () {


    $(".add-more").click(function () {

        var html = $(".copy").html();

        $(".add_more_container").append(html);


    });

    $("body").on("click", ".remove", function () {
        $(this).parents(".control-group").remove();
    });

    $("#multiple-select-picker").imagepicker({
        limit: 5,
        clicked: function () {
            var image_selected_array = $(".image-picker").data("picker").selected_values();
            $('#selected_image_array').val(image_selected_array);
            $('#featured-select-picker').empty();
            var array = $('#selected_image_array').val();
            result = array.split(',');
            $(result).each(function () {
                $('#featured-select-picker').append($("<option></option>")
                        .attr("data-img-src", this)
                        .text(this)
                        );
            });
            $("#featured-select-picker").imagepicker({
                limit: 1,
                clicked: function () {
                    var image_featured = $(".image-picker-featured").data("picker").selected_values();
                    $('#featured_image').val(image_featured);
                }
            });
        }
    });
    $("#featured-select-picker").imagepicker({
        limit: 1,
        clicked: function () {
            var image_featured = $(".image-picker-featured").data("picker").selected_values();
            $('#featured_image').val(image_featured);
        }
    });
    $('.image_picker_image').each(function () {
        $(this.parentNode).addClass('selected');
        $(this.parentNode).addClass('selected');
    });
    var image_selected_array = $(".image-picker").data("picker").selected_values();
    var selected_images = [];
    $("#multiple-select-picker option").each(function ()
    {
        selected_images.push($(this).data('img-src'));
    });
    $('#selected_image_array').val(selected_images.toString());
    $(".dropdown-menu li a").click(function () {
        $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
        $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
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
    $("form[name='form-validate']").validate({
// Specify validation rules
        rules: {
// The key name on the left side is the name attribute
// of an input field. Validation rules are defined
// on the right side
            title: "required",
            rating: {
                number: true,
                required: true
            },
            asin: "required",
        },
        // Specify validation error messages
        messages: {
            title: "The Product title cannot be empty.",
            rating: "Rating must be a number between 1 and 5.",
            asin: "You must enter an ASIN code.",
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('#load_amazon_data').click(function () {

        $('.hide_amazon_data').show();

        var asin = $('#asin').val();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ url('/products') }}/load_amazon_data",
            dataType: 'json',
            data: {asin: asin},
            success: function (data) {

                if (data == 'ASIN Incorrect') {
                    alert(data);
                } else {


                    loadImages(data[1][0]);
                }


            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    /*
     function loadPrices(data) {
     
     if (data[0][1] == 'not_found') {
     $('#lowestPrice').val('Lowest Price Not Found');
     } else {
     $('#lowestPrice').val(data[0][1].FormattedPrice);
     }
     
     if (data[0][0] == 'not_found') {
     $('#lowestUsedPrice').val('Lowest Used Price Not Found');
     } else {
     $('#lowestUsedPrice').val(data[0][0].FormattedPrice);
     }
     }
     */

    function loadImages(data) {

        $('#multiple-select-picker').empty();
        $('#featured-select-picker').empty();
        $(data).each(function () {
            $('#multiple-select-picker').append($("<option></option>")
                    .attr("data-img-src", this.URL)
                    .text(this.URL)
                    );
        });
        $("#multiple-select-picker").imagepicker({
            limit: 5,
            clicked: function () {
                var image_selected_array = $(".image-picker").data("picker").selected_values();
                $('#selected_image_array').val(image_selected_array);
                $('#featured-select-picker').empty();
                var array = $('#selected_image_array').val();
                result = array.split(',');
                $(result).each(function () {
                    $('#featured-select-picker').append($("<option></option>")
                            .attr("data-img-src", this)
                            .text(this)
                            );
                });
                $("#featured-select-picker").imagepicker({
                    limit: 1,
                    clicked: function () {
                        var image_featured = $(".image-picker-featured").data("picker").selected_values();
                        $('#featured_image').val(image_featured);
                    }
                });
            }
        });
    }

    $('#category_picker').change(function () {
        var selectedText = $(this).find("option:selected").text();
        console.log(selectedText);
        $("#category_name").val(selectedText);
    });

});
</script>


<div class="row">

    <div class="col-lg-12">
        <h1 class="page-header">
            Add Product
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Edit Product
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Content</a></li>
            <li><a data-toggle="tab" href="#menu1">Product Attributes</a></li>
            <li><a data-toggle="tab" href="#images">Images</a> </li>

        </ul>

        <form method="POST" id="form-validate" name="form-validate" action="{{ url('products/add_product/') }}">

            {{ csrf_field() }}

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">

                    <h3>Content and Features</h3>

                    Product Title
                    <div class="spacer">
                        <input type="text" class="form-control spacer" name="title" id="title" placeholder="Product Title" value="">
                    </div>
                    Product Description
                    <div class="spacer">
                        <textarea type="text" class="form-control spacer" name="content" id="content" placeholder="Product Content"></textarea>
                    </div>

                    Product Features
                    <div class="spacer">
                    </div>

                    <div class="add_more_container">



                        <div class="input-group control-group after-add-more">
                            <input type="text" name="key_features[]" class="form-control" placeholder="Enter Product Feature Here" value="">
                            <div class="input-group-btn"> 
                                <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </div>
                        </div>



                    </div>


                    <div class="copy hide">
                        <div class="control-group input-group" style="margin-top:10px">
                            <input type="text" name="key_features[]" class="form-control" placeholder="Enter Product Feature Here">
                            <div class="input-group-btn"> 
                                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                            </div>
                        </div>
                    </div>



                </div>
                <div id="menu1" class="tab-pane fade">

                    <h3>Product Attributes</h3>

                    Select Product Category
                    <div class="spacer">
                        <select class="selectpicker" name="category" id="category_picker">
                            @foreach ($product_categories as $category)


                            <option value="{{$category->id}}">{{$category->category_name}}</option>      


                            @endforeach
                        </select>

                    </div>

                    Product Rating
                    <div class="spacer">
                        <input type="text" class="form-control spacer" name="rating" id="rating" placeholder="Product Rating - Enter 0 - 5" value="">
                    </div>
                </div>

                <div id="images" class="tab-pane fade">
                    <h3>Images</h3>

                    Product ASIN
                    <div class="spacer">
                        <input type="text" class="form-control spacer" name="asin" id="asin" placeholder="Enter ASIN product code" value="">
                    </div>



                    <div id="load_amazon_data" class="btn btn-warning btn btn-sm">Load Amazon Data</div>

                    <div class="hide_amazon_data spacer" style="border-top:1px solid #ccc">

                        <h4>Select Product Images</h4>

                        Select 5 images for the product.
                        <div class="spacer"></div>
                        <select class="image-picker show-html" id="multiple-select-picker" data-limit="5" multiple="multiple"></select>

                        <div class="spacer" style="border-top:1px solid #ccc"></div>

                        Select a featured image from your selected images
                        <div class="spacer"></div>
                        <select class="image-picker-featured show-html" id="featured-select-picker" data-limit="1"></select>

                    </div>




                </div>


            </div>

            <div class="spacer">
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-block">Save all Tabs</button>

            <div class="spacer">
            </div>

            <input type="hidden" class="hidden" name="featured_image" id="featured_image" value="">
            <input type="hidden" class="hidden" name="selected_image_array" id="selected_image_array" value="">
            <input type="hidden" class="hidden" name="category_name" id="category_name" value="">
        </form>

    </div>
</div>

<div style="display:none" id="hidden-featured-array">
</div>

@endsection