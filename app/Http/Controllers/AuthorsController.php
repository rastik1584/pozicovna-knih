<?php

namespace App\Http\Controllers;

use App\Authors;
use App\Transformers\AuthorsTransformer;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        return [
            'filters' => $request->all('filters'),
            'authors' => fractal(Authors::filter($request->all())->orderBy('id', 'DESC')->get(), new AuthorsTransformer()),
        ];
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
            $autor = new Authors([
                'name' => $request->input('name'),
                'surname' => $request->input('surname')
            ]);
            $autor->save();
            return response()->json(['message' => 'Autor bol úspešne vytvorený']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Authors  $authors
     * @return
     */
    public function edit(Authors $author)
    {
        return fractal($author, new AuthorsTransformer())->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Authors  $authors
     * @return
     */
    public function update(Request $request, Authors $author)
    {
        try {
            $request->validate([
                'name' => 'required|max:500',
                'surname' => 'required|max:500'
            ]);
            $author->fill([
                'name' => $request->input('name'),
                'surname' => $request->input('surname')
            ])->save();
            return response()->json(['message' => 'Author bol úspešne aktualizovaný']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Authors  $authors
     * @return
     */
    public function destroy(Authors $author)
    {
        try {
            $author->books()->delete();
            $author->delete();
            return response()->json(['message' => 'Autor bol úspešne vymazaný']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
