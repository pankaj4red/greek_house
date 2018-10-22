@extends('v2.layouts.campaign')

@section('title', 'Approve Design')

@section('content_campaign')
    @component('v2.partials.slider.proof_slider', ['campaign' => $campaign])
    @endcomponent
    {{ Form::open() }}
    <div class="block-info-rounded">
        <div class="block-info__title">
            Design Details
        </div>
        <div class="block-info__body approve-design">
            <div class="modal__section design__details">
                @foreach (['front', 'back', 'sleeve_left', 'sleeve_right'] as $position)
                    @if ($campaign->artwork_request->{'designer_colors_' . $position . '_list'})
                        <div class="design__detail">
                            <div class="detail__title">{{ ucwords(str_replace('_', ' ', $position)) }} Colors</div>
                            @foreach (explode(',', $campaign->artwork_request->{'designer_colors_' . $position . '_list'}) as $color)
                                <div class="detail__value with-color">
                                    <div class="value__color" style="background: {{ trim($color) }};"></div>
                                    <span>{{ trim($color) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
                <div class="design__detail">
                    <div class="detail__title">Dimensions</div>
                    @foreach (['front', 'back', 'sleeve_left', 'sleeve_right'] as $position)
                        @if ($campaign->artwork_request->{'designer_dimensions_' . $position})
                            <div class="detail__value">{{ ucwords(str_replace('_', ' ', $position)) }}: {{ $campaign->artwork_request->{'designer_dimensions_' . $position} }}</div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="form-group buttons">
        <a href="{{ $back }}" class="gh-btn grey-transparent btn-close">Back</a>
        <button type="submit" class="gh-btn blue"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Submit</button>
    </div>
    {{ Form::close() }}
@endsection
