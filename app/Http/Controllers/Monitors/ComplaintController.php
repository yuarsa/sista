<?php

namespace App\Http\Controllers\Monitors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Monitors\Complaint;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

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

        return view('monitors.complaint.index', compact('status'));
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $from = $request->from;

            $to = $request->to;

            $status = $request->status_id;

            $select = Complaint::orderBy('created_at', 'DESC');

            if($from != '' AND $to != '') {
                $select = $select->between($from. ' 00:00:00', $to. ' 23:59:59');
            }

            if($status != '') {
                $select = $select->where('complain_status', $status);
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
        $data = Complaint::findOrFail($id);

        return view('monitors.complaint.show', compact('data'));
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
        $data = Complaint::get();

        return view('monitors.complaint.print', compact('data'));
    }
}
