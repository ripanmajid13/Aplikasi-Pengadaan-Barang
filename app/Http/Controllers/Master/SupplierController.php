<?php

namespace App\Http\Controllers\Master;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class SupplierController extends Controller
{
    public function index()
    {
        return view($this->folder().'index', [
            'urlTable'  => route($this->link().'table'),
            'urlCreate' => route($this->link().'create'),
            'canCreate' => $this->can('create'),
            'canEdit'   => $this->can('edit'),
            'canDelete' => $this->can('delete'),
        ]);
    }

    public function create()
    {
        return view($this->folder().'_form', [
            'column'    => new Supplier,
            'url'       => route($this->link().'store'),
            'method'    => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required'],
            'hp'        => ['required', 'unique:suppliers,hp'],
            'address'   => ['required'],
        ],  [
            'name.required' => 'Harus diisi.',
            'hp.required' => 'Harus diisi.',
            'address.required' => 'Harus diisi.',
            'hp.unique' => 'Sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('sts' => 'errors', 'errors' => $validator->errors()));
        }

        $model              = new Supplier;
        $model->name        = request('name');
        $model->hp          = request('hp');
        $model->address     = request('address');
        $model->created_by  = auth()->user()->id;
        $model->updated_by  = auth()->user()->id;
        $model->save();

        return json_encode(array('sts' => 'store', 'icon' => 'success', 'msg' => 'Berhsil disimpan.'));
    }

    public function edit($id)
    {
        return view($this->folder().'_form', [
            'column'    => Supplier::findOrFail($id),
            'url'       => route($this->link().'update', $id),
            'method'    => 'PUT',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required'],
            'hp'        => ['required', 'unique:suppliers,hp,'.$id],
            'address'   => ['required'],
        ],  [
            'name.required' => 'Harus diisi.',
            'hp.required' => 'Harus diisi.',
            'address.required' => 'Harus diisi.',
            'hp.unique' => 'Sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('sts' => 'errors', 'errors' => $validator->errors()));
        }

        $model              = Supplier::findOrFail($id);
        $model->name        = request('name');
        $model->hp          = request('hp');
        $model->address     = request('address');
        $model->created_by  = auth()->user()->id;
        $model->updated_by  = auth()->user()->id;
        $model->save();

        return json_encode(array('sts' => 'update', 'icon' => 'success', 'msg' => 'Berhasil diperbaharui.'));
    }

    public function destroy($id)
    {
        $model = Supplier::findOrFail($id);
        $model->deleted_by  = auth()->user()->id;
        $model->save();
        $model->delete();

        return json_encode(array('icon' => 'success', 'msg' => 'Berhsil dihapus.'));
    }

    //---------------------------------------------

    public function table()
    {
        $model = Supplier::orderBy('name', 'asc')->get();
        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                return view($this->folder().'_action', [
                    'model'         => $model,
                    'canEdit'       => $this->can('edit'),
                    'canDelete'     => $this->can('delete'),
                    'urlEdit'       => route($this->link().'edit', $model->id),
                    'urlDestroy'    => route($this->link().'destroy', $model->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
