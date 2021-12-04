<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Transformers\AuthorTransformer;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        return Inertia::render('Authors', [
            'authors' => fractal(Author::filter($request->all())->orderBy('id', 'DESC')->get(), new AuthorTransformer())->toArray(),
            'filters' => $request->all('filters', 'borrowed_filter'),
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
        return Inertia::render('AuthorForm', [
            'author' => ['name' => '', 'surname' => '']
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
                'name' => 'required|max:500',
                'surname' => 'required|max:500'
            ]);
            $autor = new Author([
                'name' => $request->input('name'),
                'surname' => $request->input('surname')
            ]);
            $autor->save();
            return redirect()->route('autori.index')->with('success', 'Autor bol úspešne vytvorený');
        } catch (\Exception $e) {
            return redirect()->route('autori.index')->with('error', $e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $autori
     * @return
     */
    public function edit(Author $autori)
    {
        return Inertia::render('AuthorForm', [
            'author' => $autori
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $autori
     * @return
     */
    public function update(Request $request, Author $autori)
    {
        try {
            $request->validate([
                'name' => 'required|max:500',
                'surname' => 'required|max:500'
            ]);
            $autori->fill([
                'name' => $request->input('name'),
                'surname' => $request->input('surname')
            ])->save();
            return redirect()->route('autori.index')->with('success', 'Autor bol úspešne aktualizovaný !');
        } catch (\Exception $e) {
            return redirect()->route('autori.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $autori
     * @return
     */
    public function destroy(Author $autori)
    {
        try {
            $autori->books()->delete();
            $autori->delete();
            return redirect()->route('autori.index')->with('success', 'Autor bol úspešne zmazaný !');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
