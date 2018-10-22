<style>
    #report-table {
        width: 100% !important;
        border: 1px solid #333333;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #333;
        border-spacing: 0;
    }

    #report-table tr:first-child {
        background-color: #ff5050;
        color: white;
    }

    #report-table tr > * {
        border-bottom: 1px solid #333333;
    }

    #report-table tr:last-child > * {
        border-bottom: 0;
    }

    #report-table tr:first-child th {
        width: 100%;
        text-align: center;
    }

    #report-table th, #report-table td {
        padding: 10px;
        vertical-align: top;
    }

    #report-table tr th {
        width: 33%;
        text-align: right;
        padding-right: 10px;
    }

    #report-table tr td {
        padding-left: 10px;
        width: 66%;
    }

</style>
<table id="report-table"
       style="width:100% !important; color: #333 !important; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif !important; font-size: 14px !important; border: 1px solid #333333 !important; border-spacing: 0 !important;">
    <tr>
        <th colspan="2" style="background-color: #ff5050 !important; color: #ffffff !important;">Alert Report</th>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; border-bottom: 1px solid #333333 !important; text-align: right !important;">
            Level
        </th>
        <td style="border-bottom: 1px solid #333333 !important; padding-left: 10px;">{{ $record['level'] }}</td>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; border-bottom: 1px solid #333333 !important; text-align: right !important;">
            Channel
        </th>
        <td style="border-bottom: 1px solid #333333 !important; padding-left: 10px;">{{ $record['channel'] }}</td>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; border-bottom: 1px solid #333333 !important; text-align: right !important;">
            Message
        </th>
        <td style="border-bottom: 1px solid #333333 !important; padding-left: 10px;">{{ $record['message'] }}</td>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; border-bottom: 1px solid #333333 !important; text-align: right !important;">
            File & File
        </th>
        <td style="border-bottom: 1px solid #333333 !important; padding-left: 10px;">{{ $record['context']['file'] ?? 'N/A' }}:{{ $record['context']['line'] ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; border-bottom: 1px solid #333333 !important; text-align: right !important;">
            Method
        </th>
        <td style="border-bottom: 1px solid #333333 !important; padding-left: 10px;">{{ $record['context']['method'] }} <?php /** @var array $record */ print_r($record['context']['args'], true) ?></td>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; border-bottom: 1px solid #333333 !important; text-align: right !important;">
            User Information
        </th>
        <td style="border-bottom: 1px solid #333333 !important; padding-left: 10px;">
            {{ $record['extra']['user_id'] }}
            {{ $record['extra']['username'] }}
            {{ $record['extra']['ip'] }}
            {{ $record['extra']['hardware'] }}
            {{ $record['extra']['os'] }}
            {{ $record['extra']['browser'] }}
        </td>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; border-bottom: 1px solid #333333 !important; text-align: right !important;">
            Context
        </th>
        <td style="border-bottom: 1px solid #333333 !important; padding-left: 10px;">
            <pre><?php print_r(array_except($record['context'], ['args', 'method', 'function', 'stack']), true) ?></pre>
        </td>
    </tr>
    <tr>
        <th style="vertical-align: top !important; padding: 10px !important; text-align: right !important;">Stack</th>
        <td style="padding-left: 10px;">
            <pre>{{ $record['context']['stack'] }}</pre>
        </td>
    </tr>
</table>
