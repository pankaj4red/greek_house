<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-price"></i><span class="icon-text">Fulfillment Actions</span></h3>
        @if ($campaign->shipped_at)
            <p class="pull-right"><i>Shipped Date:</i>
                <strong>{{ date('m/d/Y', strtotime($campaign->shipped_at)) }}</strong></p>
        @endif
    </div>
    <div class="panel-body">
        @if (in_array($campaign->state, ['fulfillment_validation', 'printing', 'shipped', 'delivered']))
            <div class="row">
                @if (in_array($campaign->state, ['fulfillment_validation', 'printing', 'shipped', 'delivered']))
                    <div class="col-md-12">
                        @if (in_array($campaign->state, ['fulfillment_validation', 'printing']))
                            @if (in_array($campaign->state, ['fulfillment_validation']))
                                <div class="text-title">Set Print Date</div>
                            @else
                                <div class="text-title">Print Date</div>
                            @endif
                            @if ($edit)
                                {{ Form::open(['method' => 'post', 'url' => route('customer_block_popup', ['fulfillment_actions', $campaign->id, 'fulfillment_printing_date']), 'class' => 'pull-left']) }}
                                <div class="select-date select-date-small order-date no-left-margin">
                                    <div class="date input-group" data-date-format="MM/dd/yyyy" data-toggle="modal"
                                         data-target="#myModal">
                                        <input class="form-control" size="16" type="text" name="printing_date"
                                               placeholder="Enter Printing Date" id="print-date" readonly=""
                                               value="{{ $campaign->printing_date ? \Carbon\Carbon::parse($campaign->printing_date)->format('m/d/Y') : '' }}"/>
                                        <span class="input-group-addon"><span class="glyphicon cal-icon"></span></span>
                                    </div>
                                </div>
                                <button type="submit" name="save" value="save" class="btn btn-primary vtop" id="ajax-button">
                                    @if (in_array($campaign->state, ['fulfillment_validation']))
                                        Set Print Date
                                    @else
                                        Update
                                    @endif
                                </button>
                                {{ Form::close() }}
                            @else
                                <div>{{ \Carbon\Carbon::parse($campaign->printing_date)->format('m/d/Y') }}</div>
                            @endif
                        @endif
                        @if ($edit)
                            @if (in_array($campaign->state, ['printing']))
                                <a href="{{ route('customer_block_popup', ['fulfillment_actions', $campaign->id, 'mark_shipped']) }}"
                                   class="btn btn-success width-300 ajax-popup order-detail-page pull-left">Mark as Shipped</a>
                            @endif
                            @if (in_array($campaign->state, ['shipped', 'delivered']))
                                <a href="{{ route('customer_block_popup', ['fulfillment_actions', $campaign->id, 'mark_shipped']) }}"
                                   class="btn btn-success width-300 ajax-popup order-detail-page pull-left">Update Shipped</a>
                            @endif
                            @if (in_array($campaign->state, ['shipped']))
                                {{ Form::open(['method' => 'post', 'url' => route('customer_block_popup', ['fulfillment_actions', $campaign->id, 'fulfillment_state']), 'class' => 'pull-left']) }}
                                <input type="hidden" name="fulfillment_state" value="delivered"/>
                                <button class="btn btn-success width-300">Mark as Delivered</button>
                                {{ Form::close() }}
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        @endif
        @if ($campaign->fulfillment_valid == false || in_array($campaign->state, ['fulfillment_validation', 'printing']))
            <div class="row">
                <div class="col-md-12">
                    <div class="text-title">Issues</div>
                    @if ($campaign->fulfillment_valid == false)
                        <div class="col-md-12">
                            <div class="well text-danger">
                                <strong>Issue: {{ $campaign->fulfillment_invalid_reason }}</strong><br/>
                                {!! process_text($campaign->fulfillment_invalid_text) !!}
                            </div>
                        </div>
                        @if ($edit && in_array($campaign->state, ['fulfillment_validation', 'printing']))
                            <a href="{{ route('customer_block_popup', ['fulfillment_actions', $campaign->id, 'issue_solved']) }}"
                               class="btn btn-success width-300 ajax-popup order-detail-page">Mark as
                                Solved</a>
                        @endif
                    @else
                        @if ($edit && in_array($campaign->state, ['fulfillment_validation', 'printing']))
                            <a href="{{ $popupUrl }}" class="btn btn-danger width-300 ajax-popup order-detail-page">Report
                                Issue</a>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

@section ('javascript')
    <script>
        $("#print-date").datepicker({
            inline: false
        });
        $("#scheduled-date").datepicker({
            inline: false
        });

    </script>
@append
