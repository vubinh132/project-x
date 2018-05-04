<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'diary';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'content'];

    /**
     * Get the users of role.
     */

}
