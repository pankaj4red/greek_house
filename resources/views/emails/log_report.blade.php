<style>
    #report-table {
        width: 100%;
        border: 1px solid #333333;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #333;
        border-spacing: 0;
    }

    #report-table > thead > tr:first-child {
        border-bottom: 1px solid #333333;
        background-color: #E85039 !important;
    }

    #report-table > thead > tr:last-child {
        border-bottom: 1px solid #333333;
        background-color: #F28071 !important;
    }

    #report-table > thead > tr:first-child th {
        color: white;
        text-align: center;
    }

    #report-table > tbody > tr:nth-child(4n+1), #report-table > tbody > tr:nth-child(4n+2) {
        background-color: #FFFFFF;
    }

    #report-table > tbody > tr:nth-child(4n+3), #report-table > tbody > tr:nth-child(4n+4) {
        background-color: #EEEEEE;
    }

    #report-table .log-list tr:nth-child(even) {
        background-color: #EEEEEE;
    }

    #report-table .log-list tr:nth-child(odd) {
        background-color: #FFFFFF;
    }

    #report-table th, #report-table td {
        padding: 10px;
        vertical-align: top;
    }

    #report-table tr td {
        text-align: left;
        padding-left: 10px;
    }

    #report-table tr th.level {
        width: 10%;
    }

    #report-table tr th.message {
        width: 50%;
    }

    #report-table tr th.method {
        width: 30%;
    }

    #report-table tr th.count {
        width: 10%;
    }

    #report-table .log-list {
        width: 100%;
        border: 1px solid #333333;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #333;
        border-spacing: 0;
        table-layout: fixed;
        margin-bottom: 30px;
    }

    #report-table .log-list td, #report-table .log-list th {
        text-align: left;
    }

    .log-list-wrapper {
        display: none;
        height: 0;
        overflow: hidden;
    }

    #report-table .log-list-wrapper:target {
        display: table;
        height: auto;
        margin-top: -50px;
        padding-top: 50px;
    }
</style>
<table id="report-table"
       style="width: 100% !important; border: 1px solid #333333 !important; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif !important; font-size: 14px !important; color: #333 !important; border-spacing: 0 !important;">
    <thead>
    <tr style="border-bottom: 1px solid #333333 !important; background-color: #E85039 !important;">
        <th colspan="4" style="color: white !important; text-align: center !important;">Daily Log Report</th>
    </tr>
    <tr style="border-bottom: 1px solid #333333 !important; background-color: #F28071 !important;">
        <th class="level">Level</th>
        <th class="message">Message</th>
        <th class="method">Method</th>
        <th class="count">Count</th>
    </tr>
    </thead>
    <tbody>
    @if (count($logs) > 0)
        @foreach ($logs as $log)
            <?php $id = uniqid() ?>
            <tr>
                <td class="level"
                    style="padding: 10px !important; width: 10% !important; text-align: left !important;">{{ $log['level'] }}</td>
                <td class="message"
                    style="padding: 10px !important; width: 50% !important; text-align: left !important;">{{ mb_substr($log['message'], 0, 250) }}</td>
                <td class="method"
                    style="padding: 10px !important; width: 30% !important; text-align: left !important;">{{ $log['method'] }}</td>
                <td class="count"
                    style="padding: 10px !important; width: 10% !important; text-align: left !important;">{{ $log['counting'] }}</td>
            </tr>
            <tr>
                <td class="list" colspan="4" style="border-bottom: 1px solid #333333 !important;">
                    <div class="log-list-wrapper" id="{{ $id }}">
                        <table class="log-list"
                               style="margin-left: auto !important; margin-right: auto !important; width: 80% !important; border-top: 1px solid #333333 !important; border-left: 1px solid #333333 !important; border-right: 1px solid #333333 !important; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif !important; font-size: 14px !important; color: #333 !important; border-spacing: 0 !important; margin-bottom: 30px !important;">
                            <tbody>
                            <tr style="background-color: #F28071 !important;">
                                <th style="border-bottom: 1px solid #333333 !important; font-size: 10px !important; width: 50% !important; text-align: left !important;">
                                    URL
                                </th>
                                <th style="border-bottom: 1px solid #333333 !important; font-size: 10px !important; width: 10% !important; text-align: left !important;">
                                    User
                                </th>
                                <th style="border-bottom: 1px solid #333333 !important; font-size: 10px !important; width: 20% !important; text-align: left !important;">
                                    IP
                                </th>
                                <th style="border-bottom: 1px solid #333333 !important; font-size: 10px !important; width: 20% !important; text-align: left !important;">
                                    Time
                                </th>
                            </tr>
                            @foreach ($log->entries as $entry)
                                @if ($entry->method == 'CheckoutController::postValidateAuthorizePost' && isset(json_decode($entry->context)->log_information) && !empty(json_decode($entry->context)->log_information))
                                    <tr class="entryrow">
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">{{ isset(json_decode($entry->extra)->url) ? json_decode($entry->extra)->url : '-'  }}</td>
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">
                                            [{{ isset(json_decode($entry->context)->log_information->user_id) ? json_decode($entry->context)->log_information->user_id : 0 }}
                                            ] {{ isset(json_decode($entry->context)->log_information->username) ? json_decode($entry->context)->log_information->username : 'anonymous' }}</td>
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">{{ isset(json_decode($entry->context)->log_information->ip) ? json_decode($entry->context)->log_information->ip : 'N/A' }}</td>
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">{{ date('m/d/Y H:i:s', strtotime($entry->created_at)) }}</td>
                                    </tr>
                                    <tr class="entryrow">
                                        <td style="border-bottom: 1px solid #333333 !important; font-size: 10px !important;"
                                            colspan="4">
                                                <span style="padding-right: 20px !important; display: inline-block !important; text-align: center !important">
                                                    <strong>HW: </strong>{{ isset(json_decode($entry->context)->log_information->hardware) ? json_decode($entry->context)->log_information->hardware : 'N/A' }}
                                                </span>
                                            <span style="padding-right: 20px !important; display: inline-block !important; text-align: center !important">
                                                    <strong>OS: </strong>{{ isset(json_decode($entry->context)->log_information->os) ? json_decode($entry->context)->log_information->os : 'N/A' }}
                                                </span>
                                            <span style="padding-right: 20px !important; display: inline-block !important; text-align: center !important">
                                                    <strong>Browser: </strong>{{ isset(json_decode($entry->context)->log_information->browser) ? json_decode($entry->context)->log_information->browser : 'N/A' }}
                                                </span>
                                        </td>
                                    </tr>
                                @else
                                    <tr class="entryrow">
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">{{ isset(json_decode($entry->extra)->url) ? json_decode($entry->extra)->url : '-'  }}</td>
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">
                                            [{{ $entry->user_id }}] {{ $entry->username }}</td>
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">{{ $entry->ip }}</td>
                                        <td style="border-bottom: 1px solid #f2f2f2 !important; font-size: 10px !important;">{{ date('m/d/Y H:i:s', strtotime($entry->created_at)) }}</td>
                                    </tr>
                                    <tr class="entryrow">
                                        <td style="border-bottom: 1px solid #333333 !important; font-size: 10px !important;"
                                            colspan="4">
                                                <span style="padding-right: 20px !important; display: inline-block !important; text-align: center !important">
                                                    <strong>HW: </strong>{{ isset(json_decode($entry->extra)->hardware) ? json_decode($entry->extra)->hardware : 'N/A' }}
                                                </span>
                                            <span style="padding-right: 20px !important; display: inline-block !important; text-align: center !important">
                                                    <strong>OS: </strong>{{ isset(json_decode($entry->extra)->os) ? json_decode($entry->extra)->os : 'N/A' }}
                                                </span>
                                            <span style="padding-right: 20px !important; display: inline-block !important; text-align: center !important">
                                                    <strong>Browser: </strong>{{ isset(json_decode($entry->extra)->browser) ? json_decode($entry->extra)->browser : 'N/A' }}
                                                </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td class="level" style="text-align: center !important" colspan="4">Nothing to show here :)</td>
        </tr>
    @endif
    </tbody>
</table>
