<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Masquerade extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_masquerade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'clone',
        'clone_state',
        'original',
        'original_state',
    ];
}
