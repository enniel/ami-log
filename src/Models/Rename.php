<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class Rename extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_rename';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'old_name',
        'new_name',
        'unique_id',
    ];
}
