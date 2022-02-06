<?php

namespace App\Http\Controllers;

use App\Models\Article\Article;
use App\Models\Article\ArticlesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * @param Request $request
     * @param ArticlesRepository $articlesRepository
     * @return Response
     */
    public function search(
        Request $request,
        ArticlesRepository $articlesRepository
    ): Response {
        $articles = $articlesRepository->search($request->get('query', ''));
        return response([
            'articles' => $articles
            ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(
        Request $request
    ): Response {
        $request->validate([
            'title' => ['required', 'max:128'],
            'content' => ['required'],
            'author' => ['max:64'],
        ]);

        $article = new Article();
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        $article->author = $request->get('author', 'Anonymous');
        $article->save();

        return response([
            'result' => true,
            'article' => $article
        ]);
    }

    /**
     * @param int $articleId
     * @param Request $request
     * @return Response
     */
    public function update(
        $articleId,
        Request $request
    ): Response {
        $request->validate([
            'title' => ['required', 'unique:articles', 'max:128'],
            'content' => ['required'],
            'author' => ['max:64'],
        ]);
        $article = Article::find($articleId);
        $article->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'author' => $request->get('author', 'Anonymous'),
        ]);
        return response([
            'result' => true,
            'article' => $article
        ]);
    }

    /**
     * @param int $articleId
     * @return Response
     */
    public function delete(
        $articleId
    ): Response {
        Article::destroy($articleId);
        return response([
            'result' => true
        ]);
    }
}
