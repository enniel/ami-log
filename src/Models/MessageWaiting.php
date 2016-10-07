<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class MessageWaiting extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_message_waiting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'mailbox',
        'waiting',
    ];
}
