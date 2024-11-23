<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class FriendController extends Controller
{
    use ValidatesRequests;

    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();

        return view('friends.index')
              ->with('friends', $friends)
              ->with('requests', $requests);
    }

    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()
                   ->route('home')
                   ->with('info', 'That user could not be found');
        }

        if (Auth::user()->id === $user->id) {
            return redirect()->route('home');
        }
        if (Auth::user()->hasFriendRequestPending($user) || $user->
            hasFriendRequestPending(Auth::user())) {
                return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request');
        }
        if (Auth::user()->isFriendsWith($user)) {
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'You are now friends');    
        }
           Auth::user()->addFriend($user);

           return redirect()
                ->route('profile.index', ['username' => $username])
                ->with('info', 'Request sent');
     }
     public function getAccept($username)
     {
        $user = User::where('username', $username)->first();

        if(!$user) {
            return redirect()
               ->route('home')
               ->with('info', 'That user could not be found');
        }
        if (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect('home');
        }

        Auth::user()->acceptFriendRequest($user);
        
        return redirect()
            ->route('profile.index', ['username' => $username])
            ->with('info', 'Friend request accepted');
     }

     public function postdelete($username)
     {
        $user = User::where('username', $username)->first();

        if (!Auth::user()->isFriendsWith($user)) {
            return redirect()->back();
        }

        Auth::user()->deleteFriend($user);

        return redirect()->back()->with('info', 'Friend deleted');
     }
}