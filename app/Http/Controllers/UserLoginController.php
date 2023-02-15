<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EventLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserLoginController extends Controller
{
    public function loginPage()
    {
        if (Auth::check()) {
            return redirect(route('user.link-page'));
        } else {
            return view('user-login');
        }
    }

    public function userLogin(Request $request)
    {
        $name = $request->name;
        $phone_number = $request->phone_number;

        if (!User::where('name', $name)->exists()) {
            return redirect(route('user.start-login'))->withErrors([
                'name' => 'This name not exists in DB'
            ]);
        }

        if (!User::where('phone_number', $phone_number)->exists()) {
            return redirect(route('user.start-login'))->withErrors([
                'phone_number' => 'This phone number not exists in DB'
            ]);
        }

        // Login in with the phone number and check if a token exists for a specific user
        $user           = User::where('phone_number', $phone_number)->first();
        $id             = User::where('phone_number', $phone_number)->pluck('id')->first();
        $existing_token = EventLink::where('user_id', $id)->pluck('token')->first();
        $token_term     = EventLink::where('user_id', $id)
            ->where('token', $existing_token)
            ->where('expires_at', '>', Carbon::now())->first();

        // if its time has expired then you need to create a new token so that in the end the user can go to page A
        if ($user && !$token_term) {
            Auth::login($user);
            $user_token = EventLink::where('user_id', $id)->delete();
            $plaintext = Str::random(32);
            $user_token = EventLink::create([
                'user_id'    => $id,
                'token'      => hash('sha256', $plaintext),
                'expires_at' => Carbon::now()->addDay(7),
            ]);
            $user_token->save();
            return redirect(route('user.link-page'));
        } else {
            Auth::login($user);
            return redirect(route('user.link-page'));
        }
    }
}
