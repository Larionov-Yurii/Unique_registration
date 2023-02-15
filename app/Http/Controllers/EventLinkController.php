<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventLink;
use Illuminate\Support\Facades\Auth;

class EventLinkController extends Controller
{

    public function transitionPage()
    {
        return view('transition-page');
    }


    public function transitionToPageA()
    {
        $current_user  = Auth::user()->id;
        $current_token = EventLink::where('user_id', $current_user)->value('token');
        return redirect(route('user.events-page', ['token' => $current_token]));
    }
}
