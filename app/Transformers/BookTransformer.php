<?php

namespace App\Transformers;

use App\Models\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
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
    public function transform(Book $book)
    {
        return [
            'id' => $book->id,
            'title' => $book->title,
            'is_borrowed' => (boolean)$book->is_borrowed,
            'author_full_name' => $book->author->name . ' ' . $book->author->surname,
            'author' => [
                'name' => $book->author->name,
                'surname' => $book->author->surname,
            ]
        ];
    }
}
