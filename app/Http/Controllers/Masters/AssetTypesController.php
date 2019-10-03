<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\AssetTypeRequest as AssetTypeRequest;
use App\Http\Controllers\Controller;
use App\Models\Masters\AssetType;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class AssetTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.asset_type.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = AssetType::orderBy('type_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/asset_types/' . $select->type_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->type_id, 'master/asset_types').'
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
        return view('masters.asset_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetTypeRequest $request)
    {
        try {
            $store = AssetType::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/asset_types');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_types');
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
        $data = AssetType::findOrFail($id);

        return view('masters.asset_type.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetTypeRequest $request, $id)
    {
        try {
            $update = AssetType::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/asset_types');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_types');
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
            $delete = AssetType::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/asset_types');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/asset_types');
        }
    }
}
