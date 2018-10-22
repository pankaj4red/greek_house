@extends('email')

@section('content')
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
        <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;"
                       class="mcnTextContentContainer">
                    <tbody>
                    <tr>
                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px;">
                            Hey {{ $order->contact_first_name }},<br>
                            &nbsp;
                            <div style="text-align: left;"><strong><span
                                            style="font-size:18px">Campaign # - {{ $order->campaign->id }}
                                        - {{ $order->campaign->name }}
                                        Has Been Shipped And Is On The Way To:</span></strong><br>
                                &nbsp;</div>
                            <div>
                                <strong>
                                    {{ $order->getShippingAddress()->line1 }}<br/>
                                    @if ($order->getShippingAddress()->line2)
                                        {{ $order->getShippingAddress()->line2 }}<br/>
                                    @endif
                                    {{ $order->getShippingAddress()->city }}
                                    , {{ $order->getShippingAddress()->zip_code }} {{ $order->getShippingAddress()->state }}
                                    <br/>
                                    {{ country_name($order->getShippingAddress()->country) }}
                                </strong>
                                <br>
                                <strong>{{ $order->getShippingName() }}</strong> will be receiving the order, please
                                reach out to them to ensure you receive your products.<br>
                                <br>
                                @if ($order->scheduled_date)
                                    Your order is expected to arrive
                                    <strong>{{ date('m/d/Y', strtotime($order->campaign->scheduled_date)) }}</strong>,
                                    @if ($order->getTrackingCode())
                                        you can track it by going to the UPS Website and using the following number:
                                        <strong>{{ $order->getTrackingCode() }}</strong>
                                    @endif
                                @else
                                    @if ($order->getTrackingCode())
                                        You can track this order by going to the UPS Website and using the following
                                        number: <strong>{{ $order->getTrackingCode() }}</strong>
                                    @endif
                                @endif
                                <br>
                                <br>
                                We thank you for choosing Greek House!<br>
                                <br>
                                Best,<br>
                                <br>
                                Greek House<br>
                                &nbsp;
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
