<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
		'name', 'type', 'gender', 'tgl_lahir', 'tempat_lahir', 'alamat', 'tgl_pernikahan', 'phone', 'active', 'member_id', 'district_id', 'photo', 'is_baptis',
    ];

    public function parent_member()
    {
        return $this->belongsTo('App\Member', 'member_id', 'id');
    }

    public function child_member()
    {
        return $this->hasMany('App\Member')->where('id', '!=', $this->id);
    }

    public function district_detail(){
        return $this->belongsTo('App\RajaOngkir_Subdistrict', 'district_id', 'id');
    }
}
