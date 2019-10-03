<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\PermissionRequest as PermissionRequest;
use App\Http\Controllers\Controller;
use App\Models\Auth\Permission;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.permission.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Permission::orderBy('id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('auth/permissions/' . $select->id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->id, 'auth/permissions').'
                    ';

                    return $action;
                })
                ->rawColumns(['action']);

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
        return view('auth.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        try {
            $store = Permission::create($request->all());

            flash('Data berhasil ditambahkan')->success();

            return redirect('auth/permissions');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/permissions');
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
        $data = Permission::findOrFail($id);

        return view('auth.permission.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        try {
            $update = Permission::find($id)->update($request->all());

            flash('Data Berhasil Dirubah')->success();

            return redirect('auth/permissions');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/permissions');
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
            $delete = Permission::find($id)->delete();

            flash('Data Berhasil Dihapus')->success();

            return redirect('auth/permissions');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/permissions');
        }
    }
}
