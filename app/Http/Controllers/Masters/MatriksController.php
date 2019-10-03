<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\AssetGroup;
use App\Models\Masters\FaultCategory;
use App\Models\Masters\Matrik;
use App\Models\Masters\RepairCategory;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class MatriksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.matrik.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Matrik::with(['kelompok', 'fault', 'repair'])->orderBy('matrik_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('kelompok', function($select) {
                    return $select->kelompok->assetgrp_name;
                })
                ->addColumn('fault', function($select) {
                    return $select->fault->fault_name;
                })
                ->addColumn('repair', function($select) {
                    return $select->repair->repair_name;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/matriks/' . $select->matrik_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->matrik_id, 'master/matriks').'
                    ';

                    return $action;
                })
                ->rawColumns(['aset', 'fault', 'repair', 'action']);

            return $data->make(true);
        } else {
            return abort('404', 'Upps');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelompok = AssetGroup::pluck('assetgrp_name', 'assetgrp_id')->toArray();

        $fault = FaultCategory::pluck('fault_name', 'fault_id')->toArray();

        $repair = RepairCategory::pluck('repair_name', 'repair_id')->toArray();

        return view('masters.matrik.create', compact('kelompok', 'fault', 'repair'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $store = Matrik::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/matriks');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/matriks');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Matrik::findOrFail($id);

        $kelompok = AssetGroup::pluck('assetgrp_name', 'assetgrp_id')->toArray();

        $fault = FaultCategory::pluck('fault_name', 'fault_id')->toArray();

        $repair = RepairCategory::pluck('repair_name', 'repair_id')->toArray();

        return view('masters.matrik.edit', compact('data', 'kelompok', 'fault', 'repair'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $update = Matrik::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/matriks');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/matriks');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = Matrik::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/matriks');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/matriks');
        }
    }
}
