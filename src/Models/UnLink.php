<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class UnLink extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_unlink';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel_first',
        'channel_second',
        'caller_id_first',
        'caller_id_second',
        'unique_id_first',
        'unique_id_second',
    ];
}
