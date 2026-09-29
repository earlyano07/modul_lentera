<?php

namespace Tests\Unit;

use App\Models\Material;
use PHPUnit\Framework\TestCase;

class MaterialTest extends TestCase
{
    public function test_youtube_url_parsing_for_standard_watch_url()
    {
        $material = new Material(['video' => 'https://www.youtube.com/watch?v=ShZ2IiF5k_U']);
        $this->assertTrue($material->isYoutubeVideo());
        $this->assertEquals('https://www.youtube.com/embed/ShZ2IiF5k_U', $material->getYoutubeEmbedUrl());
    }

    public function test_youtube_url_parsing_for_short_url()
    {
        $material = new Material(['video' => 'https://youtu.be/ShZ2IiF5k_U']);
        $this->assertTrue($material->isYoutubeVideo());
        $this->assertEquals('https://www.youtube.com/embed/ShZ2IiF5k_U', $material->getYoutubeEmbedUrl());
    }

    public function test_youtube_url_parsing_for_shorts_url()
    {
        $material = new Material(['video' => 'https://youtube.com/shorts/ShZ2IiF5k_U?si=uubSfsvm62bqlLVb']);
        $this->assertTrue($material->isYoutubeVideo());
        $this->assertEquals('https://www.youtube.com/embed/ShZ2IiF5k_U', $material->getYoutubeEmbedUrl());
    }

    public function test_youtube_url_parsing_for_non_youtube_video()
    {
        $material = new Material(['video' => 'materials/videos/sample.mp4']);
        $this->assertFalse($material->isYoutubeVideo());
        $this->assertNull($material->getYoutubeEmbedUrl());
    }
}
