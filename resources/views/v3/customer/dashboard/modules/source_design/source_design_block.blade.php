<div class="card mb-3">
    <div class="card-header">
        Source Design
        <a class="collapsed" data-toggle="collapse" href="#source-design" aria-expanded="true" aria-controls="test-block">
            <img class="pull-right collapse-icon mt-2" src="{{ static_asset('images/arrow-collapse.png') }}"/>
        </a>
    </div>
    <div class="card-body collapse" id="source-design">
        <div class="mb-3 mt-2">
            <a href="{{ route('home::design_gallery', [$campaign->source_design_id]) }}" target="_blank">{{ $campaign->source_design->name }}</a>
        </div>
        <div class="carousel slide" data-interval="false" data-ride="carousel" id="source-design-carousel">
            <div class="carousel-inner shadow">
                @foreach ($campaign->source_design->images as $image)
                    <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}" data-slide-number="{{ $loop->index }}">
                        <div class="d-block w-100 size-square image-background image-effect" style="background-image: url({{ route('system::image', [$image->file_id]) }})"></div>
                    </div>
                @endforeach
            </div>
            <ol class="carousel-indicators">
                @foreach ($campaign->source_design->images as $image)
                    <li class="{{ $loop->index == 0 ? 'active' : '' }}" data-slide-to="{{ $loop->index }}" data-target="#source-design-carousel">
                        <a class="{{ $loop->index == 0 ? 'active' : '' }}">
                            <img src="{{ route('system::image', [$image->file_id]) }}"/>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
