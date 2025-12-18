<?php

namespace Tests\Unit\Books;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestBookStore extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_can_store_book(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/books', [
                'title' => 'Harry Potter'
            ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'book' => [
                'id',
                'title'
            ]
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Harry Potter'
        ]);
    }
}
