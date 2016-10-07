<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DBGetResponse extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_db_get_response';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'family',
        'key',
        'val',
    ];
}
