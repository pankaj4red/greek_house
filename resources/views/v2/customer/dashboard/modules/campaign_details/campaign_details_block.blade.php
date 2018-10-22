<div class="block-info-rounded campaign__description">
    <div class="description__header row">
        <div class="col-md-3 col-sm-6 header__item">
            <div class="item__title">Designer</div>
            <div class="item__value">{{ $campaign->artwork_request->designer ? $campaign->artwork_request->designer->getFullName() : 'N/A' }}</div>
        </div>
        <div class="col-md-3 col-sm-6 header__item">
            <div class="item__title">Estimated Qty</div>
            <div class="item__value">{{ $campaign->estimated_quantity }}</div>
        </div>
        <div class="col-md-3 col-sm-6 header__item">
            <div class="item__title">University</div>
            <div class="item__value">{{ $campaign->contact_school ? $campaign->contact_school : '' }}</div>
        </div>
        <div class="col-md-3 col-sm-6 header__item">
            <div class="item__title">Chapter</div>
            <div class="item__value">{{ $campaign->contact_chapter ? $campaign->contact_chapter : '' }}</div>
        </div>
    </div>
    <div class="description__body">
        @if ($campaign->artwork_request->print_front)
            <div class="body__subtitle">
                <div>Front of Shirt</div>
                <div># of colors: {{ $campaign->artwork_request->print_front_colors }}</div>
            </div>
            <div class="body__info">gh-btn
                <p>{!! process_text($campaign->artwork_request->print_front_description) !!}</p>
            </div>
        @endif
        @if ($campaign->artwork_request->print_pocket)
            <div class="body__subtitle">
                <div>Pocket of Shirt</div>
                <div># of colors: {{ $campaign->artwork_request->print_pocket_colors }}</div>
            </div>
            <div class="body__info">
                <p>{!! process_text($campaign->artwork_request->print_pocket_description) !!}</p>
            </div>
        @endif
        @if ($campaign->artwork_request->print_back)
            <div class="body__subtitle">
                <div>Back of Shirt</div>
                <div># of colors: {{ $campaign->artwork_request->print_back_colors }}</div>
            </div>
            <div class="body__info">
                <p>{!! process_text($campaign->artwork_request->print_back_description) !!}</p>
            </div>
        @endif
        @if ($campaign->artwork_request->print_sleeve)
            <div class="body__subtitle">
                <div>Sleeves of Shirt</div>
                <div>
                    Preferred: {{ $campaign->artwork_request->print_sleeve_preferred=='left'?'Left':'' }}{{ $campaign->artwork_request->print_sleeve_preferred=='right'?'Right':'' }}{{ $campaign->artwork_request->print_sleeve_preferred=='both'?'Both':'' }}
                    Sleeve{{ $campaign->artwork_request->print_sleeve_preferred=='both'?'s':'' }} of Shirt
                </div>
                <div># of colors: {{ $campaign->artwork_request->print_sleeve_colors }}</div>
            </div>
            <div class="body__info">
                <p>{!! process_text($campaign->artwork_request->print_sleeve_description) !!}</p>
            </div>
        @endif

        @if (count($campaign->getCurrentArtwork()->images) > 0)
            <div class="body__subtitle">
                <div>References</div>
            </div>
            <div class="body__info references">
                @foreach ($campaign->getCurrentArtwork()->images as $imageEntry)
                    <div class="reference__item" style="background-image: url({{ route('system::file', [$imageEntry->file->id]) }})"></div>
            @endforeach

            <!-- don't remove this, please -->
                <div class="reference__item fix-flex-lastchild"></div>
            </div>
        @endif
    </div>
</div>