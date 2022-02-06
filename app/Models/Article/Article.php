<?php

namespace App\Models\Article;

use App\Service\Search\Searchable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Searchable;

    public $table = 'articles';

    public $guarded = [];

}
