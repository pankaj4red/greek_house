<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span class="icon-text">Designer Countdown</span></h3>
    </div>
    <div class="panel-body">
        <div class="order-proof-box">
            <table class="order-proof-box-list">
                <tr>
                    <td>Created<strong>{{ date('m/d/Y H:i:s', strtotime($campaign->created_at)) }}</strong></td>
                    <td>Customer Wait<strong>{{ time_count($campaign->getCustomerWaitingTime()) }}</strong></td>
                    <td>Designer Wait<strong>{{ time_count($campaign->getDesignerWaitingTime()) }}</strong></td>
                    <td>Reply Coutndown<strong
                                class="{{ countdown_class($campaign->getCountdownTime()) }}">{{ time_count($campaign->getCountdownTime()) }}</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

