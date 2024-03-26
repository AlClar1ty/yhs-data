<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baptism extends Model
{
    protected $fillable = [
    	'name',
		'gender',
		'tgl_lahir',
		'tempat_lahir',
		'father_name',
		'mother_name',
		'phone',
		'alamat',
		'baptism_date',
		'description',
		'consellour_id',
		'baptized_by_id',
		'district_id'
    ];

    public function consellour()
    {
        return $this->belongsTo('App\Pastor');
    }

    public function baptizedBy()
    {
        return $this->belongsTo('App\Pastor');
    }

    public function district_detail(){
        return $this->belongsTo('App\RajaOngkir_Subdistrict', 'district_id', 'id');
    }
}
