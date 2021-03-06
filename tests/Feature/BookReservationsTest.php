<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title'     => 'Book Title',
            'author'    =>'kamaluddin'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title'     => '',
            'author'    =>'kamaluddin'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        $response = $this->post('/books', [
            'title'     => 'Book Title',
            'author'    =>''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title'     => 'Book Title',
            'author'    =>'kamaluddin'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'New Book Title',
            'author'=> 'New Author'
        ]);

        $this->assertEquals('New Book Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}