<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function update($id)
    {
        $this->authorize('administrator');
        $user = User::find($id);
        $user->password = bcrypt(date("dmY",strtotime($user->date_of_birth)));
        $update = $user->update();
        if($update){
            return redirect()->route('masters.users.index')->with('success', 'Password user berhasil direset');
        }else{
            return redirect()->route('masters.users.index')->with('failed', 'Password user gagal direset');
        }
    }
}
