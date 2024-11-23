<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SearchController extends Controller
{
    use ValidatesRequests;

    public function getResults(Request $request)
    {
        $query = $request->input('query');
    
        if (!$query) {
            return redirect()->route('home');
        }
    
        $users = User::whereRaw('(first_name || " " || last_name) LIKE ?', ["%{$query}%"])
            ->orWhere('username', 'LIKE', "%{$query}%")
            ->get();
    
        return view('search.results')->with('users', $users);
    }
}