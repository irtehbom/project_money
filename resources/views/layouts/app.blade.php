<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- SELECT PICKER ADMIN -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="{{ asset('css/image-picker.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-switch.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/nestable.css') }}" rel="stylesheet">
<link href="{{ asset('css/dragula.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">

        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Scripts -->
        <script>


window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
]) !!};

$(function() {
    var url = window.location;
    var element = $('ul.nav a').filter(function() {
    return this.href == url || url.href.indexOf(this.href) == 0;
    })
    .addClass('active').parent().parent()
    .addClass('in').parent()
    .addClass('active').parent()
    .addClass('in').parent()
    .addClass('active').parent()
    .addClass('in').parent()
    .addClass('active').parent()
});
        </script>
    </head>
    <body>


        @if (!Auth::guest())

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">Project Money</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                </div>
                <!-- Top Menu Items -->

                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">





                        <li class="active">
                            <a href="{{ url('/home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#file_manager"><i class="fa fa-fw fa-arrows-v"></i> File Manager <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="file_manager" class="collapse">
                                <li>
                                    <a href="{{ url('/file_manager_all') }}">All Files</a>
                                </li>
                                <li>
                                    <a href="{{ url('/file_manager_add') }}"> Add Files</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#products"><i class="fa fa-fw fa-arrows-v"></i> Pages <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="products" class="collapse">
                                <li>
                                    <a href="{{ url('/pages') }}">All Pages</a>
                                </li>
                                <li>
                                    <a href="{{ url('/pages/add') }}">Add Page</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#guides"><i class="fa fa-fw fa-arrows-v"></i> Buying Guides <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="guides" class="collapse">
                                <li>
                                    <a href="{{ url('/buying_guides') }}">All Guides</a>
                                </li>
                                <li>
                                    <a href="{{ url('/buying_guides/add') }}">Add Guide</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#pages"><i class="fa fa-fw fa-arrows-v"></i> Products <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="pages" class="collapse">
                                <li>
                                    <a href="{{ url('/products') }}">All Products</a>
                                </li>
                                <li>
                                    <a href="{{ url('/products/add_product') }}">Add Product</a>
                                </li>
                                <li>
                                    <a href="{{ url('/all_product_categories') }}">Product Category</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#appearance"><i class="fa fa-fw fa-arrows-v"></i> Appearance <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="appearance" class="collapse">
                                <li>
                                    <a href="{{ url('/menu') }}">Menu</a>
                                </li>
                                <li>
                                    <a href="{{ url('/widgets') }}">Widgets</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ url('/settings') }}"><i class="fa fa-fw fa-file"></i>Settings</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>


            @endif


            <div id="page-wrapper">


                <div class="container-fluid">
                    @yield('content')


                    <!-- Scripts -->
                    <!-- Include Editor style. -->

                    <!-- Include JS file. -->
                    <script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=rplz90tjbbhk1xi873751i379p8d17wrvsjlff2wk2exodgx"></script>
                    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
                    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
                    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js "></script>



                    </body>
                    </html>
