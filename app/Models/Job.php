<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    public const statusPending = 'pending';
    public const statusProcessing = 'processing';
    public const statusCompleted = 'completed';
    public const statusFailed = 'failed';

    protected $with = ['actionType'];

    protected $fillable = ['type_name', 'status', 'course_id', 'sku_id', 'resource'];

    public function actionType(): BelongsTo
    {
        return $this->belongsTo('job_types', 'type_name', 'name', JobType::class);
    }
}
