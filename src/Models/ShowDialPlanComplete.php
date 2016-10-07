<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class ShowDialPlanComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_show_dial_plan_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'list_items',
        'list_extensions',
        'list_priorities',
        'list_contexts',
    ];
}
