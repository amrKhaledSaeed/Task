<?php

namespace App\Jobs;

use App\Http\RepositoryInterface\PostInterface;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ForceDeleteSoftDeletedPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $postInterface;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct(PostInterface $postInterface)
    // {
    //     $this->postInterface = $postInterface;
    // }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $posts = Post::onlyTrashed()->where('deleted_at', '<', now()->subDays(30))->get();
    foreach ($posts as $post) {
        $post->forceDelete();
    }
    }
}
