<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;

class SupplierController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:is_support');
    }

    public function getList()
    {
        return view('admin_old.supplier.list', [
            'list' => supplier_repository()->getListing(null, ['name', 'asc']),
        ]);
    }

    public function getRead($id)
    {
        return view('admin_old.supplier.read', [
            'model' => supplier_repository()->find($id),
        ]);
    }

    public function getCreate()
    {
        return view('admin_old.supplier.create', [
            'model' => [],
        ]);
    }

    public function postCreate(Request $request)
    {
        $validator = supplier_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $supplier = supplier_repository()->create([
            'name' => $request->get('name'),
        ]);
        success('Supplier Information Saved');

        return form()->route('admin::supplier::read', [$supplier->id]);
    }

    public function getUpdate($id)
    {
        $supplier = supplier_repository()->find($id);

        return view('admin_old.supplier.update', [
            'model' => $supplier,
        ]);
    }

    public function postUpdate($id, Request $request)
    {
        $supplier = supplier_repository()->find($id);
        $validator = supplier_repository()->validate($request, ['name']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $supplier->name = $request->get('name');
        $supplier->save();

        success('Supplier Information Saved');

        return form()->route('admin::supplier::read', [$id]);
    }

    public function getDelete($id)
    {
        $supplier = supplier_repository()->find($id);
        if (! $supplier) {
            return form()->error('Unknown Supplier')->route('admin::supplier::list');
        }

        return view('admin_old.supplier.delete', [
            'supplier' => $supplier,
        ]);
    }

    public function postDelete($id)
    {

    }
}
