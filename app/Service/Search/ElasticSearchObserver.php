<?php


namespace App\Service\Search;

use App\Models\Article\Article;
use Elasticsearch\Client;

class ElasticSearchObserver
{
    /** @var \Elasticsearch\Client */
    private $elasticSearch;

    public function __construct(Client $client)
    {
        $this->elasticSearch = $client;
    }

    /**
     * @param Article $model
     */
    public function saved(Article $model)
    {
        $this->elasticSearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    /**
     * @param Article $model
     */
    public function deleted(Article $model)
    {
        $this->elasticSearch->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
