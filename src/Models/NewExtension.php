<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class NewExtension extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_new_extension';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'extension',
        'context',
        'unique_id',
        'priority',
        'application',
        'app_data',
    ];
}
