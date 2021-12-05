<?php

namespace Database\Seeders;

use App\Authors;
use App\Books;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Books::class, 30)->create();
    }
}
