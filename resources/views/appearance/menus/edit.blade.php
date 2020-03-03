@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Manage Menu <small>{{ $object->name }}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Manage menu
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-4">

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Pages</div>
            <div class="panel-body">
                <label for="pages_menu">Add Pages to the menu:</label>
                <select multiple class="form-control" id="pages_menu">
                    @foreach ($pages as $page)

                    @if ($page->homepage == 1)

                    <option style="padding:10px" data-id="{{ $page->id }}" data-name="{{ $page->title }}" data-slug="/">{{ $page->title }} [ Homepage ]</option>

                    @endif

                    <option style="padding:10px" data-id="{{ $page->id }}" data-name="{{ $page->title }}" data-slug="{{ $page->slug }}">{{ $page->title }}</option>
                    @endforeach   
                </select>

                <button type="button" class="btn btn-success pull-right" id="pages_button" onClick="addToMenu(this)">Add To Menu</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Guides</div>
            <div class="panel-body">
                <label for="guides_menu">Add Guides to the menu:</label>
                <select multiple class="form-control" id="guides_menu">
                    @foreach ($guides as $guide)
                    <option style="padding:10px" data-id="{{ $guide->id }}" data-name="{{ $guide->title }}" data-slug="{{ $guide->slug }}">{{ $guide->title }}</option>
                    @endforeach   
                </select>    
                <button type="button" class="btn btn-success pull-right" id="guides_button" onClick="addToMenu(this)">Add To Menu</button>
            </div>
        </div>
    </div>
</div>



<div class="col-lg-8">

    <div class="panel panel-default">
        <div class="panel-heading">Menu</div>
        <div class="panel-body">
            <ol class="sortable" id="main_menu_subsection">
                @if ($object->items != null)
                @foreach($object->items as $items) 
                @if (!isset($items->children))
                <li id="list_{{$items->id}}" class="item menu-item-style" data-id="{{$items->id}}" data-name="{{$items->name}}" data-slug="{{$items->slug}}">
                    <div class="menu-handle">
                        <span class="menu-name">{{$items->name}}</span>
                        <button type="button" class="btn btn-danger pull-right button-change" onClick="removeMenuItem($(this).parent().parent())">Remove</button>
                        <button type="button" class="btn btn-info pull-right button-change" id="edit_name" data-toggle="modal" data-target="#myModal">Edit Name</button>
                    </div>

                </li>
                @else
                <li id="list_{{$items->id}}" class="item menu-item-style" data-id="{{$items->id}}" data-name="{{$items->name}}" data-slug="{{$items->slug}}">
                    <div class="menu-handle">
                        <span class="menu-name">{{$items->name}}</span>
                        <button type="button" class="btn btn-danger pull-right button-change" onClick="removeMenuItem($(this).parent().parent())">Remove</button>
                        <button type="button" class="btn btn-info pull-right button-change" id="edit_name" data-toggle="modal" data-target="#myModal">Edit Name</button>
                    </div>

                    <ol>
                        @foreach($items->children as $children) 

                        <li id="list_{{$children->id}}" class="item menu-item-style" data-id="{{$children->id}}" data-name="{{$children->name}}" data-slug="{{$children->slug}}">
                            <div class="menu-handle">
                                <span class="menu-name">{{$children->name}}</span>
                                <button type="button" class="btn btn-danger pull-right button-change" onClick="removeMenuItem($(this).parent().parent())">Remove</button>
                                <button type="button" class="btn btn-info pull-right button-change" id="edit_name" data-toggle="modal" data-target="#myModal">Edit Name</button>
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </li>
                @endif
                @endforeach
                @endif
            </ol>
        </div>
    </div>

    <form method="POST" id="form-validate" name="form-validate" action="{{ url('menu/edit') }}/{{ $object->id }}">

        {{ csrf_field() }}

        <input type="hidden" name="items" id="items" value="[{!! json_encode($object->items) !!}]">

        <div class="col-lg-12">

            <button type="submit" class="btn btn-success pull-right">Save Menu</button>
        </div>
    </form>


</div>

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Menu Name</h4>
            </div>
            <div class="modal-body">
                <input class="form-control inline" name="change_menu_name" id="change_menu_name" placeholder="Menu Name:" type="text" value=""/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="change_menu_item">Change Name</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{ asset('js/jquery.mjs.nestedSortable.js') }}"></script>
<script>

                                    $(document).ready(function () {


                                        $('#myModal').on('show.bs.modal', function (e) {

                                            var button = e.relatedTarget;
                                            var parent = $(button).parent();
                                            var menu_name = parent.children('.menu-name');
                                            var data_name = parent.parent();
                                            $("#change_menu_name").val(menu_name.text());

                                            $("#change_menu_item").click(function () {

                                                var input_name = $("#change_menu_name").val();
                                                menu_name.text(input_name);
                                                data_name.attr('data-name', input_name);

                                                saveOrder();

                                                $('#myModal').modal('hide');

                                                $(this).unbind("click");

                                            });



                                        });



                                        var sortable = $('.sortable').nestedSortable({
                                            handle: 'div',
                                            items: 'li',
                                            toleranceElement: '> div',
                                            relocate: function () {
                                                saveOrder();
                                            }
                                        });
                                    });

                                    function removeMenuItem(item) {
                                        item.remove();
                                        saveOrder();
                                    }

                                    function saveOrder() {

                                        var order = $('.sortable').nestedSortable('toHierarchy');
                                        var json_text = JSON.stringify(order, null, 2);

                                        $('#items').val(json_text);
                                    }


                                    function addToMenu(button) {

                                        var item = '';
                                        var title = '';
                                        var id = '';
                                        var slug = '';

                                        if ($(button).attr('id') == 'pages_button') {

                                            var item = $('#pages_menu').find(":selected");
                                            var title = item.attr('data-name');
                                            var id = item.attr('data-id');
                                            var slug = item.attr('data-slug');

                                        } else if ($(button).attr('id') == 'guides_button') {

                                            var item = $('#guides_menu').find(":selected");
                                            var title = item.attr('data-name');
                                            var id = item.attr('data-id');
                                            var slug = item.attr('data-slug');

                                        }

                                        var selectedItem = '<li id="list_' + id + '" class="item menu-item-style" data-id="' + id + '" data-name="' + title + '" data-slug="' + slug + '">' +
                                                '<div class="menu-handle">' +
                                                '<span class="menu-name">' + title + '</span>' +
                                                '<button type="button" class="btn btn-danger pull-right button-change" onClick="removeMenuItem($(this).parent().parent())">Remove</button>' +
                                                '<button type="button" class="btn btn-info pull-right button-change" id="edit_name" data-toggle="modal" data-target="#myModal">Edit Name</button>' +
                                                '</div>' +
                                                '</li>';

                                        $('#main_menu_subsection').append(selectedItem);

                                        saveOrder();

                                    }


</script>

@endsection
