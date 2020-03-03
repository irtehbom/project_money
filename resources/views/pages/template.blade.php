<!DOCTYPE html>

@include('/header/header') 
<div class="container">
    <div class="col-lg-12">
        <div class='spacer'></div>

        <div class='row'>
            <h1 style='color:#E95A44'>{!!$result->title!!}</h1>
        </div>
        <div class='spacer'></div>

        <div class='row'>
            {!!$result->content!!}
        </div>

    </div>
</div>
    @include('/footer/footer') 
</body>
</html>
