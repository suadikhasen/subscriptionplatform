<?php

namespace App\Console\Commands;

use App\Mail\PostMail;
use App\Models\Post;
use App\Models\SentPost;
use Illuminate\Console\Command;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Mail;

class SendPOstEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:post-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends post email to users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        UserSubscription::with(['users'])->where('status', true)->chunk(100, function ($userSubscriptions) {
            foreach ($userSubscriptions as $singleSubscription) {
                Post::where('website_id',$singleSubscription->website_id)->chunk(100,function($posts) use ($singleSubscription){
                    foreach($posts as $post){
                        if(!SentPost::where('user_id',$singleSubscription->user_id)->where('post_id',$post->id)->exists()){
                            Mail::to($singleSubscription->user)->queue(new PostMail($post));
                            SentPost::create([
                              'user_id'=>$singleSubscription->user->id,
                              'post_id'=>$post->id
                            ]);
                        }
                    }
                   
                });
            }
        });
    }
}
