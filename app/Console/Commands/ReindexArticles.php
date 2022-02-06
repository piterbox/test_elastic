<?php

namespace App\Console\Commands;

use App\Models\Article\Article;
use App\Service\Search\Searchable;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles-search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to Elasticsearch';

    /** @var \Elasticsearch\Client */
    private $elasticSearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticSearch)
    {
        parent::__construct();

        $this->elasticSearch = $elasticSearch;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing all articles. This might take a while...');
        foreach (Article::cursor() as $article)
        {
            $this->elasticSearch->index([
                'index' => $article->getSearchIndex(),
                'type' => $article->getSearchType(),
                'id' => $article->getKey(),
                'body' => $article->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->info('\nDone!');
        return 0;
    }
}
