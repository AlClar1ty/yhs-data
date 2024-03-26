<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeddingBless extends Model
{
    protected $fillable = [
    	'male_name',
		'female_name',
		'datetime_bless',
		'address_bless',
		'description',
		'pastor_id',
        'district_id'
    ];

    public function pastor()
    {
        return $this->belongsTo('App\Pastor');
    }

    public function district_detail(){
        return $this->belongsTo('App\RajaOngkir_Subdistrict', 'district_id', 'id');
    }
}
