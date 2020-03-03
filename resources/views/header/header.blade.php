<head>
    <link href="{{ asset('css/front_end/front.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <title>{{$result->meta_title}}</title>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="row header-bar">
                <div class="col-sm-3">
                    <a href="{{ url('/') }}"><img src="{{ asset('images/logo/couples_corner_banner.jpg') }}" class="logo"></a>
                </div>
                <div class="col-sm-9">
                    <ul id="menu" class='nav navbar-nav'>
                        @if ($data['menu'] == null)
                        No main menu set - Create a menu named header-menu in Appearance/Menus
                        @else
                        @foreach ($data['menu'] as $menu_item)
                        @if(isset($menu_item->children))
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/') }}/{{$menu_item->slug}}">{{$menu_item->name}}<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach ($menu_item->children as $children)
                                <li><a href='{{ url('/') }}/{{$children->slug}}'>{{$children->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>    
                        @else
                        <li>
                            <a href='{{ url('/') }}/{{$menu_item->slug}}'>{{$menu_item->name}}</a>
                        </li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>

