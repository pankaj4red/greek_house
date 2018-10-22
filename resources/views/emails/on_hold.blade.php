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
                            <div style="text-align: left;"><strong><span style="font-size:18px">Thanks for placing a design request with Greek House :)</span></strong></div>
                            <div style="text-align: center;">&nbsp;</div>
                            <div style="text-align: left;"><span
                                        style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Your campaign is currently being reviewed by our team before we push this for one of
our designers to grab. A member on our team may reach out for additional information before we proceed with a custom design.</span><br>
                                <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">If you have any questions or concerns, feel free to message us below :)</span><br>
                                <br style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Best,</span><br
                                        style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <span style="color: #2A313A;font-family: open sans,helvetica neue,helvetica,arial,sans-serif;line-height: 23px;">Greek House</span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
