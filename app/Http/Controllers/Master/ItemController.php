<?php

namespace App\Http\Controllers\Master;

use App\Models\{Item, Unit, Type};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class ItemController extends Controller
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
            'column'    => new Item,
            'url'       => route($this->link().'store'),
            'method'    => 'POST',
            'units'     => Unit::orderBy('name', 'asc')->get(),
            'types'     => Type::orderBy('name', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => [ 'required',
                Rule::unique('items')->where(function ($query) {
                    return $query->where('unit_id', request('unit_id'))->where('type_id', request('type_id'));
                }),
            ],
        ],  [
            'name.required' => 'Harus diisi.',
            'name.unique' => 'Sudah ada.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('sts' => 'errors', 'errors' => $validator->errors()));
        }

        $model              = new Item;
        $model->name        = request('name');
        $model->unit_id     = request('unit_id');
        $model->type_id     = request('type_id');
        $model->created_by  = auth()->user()->id;
        $model->updated_by  = auth()->user()->id;
        $model->save();

        return json_encode(array('sts' => 'store', 'icon' => 'success', 'msg' => 'Berhsil disimpan.'));
    }

    public function edit($id)
    {
        return view($this->folder().'_form', [
            'column'    => Item::findOrFail($id),
            'url'       => route($this->link().'update', $id),
            'method'    => 'PUT',
            'units'     => Unit::orderBy('name', 'asc')->get(),
            'types'     => Type::orderBy('name', 'asc')->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  => [ 'required',
                Rule::unique('items')->where(function ($query) use ($id) {
                    return $query->where('unit_id', request('unit_id'))->where('type_id', request('type_id'))->whereNotIn('id', [$id]);
                }),
            ],
        ],  [
            'name.required' => 'Harus diisi.',
            'name.unique' => 'Sudah ada.',
        ]);

        if ($validator->fails()) {
            return json_encode(array('sts' => 'errors', 'errors' => $validator->errors()));
        }

        $model              = Item::findOrFail($id);
        $model->name        = request('name');
        $model->unit_id     = request('unit_id');
        $model->type_id     = request('type_id');
        $model->updated_by  = auth()->user()->id;
        $model->save();

        return json_encode(array('sts' => 'update', 'icon' => 'success', 'msg' => 'Berhasil diperbaharui.'));
    }

    public function destroy($id)
    {
        $model = Item::findOrFail($id);
        $model->deleted_by  = auth()->user()->id;
        $model->save();
        $model->delete();

        return json_encode(array('icon' => 'success', 'msg' => 'Berhsil dihapus.'));
    }

    //---------------------------------------------

    public function table()
    {
        $model = Item::orderBy('name', 'asc')->get();
        return DataTables::of($model)
            ->addColumn('unit_id', function ($model) {
                return $model->unit->name;
            })
            ->addColumn('type_id', function ($model) {
                return $model->type->name;
            })
            ->addColumn('sum', function ($model) {
                return $model->type->name;
            })
            ->addColumn('action', function ($model) {
                $msg = $model->incomingItems->count() ? $model->name.', <span class="text-danger">akan menghapus juga barang masuk dan barang keluar</span>' : $model->name;
                return view($this->folder().'_action', [
                    'msgDelete'     => $msg,
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
