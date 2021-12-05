<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'books';
    protected $fillable = ['author_id', 'title', 'is_borrowed'];

    public function author()
    {
        return $this->belongsTo(Authors::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $table = $this->table;
        $query->when($filters['filters'] ?? null, function ($query, $search) use($table) {
            $query->leftJoin((new Authors())->getTable().' as author', "$table.author_id", '=', 'author.id')
                ->where(function($query) use ($table, $search) {
                    $query->where("$table.title", 'like', '%'.$search.'%')
                        ->orWhere("author.name", 'like', '%'.$search.'%')
                        ->orWhere('author.surname', 'like', '%'.$search.'%');
                })->select('author.name', 'author.surname', "$table.*");
        })->when($filters['borrowed_filter'] ?? null, function ($query, $borrowed) {
            $is_borrowed = $borrowed ? 1 : 0;
            $query->where('is_borrowed', $is_borrowed);
        });
    }
}
