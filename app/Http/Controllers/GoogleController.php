<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect('');
    }

    public function handleGoogleCallback(){

        try{
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if($findUser){
                Auth::login($findUser);
                return redirect()->intended('dashboard');
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'password' => encrypt('12345dummy'),
                ]);

                Auth::login($newUser);
                return redirect()->intended('dashboard');
        }
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
