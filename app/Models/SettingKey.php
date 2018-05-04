<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingKey extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'setting_keys';

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
    protected $fillable = ['key'];

    /**
     * Get the users of role.
     */

    public function values()
    {
        return $this->hasMany('App\Models\SettingValue');
    }

    public function chosenValue()
    {
        return $this->hasMany('App\Models\SettingValue')->where('choose', true);
    }

}
