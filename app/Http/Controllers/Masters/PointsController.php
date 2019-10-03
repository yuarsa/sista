<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\PointRequest as PointRequest;
use App\Http\Controllers\Controller;
use App\Models\Masters\Area;
use App\Models\Masters\Point;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class PointsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.point.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Point::with(['area'])->orderBy('point_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('area', function($select) {
                    return $select->area->area_name;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/points/' . $select->point_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->point_id, 'master/points').'
                    ';

                    return $action;
                })
                ->rawColumns(['area', 'action']);

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
        $area = Area::pluck('area_name', 'area_id')->toArray();

        return view('masters.point.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PointRequest $request)
    {
        try {
            $store = Point::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/points');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/points');
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
        $data = Point::findOrFail($id);

        $area = Area::pluck('area_name', 'area_id')->toArray();

        return view('masters.point.edit', compact('data', 'area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PointRequest $request, $id)
    {
        try {
            $update = Point::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/points');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/points');
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
            $delete = Point::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/points');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/points');
        }
    }
}
