<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\BillingTransaction;
use Illuminate\Http\Request;

class TransactionController extends AdminBaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Request $request)
    {
        $this->force(['admin']);

        return view('admin.transaction.list', [
            'list' => billing_transaction_repository()->getListing($request->all(), null, null, 20),
        ]);
    }

    /**
     * @param BillingTransaction $transaction
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRead(BillingTransaction $transaction)
    {
        $this->force(['admin']);

        return view('admin.transaction.read', [
            'transaction' => $transaction,
        ]);
    }
}
