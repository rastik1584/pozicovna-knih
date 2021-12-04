<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';
    protected $fillable = ['name', 'surname'];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
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
