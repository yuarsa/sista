<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests\Masters\AssetRequest as AssetRequest;
use App\Http\Controllers\Controller;
use App\Models\Masters\Area;
use App\Models\Masters\Asset;
use App\Models\Masters\AssetGroup;
use App\Models\Masters\AssetType;
use App\Models\Masters\Region;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.asset.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Asset::with(['region', 'area', 'tipe', 'kelompok'])->orderBy('asset_id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('code', function($select) {
                    return $select->code;
                })
                ->addColumn('kelompok', function($select) {
                    return $select->kelompok->assetgrp_name;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('master/assets/' . $select->asset_id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->asset_id, 'master/assets').'
                    ';

                    return $action;
                })
                ->rawColumns(['code', 'kelompok', 'action']);

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

        $point = [
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
        ];

        $jenis = AssetType::pluck('type_code', 'type_id')->toArray();

        $region = Region::pluck('reg_name', 'reg_id')->toArray();

        return view('masters.asset.create', compact(
            'kelompok',
            'region',
            'point',
            'jenis'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetRequest $request)
    {
        try {
            $code = $this->generateCode($request);

            $request['asset_code'] = $code;

            $store = Asset::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('master/assets');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/assets');
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
        $data = Asset::findOrFail($id);

        $kelompok = AssetGroup::pluck('assetgrp_name', 'assetgrp_id')->toArray();

        $area = Area::pluck('area_name', 'area_id')->toArray();

        $point = [
            '01' => '01',
            '02' => '02',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
        ];

        $jenis = AssetType::pluck('type_code', 'type_id')->toArray();

        $region = Region::pluck('reg_name', 'reg_id')->toArray();

        return view('masters.asset.edit', compact(
            'data',
            'kelompok',
            'area',
            'point',
            'region',
            'jenis'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetRequest $request, $id)
    {
        try {
            $update = Asset::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('master/assets');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/assets');
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
            $delete = Asset::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('master/assets');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('master/assets');
        }
    }

    public function chained(Request $request)
    {
        $val = $request->id;

        $area = Area::where('area_region_id', $val)->get();

        $return = '<option value="">Area</option>';

        foreach($area as $row)
            $return .= "<option value='$row->area_id'>$row->area_name</option>";

        return $return;
    }

    public function generateCode($request)
    {
        $current = Asset::where(['asset_point' => $request->asset_point])->first();

        if(!is_null($current)) {
            $current_code = substr($current->asset_code, -2);

            $code = sprintf("%02s", $current_code + 1);
        } else {
            $code = '01';
        }

        return $code;
    }
}
