
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