<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('administrator');
        
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
        return view('masters.users.index',[
            'title' => 'Daftar pengguna',
            'users' => $users
        ]);
    }

    public function create()
    {
        $this->authorize('administrator');
        if(Gate::allows('superadmin')){
            $roles = Role::whereNotIn('name', ['super'])->get();
        }elseif(Gate::allows('administrator')){
            $roles = Role::whereNotIn('name', ['super', 'admin'])->get();
        }
        return view('masters.users.create',[
            'title' => 'Tambah data pengguna',
            'roles' => $roles,
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $this->authorize('administrator');
        $validatedData = $request->validated();
        $validatedData['birth_date'] =date("Y-m-d",strtotime($request->birth_date));
        $validatedData['password'] = bcrypt(date("dmY",strtotime($request->birth_date)));
        if($request->hasFile('image') ){
            $validatedData['image'] = $request->file('image')->store('user-image');
        } 
        $insert = User::create($validatedData);
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
        $title = 'Ubah Data Pengguna';
        $user = User::find($id);
        $roles = Role::whereNotIn('name', ['super', 'admin'])->get();
        return view('masters.users.edit', compact('title', 'user', 'roles'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('administrator');
        $image = $user->image;
        if($request->hasFile('image') ){
            $path = 'storage/'.$image;
            if(File::exists($path)){
                File::delete($path);
            }
            $user->image = $request->file('image')->store('user-image');
        }
        $validatedData['birth_date'] =date("Y-m-d",strtotime($request->birth_date));
        $user->update($validatedData);
        $user->syncRoles($request->role_name);
        if($user){
            return redirect()->route('masters.users.index')->with('success', 'Data pengguna berhasil diubah');
        }else{
            return redirect()->route('masters.users.index')->with('failed', 'Gagal mengubah data pengguna');
        }
    }

    public function destroy($id)
    {
        $this->authorize('administrator');
        $delete = User::destroy($id);
        if($delete){
            return redirect()->route('masters.users.index')->with('success', 'Pengguna berhasil dinonaktifkan');
        }else{
            return redirect()->route('masters.users.index')->with('failed', 'Pengguna gagal dinonaktifkan');
        }
    }

    public function restore($id)
    {
        $this->authorize('administrator');
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('masters.users.index')->with('success', 'Pengguna berhasil diaktifkan kembali');
    }

    public function delete_forever($id)
    {
        $this->authorize('administrator');
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('masters.users.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
