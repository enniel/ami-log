<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationsComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_registrations_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_items',
    ];
}
