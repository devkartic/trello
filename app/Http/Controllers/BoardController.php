<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth', ['only'=>'store']); // Single privilege for Auth
        $this->middleware('auth'); // All privilege for Auth
    }

    public function index(){
        return Board::all();
    }

    public function show($boardId){
        $board = Board::findOrFail($boardId);
        return $board;
    }

    public function store(Request $request){

        Board::create([
            'name' => $request->input('name'),
            'user_id' => 1,
        ]);

        return response()->json(['message' => 'success'],200);
    }
}
