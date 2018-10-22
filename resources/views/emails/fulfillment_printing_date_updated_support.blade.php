@if ($oldPrintingDate)
    Old Print Date: {{ \Carbon\Carbon::parse($oldPrintingDate)->format('m/d/Y') }}<br/>
@endif
New Print Date: {{ $campaign->printing_date->format('m/d/Y') }}<br/>
