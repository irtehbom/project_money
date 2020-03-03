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




        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    All Buying Guides <small>View or edit your Buying Guides</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> All Guides
                    </li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <table id="data-table" class="table table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Page Name</th>
                            <th>Meta Title</th>
                            <th>Meta Description</th>
                            <th>Template</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Page Name</th>
                            <th>Meta Title</th>
                            <th>Meta Description</th>
                            <th>Date Updated</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($all as $object)
                        <tr>
                            <td><a href="{{ url('/buying_guides/edit/') }}/{{ $object->id }}">{{ $object->title }}</a></td>
                            <td>{{ $object->meta_title }}</td>
                            <td>{{ $object->meta_description }}</td>
                            <td>{{ $object->updated_at }}</td>
                            <td>
                                <a href="{{ url('/buying_guides/edit/') }}/{{ $object->id }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="{{ url('/buying_guides/delete/') }}/{{ $object->id }}">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div></div>

<!-- /.container-fluid -->




@endsection
