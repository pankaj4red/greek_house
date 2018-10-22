<ul>
    <li>Campaign: {{ $campaign->id }} - {{ $campaign->name }}</li>
    <li>Old Print Date: {{ date('m/d/Y', strtotime($oldDate)) }}</li>
    <li>New Print Date: {{ date('m/d/Y', strtotime($campaign->printing_date)) }}</li>
    <li>{{ route('dashboard::details', [$campaign->id]) }}</li>
</ul>