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
            selector: "textarea",

            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            content_css: '//www.tinymce.com/css/codepen.min.css'
        });


        $('#tabs').tabs();

        var drake = dragula({
            copySortSource: true,
            isContainer: function (el) {
                return el.classList.contains('container-dragula');
            },
            accepts: function (el, target, source, sibling) {


                if (target != document.getElementById('all_tab_order')) {
                    return target;
                } else if (source === target) {
                    return target;
                }
               
            }


        });

        drake.on('drop', (el, container, source) => {
            getGuideProductData();
        });

        var tabTitle = $("#tab_title"),
                tabContent = $("#tab_content"),
                tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
                tabCounter = 2;

        var tabs = $("#tabs").tabs();

        // Modal dialog init: custom buttons and a "close" callback resetting the form inside
        var dialog = $("#dialog").dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                Add: function () {
                    addTab();
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            close: function () {
                form[ 0 ].reset();
            }
        });

        var form = dialog.find("form").on("submit", function (event) {
            addTab();
            dialog.dialog("close");
            event.preventDefault();
        });

        function addTab() {
            
            
            var label = tabTitle.val() || "Tab " + tabCounter;
            var str = label.replace(/\s/g, '');
            var id = str + "-" + tabCounter;
            
            if (id.startsWith("£")) {
                
                id = id.replace(/\£/g, 'pound');
            }  
            
            var li = $(tabTemplate.replace(/#\{href\}/g, "#" + id).replace(/#\{label\}/g, label));
            
            

            tabs.find(".ui-tabs-nav").append(li);

            tabs.append("<div id='" + id + "'><div class='container-dragula' style='height:200px;' data-title='" + label + "'></div></div>");

            tabs.tabs("refresh");
            tabCounter++;
            getGuideProductData();
        }

        $("#add_tab")
                .button()
                .on("click", function () {
                    dialog.dialog("open");
                });

        tabs.on("click", "span.ui-icon-close", function () {
            var panelId = $(this).closest("li").remove().attr("aria-controls");
            
            var panel = "#" + panelId;

            $(panel).find('.sort-products').each(function () {
                $(this).appendTo('#all_products');
            });

            $("#" + panelId).remove();
            tabs.tabs("refresh");
             getGuideProductData();
        });

        tabs.on("keyup", function (event) {
            if (event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE) {
                var panelId = tabs.find(".ui-tabs-active").remove().attr("aria-controls");
                $("#" + panelId).remove();
                tabs.tabs("refresh");
                 getGuideProductData();
            }
        });

        $(".remove_product").each(function (index) {
            $(this).click(function () {
                $(this).parent().parent().appendTo('#all_products');
                getGuideProductData();
            });
             
        });
        
        $("#category").change(function () {

            var button = this;

            $("#dialog-confirm").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                verticalHeight: 200,
                modal: true,
                buttons: {
                    "Confirm": function () {
                        $(this).dialog("close");
                        delete_items(button);
                    },
                    Cancel: function () {
                        $(this).dialog("close");
                    }
                }
            });
        });


        $("#add_section_confirm").click(function () {

            tinyMCE.triggerSave();
            var content = $('#add_content_textarea').val();
            var title = $('#add_content_title').val();

            var content_section = '<div id="content_section_definer" class="sort-products content_section_style" data-content= "' + content + '"data-id="content_section_definer">' +
                    '<div class="sortable-title">' +
                    '<span class="sortable-title-header">Content Section: </span> ' + title +
                    '<span class="ui-icon ui-icon-close remove_content_section" role="presentation">Remove Tab</span>' +
                    '</div>' +
                    '</div>';


            $('#content_section').append(content_section);

            $(".remove_content_section").each(function (index) {
                $(this).click(function () {
                    $(this).parent().parent().appendTo('#content_section');
                });
            });



            $('#myModal').modal('toggle');


        });

    });

    function delete_items(button) {

        var category_selected = $('option:selected', button).val();

        $('#category_input').val(category_selected);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('/pages/add/get_products') }}",
            dataType: 'json',
            data: {category_selected: category_selected},
            success: function (data) {

                $('#all_products').empty();
                $('#all_tab_order').empty();
                $('#nomove').empty();

                $(".ui-tabs-panel").each(function (index) {
                    if ($(this).attr('id') != 'all_tab') {
                        $(this).remove();
                    } else {
                        $(this).removeAttr('style');
                    }

                });

                $(".ui-tabs-tab").each(function (index) {
                    if ($(this).attr('aria-controls') != 'all_tab') {
                        $(this).remove();
                    } else {
                        $(this).addClass('ui-state-active');
                        $(this).attr('aria-selected', 'true');
                        $(this).attr('aria-expanded', 'true');
                    }
                });


                $(data).each(function () {

                    var products = '<div id="' + this.id + '" class="sort-products" data-id="' + this.id + '">' +
                            '<div class="sortable-title">' +
                            '<span class="sortable-title-header">Product Title:</span> ' + this.title +
                            '</div>' +
                            '</div>';


                    $('#all_products').append(products);
                    $('#all_tab_order').append(products);
                    
                    $('#nomove').append(products);

                });

            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    }

   function getGuideProductData() {

        var productData = [];
        var productList = [];
        var all_tab_order = [];

        $(".ui-tabs-panel").each(function (index) {

            var data_id = new Array();
            var tag_id = $(this).attr('id');
            var title = $(this).children().attr('data-title');
            var products = [];
            var children = $(this).children().children();

            $(children).each(function () {
                data_id.push($(this).attr('data-id'));
                productList.push($(this).attr('data-id'));
            });

            productData.push({tag_id: tag_id, tag_title: title, data_id: data_id, products: products});
            //productData.push({"tab": [{"tag_id": tag_id, "data_id": data_id }]});
        });

        
        var get_all_order = $('#all_tab_order').children();
        
        $(get_all_order).each(function (index) {
             var all_order_id = $(this).attr('id');
             all_tab_order.push(all_order_id);
        });

        var json = JSON.stringify(productData);
        $('#products_order').val(json);
        
        var uniqueProductList = unique(productList);
        var productListToString = JSON.stringify(uniqueProductList);
        
        $('#productlist').val(productListToString);
        
         var allOrderToString = JSON.stringify(all_tab_order);
        
        $('#all_order').val(allOrderToString);
    }
    
    function unique(array) {
    return $.grep(array, function(el, index) {
        return index === $.inArray(el, array);
    });
}

</script>   

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Edit Guide <small>{{ $object->title }}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Edit Guide
            </li>
        </ol>
    </div>
</div>

<div id="dialog" title="Tab data">
    <form>
        <fieldset class="ui-helper-reset">
            <label for="tab_title">Title</label>
            <input type="text" name="tab_title" id="tab_title" value="Tab Title" class="ui-widget-content ui-corner-all">
        </fieldset>
    </form>
</div>

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Content Section</h4>
            </div>
            <div class="modal-body">
                <input class="form-control inline" name="add_content_title" id="add_content_title" placeholder="Section Title" type="text" value=""/>
                <textarea id="add_content_textarea"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add_section_confirm">Add Section</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="dialog-confirm" title="Empty the buying guide?" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Changing Product Category will remove all tabs and products from your buying guide.</p>
</div>

<form method="POST" id="form-validate" name="form-validate" action="{{ url('buying_guides/edit') }}/{{ $object->id }}">

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
        <li><a data-toggle="tab" href="#products_tab">Products</a></li>
         <li><a data-toggle="tab" href="#amazon_ids">Amazon ID's</a></li>
        
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
                <textarea type="text" class="form-control spacer mceEditor" name="content" id="content" placeholder="Product Content" value="">{{ $object->content }}</textarea>
            </div>
            
            Bottom Content
            <div class="spacer">
                <textarea type="text" class="form-control spacer mceEditor" name="bottom_content" id="bottom_content" placeholder="Product Content" value="">{{ $object->bottom_content }}</textarea>
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


        <div id="products_tab" class="tab-pane fade in">


            <div class="spacer"></div>

            <div class="row">
                <div class="col-lg-9">

                    <h3>Design your buyers guide</h3>
                    <div class="spacer"></div>

                    <div id="add_tab">Add Tab</div>

                    <div class="spacer"></div>

                    <div id="tabs">
                        <ul>
                            @foreach ($json as $decoded)
                            <li><a href="#{{$decoded->tag_id}}">{{$decoded->tag_title}}</a> 
                                <span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span>
                            </li>
                            @endforeach
                        </ul>

                        @foreach ($json as $decoded)

                        <div id="{{$decoded->tag_id}}">
                            <div style="height:600px" id="nomove" class="container-dragula" data-title="{{$decoded->tag_title}}">
                                @foreach ($decoded->products as $product)
                                <div id="{{$product->id}}" class="sort-products" data-id="{{ $product->id }}">
                                    <div class="sortable-title">
                                        <span class="sortable-title-header">Product Title:</span> <a href='{{ url('/products/edit_product/') }}/{{ $product->id }}'>{{ $product->title }}</a>
                                        @if ($decoded->tag_id != 'all_tab')
                                        <span class="ui-icon ui-icon-close remove_product" id="remove_product" role="presentation">Remove Tab</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @endforeach

                    </div>
                    
                    <h2></h2>
                    <div class="panel panel-default">
                         <div class="panel-heading">Order All Tab</div>
                         <div class="panel-body">
                              <div class="container-dragula" id="all_tab_order" >
                                @foreach ($all_products as $product)
                                <div id="{{ $product->id }}" class="sort-products" data-id="{{ $product->id }}">
                                    <div class="sortable-title">
                                        <span class="sortable-title-header">Product Title:</span> {{ $product->title }} 
                                    </div>
                                </div>
                                @endforeach
                            </div>
                         </div>
                    </div>
                    <div class="spacer"></div>


                </div>
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">All Products</div>
                        <div class="panel-body">

                            <h3>Products</h3>
                            Assign product category to buyers guide
                            <div class="spacer">
                                <select class="selectpicker" id="category">
                                    
                                    @foreach ($product_categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>      
                                    @endforeach
                        
                                </select>
                            </div>

                            <div class="container-dragula" id="all_products" >
                                @foreach ($products as $product)
                                <div id="{{ $product->id }}" class="sort-products" data-id="{{ $product->id }}">
                                    <div class="sortable-title">
                                        <span class="sortable-title-header">Product Title:</span> {{ $product->title }} 
                                        <span class="ui-icon ui-icon-close remove_product" id="remove_product" role="presentation">Remove Tab</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Content Sections</div>
                        <div class="panel-body">

                            <div class="spacer"></div>

                            <button type="button" id="add_content_section" class="btn btn-primary  btn-lg btn-block"  data-toggle="modal" data-target="#myModal">Add Section</button>

                            <div class="spacer"></div>

                            <div class="container-dragula" id="content_section" >
                            </div>  


                        </div>
                    </div>
                </div>
            </div>
        </div>
        
            <div id="amazon_ids" class="tab-pane fade in">
                
                 <h3>Assign ID's on a per country basis</h3>
                 <div class='spacer'></div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Assign an Amazon ID to the Buying Guide</th>
                    </tr>
                </thead>
                <tbody> 

                     
                    <tr>
                        <td>United Kingdom</td>
                        <td>
                            <select class="selectpicker" name="location_ids[GB]" id="locations">

                                @if (isset($settings->location_ids->GB))
                                
                                    @foreach (explode(",",$settings->location_ids->GB) as $location)


                                        @if ($object->location_ids->GB == $location)
                                            <option selected value="{{$location}}">{{$location}}</option>
                                        @else
                                            <option value="{{$location}}">{{$location}}</option>
                                        @endif

                                    @endforeach
                                @else
                                     <option value="">Not Set</option>      
                                @endif
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>United States</td>
                        <td>
                           <select class="selectpicker" name="location_ids[US]" id="locations">
                                @if (isset($settings->location_ids->US))
                                    @foreach (explode(",",$settings->location_ids->US) as $location)
                                    @if (isset($object->location_ids->GB))
                                        @if ($object->location_ids->US == $location)
                                            <option selected value="{{$location}}">{{$location}}</option>
                                        @else
                                            <option value="{{$location}}">{{$location}}</option>
                                        @endif
                                        @endif
                                    @endforeach
                                @else
                                     <option value="">Not Set</option>      
                                @endif
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Canada</td>
                        <td>
                            <select class="selectpicker" name="location_ids[CA]" id="locations">
                                @if (isset($settings->location_ids->CA))
                                    @foreach (explode(",",$settings->location_ids->CA) as $location)
                                    @if (isset($object->location_ids->GB))
                                        @if ($object->location_ids->CA == $location)
                                            <option selected value="{{$location}}">{{$location}}</option>
                                        @else
                                            <option value="{{$location}}">{{$location}}</option>
                                        @endif
                                         @endif
                                    @endforeach
                                @else
                                     <option value="">Not Set</option>      
                                @endif
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="spacer"></div>

    </div>


    <div class="col-lg-6">
    </div>



</div>

<input name="products_order" id="products_order" type="hidden" value="{{$object->products_order}}"/>
<input name="all_order" id="all_order" type="hidden" value="{{$object->all_order}}"/>
<input name="product_list" id="productlist" type="hidden" value="{{$object->product_list}}"/>
<input name="category" id="category_input" type="hidden" value="{{$object->category}}"/>

<button type="submit" class="btn btn-success btn-lg btn-block">Save all Tabs</button>
<div class="spacer"></div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>

@endsection


<!--<div id="all_tab">
                            <div class="container-dragula" style="height:200px" data-title="All Tab">
                                @foreach ($products as $product)
                                <div id="{{ $product->id }}" class="sort-products" data-id="{{ $product->id }}">
                                    <div class="sortable-title">
                                        <span class="sortable-title-header">Product Title:</span> {{ $product->title }} 

                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>-->