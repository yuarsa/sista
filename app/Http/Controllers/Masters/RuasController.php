<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\RuasRequest as RuasRequest;
use App\Http\Controllers\Controller;
use App\Models\Masters\Region;
use App\Models\Masters\Ruas;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class RuasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.ruas.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Ruas::with(['region'])->orderBy('ruas_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('region', function($select) {
                    return $select->region->reg_name;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/ruas/' . $select->ruas_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->ruas_id, 'master/ruas').'
                    ';

                    return $action;
                })
                ->rawColumns(['region', 'action']);

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
        $region = Region::pluck('reg_name', 'reg_id')->toArray();

        return view('masters.ruas.create', compact('region'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RuasRequest $request)
    {
        try {
            $store = Ruas::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/ruas');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/ruas');
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
        $data = Ruas::findOrFail($id);

        $region = Region::pluck('reg_name', 'reg_id')->toArray();

        return view('masters.ruas.edit', compact('data', 'region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RuasRequest $request, $id)
    {
        try {
            $update = Ruas::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/ruas');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/ruas');
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
            $delete = Ruas::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/ruas');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/ruas');
        }
    }
}
