<?php


namespace App\Service\Search;


trait Searchable
{
    public static function bootSearchable()
    {
        if (config('services.search.enabled')) {
            static::observe(ElasticSearchObserver::class);
        }
    }

    public function getSearchIndex()
    {
        return $this->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return '_doc';
    }

    public function toSearchArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
