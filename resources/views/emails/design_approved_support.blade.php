Hi,<br/>
{{ $campaign->user->getFullName() }} has approved design for Campaign #{{ $campaign->id }} - {{ $campaign->name }}: <a
        href="{{ route('dashboard::details', [$campaign->id]) }}">Link</a>. Please submit quote to customer & submit order to royalties.
<br/>
We appreciate your timely response and awesome work!<br/>
Thank you,<br/>
Greek House
