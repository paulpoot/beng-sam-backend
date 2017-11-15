<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'user_id', 'bot_id',
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
     * Define a one-to-many relationship with App\Message
     */
    public function messages() {
        return $this->hasMany('App\Message');
    }
}
