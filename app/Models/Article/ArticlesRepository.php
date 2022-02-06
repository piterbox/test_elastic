<?php


namespace App\Models\Article;

use Illuminate\Database\Eloquent\Collection;

interface ArticlesRepository
{
    public function search(string $query = ''): Collection;
}
