<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class VarSet extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_varset';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'unique_id',
        'channel',
        'variable',
        'value',
    ];
}
