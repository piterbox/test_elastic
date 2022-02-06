<?php

use App\Models\Article\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    const COUNT_ARTICLES = 1000000;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->truncate();
        factory(Article::class)->times(self::COUNT_ARTICLES)->create();
    }
}
