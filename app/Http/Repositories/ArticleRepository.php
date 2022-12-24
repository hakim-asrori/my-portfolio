<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\ArticleInterface;
use App\Http\Repositories\Repository;
use App\Models\Article;

class ArticleRepository extends Repository implements ArticleInterface
{
    /** @var Article */
    protected $article;

    public function __construct(Article $article)
    {
        parent::__construct($article);
        $this->article = $article;
    }

    // Write something awesome :)
}
