<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class QueueSummaryComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_queue_summary_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];
}
