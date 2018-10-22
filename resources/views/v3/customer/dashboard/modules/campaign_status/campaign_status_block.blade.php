<div class="card mb-3">
    <div class="card-body">
        <span class="tag tag-campaign-id">{{ $campaign->id }}</span>
        <span class="color-blue text-uppercase ml-3 font-weight-semi-bold">{{ $campaign->name }}</span>
        <span class="pull-right text-uppercase mt-2 color-slate">
            <span class="">Status:</span>
            <span class="">{!! campaign_state_caption($campaign->state, true, $campaign, Auth::user()) !!}</span>
        </span>
    </div>
</div>
