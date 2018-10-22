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
                            <div style="text-align: left;"><strong><span style="font-size:18px">Thank You For Your Purchase! Your Order ID Is: {{ $order->id }}
                                        &nbsp;</span></strong></div>
                            <div>
                                <br>
                                Once the order link closes, you can expect your order to arrive within 10-12 business
                                days.<br>
                                <br>
                                If you have any questions in regards to this order please email Support@Greekhouse.org
                                and include this Number: {{ $order->id }}. Be sure to include your full name and email
                                that you used when purchasing the order.<br/>
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
