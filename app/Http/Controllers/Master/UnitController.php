<?php

namespace App\Http\Controllers\Master;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class UnitController extends Controller
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
            'column'    => new Unit,
            'url'       => route($this->link().'store'),
            'method'    => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'unique:units,name'],
        ],  [
            'name.required' => 'Harus diisi.',
            'name.unique' => 'Sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('sts' => 'errors', 'errors' => $validator->errors()));
        }

        $model              = new Unit;
        $model->name        = request('name');
        $model->created_by  = auth()->user()->id;
        $model->updated_by  = auth()->user()->id;
        $model->save();

        return json_encode(array('sts' => 'store', 'icon' => 'success', 'msg' => 'Berhsil disimpan.'));
    }

    public function edit($id)
    {
        return view($this->folder().'_form', [
            'column'    => Unit::findOrFail($id),
            'url'       => route($this->link().'update', $id),
            'method'    => 'PUT',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'unique:units,name,'.$id],
        ],  [
            'name.required' => 'Harus diisi.',
            'name.unique' => 'Sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('sts' => 'errors', 'errors' => $validator->errors()));
        }

        $model              = Unit::findOrFail($id);
        $model->name        = request('name');
        $model->updated_by  = auth()->user()->id;
        $model->save();

        return json_encode(array('sts' => 'update', 'icon' => 'success', 'msg' => 'Berhsil diperbaharui.'));
    }

    public function destroy($id)
    {
        $model = Unit::findOrFail($id);
        $model->deleted_by  = auth()->user()->id;
        $model->save();
        $model->delete();

        return json_encode(array('icon' => 'success', 'msg' => 'Berhsil dihapus.'));
    }

    //---------------------------------------------

    public function table()
    {
        $model = Unit::orderBy('name', 'asc')->get();
        return DataTables::of($model)
            ->addColumn('created_by', function ($model) {
                return $model->createdBy->name;
            })
            ->addColumn('updated_by', function ($model) {
                return $model->updatedBy->name;
            })
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
