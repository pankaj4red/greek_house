<h1>Fulfillment Details</h1><br/>
<strong>Campaign Information:</strong><br/>
Campaign #: {{ $campaign->id }}<br/>
Order Name: {{ $campaign->name }}<br/>
Client: {{ $campaign->user?$campaign->user->getFullName():'N/A' }}<br/>
Designer:
@if ($campaign->artwork_request->designer)
    <a href="mailto:{{ $campaign->artwork_request->designer->email }}">{{ $campaign->artwork_request->designer->email }}</a><br/>
@else
    N/A<br/>
@endif
<br/>
<strong>Garment Information:</strong><br/>
@if ($campaign->product_colors->first()->product)
    Garment Name: {{ $campaign->product_colors->first()->product->style_number }} - {{ $campaign->product_colors->first()->product->name }}<br/>
    Garment Type: {{ $campaign->product_colors->first()->product->category->name }}<br/>
    Garment Brand: {{ $campaign->product_colors->first()->product->brand->name }}<br/>
    Garment Style #: {{ $campaign->product_colors->first()->product->style_number }}<br/>
@else
    Garment Name: N/A<br/>
    Garment Type: N/A<br/>
    Garment Style #: N/A<br/>
@endif
@if (product_color($campaign->product_colors->first()->id))
    Garment Color: {{ $campaign->product_colors->first()->name }}<br/>
@else
    Garment Color: N/A<br/>
@endif
Type of Embellishment: {{ $campaign->getCurrentArtwork()->design_type }}<br/>
@if ($campaign->notes)
    <br/><strong>Notes:</strong><br/>
    {!! process_text($campaign->notes) !!}
@endif
<br/><br/>
<strong>Color Information:</strong><br/>
Colors on the Front: {{ $campaign->artwork_request->designer_colors_front }}<br/>
Colors on the Back: {{ $campaign->artwork_request->designer_colors_back }}<br/>
<br/>
<strong>Customer Information:</strong><br/>
Customer Email: {{ $campaign->contact_email }}<br/>
Customer Phone: {{ $campaign->contact_phone }}<br/>
Fraternity/Sorority Name: {{ $campaign->contact_chapter }}<br/>
School Name: {{ $campaign->contact_school }}<br/>
Shipping Address Line 1: {{ $campaign->address_line1 }}<br/>
Shipping Address Line 2: {{ $campaign->address_line2 }}<br/>
Shipping City: {{ $campaign->address_city }}<br/>
Shipping State: {{ $campaign->address_state }}<br/>
Shipping Zip Code: {{ $campaign->address_zip_code }}<br/>
Shipping Country: {{ country_name($campaign->address_country) }}<br/>
Group Shipping: {{ $campaign->shipping_group?'Allowed':'Not Allowed' }}<br/>
Individual Shipping: {{ $campaign->shipping_individual?'Allowed':'Not Allowed' }}<br/>
@if ($hasIndividual)
    <strong>This campaign has individual orders.</strong><br/>
@endif
<br/>
<strong>Due By:</strong><br/>
Shirt in hand date: {{ $campaign->scheduled_date ? date('m/d/Y', strtotime($campaign->scheduled_date)) : ($campaign->date ? date('m/d/Y', strtotime($campaign->date)) : null) }}
<br/>
Exact Date/Flexible: {{ $campaign->flexible=='yes'?'Yes':'No' }}<br/>
<br/>
Payment Closed Date: {{ $campaign->close_date ? date('m/d/Y', strtotime($campaign->close_date)) : '' }}<br/>
<br/>
Quantity of estimated shirts: {{ $campaign->estimated_quantity }}<br/>
Quantity of shirts ordered: {{ $total }}<br/>
@foreach ($sizes as $short => $quantity)
    {{ $short }}: {{ $quantity }}<br/>
@endforeach

