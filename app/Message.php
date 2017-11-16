<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Message extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'conversation_id', 'user_id', 'content'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',  'updated_at',
    ];

    /**
     * Define an inverse one-to-many relationship with App\User.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Define an inverse one-to-many relationship with App\Conversation
     */
    public function conversation() {
        return $this->belongsTo('App\Conversation');
    }
}
