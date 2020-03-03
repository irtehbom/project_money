@extends('layouts.app')
@section('content')

<script>

    $(document).ready(function () {
        $('#data-table').DataTable({
            "order": [[4, "desc"]]
        });
    });

</script>
<div class="row">
    <div class="col-md-12 ">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    All Products <small>view all products</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> All Products
                    </li>
                </ol>
            </div>
        </div>
        
          <div class="row">
  <div class="col-lg-12">
<table id="data-table" class="table table-striped table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
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
                    <th>Category</th>
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
                    <td>{{ $product->category_name }} </td>
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
    </div>

@endsection
