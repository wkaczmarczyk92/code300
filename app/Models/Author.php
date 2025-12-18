<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Book;

class Author extends Model
{
    protected $fillable = [
        'first_name',
        'last_name'
    ];

    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string'
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(
            Book::class,
            'author_has_books',
            'author_id',
            'book_id'
        );
    }
}
