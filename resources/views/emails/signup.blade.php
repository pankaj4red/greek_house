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
                            Welcome {{ $user->first_name }},<br/>
                            <br/>
                            <strong><span
                                        style="font-size:18px">Thanks for registering with Greek House. </span></strong><br/>
                            <br/>
                            You are just a few clicks away from getting awesome shirts!&nbsp;<br/>
                            &nbsp;
                            <div style="text-align: center;"><span
                                        style="color: #FF0000;line-height: 21px;text-align: center;">(You can only click the link once!)</span>
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
                            <a class="mcnButton " title="Click Here To Access your Dashboard"
                               href="{{ route('dashboard::index') }}"
                               target="_blank"
                               style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #F1F1F1;">Click Here To Access your Dashboard</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
        <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%"
                       style="min-width: 100%;border-top: 2px solid #EAEAEA;">
                    <tbody>
                    <tr>
                        <td>
                            <span></span>
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
                            <p style="line-height: 21px; text-align: center;"><span
                                        style="font-size:18px"><strong>Save These For Your Records:</strong></span><br>
                                <br>
                                <span style="color:#000000"><span style="font-size:18px"><strong>Your Greek House Username is:</strong></span></span><br>
                                <span style="color:#008000"><span
                                            style="font-size:15px">{{ $user->username }}</span></span><br>
                                <br>
                                <span style="color:#000000"><span
                                            style="font-size:18px"><strong>Your Password is:</strong></span></span><br>
                                <span style="font-size:15px"><span style="color:#0000CD">&lt;encrypted&gt;</span></span>
                            </p>
                            <blockquote
                                    style="color: #222222;font-family: arial, sans-serif;font-size: 13px;line-height: normal;"
                                    type="cite">
                                <p>
                                    <br>
                                    Once you activate your account, you can sign in at&nbsp;<a
                                            href="http://greekhouse.org/" target="_blank">http://greekhouse.org/</a>.&nbsp;<br>
                                    <br>
                                    Having issues navigating the website and dashboard? Check out these&nbsp;awesome
                                    videos to help you get started!
                                </p>
                                <ol>
                                    <li>Placing an order:&nbsp;<a href="https://www.youtube.com/watch?v=6hXbuqv9aWY"
                                                                  target="_blank">https://www.youtube.com/watch?v=6hXbuqv9aWY</a><br>
                                        &nbsp;</li>
                                    <li>Approving a Proof &amp; Requesting Revisions:<span
                                                style="color: #333333;font-family: arial,verdana,sans-serif;font-size: 13px;line-height: 1.6em;">&nbsp;</span><a
                                                href="https://www.youtube.com/watch?v=XMjXHb8nCRk"
                                                style="font-family: Arial, Verdana, sans-serif; font-size: 13px; line-height: 1.6em;"
                                                target="_blank">https://www.youtube.com/watch?v=XMjXHb8nCRk</a><br>
                                        &nbsp;</li>
                                    <li>Completing Payment &amp; Closing an Order:<span
                                                style="color: #333333;font-family: arial,verdana,sans-serif;font-size: 13px;line-height: 1.6em;">&nbsp;</span><a
                                                href="https://www.youtube.com/watch?v=L77iELm5dNc"
                                                style="font-family: Arial, Verdana, sans-serif; font-size: 13px; line-height: 1.6em;"
                                                target="_blank">https://www.youtube.com/watch?v=L77iELm5dNc</a></li>
                                </ol>
                                <p>
                                    <br>
                                    Have questions? <a href="http://greekhouse.desk.com" target="_blank">Get
                                        Support,</a> or email us at <a href="mailto:Support@Greekhouse.org"
                                                                       target="_blank">support@greekhouse.org</a>.&nbsp;<br>
                                    <br>
                                    --Greek House Team
                                </p>
                            </blockquote>
                            <div>
                                <p>&nbsp;</p>
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
