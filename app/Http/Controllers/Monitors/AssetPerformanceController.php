<?php

namespace App\Http\Controllers\Monitors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\AssetGroup;
use App\Models\Monitors\AssetPerformance;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class AssetPerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelompok = AssetGroup::pluck('assetgrp_name', 'assetgrp_id')->toArray();

        $shift = ['1' => 'Shift 1', '2' => 'Shift 2', '3' => 'Shift 3'];

        return view('monitors.perfom.index', compact('kelompok', 'shift'));
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $kelompok = $request->kelompok_id;

            $from = $request->from;

            $to = $request->to;

            $shift = $request->shift_id;

            $select = AssetPerformance::with(['kelompok', 'aset']);

            if($kelompok != '') {
                $select = $select->where('assetperf_asset_group_id', $kelompok);
            }

            if($from != '' AND $to != '') {
                $select = $select->between($from. ' 00:00:00', $to. ' 23:59:59');
            }

            if($shift != '') {
                $select = $select->where('assetperf_shift', $shift);
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
                ->addColumn('status', function($select) {
                    if($select->assetperf_is_work == 1) {
                        $status = '<label class="label label-success">Berfungsi</label>';
                    } else if($select->assetperf_is_work == 2) {
                        $status = '<label class="label label-warning">Tidak Berfungsi</label>';
                    } else {
                        $status = '';
                    }

                    return $status;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        '.\Form::delete($select->assetperf_id, 'monitor/performances').'
                    ';

                    return $action;
                })
                ->rawColumns(['kelompok', 'code', 'aset', 'status', 'action']);

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
        try {
            $delete = AssetPerformance::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('monitor/performances');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('monitor/performances');
        }
    }

    public function printTable()
    {
        $data = AssetPerformance::get();

        $path = public_path() . '/storage/template/laporan_performa.xls';

        $file = 'Laporan_Performa_Aset_Per_'.date('ymd');

        return Excel::load($path, function($reader) use ($data) {
            $reader->sheet('Sheet1', function($sheet) use ($data) {
                $rowExcel = 7;

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
                    $sheet->getStyle('A' . $rowExcel . ':G' . $rowExcel)->getBorders()->applyFromArray($styleThinBlackBorderAllLine);
                    $sheet->setCellValue('A' . $rowExcel, $no);
                    $sheet->setCellValue('B' . $rowExcel, $val->kelompok->assetgrp_name);
                    $sheet->setCellValue('C' . $rowExcel, $val->aset->code);
                    $sheet->setCellValue('D' . $rowExcel, $val->aset->tipe->type_desc);
                    $sheet->setCellValue('E' . $rowExcel, '');

                    if($val->assetperf_is_work == 1) {
                        $status = 'Berfungsi';
                    } else if($val->assetperf_is_work == 2) {
                        $status = 'Tidak Berfungsi';
                    } else {
                        $status = '';
                    }

                    $sheet->setCellValue('F' . $rowExcel, $status);
                    $sheet->setCellValue('G' . $rowExcel, $val->assetperf_percentage);

                    $rowExcel++;
                    $no++;
                }
            });
        })->setFilename($file)->export('xls');
    }
}
