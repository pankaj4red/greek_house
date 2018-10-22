<div class="card mb-3">
    <div class="card-body greekhouse-progress">
        <div class="progress mb-5 mt-5">
            @if (in_array($campaign->state, ['fulfillment_ready', 'fulfillment_validation', 'printing']))
                <div class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
            @elseif (in_array($campaign->state, ['shipped']))
                <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
            @elseif (in_array($campaign->state, ['delivered']))
                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            @else
                <div class="progress-bar" role="progressbar" style="" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            @endif
            <div class="progress-bar-dot bottom marker text-uppercase" style="left: 33%">Closed
                @if ($campaign->close_date)
                    <br/>{{ $campaign->close_date->format('M j') }}
                @else
                    <br/>TBD
                @endif
            </div>
            <div class="progress-bar-dot bottom marker text-uppercase" style="left: 66%">
                @if (in_array($campaign->state, ['shipped', 'delivered']))
                    Shipped
                @else
                    Est. Ship
                @endif
                @if ($campaign->shipped_at)
                    <br/>{{ $campaign->shipped_at->format('M j') }}
                @elseif ($campaign->printing_date)
                    <br/>{{ $campaign->printing_date->format('M j') }}
                @else
                    <br/>TBD
                @endif
            </div>
            <div class="progress-bar-dot top right text-xs color-blue text-uppercase">
                Estimated Arrival Date:
                @if ($campaign->scheduled_date)
                    {{ $campaign->scheduled_date->format('F j, Y') }}
                @elseif ($campaign->shipped_at)
                    {{ $campaign->shipped_at->addWeekdays($campaign->days_in_transit ?? 0)->format('F j, Y') }}
                @elseif ($campaign->printing_date)
                    {{ $campaign->printing_date->addWeekdays($campaign->days_in_transit ?? 0)->format('F j, Y') }}
                @else
                    TBD
                @endif
            </div>
            <div class="progress-bar-dot bottom right color-blue">
                {{ $campaign->fulfillment_shipping_line1 ?? $campaign->address_line1 }}
                {{ $campaign->fulfillment_shipping_line2 ?? $campaign->address_line2 }}
                <br/>
                {{ $campaign->fulfillment_shipping_city ?? $campaign->address_city }},
                {{ $campaign->fulfillment_shipping_state ?? $campaign->address_state }} {{ $campaign->fulfillment_shipping_zip_code ?? $campaign->address_zip_code }}
            </div>
        </div>
    </div>
</div>
