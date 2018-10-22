<div class="card mb-3">
    <div class="card-header">
        Uploaded Proofs
        @if ($edit)
            <a href="{{ route('customer_module_popup', ['design_information', $campaign->id]) }}" data-toggle="modal" data-target="#gh-modal">
                <i class="fa fa-edit color-slate pull-right text-lg"></i>
            </a>
        @endif
    </div>
    <div class="card-body">
        @if ($campaign->getProofCount() > 0)
            @component('v3.partials.slider.proof_slider', ['campaign' => $campaign])
                @if ($approval)
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-info btn-inverted module-link mr-1" href="{{ route('customer_module_popup', ['design_information', $campaign->id, 'revision']) }}" data-toggle="modal"
                               data-target="#gh-modal" data-modal-width="800px">
                                Make changes
                            </a>
                            <a class="btn btn-success module-link ml-1" href="{{ route('customer_module_popup', ['design_information', $campaign->id, 'accept']) }}" data-toggle="modal"
                               data-target="#gh-modal" data-modal-width="800px">
                                <i class="fa fa-check" aria-hidden="true"></i>&nbsp;Approve Design
                            </a>
                        </div>
                    </div>
                @endif
            @endcomponent
        @endif
    </div>
</div>
