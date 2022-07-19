<?php

namespace Ubuntu\Press\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Ubuntu\Press\Post;

class SavePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_can_be_created_with_the_factory()
    {
        $post = factory(Post::class)->create();

        $this->assertCount(1, Post::all());
        
    }
}