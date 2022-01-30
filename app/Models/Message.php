<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    

    public function user($user_id)
    {
        $user = User::find($user_id);
        return $user;
    } 

}
