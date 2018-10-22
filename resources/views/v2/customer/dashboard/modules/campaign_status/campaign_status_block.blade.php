<div class="block-info-rounded campaign-header">
    <div class="campaign-header__badge">{{ $campaign->id }}</div>
    <div class="campaign-header__name">{{ $campaign->name }}</div>
    <div class="campaign-header__status"><span>Status:</span> {!! campaign_state_caption($campaign->state, true, $campaign, Auth::user()) !!}</div>
</div>
