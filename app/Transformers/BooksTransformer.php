<?php

namespace App\Transformers;

use App\Books;
use League\Fractal\TransformerAbstract;

class BooksTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Books $books)
    {
        return [
            'id' => $books->id,
            'title' => $books->title,
            'is_borrowed' => (boolean)$books->is_borrowed,
            'author_full_name' => $books->author->name . ' ' . $books->author->surname,
            'author_id' => $books->author_id,
            'author' => [
                'name' => $books->author->name,
                'surname' => $books->author->surname,
            ]
        ];
    }
}
