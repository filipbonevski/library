<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $this->post('/author', [
            'name' => 'Orwell',
            'dob' => '05/14/1945'
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1945/14/05', $author->first()->dob->format('Y/d/m'));
    }
}
