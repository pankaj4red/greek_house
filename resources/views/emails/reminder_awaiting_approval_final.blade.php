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
                            <div style="text-align: left;"><strong><span style="font-size:18px">FINAL REMINDER - The Design&nbsp;For&nbsp;Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }} Still Needs Your Approval.</span></strong></div>

                            <div style="text-align: left;"><br
                                        style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                @if ($campaign->awaiting_approval_at)
                                    <span style="font-family: open sans, helvetica neue, helvetica, arial, sans-serif"><span
                                                style="line-height:23px">It has been <span
                                                    style="color:#FF0000"><u><strong>{{ $daysSinceAwaitingApproval }}
                                                        &nbsp;days</strong></u>&nbsp;</span>since the designer has uploaded a proof for this order and we still have not heard from you :(<br>
                                    <br>
                                            @endif
                                            Please log in at your earliest convenience to approve the design&nbsp;or request revisions.</span></span>
                                    <br>
                                    <br>
                                    <u>If we do not hear from you soon, someone from our support team will give you a
                                        call to provide any help you may need.</u></div>

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
                            <a class="mcnButton " title="Go To Order &amp; Approve Design"
                               href="{{ route('dashboard::details', [$campaign->id]) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Go
                                To Order &amp; Approve Design</a>
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

                            <span style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif; line-height:23px">If you are unsure of how to do so you can view this video on </span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;"><a
                                        href="https://www.youtube.com/watch?v=XMjXHb8nCRk" target="_blank">How to Approve a Proof &amp; Request Revisions.</a></span><br>
                            <br>
                            The sooner you approve the proof the sooner we can get you your shirts so be sure to act
                            quickly!<br
                                    style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
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
