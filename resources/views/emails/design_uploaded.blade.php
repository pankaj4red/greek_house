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
                            Hey {{ $campaign->user->first_name }},<br>
                            &nbsp;
                            <div style="text-align: left;"><strong><span style="font-size:18px">A new design has been posted to the Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }}.</span></strong></div>
                            <div style="text-align: center;">&nbsp;</div>
                            <div style="text-align: left;">Please login at Greekhouse.org to approve the design, or
                                request changes.
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
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer"
                       style="border-collapse: separate !important;border: 2px solid #3AA530;border-radius: 5px;background-color: #3AA530;">
                    <tbody>
                    <tr>
                        <td align="center" valign="middle" class="mcnButtonContent"
                            style="font-family: arial, sans-serif; font-size: 16px; padding: 16px;">
                            <a class="mcnButton " title="Login To View Your Design"
                               href="{{ route('dashboard::details', [$campaign->id]) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Login
                                To View Your Design</a>
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
                            <span style="line-height:21px">For any changes, please click the "Make Changes" button and follow&nbsp;</span><br
                                    style="line-height: 21px;">
                            <span style="line-height:21px">the instructions in the numbered list. *DO NOT post revisions in the messages&nbsp;</span><br
                                    style="line-height: 21px;">
                            <span style="line-height:21px">section as the designer will not be notified.*</span><br
                                    style="line-height: 21px;">
                            <br style="line-height: 21px;">
                            <span style="line-height:21px">If you are unsure of how to use the dashboard, you can view step by step&nbsp;</span><br
                                    style="line-height: 21px;">
                            <span style="line-height:21px">instructions on How to Approve a Proof -OR- Request Changes here:&nbsp;</span><a
                                    href="https://www.youtube.com/watch?v=XMjXHb8nCRk" style="line-height: 21px;"
                                    target="_blank">https://www.youtube.com/watch?v=XMjXHb8nCRk</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
