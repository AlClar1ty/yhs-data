<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pastor extends Model
{
    protected $fillable = [
		'name', 'member_id'
    ];

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
}
