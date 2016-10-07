<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_registry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel',
        'domain',
        'status',
    ];
}
