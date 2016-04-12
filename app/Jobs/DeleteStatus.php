<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Exception;
use App\Status;

class DeleteStatus extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Status $status) 
    {
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $provider = '\App\Http\Socials\Providers\\'.ucwords($this->status->provider);
            $post = new $provider($this->status);
            $post->delete();
        } catch (Exception $e) {
            //do nothing
        }
    }
}
