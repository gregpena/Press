<?php

namespace Ubuntu\Press\Drivers;

use Illuminate\Support\Str;
use Ubuntu\Press\PressFileParser;

abstract class Driver
{
    protected $config;
    protected $posts = [];

    public function __construct()
    {
        $this->setConfig();

        $this->validateSource();
    }

    public abstract function fetchPosts();
    
    protected function setConfig()
    {
        //dd(config('press.file'));
        $this->config = config('press.'.config('press.driver'));
        //dd($this->config);
    }

    protected function validateSource()
    {
        return true;
    }

    protected function parse($content, $identifier)
    {
        $this->posts[] = array_merge(
            (new PressFileParser($content))->getData(),
            ['identifier' => Str::slug($identifier)]);
    }
}