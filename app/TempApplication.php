<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;
use Webpatser\Uuid\Uuid;
use function PHPUnit\Framework\isNull;

class TempApplication extends Model
{
    use hasUuid;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'age',
        'steam_url',

        'rules_opinion',
        'rp_definition',
        'past_characters',
        'character_idea',
        'streamer',
        'me_do',
        'ooc_vs_ic',
        'do_lying',
        'revenge_kill',
        'brutally_wounded',
        'meta_gaming',
        'power_gaming',
        'rp_action_1',
        'rp_action_2',
        'rp_action_3',
        'rp_action_4',
        'rp_action_5',
        'rp_action_6',
        'rp_action_7',
        'rp_action_8',
        'rp_action_9',
        'rp_action_10',
    ];


    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function getReason($id){
        $reason = ReturnedLogs::where('app_uuid', $id)->latest()->first();
        if(!$reason) return "Nie podano";
        return $reason->reason;
    }
}
