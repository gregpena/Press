<?php

namespace Ubuntu\Press\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ubuntu\Press\Post;
use Ubuntu\Press\Facades\Press;
use Ubuntu\Press\Repositories\PostRepository;

class ProcessCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'press:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Blog posts.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'press:process';

    /**
     * Execute the console command.
     *
     * @param \ubuntu\Press\Repositories\PostRepository $postRepository
     *
     * @return mixed
     */
    public function handle(PostRepository $postRepository)
    {
        if (Press::configNotPublished()) {
            return $this->warn('Please publish the config file by running ' .
            '\'php artisan vendor:publish --tag=press-config\'');
        }
        try {
            $posts=Press::driver()->fetchPosts();

            $this->info('Number of Posts: '. count($posts));

        foreach($posts as $post){
           $postRepository->save($post);

           $this->info('Post: '. $post['title']);
        }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}