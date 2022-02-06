<?php

namespace App\Http\Controllers;

use App\Models\Article\ArticlesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function search(
        Request $request,
        ArticlesRepository $articlesRepository
    ): Response {
        $articles = $articlesRepository->search($request->get('query', ''));
        return response([
            'articles' => $articles
            ]);
    }
}
