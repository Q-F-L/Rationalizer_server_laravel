<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|min:1|max:150',
            'discussion_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->failed()) {
            return response()->json([
                'error' => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validator->errors(),
                ]
            ], 422);
        }

        $message = new Message();
        $message->message = $request->input('message');
        $message->user_id = $request->input('user_id');
        $message->discussion_id = $request->input('discussion_id');
        $message->save();
        return response()->json([
            'message' => 'create you\'r message'
        ]);
    }

    public function delete($user_id, $id, Request $request)
    {
        $user = DB::table('users')->where('remember_token', $request->bearerToken())->first();
        if($user->id == $user_id)
        {
            return Message::destroy($id);
        }
    }

    public function edit($id, Request $request)
    {
        $user = DB::table('users')->where('remember_token', $request->bearerToken())->first();

        $validator = Validator::make($request->all(), [
            'message' => 'required|min:1|max:150',
            'discussion_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->failed()) {
            return response()->json([
                'error' => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validator->errors(),
                ]
            ], 422);
        }
        

        if($user->id == $request->user_id)
        {
            $message = Message::find($id);
            $message->message = $request->input('message');
            $message->save();
            return response()->json([
                'message' => 'edit you\'r message'
            ]);
        }
    }
}
