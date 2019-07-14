<?php

namespace App\Http\Controllers;

use App\Board;
use App\Lists;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // All privilege for Auth
    }

    public function index($board){
        $board = Board::findOrfail($board);
        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }
        return Response()->json(['lists'=>$board->lists]);
    }


    public function show($boardId, $listId){

        $board = Board::findOrFail($boardId);

        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }

        return $board->list()->findOrfail($listId);
    }


    public function store(Request $request, $boardId){

        $this->validate($request, ['name' => 'required']);

        $board = Board::findOrfail($boardId);

        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }

        $board->lists()->create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Save successfully'],200);
    }

    public function update(Request $request, $boardId, $listId){

        $this->validate($request, ['name' => 'required']);

        $board = Board::findOrFail($boardId);

        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }

        $board->lists()->findOrFail($listId)->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Updated successfully'],200);
    }

    public function destroy($boardId, $listId){

        $board = Board::findOrFail($boardId);

        if(Auth::user()->id!==$board->user_id){
            return response()->json(['status'=>'error', 'message' => 'Unauthorized'],200);
        }

        $delete = $board->lists()->findOrFail($listId)->delete();

        if($delete){
            return response()->json(['message' => 'Deleted successfully'],200);
        }

        return response()->json(['message' => 'Deleted Failed'],401);

    }
}
