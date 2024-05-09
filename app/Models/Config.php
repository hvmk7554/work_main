<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes;

    protected $table = 'config';

    protected $fillable = [
        'noti_send_all_channel'
    ];

    protected $casts = [
        'noti_send_all_channel' => 'boolean'
    ];

    public function channels(): HasMany{
        return $this->hasMany(ChannelNotification::class);
    }
}
