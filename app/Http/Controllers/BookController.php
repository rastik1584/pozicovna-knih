<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Transformers\BookAuthorTransformer;
use App\Transformers\BookTransformer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        return Inertia::render('Books', [
            'filters' => $request->all('filters', 'borrowed_filter'),
            'knihy' => fractal(Book::filter($request->all())->orderBy('id', 'DESC')->get(), new BookTransformer()),
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        return Inertia::render('BookForm', [
            'knihy' => ['title' => '', 'is_borrowed' => false, 'author_id' => ''],
            'authors' => fractal(Author::all(), new BookAuthorTransformer()),
        ]);
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
            $book = new Book([
                'title' => $request->input('title'),
                'author_id' => $request->input('author_id'),
                'is_borrowed' => $request->input('is_borrowed')
            ]);
            $book->save();
            return redirect()->route('knihy.index')->with('success', 'Kniha bola úspešne vytvorená !');
        } catch (\Exception $e) {
            return redirect()->route('knihy.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return
     */
    public function edit(Book $knihy)
    {
        return Inertia::render('BookForm', [
            'knihy' => $knihy,
            'authors' => fractal(Author::all(), new BookAuthorTransformer()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return
     */
    public function update(Request $request, Book $knihy)
    {
        try {
            $request->validate([
                'title' => 'required|max:500',
                'author_id' => 'required|integer',
                'is_borrowed' => 'required'
            ]);
            $knihy->fill([
                'title' => $request->input('title'),
                'author_id' => $request->input('author_id'),
                'is_borrowed' => $request->input('is_borrowed')
            ])->save();

            return redirect()->route('knihy.index')->with('success', 'Kniha bola úspešne vytvorená !');
        } catch (\Exception $e) {
            return redirect()->route('knihy.index')->with('error', $e->getMessage());
        }
    }

    public function updateBorrowed(Request $request, Book $knihy)
    {
        try {
            $request->validate([
                'is_borrowed' => 'required|boolean'
            ]);
            $knihy->update(['is_borrowed' => $request->is_borrowed]);
            return response()->json(['success', 'Stav knihy bol aktualizovaný'])->header('X-Inertia', true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage()])->header('X-Inertia', true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return
     */
    public function destroy(Book $knihy)
    {
        try {
            $knihy->delete();
            return redirect()->route('knihy.index')->with('success', 'Kniha bola úspešne vymazaná');
        } catch (\Exception $e) {
            return redirect()->route('knihy.index')->with('error', $e->getMessage());
        }
    }
}
