<?php

namespace App\Transformers;

use App\Authors;
use League\Fractal\TransformerAbstract;

class BookAuthorTransformer extends TransformerAbstract
{


    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Authors $authors)
    {
        return [
            'id' => $authors->id,
            'text' => $authors->name . ' ' . $authors->surname,
        ];
    }
}
