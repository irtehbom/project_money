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

<form method="POST" id="form-validate" name="form-validate"  action="{{ url('all_product_categories/edit') }}/{{ $category->id }}">

    {{ csrf_field() }}

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Edit Product Category <small>{{ $category->category_name }}</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Edit Product Category
                </li>
            </ol>
        </div>
 </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group ">
                    <h4>
                        Category Name
                    </h4>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope-o"></i> 
                        </div>
                        <input class="form-control inline" id="category_name" name="category_name" type="text"/>
                    </div>
                    <div class='spacer'></div>
                    <button type="submit" class="btn btn-success inline pull-right">Save</button>

                </div> 
            </div>
        </div> 

</form>

<div class="col-md-12">

    <div class='spacer'></div>
    <h4>
        All products in this category
    </h4>
    <div class='spacer'></div>

    <table id="data-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Rating</th>
                <th>UK Asin</th>
                <th>USA Asin</th>
                <th>UK Associate Tag</th>
                <th>USA Associate Tag</th>
                <th>Featured Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Product Name</th>
                <th>Rating</th>
                <th>UK Asin</th>
                <th>USA Asin</th>
                <th>UK Associate Tag</th>
                <th>USA Associate Tag</th>
                <th>Featured Image</th>
                <th>Actions</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td><a href="{{ url('/products/edit_product/') }}/{{ $product->id }}">{{ $product->title }}</a></td>
                <td>{{ $product->rating }} </td>
                <td>{{ $product->asin_UK }}</td>
                <td>{{ $product->asin }}</td>
                <td>{{ $product->amazonID_UK }}</td>
                <td>{{ $product->amazonID }}</td>
                <td><div class='category-edit-featured-image' style="background-image:url('{{ $product->featured_image }}')"</td>
                <td>
                    <a href="{{ url('/products/edit_product/') }}/{{ $product->id }}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <a href="{{ url('/products/delete_product/') }}/{{ $product->id }}">
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
