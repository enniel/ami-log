<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Jabber extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_jabber';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'account',
        'packet',
    ];
}
