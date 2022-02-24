<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DiscussionController;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function search($id)
    {
        return Project::find($id);
    }

    public function create(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'topic' => 'required|min:4|max:50',
            'title' => 'required|min:1|max:35',
            'now_description' => 'required|min:6|max:500',
            'now_video' => '',
            'now_photo' => '',
            'need_description' => 'required|min:6|max:500',
            'need_video' => '',
            'need_photo' => '',
            'will_description' => 'required|min:1|max:500',
            'rating' => '',
            'status' => '',
            'discussion_id' => '',
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

        function craete_discussion($title)
        {
            $discussion = new Discussion();
            $discussion->title = $title;
            $discussion->save();
            return $discussion['id'];
        }


        $project = new Project();
        $project->topic = $req->input('topic');
        $project->title = $req->input('title');
        $project->now_description = $req->input('now_description');
        $project->now_video = $req->input('now_video'); //сохранение видео в public
        $project->now_photo = $req->input('now_photo'); //сохранение фото в public        $project->need_description = $req->input('need_description');
        $project->need_video = $req->input('need_video');
        $project->need_photo = $req->input('need_photo');
        $project->need_description = $req->input('need_description');
        $project->will_description = $req->input('will_description');
        $project->rating = 0;
        $project->status = 'consideration';
        $project->discussion_id = craete_discussion($req->input('title')); //автоматиеческое создание дискусий
        $project->user_id = $req->input('user_id');
        $project->save();

        return response()->json([
            'code' => '1',
            'message' => "Create project"
        ]);
    }

    

    public function index()
    {
        return Project::all();
    }

    public function searchName($title)
    {
        return DB::table('projects')->where('title', 'like', $title.'%')->get();
    }


}
