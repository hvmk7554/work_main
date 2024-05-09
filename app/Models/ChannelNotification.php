<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelNotification extends Model
{
    use SoftDeletes;

    protected $table = 'channel_notifications';

    const CHANNEL_ZALO = 'zalo';
    const CHANNEL_EMAIL = 'email';
    const CHANNEL_SMS = 'sms';

    protected $fillable = [
        'type',
        'priority',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'priority' => 'integer',
        'status' => 'boolean'
    ];

    public function templates(): BelongsToMany{
        return $this->belongsToMany(ZaloTemplate::class,'channel_notification_templates','channel_notification_id','template_id');
    }
}
