<?php

namespace App\Transformers;

use App\Authors;
use League\Fractal\TransformerAbstract;

class AuthorsTransformer extends TransformerAbstract
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
    public function transform(Authors $authors)
    {
        return [
            'id' => $authors->id,
            'name' => $authors->name,
            'surname' => $authors->surname,
            'book_count' => $authors->books->count(),
        ];
    }
}
