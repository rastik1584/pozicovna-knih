<?php

namespace App\Transformers;

use App\Models\Author;
use App\Models\Book;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
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
    public function transform(Author $author)
    {
        return [
            'id' => $author->id,
            'name' => $author->name,
            'surname' => $author->surname,
            'book_count' => $author->books->count(),
        ];
    }
}
