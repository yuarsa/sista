<?php

namespace App\Http\Controllers\Monitors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Area;
use App\Models\Masters\AssetGroup;
use App\Models\Monitors\Inspection;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

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

        $area = Area::pluck('area_name', 'area_id')->toArray();

        $status = ['1' => 'Open', '2' => 'Close'];

        $shift = ['1' => 'Shift 1', '2' => 'Shift 2', '3' => 'Shift 3'];

        return view('monitors.inspection.index', compact('kelompok', 'area', 'status', 'shift'));
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $kelompok = $request->kelompok_id;

            $area = $request->area_id;

            $shift = $request->shift_id;

            $status = $request->status_id;

            $from = $request->from;

            $to = $request->to;

            $select = Inspection::with(['kelompok', 'area', 'aset']);

            if($kelompok != '') {
                $select = $select->where('insp_asset_group_id', $kelompok);
            }

            if($area != '') {
                $select = $select->where('insp_area_id', $area);
            }

            if($status != '') {
                $select = $select->where('insp_status', $status);
            }

            if($shift != '') {
                $select = $select->where('insp_shift_id', $shift);
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

    public function export(Request $request)
    {
        $kelompok = $request->export_kelompok;

        $area = $request->export_area;

        $status = $request->export_status;

        $shift = $request->export_shift;

        $from = $request->export_from;

        $to = $request->export_to;

        $data = Inspection::orderBy('created_at', 'desc');

        if($kelompok != '') {
            $data = $data->where('insp_asset_group_id', $kelompok);
        }

        if($area != '') {
            $data = $data->where('insp_area_id', $area);
        }

        if($status != '') {
            $data = $data->where('insp_status', $status);
        }

        if($shift != '') {
            $data = $data->where('insp_shift_id', $shift);
        }

        if($from != '' AND $to != '') {
            $data = $data->between($from. ' 00:00:00', $to. ' 23:59:59');
        }

        $data = $data->get();

        $path = public_path() . '/storage/template/laporan_inspeksi.xls';

        $file = 'Laporan_Inspeksi_Per_'.date('ymd');

        return Excel::load($path, function($reader) use ($data, $shift) {
            $reader->sheet('Sheet1', function($sheet) use ($data, $shift) {
                $sheet->setCellValue('C4', date('Y-m-d'));
                $sheet->setCellValue('C5', 'Shift '. $shift);

                $rowExcel = 11;

                $no = 1;

                $styleThinBlackBorderAllLine = array(
                    'allborders' => array(
                        'style' => 'thin',
                        'color' => array(
                            'rgb' => '000000'
                        )
                    )
                );

                foreach ($data as $val) {
                    $lokasi = $val->area->area_name.', '.$val->area->ruas->ruas_name.', '.$val->area->region->reg_name;

                    if($val->insp_status == '1') {
                        $status = 'Open';
                    } else if($val->insp_status == '2') {
                        $status = 'Close';
                    } else {
                        $status = '';
                    }

                    $sheet->getStyle('A' . $rowExcel . ':L' . $rowExcel)->getBorders()->applyFromArray($styleThinBlackBorderAllLine);
                    $sheet->setCellValue('A' . $rowExcel, $no);
                    $sheet->setCellValue('B' . $rowExcel, $val->kelompok->assetgrp_name);
                    $sheet->setCellValue('C' . $rowExcel, $val->aset->code);
                    $sheet->setCellValue('D' . $rowExcel, $val->aset->tipe->type_desc);
                    $sheet->setCellValue('E' . $rowExcel, '');
                    $sheet->setCellValue('F' . $rowExcel, $lokasi);
                    $sheet->setCellValue('G' . $rowExcel, $val->insp_desc);
                    $sheet->setCellValue('H' . $rowExcel, $val->insp_volume);
                    $sheet->setCellValue('I' . $rowExcel, $val->matrik->matrik_name.' ('.$val->matrik->fault->fault_name.')');
                    $sheet->setCellValue('J' . $rowExcel, $val->matrik->repair->repair_name);
                    $sheet->setCellValue('K' . $rowExcel, $val->insp_follow_up);
                    $sheet->setCellValue('L' . $rowExcel, $status);
                    $rowExcel++;
                    $no++;
                }
            });
        })->setFilename($file)->export('xls');
    }
}
