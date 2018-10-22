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
                            <div style="text-align: left;"><strong><span style="font-size:18px">New Garment&nbsp;Update&nbsp;For Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }}&nbsp;</span></strong><br>
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
                            <a class="mcnButton " title="Login To Dashboard To Review New Garment Information"
                               href="{{ route('dashboard::details', [$campaign->id], true) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Login
                                To Dashboard To Review New Garment Information</a>
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
                            <span style="line-height:21px">The new garment for Campaign # - {{ $campaign->id }}
                                - {{ $campaign->name }} has been updated per your previous request.</span><br>
                            <br>
                            <u style="line-height:21px">Please approve the new garment as soon as possible to ensure
                                the order is accurate and on track.</u>
                            <ul>
                                <li><span style="line-height:21px"><strong>If the garment is correct:</strong>&nbsp;please confirm the new garment&nbsp;on your dashboard.</span><br>
                                    &nbsp;</li>
                                <li><span style="line-height:21px"><strong>If the garment is still incorrect:</strong>&nbsp;please mark the garment as bad and provide very clear and concise reasons for what is wrong and what our fulfillment agent can do to correct the issue.&nbsp;</span>
                                </li>
                            </ul>
                            <span style="line-height:21px">A Greek House fulfillment agent will be notified and work to get you an update as quickly as possible.</span>
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
