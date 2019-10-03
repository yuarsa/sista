<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\RegionRequest as RegionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Masters\Region;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.region.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Region::orderBy('reg_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/regions/' . $select->reg_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->reg_id, 'master/regions').'
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
        return view('masters.region.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionRequest $request)
    {
        try {
            $store = Region::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/regions');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/regions');
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
        $data = Region::findOrFail($id);

        return view('masters.region.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegionRequest $request, $id)
    {
        try {
            $update = Region::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/regions');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/regions');
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
            $delete = Region::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/regions');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/regions');
        }
    }
}
