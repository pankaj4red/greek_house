@if ($goals)
    <div class="card campaign-progress mb-3">
        <div class="card-body">
            <div class="campaign-progress-stats">
                <div class="campaign-progress-stat">
                    <div class="stat-title">Current<br>orders</div>
                    <div class="stat-value">{{ $campaign->getCurrentQuantity() }}</div>
                </div>
                @if ($campaign->getNextQuantityGoal())
                    <div class="campaign-progress-stat">
                        <div class="stat-title">Next<br>goal</div>
                        <div class="stat-value">{{ $campaign->getNextQuantityGoal() }}</div>
                        <div class="stat-tip">Reach This So Your<br>{{ $campaign->getNextGoalText() }}</div>
                    </div>
                @endif
            </div>
            <div class="campaign-progress-bar">
                <div class="progress-success" style="width: {{ $campaign->getGoalPercentage() }}%;"></div>
                <div class="progress-point min">
                    <div class="point-dash"></div>
                    <div class="point-title" data-mob="Min {{ $campaign->getMinimumQuantity() }}">Minimum at: {{ $campaign->getMinimumQuantity() }}</div>
                </div>
                <div class="progress-point best">
                    <div class="point-dash"></div>
                    <div class="point-title" data-mob="Best {{ $campaign->getMaximumQuantity() }}">Best price at: {{ $campaign->getMaximumQuantity() }}</div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="card mb-3">
    <div class="card-body">
        @if ($payment)
            <div class="row mb-3">
                <div class="col-12 col-md-9">
                    <a href="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}" class="btn btn-success w-100 text-center text-reg text-uppercase"
                       target="_blank">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now
                    </a>
                </div>
                <div class="col-12 col-md-3">
                    <div class="pull-right">
                        <div class="text-uppercase">Price range</div>
                        <div class="text-right color-blue">{{ quote_range($campaign->quote_low * 1.07, $campaign->quote_high * 1.07, $campaign->quote_final * 1.07) }}</div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-lg-9 d-inline-flex justify-content-between align-items-stretch">
                    <label class="text-xs mr-3 mt-2 text-uppercase">Share this campaign</label>
                    <div class="copy-to-clipboard-content">{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}</div>
                    <div class="copy-to-clipboard-button copy-text" data-copy-text=".copy-to-clipboard-content">Copy url</div>
                </div>
            </div>
        @endif
        <table class="table table-fixed mb-0">
            <tr>
                @foreach ($sizes['sizes'] as $size)
                    <td class="text-center font-weight-semi-bold border-right pt-0 pb-0 align-middle">
                        <div class="color-black">{{ $size['quantity'] }}</div>
                        <div>{{ $size['short'] }}</div>
                    </td>
                @endforeach
                <td class="text-center font-weight-semi-bold border-right pt-0 pb-0 align-middle">
                    <div class="color-blue">{{ $sizes['total'] }}</div>
                    <div>Total</div>
                </td>
                @if ($seePaymentTableView)
                    <td class="text-center font-weight-semi-bold position-relative text-center text-sm pt-0 pb-0  align-middle">
                        <a href="{{ route('customer_module_popup', ['payment_details', $campaign->id, 'sales']) }}" class="text-no-underline d-flex align-items-stretch" data-toggle="modal"
                           data-target="#gh-modal" data-modal-width="80%">
                            View Orders
                            <i class="fa fa-angle-right color-blue position-absolute" aria-hidden="true" style="right: 8px; top: 33%;"></i>
                        </a>
                    </td>
                @endif
            </tr>
        </table>
        @if ($edit)
            <div class="d-inline-flex justify-content-between align-items-center color-slate w-100 mt-2">
                <div class="text-center text-uppercase">
                    @if ($timeLeft && $timeLeftUnit)
                        <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $timeLeft }} {{ $timeLeftUnit }} left
                    @endif
                </div>
                <div class="">
                    <label class="text-xxs text-uppercase mb-0">Campaign close date</label>
                    <div class="text-xs">{{ $campaign->close_date ? $campaign->close_date->format('m/d/Y') : 'N/A' }}</div>
                </div>
                <div class="close__btn">
                    <div class="btn btn-info btn-inverted text-reg text-uppercase" data-toggle="modal" data-target="#extendDate">
                        Extend Campaign Close Date
                    </div>
                    <div class="modal fade" id="extendDate" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="extendDatePicker" class="js-datepicker" data-input="#extend-date-value"></div>
                                    <div class="mt-2">
                                        {{ Form::open(['route' => ['customer_module_popup', 'payment_details', $campaign->id, 'extend_date']]) }}
                                        {{ Form::hidden('close_date', '', ['id' => 'extend-date-value']) }}
                                        <button class="btn btn-info text-upper text-reg w-100">Update Order Close date</button>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="close__btn">
                    {{ Form::open(['route' => ['customer_module_popup', 'payment_details', $campaign->id, 'close_campaign']]) }}
                    <button type="submit" class="btn btn-info text-reg text-uppercase">Close campaign</button>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    </div>
</div>
