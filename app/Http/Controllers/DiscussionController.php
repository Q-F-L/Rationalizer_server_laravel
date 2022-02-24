<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function create($title){
        $discussion = new Discussion();
        $discussion->title = $title;
        $discussion->save();
        return $discussion['id'];
    }
}
