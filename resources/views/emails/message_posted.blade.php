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
                            Hey {{ $notify->first_name }},
                            <div style="text-align: left;"><br
                                        style="color: #2A313A;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height: 23px;">
                                <strong><span style="font-size:18px"><span
                                                style="font-family: open sans, helvetica neue, helvetica, arial, sans-serif"><span
                                                    style="line-height:23px">A new message has been posted to #{{ $campaign->id }}
                                                - {{ $campaign->name }}</span></span></span></strong></div>

                            <div style="text-align: left;"><span style="font-size:18px"><span
                                            style="font-family: open sans, helvetica neue, helvetica, arial, sans-serif"><span
                                                style="line-height:23px"><span
                                                    style="font-size:16px">The {{ $user->type->caption }}
                                                , </span></span></span><span style="font-size:16px"><span
                                                style="font-family:open sans,helvetica neue,helvetica,arial,sans-serif; line-height:23px">{{ $user->first_name }}
                                            said:</span></span></span></div>

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
                                   width="100%"
                                   style="min-width: 100% !important;border: 2px solid #AFCDEC;background-color: #FFFFFF;">
                                <tbody>
                                <tr>
                                    <td valign="top" class="mcnTextContent"
                                        style="color: #616060;font-family: Helvetica, sans-serif;font-size: 14px;font-weight: normal;text-align: center;">
                                        <span style="font-size:16px">{!! process_text($messageText) !!}</span>
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
                            <a class="mcnButton " title="Read &amp; Reply To Message"
                               href="{{ route('dashboard::details', [$campaign->id], true) }}" target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Read
                                &amp; Reply To Message</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection