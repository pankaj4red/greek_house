@extends('email')

@section('content')
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
        <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                    <tr>
                <![endif]-->

                <!--[if mso]>
                <td valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;"
                       width="100%" class="mcnTextContentContainer">
                    <tbody>
                    <tr>

                        <td valign="top" class="mcnTextContent"
                            style="padding: 0 18px 9px;">

                            Hey {{ $campaign->user->first_name }},<br>
                            &nbsp;
                            <div style="text-align: left;"><strong><span style="font-size:18px">URGENT - Follow Instructions&nbsp;to Keep Your Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }} On Track&nbsp;</span></strong></div>

                            <div style="text-align: left;"><br>
                                Your order is currently set to close on&nbsp;<strong><span
                                            style="color:#FF0000">{{ date('m/d/Y', strtotime($campaign->close_date)) }}</span>.
                                </strong>In order for us to process the order on this date&nbsp;the following actions
                                must be met:
                            </div>
                            <ul>
                                <li style="text-align: left;">Days left to Collect all sizes and payments: <span
                                            style="color:#FF0000"><strong>{{ $daysUntilPaymentClose }}</strong></span>
                                </li>
                                <li style="text-align: left;">Current number of shirts purchased: <span
                                            style="color:#FF0000"><strong>{{ $campaign->getSuccessQuantity() + $campaign->getAuthorizedQuantity() }}</strong></span>
                                </li>
                                <li style="text-align: left;">Minimum Number of shirts to be purchased: <span
                                            style="color:#FF0000"><strong>{{ $campaign->getMinimumQuantity() }}</strong></span>
                                </li>
                                <li style="text-align: left;">Additional shirts&nbsp;needed to meet minimum estimated
                                    qty: <span style="color:#FF0000"><strong>{{ $campaign->getQuantityLeft() }}</strong></span>
                                </li>
                            </ul>

                            <div style="text-align: left;">If you do not meet the minimum estimated quantity for this
                                order then we cannot close the order on the selected date.
                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]>
                </td>
                <![endif]-->

                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
        <tbody class="mcnButtonBlockOuter">
        <tr>
            <td style="padding: 0 18px 18px;" valign="top"
                align="center" class="mcnButtonBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer"
                       style="border-collapse: separate !important;border: 2px solid #3AA530;border-radius: 5px;background-color: #3AA530;">
                    <tbody>
                    <tr>
                        <td align="center" valign="middle" class="mcnButtonContent"
                            style="font-family: arial, sans-serif; font-size: 16px; padding: 16px;">
                            <a class="mcnButton " title="Log Into Your Account &amp; View Campaign"
                               href="{{ route('dashboard::details', [$campaign->id]) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Log
                                Into Your Account &amp; View Campaign</a>
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
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                    <tr>
                <![endif]-->

                <!--[if mso]>
                <td valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;"
                       width="100%" class="mcnTextContentContainer">
                    <tbody>
                    <tr>

                        <td valign="top" class="mcnTextContent"
                            style="padding: 0 18px 9px;">

                            If you have any questions or need assistance with your order please email support@greekhouse
                            .org or text our support line at 424-326-3375.<br>
                            <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif; line-height:23px">Kind regards,</span><br
                                    style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif; line-height:23px">Greek House</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!--[if mso]>
                </td>
                <![endif]-->

                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
@endsection
