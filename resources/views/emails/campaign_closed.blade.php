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
                            <div style="text-align: left;"><strong><span
                                            style="font-size:18px">Campaign # - {{ $campaign->id }}
                                        - {{ $campaign->name }} Has Been Closed And Is Being Processed.</span></strong>
                            </div>
                            <div>
                                <br>
                                Your Order is estimated to arrive between
                                <u><strong>{{ date('m/d/Y', strtotime($campaign->close_date) + (14 * 24 * 60 * 60)) }}</strong></u>
                                and
                                <u><strong>{{ date('m/d/Y', strtotime($campaign->close_date) + (20 * 24 * 60 * 60)) }}</strong></u><br>
                                <br>
                                We'll send you a notice with tracking info once your order has shipped. If you ordered
                                multiple items, they may come in separate shipments.<br>
                                <br>
                                If garments are out of stock, you will be contacted within 24 hours. Turnaround times
                                may vary and are based on availability of the garments and shipping constraints<br>
                                <br>
                                If you have any questions, please contact support@greekhouse.org. We're here to
                                help!<br>
                                <br>
                                Best,<br>
                                Greek House Team<br>
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
@endsection
