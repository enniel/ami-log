<?php

namespace Enniel\AmiLog\Models;

use Illuminate\Database\Eloquent\Model;

class DAHDIShowChannels extends Model
{
    /**
     * {@inheritdoc}
     */
    public $table = 'ami_log_dahdi_show_channels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel',
        'signalling',
        'signalling_code',
        'context',
        'dnd',
        'alarm',
    ];
}
