<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-van"></i><span class="icon-text">Shipping Types</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <ul class="shipping-types">
            <li><b>Group Shipping?</b> <i>{{ $campaign->shipping_group?'Enabled':'Disabled' }}</i></li>
            <li><b>Individual Shipping?</b> <i>{{ $campaign->shipping_individual?'Enabled':'Disabled' }}</i></li>
        </ul>
    </div>
</div>