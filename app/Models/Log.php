<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    const CATEGORY = [
        'SECURITY' => 1,
        'JOB' => 2,

    ];
    const CATEGORY_TEXT = [
        'SECURITY' => 'Security',
        'JOB' => 'Cron-job'
    ];

    const NOTIFICATION_TYPE = [
        'NONE' => 0,

    ];
    const NOTIFICATION_TYPE_TEXT = [
        'NONE' => 'None',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'logs';

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
    protected $fillable = ['category', 'content', 'notification_type'];

    /**
     * Get the users of role.
     */
    public function categoryText()
    {
        return $this->category ? Log::CATEGORY_TEXT[array_keys(Log::CATEGORY, $this->category)[0]] : '';
    }

    public static function getCategories(){
        $categories = [];
        $categories[0] = 'ALL';
        foreach (Log::CATEGORY as $key => $value){
            $categories[$value] = $key;
        }
        return $categories;
    }

}
