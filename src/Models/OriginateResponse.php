<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class OriginateResponse extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_originate_response';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'extension',
        'channel',
        'context',
        'reason',
        'unique_id',
        'action_id',
        'response',
        'caller_id_num',
        'caller_id_name',
    ];
}
