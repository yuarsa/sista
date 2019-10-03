<?php

namespace App\Http\Controllers\Monitors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\AssetGroup;
use App\Models\Monitors\Inspection;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelompok = AssetGroup::pluck('assetgrp_name', 'assetgrp_id')->toArray();

        return view('monitors.inspection.index', compact('kelompok'));
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $kelompok = $request->kelompok_id;

            $from = $request->from;

            $to = $request->to;

            $select = Inspection::with(['kelompok', 'area', 'aset']);

            if($kelompok != '') {
                $select = $select->where('insp_asset_group_id', $kelompok);
            }

            if($from != '' AND $to != '') {
                $select = $select->between($from. ' 00:00:00', $to. ' 23:59:59');
            }

            $select = $select->get();

            $data = Datatables::of($select)
                ->addColumn('kelompok', function($select) {
                    return $select->kelompok->assetgrp_name;
                })
                ->addColumn('code', function($select) {
                    return $select->aset->code;
                })
                ->addColumn('aset', function($select) {
                    return $select->aset->asset_name;
                })
                ->addColumn('area', function($select) {
                    return $select->area->area_name;
                })
                ->addColumn('status', function($select) {
                    if($select->insp_status == 1) {
                        $status = '<label class="label label-success">Open</label>';
                    } else if($select->insp_status == 2) {
                        $status = '<label class="label label-warning">Close</label>';
                    } else {
                        $status = '';
                    }

                    return $status;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('monitor/inspections/' . $select->insp_id).'" class="btn btn-sm btn-default" title="Detail"><i class="fa fa-search"></i></a>
                        '.\Form::delete($select->insp_id, 'monitor/inspections').'
                    ';

                    return $action;
                })
                ->rawColumns(['kelompok', 'code', 'aset', 'area', 'status', 'action']);

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Inspection::findOrFail($id);

        return view('monitors.inspection.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function printTable()
    {
        $data = Inspection::get();

        return view('monitors.inspection.print', compact('data'));
    }
}