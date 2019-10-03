<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RoleRequest as RoleRequest;
use App\Http\Controllers\Controller;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.role.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = Role::orderBy('id', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('auth/roles/' . $select->id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->id, 'auth/roles').'
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
        $names = $permissions = [];

        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission) {
            $n = explode('-', $permission->name);

            if (!in_array($n[0], $names)) {
                $names[] = $n[0];
            }

            $permissions[$n[0]][] = $permission;
        }

        return view('auth.role.create', compact('names', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $role = Role::create($request->all());

            $role->permissions()->attach($request['permissions']);

            flash('Data berhasil ditambahkan')->success();

            return redirect('auth/roles');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/roles');
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
        $role = Role::findOrFail($id);

        $names = $permissions = [];

        $allPermissions = Permission::all();

        $rolePermissions = $role->permissions()->pluck('id', 'id')->toArray();

        foreach ($allPermissions as $permission) {
            $n = explode('-', $permission->name);

            if (!in_array($n[0], $names)) {
                $names[] = $n[0];
            }

            $permissions[$n[0]][] = $permission;
        }

        return view('auth.role.edit', compact('role', 'names', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        try {
            $role = Role::find($id);

            $role->update($request->all());

            $role->permissions()->sync($request['permissions']);

            flash('Data Berhasil Dirubah')->success();

            return redirect('auth/roles');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/roles');
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
        $role = Role::find($id)->delete();
        
		flash('Data Berhasil Dirubah')->success();
		
        return redirect('auth/roles');
    }
}
