<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testBookCanBeAddedToTheLibrary()
    {
        $response = $this->post('/books', [
            'title' => 'Vojna i mir',
            'author' => 'Tolstoy'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
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

        $response = $this->patch($book->path(), [
            'title' => 'Zoki Poki',
            'author' => 'Olivera'
        ]);

        $this->assertEquals('Zoki Poki', Book::first()->title);
        $this->assertEquals('Olivera', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    public function testBookCanBeDeleted()
    {
        $this->post('/books', [
            'title' => '1984',
            'author' => 'Orwell'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
