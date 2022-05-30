<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|min:4|max:50|unique:users,email',
            'name' => 'required|min:1|max:35',
            'password' => 'required|min:6|max:20',
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


        $user = new User();
        $user->email = $req->input('email');
        $user->name = $req->input('name');
        $user->password = Hash::make($req->input("password"));
        $user->type = 'user';
        $user->remember_token = '';
        $user->save();

        return response()->json([
            'code' => '1',
            'message' => "register"
        ]);
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|min:4|max:50',
            'password' => 'required|min:6|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validator->errors(),
                ]
            ], 422);
        }

        $user = User::where("email", $req->email)->first();


        if (!$user)
            return response()->json("This user does not exist!");
        if (!Hash::check($req->password, $user->password))
            return response()->json("The entered data is incorrect!");

        $token = Str::random(60);
        $user->remember_token = $token;
        $user->save();

        return response()->json(
            [
                "message" => 'login',
                "user_id" => $user->id,
                "token" => $token,
                'type' => $user->type,
            ]
        );
    }

    public function search($id, Request $request)
    {
        $user = User::where('remember_token', $request->bearerToken())->first();

        if ($user->id == $id) {
            $user = User::find($id);
            $count = 0;

            foreach ($user->project as $project) {
                if ($project['status'] === 'approved') {
                    $count++;
                }
            }

            return response()->json([
                'name' => $user['name'],
                'estimation' => count($user->rating),
                'comments' => count($user->message),
                'offers' => count($user->project),
                'approved' => $count
            ]);
        }
    }
}
