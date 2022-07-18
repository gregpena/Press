<?php

namespace Ubuntu\Press\Tests;

use Ubuntu\Press\MarkdownParser;

class MarkdownTest extends TestCase
{
    /** @test */
    public function simple_markdown_is_parsed()
    {
        $this->assertEquals('<h1>test string</h1>', MarkdownParser::parse("# test string"));
    }
}