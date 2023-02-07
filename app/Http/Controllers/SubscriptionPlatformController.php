<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionPlatformController extends Controller
{
    public function post(PostRequest $postRequest)
    {
        $post = Post::create($postRequest->toArray());
        return response()->json([
            'post'=>$post,
            'message'=>'post created successfully'
        ],Response::HTTP_CREATED);
    }
}
