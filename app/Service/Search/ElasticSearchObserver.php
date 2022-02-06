<?php


namespace App\Service\Search;

use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;

class ElasticSearchObserver
{
    /** @var \Elasticsearch\Client */
    private $elasticSearch;

    public function __construct(Client $client)
    {
        $this->elasticSearch = $client;
    }

    public function saved(Model $model)
    {
        $this->elasticSearch->index([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    public function deleted(Model $model)
    {
        $this->elasticSearch->delete([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ]);
    }
}
