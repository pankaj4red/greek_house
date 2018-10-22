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
                            <div style="text-align: left;"><strong><span style="font-size:18px">A New Quote&nbsp;Has Been Posted To The Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }}.</span></strong></div>
                            <div style="text-align: center;">&nbsp;</div>
                            <div style="text-align: left;"><span
                                        style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">You're ready for payment, the order: {{ $campaign->name }}
                                    &nbsp;has </span><span
                                        style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">been quoted based on the estimated quantity you've provided.</span><br>
                                <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">The payment link is now live and will remain open for 72 hours.</span><br>
                                <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Be sure to send out the payment link right away and let everyone know they&nbsp;</span><span
                                        style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">need to get their orders in on time. To send a link for Individual Payment to&nbsp;</span><span
                                        style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">your members, use the following link:</span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
        <tbody class="mcnBoxedTextBlockOuter">
        <tr>
            <td valign="top" class="mcnBoxedTextBlockInner">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;"
                       class="mcnBoxedTextContentContainer">
                    <tbody>
                    <tr>
                        <td style="padding: 9px 18px;">
                            <table border="0" cellpadding="18" cellspacing="0" class="mcnTextContentContainer"
                                   width="100%" style="min-width: 100% !important;background-color: #5EAC15;">
                                <tbody>
                                <tr>
                                    <td valign="top" class="mcnTextContent"
                                        style="color: #F2F2F2;font-family: Helvetica, sans-serif;font-size: 14px;font-weight: normal;text-align: center;">
                                        SEND THIS LINK OUT TO YOUR CHAPTER:<br>
                                        <span style="color:#0000CD">{{ route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]) }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">If you'd like to pay for all the garments in bulk, please select the 'Group&nbsp;</span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Payment' option on the Order Page.</span><br>
                            <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">If you need to extend the order beyond the 72 hour period you can do so from&nbsp;</span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">the order page. Please note that extending the close date will also increase&nbsp;</span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">the turnaround time.</span><br>
                            <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">The estimated turnaround time is 10-12 business days from the time the order </span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">closes. This is subject to change due to the availability of garments and&nbsp;</span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">shipping constraints.</span><br>
                            <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">You can also view Step by Step directions on Completing Payment &amp; Closing&nbsp;</span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">orders in this video:&nbsp;</span><a
                                    href="https://www.youtube.com/watch?v=L77iELm5dNc" target="_blank">https://www.youtube.com/watch?v=L77iELm5dNc</a><br>
                            <br>
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Lastly, please keep in mind that once an order closes there cannot be ANY&nbsp;</span><span
                                    style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">changes so make sure everyone gets their orders in early!</span><br>
                            <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                            <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Best,</span><br
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
