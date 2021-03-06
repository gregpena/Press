<?php

namespace Ubuntu\Press\Tests;

use Ubuntu\Press\PressFileParser;
use Carbon\Carbon;

class PressFileParserTest extends TestCase
{
    /** @test */
    public function the_head_and_body_gets_split()
    {
        $pressFileParser = (new PressFileParser(__DIR__.'/../blogs/MarkFile1.md'));

        $data = $pressFileParser->getRawData();
        
        $this->assertStringContainsString('title: My Title', $data[1]);
        $this->assertStringContainsString('description: Description here', $data[1]);
        $this->assertStringContainsString('Blog post body here', $data[2]);              
    }

    /** @test */
    public function a_string_can_also_be_used_instead()
    {
        $pressFileParser = (new PressFileParser("---\r\ntitle: My Title\r\ndescription: Description here\r\n---\r\n\r\n# Heading\r\n\r\nBlog post body here"));

        $data = $pressFileParser->getRawData();
        
        $this->assertStringContainsString('title: My Title', $data[1]);
        $this->assertStringContainsString('Blog post body here', $data[2]);              
    }

    /** @test */
    public function each_head_field_gets_separated()
    {
        $pressFileParser = (new PressFileParser(__DIR__.'/../blogs/MarkFile1.md'));

        $data = $pressFileParser->getData();
        
       $this->assertEquals('My Title', $data['title']);
       $this->assertEquals('Description here', $data['description']);  
    }
    
    /** @test */
    public function the_body_gets_saved_and_trimmed()
    {
        $pressFileParser = (new PressFileParser(__DIR__.'/../blogs/MarkFile1.md'));

        $data = $pressFileParser->getData();
        
        $this->assertEquals("<h1>Heading</h1>\n<p>Blog post body here</p>", $data['body']);
    }

    /** @test */
    public function a_date_field_gets_parsed()
    {
        $pressFileParser = (new PressFileParser("---\r\ndate: October 18, 1968\r\n---\r\n"));

        $data = $pressFileParser->getData();
        $this->assertInstanceOf(Carbon::class, $data['date']);
        
        $this->assertEquals("10-18-1968", $data['date']->format('m-d-Y'));
    }
    /** @test */
    public function an_extra_field_gets_saved()
    {
        $pressFileParser = (new PressFileParser("---\r\nauthor: Greg Pena\r\n---\r\n"));

        $data = $pressFileParser->getData();
        
        $this->assertEquals(json_encode(['author' => 'Greg Pena']), $data['extra']);
    }
    
    /** @test */
    public function two_additional_fields_are_put_into_extra()
    {
        $pressFileParser = (new PressFileParser("---\r\nauthor: Greg Pena\r\nimage: some/image.jpg\r\n---\r\n"));

        $data = $pressFileParser->getData();
        
        $this->assertEquals(json_encode(['author' => 'Greg Pena', 'image' => 'some/image.jpg']), $data['extra']);
    }
}