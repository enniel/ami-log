<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_transfer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'transfer_method',
        'transfer_type',
        'target_channel',
        'sip_call_id',
        'unique_id',
        'target_unique_id',
        'transfer_extension',
        'transfer_context',
    ];
}
