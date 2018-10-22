@component('v2.partials.slider.proof_slider', ['campaign' => $campaign])
    @if ($edit)
        <div class="row">
            <div class="col-12 proofs__btn">
                <a class="gh-btn blue-transparent module-link" href="{{ route('customer_module_popup', ['uploaded_proofs', $campaign->id, 'revision']) }}">
                    Make changes
                </a>
                <a class="gh-btn green module-link" href="{{ route('customer_module_popup', ['uploaded_proofs', $campaign->id, 'accept']) }}">
                    <i class="fa fa-check" aria-hidden="true"></i>&nbsp;Approve Design
                </a>
            </div>
        </div>
    @endif
@endcomponent

