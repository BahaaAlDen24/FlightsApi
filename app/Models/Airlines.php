<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airlines extends Model
{



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'airlines';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['ANAME', 'ENAME', 'ADESCRIPTION', 'EDESCRIPTION', 'CODE', 'IMGSRC1', 'IMGSRC2', 'IMGSRC3', 'IMGSRC4', 'CREATED_AT', 'UPDATED_AT'];

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
