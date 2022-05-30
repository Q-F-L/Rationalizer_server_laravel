<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DiscussionController;
use App\Models\Discussion;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProjectController extends Controller
{
    public function search($id)
    {
        return  Project::find($id);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'user_id' => '',
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

        $user = User::where('remember_token', $request->bearerToken())->first();
        $project = new Project();
        $project->topic = $request->input('topic');
        $project->title = $request->input('title');
        $project->now_description = $request->input('now_description');
        $project->now_video = $request->input('now_video'); //сохранение видео в public
        $project->now_photo = $request->input('now_photo'); //сохранение фото в public        $project->need_description = $request->input('need_description');
        $project->need_video = $request->input('need_video');
        $project->need_photo = $request->input('need_photo');
        $project->need_description = $request->input('need_description');
        $project->will_description = $request->input('will_description');
        $project->rating = 0;
        $project->status = 'consideration';
        $project->discussion_id = craete_discussion($request->input('title')); //автоматиеческое создание дискусий
        $project->user_id = $request->input('user_id');
        $project->save();

        return response()->json([
            'code' => '1',
            'message' => "Create project from id = {$project->id}"
        ]);
    }

    

    public function index()
    {
        return response()->json([
            'project' => Project::all(),
        ]);
    }

    public function searchName($title)
    {
        return DB::table('projects')->where('title', 'like', $title.'%')->get();
    }

    public function delete($id, Request $request)
    {
        $project = Project::find($id);
        Discussion::destroy($project->discussion_id);
        Project::destroy($id);

        return response()->json([
            'code' => '1',
            'message' => "Delete project {$project->id}"
        ]);
    }

    public function filter_status($status)
    {
        $project = Project::where('status', $status)->get();
        return $project;
    }

    public function rating($id, $rating_get, Request $request)
    {
        $user = DB::table('users')->where('remember_token', $request->bearerToken())->first();
	      $project = Project::find($id);
	      $rating = DB::table('ratings')->where('project_id', '=', $id)->where('user_id', '=',$user->id)->first();
	      if ($rating != null) {
	      	if($rating_get <= 5 && $rating_get > 0)
	         {
	         	$rating_calc = $rating->rating - $rating_get; 
	            DB::table('ratings')->decrement('rating', $rating_calc);

	            return response()->json([
	                'code' => '1',
	                'message' => "Update rating in project ".$id,
	            ]);
	         }
	         return $rating_get <= 5 && $rating_get > 0 ? 'Obnovleno no error' : 'true';
	      } else {
	      	if(($rating_get <= 5 && $rating_get > 0))
	        {
	            $rating = new Rating;
	            $rating->user_id = $user->id;
	            $rating->project_id = $id;
	            $rating->rating = $rating_get;
	            $rating->save();

	            return response()->json([
	                'code' => '1',
	                'message' => "Create rating"
	            ]);
	        }

	        return response()->json([
	            'code' => '3',
	            'message' => "Error! У вас не достаточно прав!"
	        ]);
	      }
	      return 'Переданны некоректные данные';
    }

    public function rating_calc($project_id)
    {
        $rating = Rating::where('project_id', $project_id)->pluck('rating')->toArray();
        $math = 0;

        foreach ($rating as $key => $value) {
            $math += $value;
        }

        $math = round($math / count($rating), 1);
        $project = Project::where('id', $project_id)->first();
        $project->rating = $math;
        $project->save();
        return $project;
    }

    public function status($id, Request $request)
    {
        $project = Project::find($id);
        $project->status = $request->status;
        $project->save();
        return response()->json([
            'code' => '1',
            'message' => "Edit status"
        ]);
    }

    public function edit($id, Request $request)
    {
        $user = DB::table('users')->where('remember_token', $request->bearerToken())->first();
        $project = Project::find($id);
        
        if($user->id == $project->user_id)
        {
            $validator = Validator::make($request->all(), [
                'topic' => 'min:4|max:50',
                'title' => 'min:1|max:35',
                'now_description' => 'min:6|max:500',
                'need_description' => 'min:6|max:500',
                'will_description' => 'min:1|max:500',
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

            
            $project->topic = !empty($request->topic) ? $request->topic : $project->topic;
            $project->title = !empty($request->title) ? $request->title : $project->title;
            $project->now_description = !empty($request->now_description) ? $request->now_description : $project->now_description;
            $project->now_video = !empty($request->now_video) ? $request->now_video : $project->now_video;
            $project->now_photo = !empty($request->now_photo) ? $request->now_photo : $project->now_photo;
            $project->need_video = !empty($request->need_video) ? $request->need_video : $project->need_video;
            $project->need_photo = !empty($request->need_photo) ? $request->need_photo : $project->need_photo;
            $project->need_description = !empty($request->need_description) ? $request->need_description : $project->need_description;
            $project->will_description = !empty($request->will_description) ? $request->will_description : $project->will_description;
            $project->rating = $project->rating;
            $project->status = $project->status;
            $project->discussion_id = $project->discussion_id;
            $project->user_id = $project->user_id;
            $project->save();

            return response()->json([
                'code' => '1',
                'message' => "Edit project"
            ]);
        }

        return response()->json([
            'code' => '3',
            'message' => "Error! У вас не достаточно прав!"
        ]);
    }
}
