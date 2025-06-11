<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            $user = User::where('google_id', $google_user->getId())->first();

            $avatarUrl = $google_user->getAvatar();

            // Generate a unique file name
            $fileName = 'profile-photos/' . Str::uuid() . '.png';

            // Download and store the image in the 'public' disk (storage/app/public/avatars)
            $avatarContents = file_get_contents($avatarUrl);
            Storage::disk('public')->put($fileName, $avatarContents);

            if(!$user) {
                // If the user does not exist, create a new user
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'password' => bcrypt("password"),
                    'google_id' => $google_user->getId(),
                    'email_verified_at' => now(),
                    'profile_photo_path' => $fileName,
                ]);

                Auth()->login($new_user, true);

                return redirect('/dashboard')->with('success', 'Successfully logged in with Google.');
            }else{
                // If the user exists, log them in
                Auth()->login($user, true);

                return redirect('/dashboard')->with('success', 'Successfully logged in with Google.');
            }
        } catch (\Exception $e) {
            // Handle the exception, e.g., log it or return an error response
            // dd($e->getMessage());
            return redirect('/login')->with('status', 'Failed to authenticate with Google.'.$e->getMessage());
        }




    }
}
