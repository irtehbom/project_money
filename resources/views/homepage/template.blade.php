<!DOCTYPE html>

@include('/header/header') 

<div class="container">
    <div class="col-sm-12">
        <div class='spacer'></div>


            <h1 style='color:#E95A44'>{!!$result->title!!}</h1>

        <div class='spacer'></div>

        {!!$result->content!!}

        <div class="guides-list-container">
            <div class="guides-list-title">
                <h2>Recent Buying Guides</h2>
            </div>

            <ul class="guides-list">
                @foreach ($guides as $guide)

                <li><a href="{{$guide->slug}}">{{$guide->title}}</a></li>

                @endforeach
            </ul>
        </div>
    </div>
</div>

@include('/footer/footer') 

</body>
</html>
