<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller
{
    public function index()
{
    $numUsers = Cache::remember('numUsers', 60, function () {
        return User::count();
    });

    $numPosts = Cache::remember('numPosts', 60, function () {
        return Post::count();
    });

    $numUsersWithNoPosts = Cache::remember('numUsersWithNoPosts', 60, function () {
        return User::doesntHave('posts')->count();
    });

    return response()->json([
        'num_users' => $numUsers,
        'num_posts' => $numPosts,
        'num_users_with_no_posts' => $numUsersWithNoPosts,
    ]);
}
}
