<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class LogController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:is_admin');
    }

    public function getList(Request $request)
    {
        $query = DB::connection('logs')->table('logs')->orderBy('id', 'desc');
        foreach ($request->all() as $key => $value) {
            if (! is_null($value) && $value !== '') {
                if (in_array($key, ['id', 'channel', 'level', 'ip'])) {
                    $query->where($key, $value);
                    continue;
                }
                if ($key == 'user_id') {
                    if ($value == 'null') {
                        $query->whereIsNull($key);
                        continue;
                    } else {
                        $query->where($key, $value);
                        continue;
                    }
                }
                if ($key == 'time_from') {
                    $query->where('created_at', '>=', $value);
                    continue;
                }
                if ($key == 'time_to') {
                    $query->where('created_at', '<=', $value);
                    continue;
                }
                if ($key == 'message') {
                    $query->where('message', 'like', '%'.$value.'%');
                    continue;
                }
                if ($key == 'campaign') {
                    $query->where(function ($query2) use ($value) {
                        /** @var Builder $query2 */
                        $query2->whereExists(function ($query3) use ($value) {
                            /** @var Builder $query3 */
                            $query3->select(DB::raw(1))->from('log_details')->whereRaw('log_details.log_id = logs.id')->where('key', 'campaign.id')->where('value', $value);
                        });
                        $query2->orWhere('message', 'like', '%'.$value.'%');
                    });
                }
                if ($key == 'order') {
                    $query->where(function ($query2) use ($value) {
                        /** @var Builder $query2 */
                        $query2->whereExists(function ($query3) use ($value) {
                            /** @var Builder $query3 */
                            $query3->select(DB::raw(1))->from('log_details')->whereRaw('log_details.log_id = logs.id')->where('key', 'order.id')->where('value', $value);
                        });
                        $query2->orWhere('message', 'like', '%'.$value.'%');
                    });
                }
                if ($key == 'key' && \Request::get('value')) {
                    $query->whereExists(function ($query2) use ($value) {
                        /** @var Builder $query2 */
                        $query2->select(DB::raw(1))->from('log_details')->whereRaw('log_details.log_id = logs.id')->where('key', $value)->where('value', \Request::get('value'));
                    });
                }
            }
        }
        $logs = $query->where('message', 'not like', '%/admin/log/%')->where('message', 'not like', '%image/%.png%')->paginate(100);

        return view('admin_old.log.list', [
            'list' => $logs,
        ]);
    }

    public function getRead($id)
    {
        $log = DB::connection('logs')->table('logs')->find($id);
        if (! $log) {
            return form()->error('Unknown log entry')->url(route('admin::log::list'));
        }
        $logDetails = DB::connection('logs')->table('log_details')->where('log_id', $id)->get();
        $log->details = $logDetails;

        return view('admin_old.log.read', [
            'log' => $log,
        ]);
    }
}
