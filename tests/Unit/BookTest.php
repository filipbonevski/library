<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorIdIsRecorded()
    {
        Book::create([
            'title' => '1984',
            'author_id' => 1
        ]);

        $this->assertCount(1, Book::all());
    }
}
