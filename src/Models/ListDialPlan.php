<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class ListDialPlan extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_list_dial_plan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'context',
        'extension',
        'priority',
        'application',
        'app_data',
        'registrar',
        'include_context',
    ];
}
