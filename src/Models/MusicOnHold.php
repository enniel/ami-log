<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class MusicOnHold extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_music_on_hold';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'state',
        'unique_id',
    ];
}
