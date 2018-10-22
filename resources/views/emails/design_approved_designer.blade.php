Hi,<br/>
{{ $campaign->user->getFullName() }} has approved design for Campaign #{{ $campaign->id }} - {{ $campaign->name }}: <a
        href="{{ route('dashboard::details', [$campaign->id]) }}">Link</a>. Please update your design hours and upload print files to the order page. We appreciate your timely response and awesome work!
<br/>
Thank you,<br/>
Greek House


Customer Name: {{ $campaign->user->getFullName() }};<br/>
Customer Email: {{ $campaign->user->email }};<br/>
Customer Phone: {{ $campaign->user->phone }}<br/>
Campaign # {{ $campaign->id }}<br/>
Campaign Name: {{ $campaign->name }}<br/>
Fraternity/Sorority Name: {{ $campaign->chapter }}<br/>
School Name: {{ $campaign->user->school }};