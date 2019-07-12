<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return Auth::user()->boards;
    }


    public function store(Request $request){

        Auth::user()->boards()->create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Save successfully'],200);
    }

    public function show($board){

        $board = Board::findOrFail($board);

        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }

        return $board;
    }



    public function update(Request $request, $id){

        $board = Board::findOrFail($id);

        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }

        $board->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Updated successfully'],200);
    }

    public function destroy($id){

        $board = Board::findOrFail($id);

        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }

        $delete = Board::destroy($id);

        if($delete){
            return response()->json(['message' => 'Deleted successfully'],200);
        }

        return response()->json(['message' => 'Deleted Failed'],401);

    }
}
