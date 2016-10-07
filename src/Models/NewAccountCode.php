<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class NewAccountCode extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_new_account_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'privilege',
        'channel',
        'unique_id',
        'account_code',
        'old_account_code',
    ];
}
