<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class,'website_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'website_id');

    }

}
