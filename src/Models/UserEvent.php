<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_user_event';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'unique_id',
        'user_event',
    ];
}
