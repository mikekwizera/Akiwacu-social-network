<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class StatusController extends Controller
{
    use ValidatesRequests;

    public function postStatus(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10000',
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
        ]);
        return redirect()
             ->route('home')
             ->with('info', 'Status posted.');
    }

    public function postReply(Request $request, $statusId)
    {
        $this->validate($request, [
            "reply-{$statusId}" => 'required|max:1000',
        ],[
            'required' => 'The reply body is required.',
        ]);
    
        $status = Status::notReply()->find($statusId);
    
        if (!$status) {
            return redirect()->route('home');
        }
        if (!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id) {
            return redirect()->route('home');
        }
    
        // Create the reply and associate the user
        $reply = new Status([
            'body' => $request->input("reply-{$statusId}"),
        ]);
        $reply->user()->associate(Auth::user());
    
    
        // Save the reply to the database
       $status->replies()->save($reply);

       return redirect()->back();
    }
    public function getLike($statusId)
    {
        $status = Status::find($statusId);
    
        if (!$status) {
            return redirect()->route('home');
        }
    
        if (!Auth::user()->isFriendsWith($status->user)) {
            return redirect()->route('home');
        }
    
        if (Auth::user()->hasLikedStatus($status)) {
            return redirect()->back();
        }
    
        // Create the like and associate it with the current user
        $like = $status->likes()->create([
            'user_id' => Auth::id(), // Ensure user_id is set
        ]);
    
        Auth::user()->likes()->save($like);
    
        return redirect()->back();
    }
}