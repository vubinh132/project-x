<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingValue extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'setting_values';

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
    protected $fillable = ['setting_key_id', 'value', 'description', 'choose'];

    /**
     * Get the users of role.
     */

    public $timestamps = false;

}
