<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use Illuminate\Http\JsonResponse;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $authors = Author::with('books')->paginate(200);
            return response()->json([
                'authors' => $authors
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas pobierania informacji o autorach.'
            ], 500);
        }
    }

    public function store(AuthorStoreRequest $request): JsonResponse
    {
        try {
            $author = Author::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name')
            ]);

            if ($request->has('book_id')) {
                $author->books()->attach($request->input('book_id'));
                $author->load('books');
            }

            return response()->json([
                'msg' => 'Autor został dodany.',
                'author' => $author
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas dodawania autora.'
            ], 500);
        }
    }

    public function update(AuthorUpdateRequest $request, Author $author): JsonResponse
    {
        try {
            $author->fill($request->only([
                'first_name',
                'last_name',
            ]));

            if ($author->isDirty()) {
                $author->save();
            }

            return response()->json([
                'message' => 'Autor został zaktualizowany.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas aktualizowania autora.'
            ], 500);
        }
    }

    public function destroy(Author $author): JsonResponse
    {
        try {
            $result = $author->delete();
            $msg = $result ? 'Autor został usunięty.' : 'Wystąpił błąd podczas usuwania autora.';
            $code = $result ? 200 : 409;
            return response()->json([
                'message' => $msg
            ], $code);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Wystąpił błąd podczas usuwania autora.'
            ], 500);
        }
    }
}
