<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_group_user');
    }
}
