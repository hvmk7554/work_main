<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'changes',
        'original',
        'batch_id',
        'user_id',
        'name',
        'actionable_type',
        'actionable_id',
        'target_type',
        'target_id',
        'model_type',
        'model_id',
        'fields',
        'exception'
    ];

    protected $casts = [
        'changes' => 'json',
        'original' => 'json'
    ];

    public static function getActionName(string|null $type = null): array
    {
        $data = ActionEvent::query()->where(function (Builder $query) use ($type){
            if($type) $query->where('target_type',$type);
        })->groupBy('name')->get('name')->pluck('name','name')->toArray();

        return array_map('ucfirst', array_map('strtolower', $data));
    }

    public static function getActionStatus(): array
    {
        $data = ActionEvent::query()->groupBy('status')->get('status')->pluck('status','status')->toArray();
        return array_map('ucfirst', array_map('strtolower', $data));
    }
    //build again

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class,'target_id','id')->where('target_type',Subscription::class);
    }
}
