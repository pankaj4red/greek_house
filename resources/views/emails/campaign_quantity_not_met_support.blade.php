<a href="{{ route('dashboard::details', [$campaign->id]) }}">Campaign # {{ $campaign->id }}
    - {{ $campaign->name }}</a> did not reach the estimated quantity. Order details are below:<br/>
Estimated Quantity: {{ $campaign->estimated_quantity }}<br/>
Total Quantity Ordered: {{ $total }}<br/>
Garment Style #: {{ $campaign->product_colors->first()->product->style_number }}<br/>
Garment Color: {{ $campaign->product_colors->first()->pivot->name }}<br/>
# of Design Hours: {{ to_hours($campaign->artwork_request->design_minutes) }}<br/>
# of Colors on Front: {{ $campaign->getCurrentArtwork()->designer_colors_front }}<br/>
# of Colors on Back: {{ $campaign->getCurrentArtwork()->designer_colors_back }}<br/>

