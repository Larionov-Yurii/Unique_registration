<?php

namespace App\Http\Controllers;

use App\Models\EventNumbers;
use App\Models\EventLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventNumbersController extends Controller
{
    public function eventPage()
    {
        if ($this->currentTimeToken()) {
            // if the token exists and its time has not expired then show page A
            return view('special-page-a');
        } else {
            return $this->expiredTimeToken();
        }
    }

    public function imFeelingLucky()
    {
        if ($this->currentTimeToken()) {
            $current_user  = Auth::user()->id;
            $random_number = rand(0, 1000);

            if ($random_number % 2 == 0 && $random_number != 0) {
                if ($random_number > 900) {
                    $info_text = 'Win';
                    $winning_amount = 0.7 * $random_number;
                } elseif ($random_number > 600) {
                    $info_text = 'Win';
                    $winning_amount = 0.5 * $random_number;
                } elseif ($random_number > 300) {
                    $info_text = 'Win';
                    $winning_amount = 0.3 * $random_number;
                } else {
                    $info_text = 'Win';
                    $winning_amount = 0.1 * $random_number;
                }
            } else {
                $info_text = 'Lose';
                $winning_amount = 0;
            }

            $start_event  = EventNumbers::create([
                'user_id'          => $current_user,
                'random_number'    => $random_number,
                'info_text'        => $info_text,
                'winning_amount'   => $winning_amount,
            ]);
            $start_event->save();

            $result_event = EventNumbers::select('random_number', 'info_text', 'winning_amount')
                ->where('user_id', $current_user)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->get();

            return view('special-page-a', compact('result_event'));
        } else {
            return $this->expiredTimeToken();
        }
    }

    public function getHistory()
    {
        if ($this->currentTimeToken()) {
            $current_user   = Auth::user()->id;
            $get_actions    = EventNumbers::select('random_number', 'info_text', 'winning_amount')
                ->where('user_id', $current_user)
                ->orderBy('created_at', 'desc')
                ->latest()
                ->limit(3)
                ->get();

            return view('special-page-a', compact('get_actions'));
        } else {
            return $this->expiredTimeToken();
        }
    }

    public function createUniqueLink()
    {
        if ($this->currentTimeToken()) {
            session()->flash('link-created', 'New link is created!');

            $plaintext     = Str::random(32);
            $current_user  = Auth::user()->id;
            $user_token    = EventLink::where('user_id', $current_user)->delete();

            $user_token    = EventLink::create([
                'user_id'    => $current_user,
                'token'      => hash('sha256', $plaintext),
                'expires_at' => Carbon::now()->addDay(7)
            ]);
            $user_token->save();

            $user_token    = EventLink::where('user_id', $current_user)->value('token');
            return redirect(route('user.events-page', ['token' => $user_token]));
        } else {
            return $this->expiredTimeToken();
        }
    }

    public function deactivateUniqueLink()
    {
        if ($this->currentTimeToken()) {
            session()->flash('link-delete', 'The link was deleted. If you want to return to the page A again,
        then you need to log in again so that the new link is automatically created');

            $current_user     = Auth::user()->id;
            $delete_user_link = EventLink::where('user_id', $current_user)->delete();
            $delete_user_link = $this->userLogout();

            return $delete_user_link;
        } else {
            return $this->expiredTimeToken();
        }
    }

    public function currentTimeToken()
    {
        $current_user  = Auth::user()->id;
        $current_token = EventLink::where('user_id', $current_user)->value('token');
        $term_token    = EventLink::where('user_id', $current_user)
            ->where('token', $current_token)
            ->where('expires_at', '>', Carbon::now())->first();

        return $term_token;
    }

    public function expiredTimeToken()
    {
        session()->flash('link-expired', 'Sorry, but your link has expired, in order to return to page A again,
            please log in again and a new link will be generated!');

        $expired_user_token = $this->userLogout();

        return $expired_user_token;
    }

    public function userLogout()
    {
        Auth::logout();

        return redirect(route('user.start-login'));
    }
}
