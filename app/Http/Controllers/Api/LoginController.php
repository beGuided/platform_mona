<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{

// public function redirectToProvider($driver)
// {
//     return Socialite::driver($driver)->redirect();
// }

// public function handleProviderCallback($driver)
// {
//     try {
//         $user = Socialite::driver($driver)->user();
//     } catch (\Exception $e) {
//         return redirect()->route('login');
//     }

//     $existingUser = User::where('email', $user->getEmail())->first();

//     if ($existingUser) {
//         auth()->login($existingUser, true);
//     } else {
//         $newUser                    = new User;
//         $newUser->provider_name     = $driver;
//         $newUser->provider_id       = $user->getId();
//         $newUser->name              = $user->getName();
//         $newUser->email             = $user->getEmail();
//         // we set email_verified_at because the user's email is already veridied by social login portal
//         $newUser->email_verified_at = now();
//         // you can also get avatar, so create avatar column in database it you want to save profile image
//         // $newUser->avatar            = $user->getAvatar();
//         $newUser->save();

//         auth()->login($newUser, true);
//     }

//     return redirect($this->redirectPath());
// }
}
