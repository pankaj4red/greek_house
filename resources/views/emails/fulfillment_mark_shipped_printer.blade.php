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

                            <div style="text-align: left;"><strong><span
                                            style="font-size:18px">Please Mark Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }} As Shipped.</span></strong><br>
                                &nbsp;</div>
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
                            <a class="mcnButton " title="Login To Dashboard To Mark Campaign As Shipped"
                               href="{{ route('dashboard::details', [$campaign->id], true) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Login
                                To Dashboard To Mark Campaign As Shipped</a>
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
                            The estimated ship date for this order was set
                            for {{ date('m/d/Y', strtotime($campaign->printing_date)) }} but the order has not been
                            marked as shipped yet.<br>
                            <br>
                            <u style="line-height:21px">Please mark the campaign as shipped and enter the tracking
                                code as soon as you can to ensure the order is accurate and on track.</u>
                            <ul>
                                <li><span style="line-height:21px"><strong>If the ship campaign did not ship:</strong>&nbsp;please update the website with the new shipdate along with a reason so we can inform our customers of the change.</span><br>
                                    &nbsp;</li>
                                <li><strong>If there is a problem:</strong> preventing the campaign from shipping please
                                    post the reason to the message board asap.
                                </li>
                            </ul>
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
