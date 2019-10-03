<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Masters\Area;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.user.index');
    }

    public function datatables(Request $request)
    {
        if($request->ajax()) {
            $select = User::with(['roles'])->orderBy('name', 'ASC')->get();

            $data = Datatables::of($select)
                ->addColumn('role', function($select) {
                    $role = '';
                    foreach ($select->roles as $row) {
                        $role .= '<label class="label label-default">'.$row->display_name.'</label>&nbsp;';
                    }

                    return $role;
                })
                ->addColumn('action', function($select) {
                    $action = '
                        <a href="'.url('auth/users/' . $select->id . '/edit').'" class="btn btn-sm bg-yellow"><i class="fa fa-pencil"></i></a>
                        '.\Form::delete($select->id, 'auth/users').'
                    ';

                    return $action;
                })
                ->rawColumns(['role', 'action']);

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
        $roles = Role::all();

        $shift = ['1' => 'Shift 1', '2' => 'Shift 2', '3' => 'Shift 3'];

        $area = Area::pluck('area_name', 'area_id')->toArray();

        return view('auth.user.create', compact('roles', 'shift', 'area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request['password'] = bcrypt($request->password);

            $users = User::create($request->all());

            $users->roles()->attach($request->roles);

            flash('Data berhasil ditambahkan')->success();

            return redirect('auth/users');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/users');
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
        $data = User::findOrFail($id);

        $roles = Role::all();

        $shift = ['1' => 'Shift 1', '2' => 'Shift 2', '3' => 'Shift 2'];

        $area = Area::pluck('area_name', 'area_id')->toArray();

        return view('auth.user.edit', compact('roles', 'data', 'shift', 'area'));
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
        try {
            $user = User::find($id);

            if(empty($request['password'])) {
                unset($request['password']);
            } else {
                $request['password'] = bcrypt($request->password);
            }

            $user->update($request->all());

            $user->roles()->sync($request->roles);

            flash('Data berhasil dirubah')->success();

            return redirect('auth/users');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/users');
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
            $user = User::find($id);

            if($user->id == \Auth::user()->id) {
                flash('Anda tidak dapat menghapus data diri sendiri')->warning();

                return redirect('auth/users');
            }

            $user->delete();

            flash('Data berhasil dihapus')->success();

            return redirect('auth/users');
        } catch (QueryException $err) {
            flash($err->getMessage() . ' ' . $err->getLine())->error();

            return redirect('auth/users');
        }
    }
}
