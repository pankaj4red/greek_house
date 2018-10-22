<div class="product__image-gallery active {{ $color[0]->name }}">
    <div class="image__main">
        <div class="main__bg" style="background-image: url({{ route('system::image', [$color[0]->image_id]) }});"></div>
    </div>
    <div class="image__thumbs">
        @foreach($color as $image)
            <div class="image__thumb" data-image="{{ route('system::image', [$image->thumbnail_id]) }}">
                <div class="thumb__bg" style="background-image: url({{ route('system::image', [$image->thumbnail_id]) }});"></div>
            </div>
        @endforeach
    </div>
</div>