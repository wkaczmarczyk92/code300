<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Author;

class StoreAuthorLastStoredBookTitle implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $author_id, private string $book_title)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $author = Author::find($this->author_id);

        if (!$author) {
            return;
        }

        $author->last_stored_book_title = $this->book_title;
        $author->save();
    }
}
