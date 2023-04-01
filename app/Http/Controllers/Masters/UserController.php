<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('administrator');
        $title = 'User';
        
        if(Gate::allows('superadmin')){
            $users = User::when($request->has('archive'), function($query){
                $query->onlyTrashed();
            })
            ->with('roles')
            ->whereHas("roles", function($q){ 
                $q->whereNotIn("name", ["super"]);
            })
            ->orderBy('name', 'asc')->get();
        }elseif(Gate::allows('administrator')){
            $users = User::when($request->has('archive'), function($query){
                $query->onlyTrashed();
            })
            ->with('roles')
            ->whereHas("roles", function($q){ 
                $q->whereNotIn("name", ["super", "admin"]);
            })
            ->orderBy('name', 'asc')->get();
        }
        return view('masters.users.index', compact('title','users'));
    }

    public function create()
    {
        $this->authorize('administrator');
        $title = 'Tambah User';
        if(Gate::allows('superadmin')){
            $roles = Role::whereNotIn('name', ['super'])->get();
        }elseif(Gate::allows('administrator')){
            $roles = Role::whereNotIn('name', ['super', 'admin'])->get();
        }
        return view('masters.users.create',compact('title', 'roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('administrator');
        $userValidateData = $request->validate([
            'name' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required|email:dns',
        ]);
        $userValidateData['date_of_birth'] =date("Y-m-d",strtotime($request->date_of_birth));
        $userValidateData['password'] = bcrypt(date("dmY",strtotime($request->date_of_birth)));
        // dd($userValidateData);
        $insert = User::create($userValidateData);
        $insert->assignRole('user');
        if($insert){
            return redirect()->route('masters.users.index')->with('success', 'User berhasil ditambahkan');
        }else{
            return redirect()->route('masters.users.index')->with('failed', 'User gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $this->authorize('administrator');
        $title = 'Edit User';
        $user = User::find($id);
        $roles = Role::whereNotIn('name', ['super', 'admin'])->get();
        return view('masters.users.edit', compact('title', 'user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('administrator');
        $userValidateData = $request->validate([
            'name' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required|email:dns',
        ]);
        $userValidateData['date_of_birth'] =date("Y-m-d",strtotime($request->date_of_birth));
        $update = User::where('id', $id)->update($userValidateData);
        if($update){
            return redirect()->route('masters.users.index')->with('success', 'Data user berhasil diedit');
        }else{
            return redirect()->route('masters.users.index')->with('failed', 'Data user gagal diedit');
        }
    }

    public function destroy($id)
    {
        $this->authorize('administrator');
        $delete = User::destroy($id);
        if($delete){
            return redirect()->route('masters.users.index')->with('success', 'User berhasil dinonaktifkan');
        }else{
            return redirect()->route('masters.users.index')->with('failed', 'User gagal dinonaktifkan');
        }
    }

    public function restore($id)
    {
        $this->authorize('administrator');
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('masters.users.index')->with('success', 'User berhasil diaktifkan kembali');
    }

    public function delete_forever($id)
    {
        $this->authorize('administrator');
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('masters.users.index')->with('success', 'User berhasil dihapus');
    }
}
