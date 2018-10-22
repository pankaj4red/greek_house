<?php $sliderId = uniqid(); ?>
<div class="fotorama" id="{{ $sliderId }}" data-nav="thumbs" data-width="100%" data-ratio="16/9">
    @for ($i = 0; $i < count($images); $i++)
        <a href="{{ route('system::image', [get_image_id($images[$i]->id)], true) }}">
            <img src="{{ route('system::image', [get_image_id($images[$i]->id, true)]) }}" alt="{{ $images[$i]->name }}"/>
        </a>
    @endfor
</div>

@section ('include')
    <?php register_css(static_asset('css/fotorama.css')) ?>
    <?php register_js(static_asset('js/fotorama.js')) ?>
@append

@section ('javascript')
@append
