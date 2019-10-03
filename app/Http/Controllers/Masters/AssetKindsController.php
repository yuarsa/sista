<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\AssetKindRequest as AssetKindRequest;
use App\Http\Controllers\Controller;
use App\Models\Masters\AssetGroup;
use App\Models\Masters\AssetKind;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class AssetKindsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.asset_kind.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = AssetKind::with(['kelompok'])->orderBy('kind_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('kelompok', function($select) {
                    return $select->kelompok->assetgrp_name;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/asset_kinds/' . $select->kind_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->kind_id, 'master/asset_kinds').'
                    ';

                    return $action;
                })
                ->rawColumns(['kelompok', 'action']);

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

        return view('masters.asset_kind.create', compact('kelompok'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetKindRequest $request)
    {
        try {
            $store = AssetKind::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/asset_kinds');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_kinds');
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
        $data = AssetKind::findOrFail($id);

        $kelompok = AssetGroup::pluck('assetgrp_name', 'assetgrp_id')->toArray();

        return view('masters.asset_kind.edit', compact('data', 'kelompok'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetKindRequest $request, $id)
    {
        try {
            $update = AssetKind::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/asset_kinds');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_kinds');
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
            $delete = AssetKind::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/asset_kinds');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_kinds');
        }
    }
}
