<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueStatusComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_status_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
}
