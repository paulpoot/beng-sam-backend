<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Conversation extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'user_id', 'bot_id', 'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at'
    ];

    /**
     * Define a one-to-many relationship with App\Message
     */
    public function messages() {
        return $this->hasMany('App\Message');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
