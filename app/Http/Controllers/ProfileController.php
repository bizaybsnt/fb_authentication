<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Socialite;

class ProfileController extends Controller
{
    public function index()
    {

        return view('profile');
    }

    public function newPassword($id)
    {
        $this->validate(request(),[
            'newPassword' => 'required|min:6',
            'confirmPassword' =>'required|same:newPassword'
        ]);

        $users =User::find($id);
        $users->password=  bcrypt(request('newPassword'));
        $users->save();


        return redirect('/profile');
    }

    public function disconnect()
    {
        $users=User::find(Auth::user()->id);
        if($users->password==null)
        {
            return view('profile')->with('message', 'You have to enter new password to disconnect Facebook');
        }else{
            $users->provider=null;
            $users->provider_id=null;
            $users->save();

        }
        return redirect('/profile');
    }
}
