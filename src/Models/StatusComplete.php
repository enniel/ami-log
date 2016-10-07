<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class StatusComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_status_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'items',
    ];
}
