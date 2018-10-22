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
                            Hello Support,
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
                            <div style="text-align: left;"><strong><span style="font-size:18px">New Message Posted To&nbsp;Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }}&nbsp;</span></strong></div>
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
                            {{ $sender->getFullName() }} has sent the following message for <span
                                    style="line-height:21px">Campaign # - {{ $campaign->id }}
                                - {{ $campaign->name }}</span>:<br>
                            <br>
                            &nbsp;
                            <div style="text-align: center;">{!! process_text($messageText) !!}</div>
                            <div style="text-align: left;">&nbsp;</div>
                            <br>
                            Please login to your order dashboard to respond in a timely manner.
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
                            <a class="mcnButton " title="Login To Dashboard To View Message &amp; Reply"
                               href="{{ route('dashboard::details', [$campaign->id], true) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Login
                                To Dashboard To View Message &amp; Reply</a>
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
