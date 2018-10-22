<?php

namespace App\Http\Controllers\Helpers;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function __construct()
    {
        if (App::environment() == 'production') {
            abort(404);
        }
        parent::__construct();
    }

    public function getColumn()
    {
        return view('helpers.column');
    }

    public function postColumn(Request $request)
    {
        form($request)->validate([
            'column' => 'required|integer',
            'text'   => 'required',
        ]);

        $column = $request->get('column');
        $text = $request->get('text');

        $text = str_replace("\r", "", $text);
        $lines = array_values(array_filter(explode("\n", $text)));
        $values = [];

        foreach ($lines as $line) {
            $columns = array_values(array_filter(explode('|', $line)));
            if (array_key_exists((int) $column, $columns)) {
                $values[] = trim($columns[$column]);
            } else {
                $values[] = '';
            }
        }

        $valueList = implode(', ', $values);
        $log = 'select logs.* from logs inner join log_details on logs.id = log_details.log_id where logs.id in ('.$valueList.') and log_details.`key` = "campaign.id" and log_details.`value` = "12345"';

        return form()->success($valueList)->success($log)->back();
    }
}
