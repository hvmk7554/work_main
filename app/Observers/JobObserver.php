<?php

namespace App\Observers;

use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Services\RedisPublishingService;

class JobObserver
{
    /**
     * Handle the Job "created" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function created(Job $job)
    {
        RedisPublishingService::publishMessage('job', 'created', new JobResource($job));
    }

    /**
     * Handle the Job "updated" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function updated(Job $job)
    {
        //
    }

    /**
     * Handle the Job "deleted" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function deleted(Job $job)
    {
        //
    }

    /**
     * Handle the Job "restored" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function restored(Job $job)
    {
        //
    }

    /**
     * Handle the Job "force deleted" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function forceDeleted(Job $job)
    {
        //
    }
}
