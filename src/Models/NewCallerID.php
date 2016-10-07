<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class NewCallerID extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_new_caller_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'caller_id_num',
        'caller_id_name',
        'unique_id',
        'cid_calling_pres',
    ];
}
