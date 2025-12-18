<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Jobs\StoreAuthorLastStoredBookTitle;

use App\Models\Book;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $books = Book::with('authors')->paginate(200);
            return response()->json([
                'books' => $books
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas pobierania informacji o książkach.'
            ], 500);
        }
    }

    public function store(BookStoreRequest $request): JsonResponse
    {
        try {
            $book = Book::create([
                'title' => $request->input('title')
            ]);

            if ($request->has('author_id')) {
                $book->authors()->sync($request->input('author_id'));
                $book->load('authors');
                StoreAuthorLastStoredBookTitle::dispatch(
                    $request->input('author_id'),
                    $request->input('title')
                );
            }

            if ($request->has('author_ids')) {
                $book->authors()->sync($request->input('author_ids'));
                $book->load('authors');

                foreach ($request->input('author_ids') as $author_id) {
                    StoreAuthorLastStoredBookTitle::dispatch(
                        $author_id,
                        $request->input('title')
                    );
                }
            }

            return response()->json([
                'msg' => 'Książka została dodana.',
                'book' => $book
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas dodawania książki.'
            ], 500);
        }
    }

    public function update(BookUpdateRequest $request, Book $book): JsonResponse
    {
        try {
            $book->fill($request->only([
                'title'
            ]));

            if ($book->isDirty()) {
                $book->save();
            }

            return response()->json([
                'message' => 'Książka została zaktualizowana.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas aktualizowania książki.'
            ], 500);
        }
    }

    public function destroy(Book $book): JsonResponse
    {
        try {
            $result = $book->delete();
            $msg = $result ? 'Książka została usunięta.' : 'Wystąpił błąd podczas usuwania książki.';
            $code = $result ? 200 : 409;
            return response()->json([
                'message' => $msg
            ], $code);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas usuwania książki.'
            ], 500);
        }
    }
}
