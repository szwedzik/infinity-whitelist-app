<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedLogs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason',
        'admin',
        'action'
    ];

    public static string $foreingKey = 'app_uuid';

}
