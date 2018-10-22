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
                            Hey {{ $campaign->artwork_request->designer ? $campaign->artwork_request->designer->first_name : 'Designer' }},<br>
                            &nbsp;
                            <div style="text-align: left;"><strong><span style="font-size:18px">Revisions Requested for #{{ $campaign->id }}
                                        - {{ $campaign->name }}.</span></strong></div>
                            <div style="text-align: left;"><br
                                        style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <span style="font-family: open sans, helvetica neue, helvetica, arial, sans-serif"><span
                                            style="line-height:23px">In order to keep our promise to the customer, please post revisions within 24 hours.</span></span><br
                                        style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
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
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer"
                       style="border-collapse: separate !important;border: 2px solid #3AA530;border-radius: 5px;background-color: #3AA530;">
                    <tbody>
                    <tr>
                        <td align="center" valign="middle" class="mcnButtonContent"
                            style="font-family: arial, sans-serif; font-size: 16px; padding: 16px;">
                            <a class="mcnButton " title="Go To Order &amp; View Revision Request"
                               href="{{ route('dashboard::details', [$campaign->id], true) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Go
                                To Order &amp; View Revision Request</a>
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
                            <span style="font-family: open sans, helvetica neue, helvetica, arial, sans-serif"><span
                                        style="line-height:23px">The 24 hour turnaround is a competitive advantage Greek House offers against other companies and it is very important we meet go above and beyond to meet this.<br>
                                    <br>
                                    Getting initial proofs back is priority number one but revisions can bottleneck orders and push deadline back so they second most important.</span></span><br>
                            <br>
                            <span style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif; line-height:23px">We understand it is a tight deadline and we thank you in advance for the hard work required to keep the order on track.</span><br>
                            <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif; line-height:23px">Kind regards,</span><br
                                    style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif; line-height:23px">Greek House</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection