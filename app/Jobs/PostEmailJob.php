<?php

namespace App\Jobs;

use App\Mail\PostMail;
use App\Models\Post;
use App\Models\SentPost;
use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PostEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        UserSubscription::with(['users'])->where('status',true)->chunk(100,function($userSubscriptions){
            foreach($userSubscriptions as $singleSubscription){
                if($singleSubscription->website_id == $this->post->website_id){
                    Mail::to($singleSubscription->user)->queue(new PostMail($this->post));
                    SentPost::create([
                      'user_id'=>$singleSubscription->user->id,
                      'post_id'=>$this->post->id
                    ]);
                }
                
            }
        });
    }
}
