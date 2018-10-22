<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-price"></i><span class="icon-text">Embellishment</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="colored-list">
            <div class="colored-item blue">
                <div class="colored-item-information">
                    <p class="colored-item-text">Print Type</p>
                    <h5 class="colored-item-title">
                        @if ($campaign->getCurrentArtwork()->design_type == 'screen')
                            <span class="bold-black-text">Screenprint</span>
                        @else
                            <span class="bold-black-text">Embroidery</span>
                        @endif
                    </h5>
                </div>
            </div>
            <div class="colored-item green">
                <div class="colored-item-information">
                    <p class="colored-item-text">Polybag & Label</p>
                    <h5 class="colored-item-title">
                        @if ($campaign->polybag_and_label)
                            <span class="bold-red-text">Yes</span>
                        @else
                            <span class="bold-black-text">No</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
