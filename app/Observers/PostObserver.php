<?php

namespace App\Observers;

use App\Jobs\PostEmailJob;
use App\Models\Post;

class PostObserver
{
     /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $user
     * @return void
     */
    public function created(Post $post)
    {
        PostEmailJob::dispatch($post);
    }
}
