<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testBookCanBeAddedToTheLibrary()
    {
        $response = $this->post('/books', $this->data());

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
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    public function testBookCanBeUpdated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'Zoki Poki',
            'author_id' => 'Olivera'
        ]);

        $this->assertEquals('Zoki Poki', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    public function testBookCanBeDeleted()
    {
        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    public function testNewAuthorIsAutomaticallyAdded()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => '1984',
            'author_id' => 'Orwell'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data(): array
    {
        return [
            'title' => 'Vojna i mir',
            'author_id' => 'Tolstoy'
        ];
    }
}
