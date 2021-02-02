<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testOnlyNameIsRequiredToCreateAnAuthor()
    {
        Author::firstOrCreate([
            'name' =>'John Doe'
        ]);

        $this->assertCount(1, Author::all());
    }
}
