<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\AreaRequest as AreaRequest;
use App\Http\Controllers\Controller;
use App\Models\Masters\Area;
use App\Models\Masters\Region;
use App\Models\Masters\Ruas;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.area.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Area::with(['region', 'ruas'])->orderBy('area_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('region', function($select) {
                    return $select->region->reg_name;
                })
                ->addColumn('ruas', function($select) {
                    return $select->ruas->ruas_name;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/areas/' . $select->area_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->area_id, 'master/areas').'
                    ';

                    return $action;
                })
                ->rawColumns(['region', 'ruas', 'action']);

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

        return view('masters.area.create', compact('region'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        try {
            $store = Area::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/areas');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/areas');
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
        $data = Area::findOrFail($id);

        $region = Region::pluck('reg_name', 'reg_id')->toArray();

        return view('masters.area.edit', compact('data', 'region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, $id)
    {
        try {
            $update = Area::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/areas');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/areas');
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
            $delete = Area::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/areas');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/areas');
        }
    }

    public function ruasDropdown(Request $request)
    {
        $val = $request->id;

        $ruas = Ruas::where('ruas_region_id', $val)->get();

        $return = '<option value="">Area</option>';

        foreach($ruas as $row) {
            $return .= "<option value='$row->ruas_id'>[$row->ruas_code] - $row->ruas_name</option>";
        }

        return $return;
    }
}