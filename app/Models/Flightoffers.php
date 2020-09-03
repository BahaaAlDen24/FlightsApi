<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flightoffers extends Model
{



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'flightoffers';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['OFFERID', 'FLIGHTID', 'ADESCRIPTION', 'EDESCRIPTION', 'CREATED_AT', 'UPDATED_AT'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['CREATED_AT', 'UPDATED_AT'];

}
