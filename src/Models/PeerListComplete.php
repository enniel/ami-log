<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class PeerListComplete extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_peer_list_complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_items',
    ];
}
