<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Author;

class Book extends Model
{
    protected $fillable = [
        'title'
    ];

    protected $casts = [
        'title' => 'string'
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(
            Author::class,
            'author_has_books',
            'book_id',
            'author_id'
        );
    }
}
