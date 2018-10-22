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
                            Hello {{ $campaign->decorator->first_name }},
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
        <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;"
                       class="mcnTextContentContainer">
                    <tbody>
                    <tr>
                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px;">
                            <div style="text-align: left;"><strong><span style="font-size:18px">New Campaign Submitted Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }}</span></strong><br>
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
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
        <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding: 0 18px 18px;" valign="top" align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonContentContainer"
                       style="border-collapse: separate !important;border: 2px solid #3AA530;border-radius: 5px;background-color: #3AA530;">
                    <tbody>
                    <tr>
                        <td align="center" valign="middle" class="mcnButtonContent"
                            style="font-family: arial, sans-serif; font-size: 16px; padding: 16px;">
                            <a class="mcnButton " title="Login To Dashboard To View Order"
                               href="{{ route('dashboard::details', [$campaign->id], true) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Login
                                To Dashboard To View Order</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
        <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;"
                       class="mcnTextContentContainer">
                    <tbody>
                    <tr>
                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px;">
                            <span style="line-height:21px">Campaign # - {{ $campaign->id }} - {{ $campaign->name }}
                                has been added to your queue. Please go to&nbsp;</span><a
                                    href="{{ route('dashboard::index') }}" style="line-height: 21px;" target="_blank">Greekhouse.org</a><span
                                    style="line-height:21px">&nbsp;and login into your dashboard to view the order.<br>
                            <br>
                            <u>Please approve the art and check in the garments as soon as possible to ensure the order is accurate and on track.</u><br>
                            <br>
                            Here is a short summary of the Campaign:<br>
                            <br>
                            <strong>Campaign Name:</strong> {{ $campaign->id }} - {{ $campaign->name }}<br>
                            <strong>Campaign Due Date:</strong> {{ $campaign->date ? date('m/d/Y', strtotime($campaign->date)) : null }}<br>
                            <strong>Rush Order:</strong> {{ $campaign->rush?'Rush':'Normal' }}<br>
                            <strong>Garment Arrival Date:</strong> {{ date('m/d/Y', strtotime($campaign->garment_arrival_date)) }}
                                <br>
                            <br>
                            <strong>Garment Name:</strong> {{ $campaign->product_colors->first()->product->name }}<br>
                            <strong>Garment Style:</strong> #{{ $campaign->product_colors->first()->product->style_number }}<br>
                            <strong>Garment Color:</strong> {{ $campaign->product_colors->first()->name }}<br>
                            <strong>Number of Garments:</strong> {{ $campaign->getSuccessQuantity() }}<br>
                            <br>
                            <strong>Number of Colors front:</strong> {{ $campaign->artwork_request->designer_colors_front }}<br>
                            <strong>Number of Colors back:</strong> {{ $campaign->artwork_request->designer_colors_back }}<br>
                            <br>
                            <strong>Ship to Address:</strong> {{ $campaign->fulfillment_shipping_line1 }} {{ $campaign->fulfillment_shipping_line2 }}
                                , {{ $campaign->fulfillment_shipping_city }}
                                , {{ $campaign->fulfillment_shipping_zip_code }} {{ $campaign->fulfillment_shipping_state }} {{ country_name($campaign->fulfillment_shipping_country) }}
                                <br>
                            <strong>Group Shipping: </strong> {{ $campaign->shipping_group?'Enabled':'Disabled' }}<br>
                            <strong>Individual Shipping:</strong> {{ $campaign->shipping_individual?'Enabled':'Disabled' }}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
        <tbody class="mcnImageBlockOuter">
        <tr>
            <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                @foreach ($campaign->artwork_request->proofs as $proof)
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0"
                           class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody>
                        <tr>
                            <td class="mcnImageContent" valign="top" style="padding: 0 9px;text-align:center;">
                                <img align="center" alt=""
                                     src="{{ route('system::image', [$proof->file_id], true) }}"
                                     width="564"
                                     style="max-width:600px; padding-bottom: 0; display: inline !important; vertical-align: bottom;"
                                     class="mcnImage">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
        <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;"
                       class="mcnTextContentContainer">
                    <tbody>
                    <tr>
                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px;">
                            If you have any questions or concerns please post them directly to the message board within
                            the order dashboard.<br>
                            <br>
                            For all other questions and inquiry's please send an email to <a
                                    href="mailto:Decorators@Greekhouse.org" target="_blank">Decorators@Greekhouse
                                .org</a> to receive a quick response.<br>
                            <br>
                            Thank you in advance for your hard work and dedication on delivering a quality product.<br>
                            <br>
                            Best,<br>
                            <br>
                            Greek House<br>
                            Fulfillment Team<br>
                            <a href="http://Decorators@Greekhouse.org" target="_blank">Decorators@Greekhouse.org</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
