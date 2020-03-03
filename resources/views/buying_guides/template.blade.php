<!DOCTYPE html>

@include('/header/header') 
<link href="{{ asset('css/front_end/buying_guides.css') }}" rel="stylesheet">
<link href="{{ asset('css/lightslider.css') }}" rel="stylesheet">
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
        
        <div class='spacer'></div>
        
        
        
        <div class='row'>
            
            <h2 style='color:#E95A44'>Our Top 10 List</h2>
            <div class='spacer'></div>
        
         <table class="table table-striped top-10" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Product Name</th>
                            <th>Check Prices</th>
                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Rank</th>
                            <th>Product Name</th>
                            <th>Check Prices</th>
                        </tr>
                    </tfoot>
                    <tbody>
                         @foreach ($all_order_table as $product)

                        <tr>
                            <td class="first-top-10">
                            #{{$loop->iteration}}
                            </td>
                            <td>
                            {{$product[0]->title}}
                            </td>
                            <td>
                            @if ($amazon['local'])
                            <a href="{{$amazon['link']}}{{$product[0]->asin}}/?tag={{$amazon['tag']}}"><img src="{{ asset($amazon['button']) }}" class="table-image-amazon"></a>
                            @else
                            <a href="{{$amazon['link']}}{{$product[0]->title}}&tag={{$amazon['tag']}}"><img src="{{ asset($amazon['button']) }}" class="table-image-amazon"></a>
                            @endif
                            </td>
                        </tr>
            @endforeach
                    </tbody>
                </table>

    </div>
    </div>

    <div class='spacer'></div>

    <ul id="filters" class="col-sm-12">
        <li><span id="all_select" onClick="allSort()" class="filter active" data-filter="{{$tag_list}}">All</span></li>
        @foreach ($json as $decoded)
        <li><span class="filter" onClick="changeSort(this)" data-ids="[{{ implode(',',$decoded->data_id) }},{!!$result->all_order!!}]" data-filter=".{{$decoded->tag_id}}">{{$decoded->tag_title}}</span></li>
        @endforeach
    </ul>

    <div class="row">
        <div class="col-lg-12" id="reviewlist">

            @foreach ($json as $decoded)
            @foreach ($decoded->products as $product)

            <div class="review {{$decoded->tag_id}}" data-cat="{{$decoded->tag_id}}" data-id="{{$product->id}}" >

                <div class="row">
                    <div class="col-lg-1">
                        <div class="featured-item">
                            Portable under £60
                        </div>
                    </div>
                    <div class="col-lg-11">
                        <div class="col-lg-10">
                            <span class="review-title">{{$product->title}}</span>
                        </div>
                        <div class="col-lg-2">
                            <div class="rating">
                                <div class="rating-title">Our Rating</div>
                                <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-11">
                        <div class="col-lg-12" style="margin-bottom:30px">
                            {!! $product->content !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-11">
                        <div class="col-lg-4">
                            <div class="item">            
                                <div class="clearfix" style="max-width:300px;">
                                    <ul id="image-gallery" class="gallery lightslider list-unstyled">
                                        <li data-thumb="{!! $product->featured_image !!}">
                                            <div class="guides-image" style="background-image:url('{!! $product->featured_image !!}');" />
                                        </li>
                                        @foreach ($product->selected_image_array as $image)
                                        <li data-thumb="{!! $image !!}">
                                            <div class="guides-image" style="background-image:url('{!! $image !!}');" />
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" style="border-right:1px solid #ccc">
                            @if($product->key_features != null)
                            <h4>Key Features</h4>
                            <ul class="features-list" style="list-style-type: disc !important;">
                                @foreach ($product->key_features as $feature)
                                <li style="font-weight:bold">{{$feature}}</li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        <div class="col-lg-4" >
                            <h4>Buy Now From</h4>
                            @if ($amazon['local'])
                            <a href="{{$amazon['link']}}{{$product->asin}}/?tag={{$amazon['tag']}}"><img src="{{ asset($amazon['button']) }}"></a>
                            @else
                            <a href="{{$amazon['link']}}{{$product->title}}&tag={{$amazon['tag']}}"><img src="{{ asset($amazon['button']) }}"></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            @endforeach

        </div>
    </div>
            
            <div class='spacer'></div>

        <div class='row bottom-content'>
            {!!$result->bottom_content!!}
        </div>
            
             <div class='spacer'></div>
            
</div>
        
@include('/footer/footer') 

<script src="{{ asset('/js/jquery.mixitup.min.js') }}"></script>
<script src="{{ asset('/js/lightslider.js') }}"></script>

<script>

$(document).ready(function () {


    $('.lightslider').each(function (index) {
        $(this).lightSlider({
            gallery: true,
            item: 1,
            loop: false,
            slideMargin: 0,
            thumbItem: 5,
            onBeforeSlide: function (el) {
                $('#counter' + index).text(el.getCurrentSlideCount());
            }
        });
    });


    const ids = [{!!$result->all_order!!}];
    const targets = ids.map(id => document.querySelector('[data-id="' + id + '"]'));
    
    console.log(targets);

    var mixer = $('#reviewlist').mixItUp({
        data: {
            uidKey: 'id'
        },
        animation: {
            enable: false
        },
        selectors: {
            target: '.review',
            filter: '.filter'
        },
        load: {
            sort: targets
        }
    });
    
    $('#all_select').addClass('active');

});


function changeSort(div) {

    const ids = JSON.parse($(div).attr('data-ids'));
    var uniqueIDS = unique(ids);


    if (ids.length >= 1) {
        const targets = uniqueIDS.map(id => document.querySelector('[data-id="' + id + '"]'));
        $('#reviewlist').mixItUp('sort', targets);
    }

}

function allSort() {

    const ids = [{!!$result->all_order!!}];
    const targets = ids.map(id => document.querySelector('[data-id="' + id + '"]'));
    $('#reviewlist').mixItUp('sort', targets);

}

function unique(array) {
    return $.grep(array, function (el, index) {
        return index === $.inArray(el, array);
    });
}

</script>

        
</body>
</html>
