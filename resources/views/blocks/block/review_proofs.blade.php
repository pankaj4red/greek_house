<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-image"></i><span class="icon-text">Uploaded Proofs</span></h3>
        <span class="pull-right design-hours">{{ to_hours($campaign->artwork_request->design_minutes) }}</span>
        </div>
    <div class="panel-body background-white">
        @if (count($campaign->getCurrentArtwork()->proofs) > 0)
            <?php $images = []; ?>
            @foreach ($campaign->getCurrentArtwork()->proofs as $proofEntry)
                <?php /** @var \App\Models\ArtworkRequestFile $proofEntry */ $images[] = $proofEntry->file; ?>
            @endforeach
            @include('partials.slider', [ 'watermark' => true,
                'images' => $images, 'actionArea' => $edit?'<div class="col-xs-12 col-sm-12 col-lg-12 noPadd filter-prod slider-btn">
                <button class="btn btn-info ajax-popup order-detail-page" href="' . route('customer_block_popup', ['review_proofs', $campaign->id, 'request_revision']) . '">MAKE CHANGES</button>
                <button class="btn btn-primary ajax-popup approve-design" href="' . route('customer_block_popup', ['review_proofs', $campaign->id, 'approve_design']) . '">APPROVE DESIGN</button>
            </div>':'',
            'slide' => array_key_exists('slide', get_defined_vars()) ? $slide : true,
            ])
        @else
            <div class="no-content">
                No Proofs were uploaded.
            </div>
        @endif
    </div>
</div>
