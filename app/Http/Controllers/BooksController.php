<?php

namespace App\Http\Controllers;

use App\Authors;
use App\Books;
use App\Transformers\BookAuthorTransformer;
use App\Transformers\BooksTransformer;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        return [
            'filters' => $request->all('filters', 'borrowed_filter'),
            'books' => fractal(Books::filter($request->all())->orderBy('id', 'DESC')->get(), new BooksTransformer())
        ];
    }

    public function edit(Books $book)
    {
        return fractal($book, new BooksTransformer())->toJson();
    }

    public function getBookAuthorsForm()
    {
        return fractal(Authors::all(), new BookAuthorTransformer())->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|max:500',
                'author_id' => 'required|integer',
                'is_borrowed' => 'required'
            ]);
            $book = new Books([
                'title' => $request->input('title'),
                'author_id' => $request->input('author_id'),
                'is_borrowed' => $request->input('is_borrowed')
            ]);
            $book->save();
            return response()->json(['message' => 'Kniha bola úspešne vytvorená']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Books  $books
     * @return
     */
    public function update(Request $request, Books $book)
    {
        try {
            $request->validate([
                'title' => 'required|max:500',
                'author_id' => 'required|integer',
                'is_borrowed' => 'required'
            ]);
            $book->fill([
                'title' => $request->input('title'),
                'author_id' => $request->input('author_id'),
                'is_borrowed' => $request->input('is_borrowed')
            ])->save();

            return response()->json(['message' => 'Kniha bola úspešne aktualizovaná']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function updateBorrowed(Request $request, Books $books)
    {
        try {
            $request->validate([
                'is_borrowed' => 'required'
            ]);
            $books->update(['is_borrowed' => $request->input('is_borrowed')]);
            return response()->json(['message' => 'Stav knihy bol úspešne zmenený']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Books  $books
     * @return
     */
    public function destroy(Books $book)
    {
        try {
            $book->delete();
            return response()->json(['message' => 'Kniha bola úspešne zmazaná ']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
