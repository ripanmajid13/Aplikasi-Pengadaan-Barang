<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Yajra\Datatables\Datatables;

class ReportController extends Controller
{
    public function index()
    {
        return view($this->folder().'index', [
            'urlCreate' => route($this->link().'create'),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), ['report' => ['required']], ['report.required' => 'Harus diisi.']);

        if ($validator->fails()) {
            return json_encode(array('sts' => 'errors', 'errors' => $validator->errors()));
        }

        return json_encode(
            array(
                'sts'       => 'ok',
                'urlPrint'  => route($this->link().'print', [
                    'report'    => request('report'),
                    'date_from' => request('date_from'),
                    'date_to'   => request('date_to')
                ])
            )
        );
    }

    public function print()
    {
        // $model = BudgetPlan::findOrFail($id);
        // $title = empty($model->title_pe) ? $model->title : $model->title_pe;

        // $html = view('pages.rab.budget_plan_pe.print', [
        //     'model'     => $model,
        //     'subTitle'  => BudgetPlanSub::where('bp_id', $id)->orderBy('created_at', 'asc')->get()
        // ]);

        switch (request('report')) {
            case '1':
                $html = 'Laporan Stok';
                break;
            case '2':
                $view = view($this->folder().'._incoming_item', [
                    'report'    => request('report'),
                    'date_from' => request('date_from'),
                    'date_to'   => request('date_to')
                ])->render();
                break;
            case '3':
                $html = 'Laporan Barang Keluar';
                break;

            default:
                $html = 'Not Found';
                break;
        }
        $pdf = PDF::loadHtml($view)->setPaper('a4');
        return $pdf->stream('Laporan.pdf');
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
                    'msgDelete'         => $model->name,
                    'itemsWithTrashed'  => $model->itemsWithTrashed->count(),
                    'items'             => $model->items->count(),
                    'canEdit'           => $this->can('edit'),
                    'canDelete'         => $this->can('delete'),
                    'urlEdit'           => route($this->link().'edit', $model->id),
                    'urlDestroy'        => route($this->link().'destroy', $model->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
