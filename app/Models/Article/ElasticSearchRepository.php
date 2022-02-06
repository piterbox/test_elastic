<?php


namespace App\Models\Article;

use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class ElasticSearchRepository implements ArticlesRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticSearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticSearch = $elasticsearch;
    }
    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticSearch($query);
        return $this->buildCollection($items);
    }
    private function searchOnElasticSearch(string $query = ''): array
    {
        $model = new Article;
        $items = $this->elasticSearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title^5', 'content'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);
        return $items;
    }
    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        return Article::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
