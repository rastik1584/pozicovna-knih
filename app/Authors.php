<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $table = 'authors';
    protected $fillable = ['name', 'surname'];

    public function books()
    {
        return $this->hasMany(Books::class, 'author_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['filters'] ?? null, function ($query, $search) {
            $query->where(function ($q)  use($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('surname', 'like', '%'.$search.'%');
            });
        });
    }

}
