<?php

namespace App\Http\Controllers\Monitors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Area;
use App\Models\Monitors\Complaint;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = ['1' => 'Open', '2' => 'Close'];

        $shift = ['1' => 'Shift 1', '2' => 'Shift 2', '3' => 'Shift 3'];

        $area = Area::pluck('area_name', 'area_id')->toArray();

        return view('monitors.complaint.index', compact('status', 'shift', 'area'));
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $from = $request->from;

            $to = $request->to;

            $area = $request->area_id;

            $shift = $request->shift_id;

            $status = $request->status_id;

            $select = Complaint::with(['user']);

            if($area != '') {
                $select = $select->whereHas('user', function($q) use($area) {
                    $q->where('area_id', $area);
                });
            }

            if($shift != '') {
                $select = $select->whereHas('user', function($q) use($shift) {
                    $q->where('shift', $shift);
                });
            }

            if($status != '') {
                $select = $select->where('complain_status', $status);
            }

            if($from != '' AND $to != '') {
                $select = $select->between($from. ' 00:00:00', $to. ' 23:59:59');
            }

            $select = $select->get();

            $data = Datatables::of($select)
                ->addColumn('status', function($select) {
                    if($select->complain_status == 1) {
                        return '<label class="label label-success">Open</label>';
                    } else if($select->complain_status == 2) {
                        return '<label class="label label-warning">Close</label>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('monitor/complaints/' . $select->complain_id).'" class="btn btn-sm btn-default" title="Detail"><i class="fa fa-search"></i></a>
                        '.\Form::delete($select->inscomplain_idp_id, 'monitor/complaints').'
                    ';

                    return $action;
                })
                ->rawColumns(['status', 'action']);

            return $data->make(true);
        } else {
            return abort('404', 'Upps');
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
        $data = Complaint::findOrFail($id);

        return view('monitors.complaint.show', compact('data'));
    }

    public function printTable(Request $request)
    {
        $status = $request->export_status;

        $area = $request->export_area;

        $shift = $request->export_shift;

        $from = $request->export_from;

        $to = $request->export_to;

        $data = Complaint::with(['user']);

        if($status != '') {
            $data = $data->where('complain_status', $status);
        }

        if($area != '') {
            $data = $data->whereHas('user', function($q) use($area) {
                $q->where('area_id', $area);
            });
        }

        if($shift != '') {
            $data = $data->whereHas('user', function($q) use($shift) {
                $q->where('shift', $shift);
            });
        }

        if($from != '' AND $to != '') {
            $data = $data->between($from. ' 00:00:00', $to. ' 23:59:59');
        }

        $data = $data->get();

        $path = public_path() . '/storage/template/laporan_komplain.xls';

        $file = 'Laporan_Komplain_Per_'.date('ymd');

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
                    $sheet->getStyle('A' . $rowExcel . ':H' . $rowExcel)->getBorders()->applyFromArray($styleThinBlackBorderAllLine);
                    $sheet->setCellValue('A' . $rowExcel, $no);
                    $sheet->setCellValue('B' . $rowExcel, $val->created_at);
                    $sheet->setCellValue('C' . $rowExcel, $val->complain_failure);
                    $sheet->setCellValue('D' . $rowExcel, $val->complain_desc);
                    $sheet->setCellValue('E' . $rowExcel, $val->complain_name);
                    $sheet->setCellValue('F' . $rowExcel, $val->complain_address);
                    $sheet->setCellValue('G' . $rowExcel, $val->complain_follow_up);

                    if($val->complain_status == 1) {
                        $status = 'Open';
                    } else if($val->complain_status == 2) {
                        $status = 'Close';
                    } else {
                        $status = '';
                    }

                    $sheet->setCellValue('H' . $rowExcel, $status);

                    $rowExcel++;
                    $no++;
                }
            });
        })->setFilename($file)->export('xls');
    }
}
