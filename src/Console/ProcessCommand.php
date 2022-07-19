<?php

namespace Ubuntu\Press\Console;

use Illuminate\Console\Command;

class ProcessCommand extends Command
{
    protected $signature = 'press:process';

    protected $description = 'Updates Blog posts.';

    public function handle()
    {
        $this->info('Test');
    }

}