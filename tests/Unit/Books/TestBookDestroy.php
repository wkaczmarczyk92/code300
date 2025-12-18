<?php

namespace Tests\Unit\Books;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestBookDestroy extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_book_destroy(): void
    {
        $user = User::factory()->create();
        $book = Book::create([
            'title' => fake()->sentence(3)
        ]);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->deleteJson('/api/books/' . $book->id, );

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', [
            'id' => $book->id
        ]);
    }
}
