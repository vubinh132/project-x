<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    const CATEGORY = [
        'SECURITY' => 1,
        'JOB' => 2,
        'ERROR' => 4,

        //specific
        'ROM' => 101,
        'ACTIVITIES' => 102

    ];
    const CATEGORY_TEXT = [
        'SECURITY' => 'Security',
        'JOB' => 'Cron-job',
        'ERROR' => 'Error',
        'ROM' => 'Rom',
        'ACTIVITIES' => 'Activities'
    ];

    const NOTIFICATION_TYPE = [
        'NONE' => 0,
        'MAIL' => 1

    ];
    const NOTIFICATION_TYPE_TEXT = [
        'NONE' => 'None',
        'MAIL' => 'Mail'
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
