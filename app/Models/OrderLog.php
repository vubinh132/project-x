<?php

namespace App\Models;

use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Model;
use File, DB, Exception, Log;
use Carbon\Carbon;
use GuzzleHttp\Client;

class OrderLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_logs';

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
    protected $fillable = ['order_id', 'from', 'to', 'entity_id', 'is_manual', 'creation_time'];

    public $timestamps = false;

    public function order()
    {
        return $this->belongs('App\Models\Order', 'order_id');
    }

    public function entity()
    {
        return $this->belongs('App\Models\User', 'entity_id');
    }

}
