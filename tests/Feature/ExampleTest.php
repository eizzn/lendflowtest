<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_2_isbn_codes()
    {
        $response = $this->get('/api/1/nyt/best-sellers?isbn[]=9780786965755&isbn[]=9780786962235');

        $content = $response->content();
        $json = json_decode($content);

        self::assertCount(2, $json);
    }

    public function test_isbn_must_be_array()
    {
        $response = $this->get('/api/1/nyt/best-sellers?isbn=9780786965755');

        $response->assertStatus(400);
    }

    public function test_isbn_fails_less_than_10_characters()
    {
        $response = $this->get('/api/1/nyt/best-sellers?isbn[]=97807869657');

        $response->assertStatus(400);
    }

    public function test_offset_0_is_success()
    {
        $response = $this->get('/api/1/nyt/best-sellers?offset=0');

        $response->assertStatus(200);
    }

    public function test_offset_20_is_success()
    {
        $response = $this->get('/api/1/nyt/best-sellers?offset=20');

        $response->assertStatus(200);
    }

    public function test_offset_10_fails()
    {
        $response = $this->get('/api/1/nyt/best-sellers?offset=10');

        $response->assertStatus(400);
    }
}
