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
                            <div style="text-align: left;"><strong><span
                                            style="font-size:18px">Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }} Is Set To Close In 24 Hours.</span></strong></div>
                            <div style="text-align: left;"><br
                                        style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Please make&nbsp;</span><span
                                        style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">sure to double check on Order Quantities &amp; Print Files/Order Form</span><br
                                        style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
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
                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer"
                       style="border-collapse: separate !important;border: 2px solid #3AA530;border-radius: 5px;background-color: #3AA530;">
                    <tbody>
                    <tr>
                        <td align="center" valign="middle" class="mcnButtonContent"
                            style="font-family: arial, sans-serif; font-size: 16px; padding: 16px;">
                            <a class="mcnButton " title="Go To Order To Check Quantities &amp; Upload Forms"
                               href="{{ route('dashboard::details', [$campaign->id]) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Go
                                To Order To Check Quantities &amp; Upload Forms</a>
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
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Thank you in advance, we appreciate all your hard work!</span><br
                                    style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Kind regards,</span><br
                                    style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Greek House</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
