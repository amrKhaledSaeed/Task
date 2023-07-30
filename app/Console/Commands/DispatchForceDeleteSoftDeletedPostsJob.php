<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ForceDeleteSoftDeletedPosts;

class DispatchForceDeleteSoftDeletedPostsJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'force-delete:soft-deleted-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new ForceDeleteSoftDeletedPosts());
    }
}
