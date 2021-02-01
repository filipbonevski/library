<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function testBookCanBeAddedToTheLibrary()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Vojna i mir',
            'author' => 'Tolstoy'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function testTitleIsRequired()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Orwell'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function testAuthorIsRequired()
    {
        $response = $this->post('/books', [
            'title' => '1984',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function testBookCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => '1984',
            'author' => 'Orwell'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'Zoki Poki',
            'author' => 'Olivera'
        ]);

        $this->assertEquals('Zoki Poki', Book::first()->title);
        $this->assertEquals('Olivera', Book::first()->author);
    }
}
