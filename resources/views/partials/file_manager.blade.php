<script src="{{ asset('js/dropzone.js') }}"></script>
<script>

$(document).ready(function () {

    var selected = null;

    $('.modal').on('show.bs.modal', function (e) {
        var trigger = $(e.relatedTarget);
        var input = $(trigger).closest('.input-group').find('input[type=text]');

        $('.identifyingClass').each(function () {

            $(this).click(function () {
                
                selected = $(this);
                var url = $(selected).data('path');
                $(input).attr('value', url);
                $(input).val(url);

                $('#my_modal').modal('hide');

            });
            
        });
    });


});
</script>   


@foreach ($all as $media)

<div class="gallery">
    <a href="#" class="identifyingClass"
       data-id="{{$media->id}}" 
       data-image="{{ url('/') }}{{$media->path}}" 
       data-filename="{{$media->originalName}}"
       data-filetype="{{$media->mimeType}}"
       data-url="{{ url('/') }}{{$media->path}}"
       data-alt="{{$media->altTag}}"
       data-modified="{{$media->updated_at}}"
       data-created="{{$media->created_at}}"
       data-path="{{$media->path}}">

        <div class="image-gallery-single" style="background-image:url('{{ url('/') }}{{$media->path}}')"></div>
    </a>
    <div class="desc">{{$media->altTag}}</div>
</div>
@endforeach



