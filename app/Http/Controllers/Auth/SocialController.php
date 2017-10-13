<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;

use App\User;
use Auth;

class SocialController extends Controller
{
    protected $redirectTo = '/home';

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {

        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $users = Socialite::driver('facebook')->stateless()->user();
        if(Auth::user()){

            $user =User::find(Auth::user()->id);
            if($users->email!=Auth::user()->email){
                $user->secondary_email =$users->email;

            }
            $user->provider= 'facebook';
            $user->provider_id=$users->id;
            $user->save();
            return redirect('/profile');
        }
        else {
            $authUser = $this->findOrCreateUser($users, 'facebook');
            //$token = User::where('provider_id', $user->id)->get()->count();
            Auth::login($authUser, true);
            return redirect($this->redirectTo);
        }
    }
    public function findOrCreateUser($user)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        //if $user-> email == email already registered
        //              update provider name and provider id
        //user is logged in via facebook
        //

        if ($authUser) {
            return $authUser;
        }

        $authUser = User::where('email', $user->email)->first();
        if($authUser){
            $users =User::find($authUser->id);
            $users->provider= 'facebook';
            $users->provider_id=$user->id;
            $users->save();
            return $users;
        }

        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => 'facebook',
            'provider_id' => $user->id
        ]);
    }
}