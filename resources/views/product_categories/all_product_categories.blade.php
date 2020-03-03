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


<form method="POST" id="form-validate" name="form-validate" action="{{ url('all_product_categories') }}">
    
    {{ csrf_field() }}
    
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    All Categories <small>view all categories</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> All Categories
                    </li>
                </ol>
            </div>
        </div>

        <div class="form-group ">
            <h4>
                Add Category
            </h4>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-envelope-o"></i> 
                </div>
                <input class="form-control inline" id="category_name" name="category_name" type="text"/>
            </div>
             <div class='spacer'></div>
            <button type="submit" class="btn btn-success inline pull-right">Add Category</button>
            
        </div> 

</form>
    
    <div class="col-md-12">
        
        <div class='spacer'></div>
    <h4>
    All Categories
    </h4>
    <div class='spacer'></div>
        
        <table id="data-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Number of Products in category</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Category Name</th>
                    <th>Number of Products in category</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($product_categories as $categories)
                <tr>
                    <td><a href="{{ url('/all_product_categories/edit/') }}/{{ $categories->id }}">{{ $categories->category_name }}</a></td>
                    <td>{{ $categories->productCount }}</td>
                    <td>{{ $categories->updated_at }}</td>
                    <td>{{ $categories->created_at }}</td>
                    <td>
                        <a href="{{ url('/all_product_categories/edit/') }}/{{ $categories->id }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <a href="{{ url('/all_product_categories/delete/') }}/{{ $categories->id }}">
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
