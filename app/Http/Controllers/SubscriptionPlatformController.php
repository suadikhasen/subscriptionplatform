<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Carbon\Carbon;
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

    public function subscribe(SubscriptionRequest $subscriptionRequest)
    {
         $subscription = Subscription::findOrFail($subscriptionRequest->subscription_id);
         $userSubscription = UserSubscription::create([
            'user_id'=>$subscriptionRequest->user_id,
            'start_date'=>Carbon::today(),
            'expired_date'=>Carbon::today()->addDays($subscription->druation)
         ]);
         return response()->json([
            'subscription'=>$userSubscription,
            'message'=>'subscribed successfully.'
         ],Response::HTTP_OK);
    }
}
