@if ($goals)
    <div class="block-info-rounded block-campaign-stats big-paddings">
        <div class="block-info__body">
            <div class="stats__container">
                <div class="stat__block">
                    <div class="stat__title">Current<br>orders</div>
                    <div class="stat__value">{{ $campaign->getCurrentQuantity() }}</div>
                </div>
                @if ($campaign->getNextQuantityGoal())
                    <div class="stat__block">
                        <div class="stat__title">Next<br>goal</div>
                        <div class="stat__value">{{ $campaign->getNextQuantityGoal() }}</div>
                        <div class="stat__tip">Reach This So Your<br>{{ $campaign->getNextGoalText() }}</div>
                    </div>
                @endif
            </div>

            <div class="stats__progress">
                <div class="progress__success" style="width: {{ $campaign->getGoalPercentage() }}%;"></div>
                <div class="progress__point min">
                    <div class="point__dash"></div>
                    <div class="point__title" data-mob="Min 42">Minimum at: {{ $campaign->getMinimumQuantity() }}</div>
                </div>
                <div class="progress__point best">
                    <div class="point__dash"></div>
                    <div class="point__title" data-mob="Best 72">Best price at: {{ $campaign->getMaximumQuantity() }}</div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="block-info-rounded big-paddings block-payment-details">
    <div class="block-info__title">Payment details</div>
    <div class="block-info__body">
        <div class="row payment__buy-now">
            <div class="col-md-9 col-sm-12 payment__btn">
                <a href="{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}" class="gh-btn green w-100 text-center text-reg text-upper" target="_blank">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now
                </a>
            </div>
            <div class="col-md-3 col-sm-12 payment__price-range">
                <div class="">Price range</div>
                <div class="price">{{ quote_range($campaign->quote_low * 1.07, $campaign->quote_high * 1.07, $campaign->quote_final * 1.07) }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-12 payment__share-campaign">
                <label>Share this campaign</label>
                <div class="share__url">{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}</div>
                <div class="share__btn copy-text" data-copy-text=".share__url">Copy url</div>
            </div>
        </div>

        <div class="payment__sizes">
            @foreach ($sizes['sizes'] as $size)
                <div class="payment__size">
                    <div class="size__qty">{{ $size['quantity'] }}</div>
                    <div>{{ $size['short'] }}</div>
                </div>
            @endforeach
            <div class="payment__size total">
                <div class="size__qty">{{ $sizes['total'] }}</div>
                <div>Total</div>
            </div>
            @if ($seePaymentTableView)
                <div class="payment__size view-orders">
                    <a href="{{ route('customer_module_popup', ['payment_details', $campaign->id, 'sales']) }}" class="module-link" data-width="95%">View orders</a>
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </div>
            @endif
        </div>
        @if ($edit)
            <div class="payment__close-date">
                <div class="close__days-left">
                    @if ($timeLeft && $timeLeftUnit)
                        <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $timeLeft }} {{ $timeLeftUnit }} left
                    @endif
                </div>
                <div class="close__date">
                    <label>Campaign close date</label>
                    <div>{{ $campaign->close_date ? $campaign->close_date->format('m/d/Y') : 'N/A' }}</div>
                </div>
                <div class="close__btn">
                    <div class="gh-btn blue-transparent text-reg text-upper btn-short" data-toggle="modal" data-target="#extendDate">
                        Extend Campaign Close Date
                    </div>
                    <div class="modal fade campaign-modal extend-date" id="extendDate" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="extendDatePicker" class="js-datepicker" data-input="#extend-date-value"></div>
                                    <div class="modal__btns">
                                        {{ Form::open(['route' => ['customer_module_popup', 'payment_details', $campaign->id, 'extend_date']]) }}
                                        {{ Form::hidden('close_date', '', ['id' => 'extend-date-value']) }}
                                        <button class="gh-btn blue text-upper text-reg w-100">Update Order Close date</button>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="close__btn">
                    {{ Form::open(['route' => ['customer_module_popup', 'payment_details', $campaign->id, 'close_campaign']]) }}
                    <button type="submit" class="gh-btn blue text-reg text-upper btn-short">Close campaign</button>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    </div>
</div>