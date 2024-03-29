<?php

namespace App\Http\Controllers\Monitors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Area;
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

        $area = Area::pluck('area_name', 'area_id')->toArray();

        return view('monitors.perfom.index', compact('kelompok', 'shift', 'area'));
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $kelompok = $request->kelompok_id;

            $area = $request->area_id;

            $shift = $request->shift_id;

            $from = $request->from;

            $to = $request->to;

            $select = AssetPerformance::with(['kelompok', 'aset']);

            if($kelompok != '') {
                $select = $select->where('assetperf_asset_group_id', $kelompok);
            }

            if($area != '') {
                $select = $select->whereHas('aset', function($q) use($area) {
                    $q->where('asset_area_id', $area);
                });
            }

            if($shift != '') {
                $select = $select->where('assetperf_shift', $shift);
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

    public function printTable(Request $request)
    {
        $kelompok = $request->export_kelompok;

        $area = $request->export_area;

        $shift = $request->export_shift;

        $from = $request->export_from;

        $to = $request->export_to;

        $data = AssetPerformance::with(['aset']);

        if($kelompok != '') {
            $data = $data->where('assetperf_asset_group_id', $kelompok);
        }

        if($area != '') {
            $data = $data->whereHas('aset', function($q) use($area) {
                $q->where('asset_area_id', $area);
            });
        }

        if($shift != '') {
            $data = $data->where('assetperf_shift', $shift);
        }

        if($from != '' AND $to != '') {
            $data = $data->between($from. ' 00:00:00', $to. ' 23:59:59');
        }

        $data = $data->get();

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
