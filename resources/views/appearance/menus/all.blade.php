@extends('layouts.app')
@section('content')

<script>

    $(document).ready(function () {
        $('#data-table').DataTable({
            "order": [[4, "desc"]]
        });
        
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
        
    });

</script>


<form method="POST" id="form-validate" name="form-validate" action="{{ url('menu/add') }}">
    
    {{ csrf_field() }}
    
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                   Add or Edit Menus <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Menus
                    </li>
                </ol>
            </div>
        </div>

        <div class="form-group ">
            <h4>
                Add Menu
            </h4>
            
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-envelope-o"></i> 
                </div>
                <input class="form-control inline" id="name" name="name" type="text" placeholder="Menu Name"/>
            </div>
             <div class='spacer'></div>
            <button type="submit" class="btn btn-success inline pull-right">Add Menu</button>
            
        </div> 

</form>
    
    <div class="col-md-12">
        
        <div class='spacer'></div>
    <h4>
    All Menus
    </h4>
    <div class='spacer'></div>
        
        <table id="data-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Menu Name</th>
                    <th>Menu Item Count</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Menu Name</th>
                    <th>Menu Item Count</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($menus as $menu)
                <tr>
                    <td><a href="{{ url('/menu/edit/') }}/{{ $menu->id }}">{{ $menu->name }}</a></td>
                    <td>
                        @if (count($menu->count) === 0)
                        Empty
                        @else
                        {{ $menu->count }}
                        @endif
                        
                    </td>
                    <td>{{ $menu->updated_at }}</td>
                    <td>{{ $menu->created_at }}</td>
                    <td>
                        <a href="{{ url('/menu/edit/') }}/{{ $menu->id }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <a href="{{ url('/menu/delete/') }}/{{ $menu->id }}">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
