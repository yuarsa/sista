<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\AssetGroupRequest as AssetGroupRequest;
use App\Http\Controllers\Controller;
use App\Models\Masters\AssetGroup;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class AssetGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.asset_group.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = AssetGroup::orderBy('assetgrp_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/asset_groups/' . $select->assetgrp_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->assetgrp_id, 'master/asset_groups').'
                    ';

                    return $action;
                })
                ->rawColumns(['action']);

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
        return view('masters.asset_group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetGroupRequest $request)
    {
        try {
            $store = AssetGroup::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/asset_groups');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_groups');
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
        $data = AssetGroup::findOrFail($id);

        return view('masters.asset_group.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetGroupRequest $request, $id)
    {
        try {
            $update = AssetGroup::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/asset_groups');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_groups');
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
            $delete = AssetGroup::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/asset_groups');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_groups');
        }
    }
}
