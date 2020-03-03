@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Manage Widgets 
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Manage Widgets
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-8">

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Widgets</div>
        </div>
    </div>
    <div class="row">

        <div class="container-dragula" id="widgets">


            <div class="panel panel-default widgets-inline" data-type="menu">
                <div class="panel-heading" data-target="" data-toggle="collapse">Menu</div>
            </div>

        </div>

    </div>

</div>


<div class="col-lg-4">

    <div class="panel panel-default">
        <div class="panel-heading">Sidebar Widgets</div>
        <div class="panel-body">

            <div class="container-dragula expand">


            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Footer 1</div>
        <div class="panel-body">

            <div class="container-dragula expand">


            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Footer 2</div>
        <div class="panel-body">

            <div class="container-dragula expand">


            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Footer 3</div>
        <div class="panel-body">

            <div class="container-dragula expand">


            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Footer 4</div>
        <div class="panel-body">

            <div class="container-dragula expand">


            </div>

        </div>
    </div>
</div>


<div id="menu-hidden" style="display:none;">

    <div class="panel-heading" id="colapse-menu" data-target="" data-toggle="collapse">Menu</div>

    <div id="target-div"  data-target="" class="collapse target-div">
        <div class="spacer"></div>
        <table class="table">
            <tbody>
                <tr>
                    <td style="margin-top:20px">Widget Title</td>
                    <td>
                        <input class="form-control inline" name="widget_title" id="widget_title" value="" type="text"/> 
                    </td>
                </tr>
                <tr>
                    <td>
                        Select Menu
                    </td>
                    <td>
                        <select>
                            @foreach ($menus as $menu) 
                            <option value="{{$menu->id}}">{{$menu->name}}</option>
                            @endforeach
                        </select> 
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="spacer"></div>
        <button type="button" class="btn btn-success pull-right save_button" onClick="saveMenu(this)" data-id="" data-type="menu">Save</button>
        
    </div>

</div>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{ asset('js/jquery.mjs.nestedSortable.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>

<script>
    
function saveMenu(button) {
    
    var parents = $(button).parent();
    
    var widget_title = $(parents).find('input').val();
    var selected_menu = $(parents).find('select').val();
               
    console.log(widget_title);
    console.log(selected_menu);
}

$(document).ready(function () {

    var count = 1;

    var drake = dragula({
        copySortSource: false,
        copy: true,
        isContainer: function (el) {
            return el.classList.contains('container-dragula');
        },
        accepts: function (el, target, source, sibling) {

            if (target != document.getElementById('widgets')) {
                return target;
            } else if (source === target) {
                return target;
            }
        }
    });

    drake.on('drag', (el, container, source) => {
        $('.expand').each(function () {

            var height = $(this).height();
            var newHeight = height + 80;
            $(this).height(newHeight);

        });
    });

    drake.on('drop', (el, container, source) => {

        count++;

        $('.expand').each(function () {
            var height = $(this).height();
            $(this).css('height', 'auto');
        });
        $(el).removeClass('widgets-inline');
        var type = $(el).attr('data-type');


        switch (type) {

            case 'menu':
                
                $(el).empty();
                
                var reset_target = $('#menu-hidden').closest('div').find(".target-div");
                $(reset_target).attr('id', 'target-div');
                
                var target = $('#menu-hidden').closest('div').find("#target-div");
                var collapse_title = $('#menu-hidden').closest('div').find("#colapse-menu");

                $(collapse_title).attr('data-target', '#target_' + count);
                $(target).attr('id', 'target_' + count);
                
                var save_button = $('#menu-hidden').closest('div').find(".save_button");
                $(save_button).attr('data-id', 'target_' + count);

                var container = $('#menu-hidden').html();
                $(el).html(container);

                break;
        }

    });
}
);

</script>



@endsection
