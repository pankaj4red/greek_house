<?php
/**
 * Created by PhpStorm.
 * User: Asma Shaheen
 * Date: 6/20/2018
 * Time: 12:23 PM
 */
?>

Hi<br><br>
Following are details of Campaign: <br>
Campaign Link: <a href="{{ route('dashboard::details', [$campaign->id]) }}">Link</a>
<br>
@if ($emailType == 'help')
Sizes Collected by Date: {{ \Carbon\Carbon::parse($campaign->sizes_collected_date)->format('m/d/Y')}}<br>
@endif
Delivery Due Date: {{ \Carbon\Carbon::parse($campaign->date)->format('m/d/Y')}}<br>
Embellishment Type: {{($campaign->getCurrentArtwork()->design_type == 'screen')? 'Screen Printing' : 'Embriodery'}}<br>
Product Sku: {{$campaign->product_colors->first()->product->style_number}}<br>
Product Name: {{$campaign->product_colors->first()->product->name}}<br>
Product Color: {{$campaign->product_colors->first()->name }}<br>
Estimated Quantity Range: {{$campaign->estimated_quantity}}<br>
@if ($emailType == 'urgent')
    Customer Shipping Address: {{$campaign->address_line1}} {{$campaign->address_line2}}, {{$campaign->address_city}} {{$campaign->address_state}}, {{$campaign->address_zip_code}}
    {{$campaign->address_stacountry}}<br>
    Customer Phone: {{$campaign->contact_phone}}<br>
@endif

<br>
Thanks,<br>
{{ $campaign->user->getFullName() }}