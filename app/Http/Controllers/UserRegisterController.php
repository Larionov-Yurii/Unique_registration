<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EventLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserRegisterController extends Controller
{
    public function startPage()
    {
        if (Auth::check()) {
            return redirect(route('user.link-page'));
        } else {
            return view('user-registration');
        }
    }

    public function createUser(Request $request)
    {
        $fields = $request->validate([
            'name'          => ['required', 'string', 'max:50'],
            'phone_number'  => ['required', 'string'],
        ]);

        if (User::where('name', $fields['name'])->exists()) {
            return redirect(route('user.start-registration'))->withErrors([
                'name' => 'This name already exists in DB'
            ]);
        }

        if (User::where('phone_number', $fields['phone_number'])->exists()) {
            return redirect(route('user.start-registration'))->withErrors([
                'phone_number' => 'This phone number already exists in DB'
            ]);
        }

        $user = User::create($fields);

        // Creating a token that will be in the link
        $id        = User::find($user)->first()->id;
        $plaintext = Str::random(32);
        $user_token = EventLink::create([
            'user_id'    => $id,
            'token'      => hash('sha256', $plaintext),
            'expires_at' => Carbon::now()->addDay(7),
        ]);

        $user_token->save();

        if ($user) {
            Auth::login($user);

            return redirect(route('user.link-page'));
        }
    }
}
