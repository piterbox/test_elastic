<?php
namespace App\Models\Article;

use Illuminate\Database\Eloquent\Collection;

class EloquentRepository implements ArticlesRepository
{
    public function search(string $query = ''): Collection
    {
        return Article::query()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->get();
    }
}
