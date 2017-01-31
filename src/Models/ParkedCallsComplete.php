<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class ParkedCallsComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_parked_calls_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];
}
