<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiData extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_data';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $dates = ['last_time_called'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['path', 'number_of_uses', 'last_time_called', 'is_locked'];


}
