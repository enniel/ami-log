<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class ExtensionStatus extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_extension_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'status',
        'extension',
        'context',
        'hint',
    ];
}
