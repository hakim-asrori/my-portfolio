<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\ArticleInterface;
use App\Http\Requests\API\Article\CreateRequest;
use App\Http\Resources\API\Article\ArticleCollection;
use App\Http\Resources\API\Article\ArticleDetail;
use App\Http\Searches\ArticleSearch;
use App\Http\Traits\MultipleUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    use MultipleUpload;

    protected $articleRepository;

    public function __construct(ArticleInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index(Request $request)
    {
        $factory = app()->make(ArticleSearch::class);
        $articles = $factory->apply()->paginate($request->per_page);

        return new ArticleCollection($articles);
    }

    public function store(CreateRequest $request)
    {
        $attributes = $request->all();
        $attributes['article_slug'] = Str::slug($request->article_title);

        return DB::transaction(function () use ($attributes) {
            $article = $this->articleRepository->store($attributes);
            $this->uploadThumbnail($attributes['document_thumbnail'], $article, 'article');
            $this->uploads($attributes['documents'], $article, 'article');

            return $article;
        });
    }

    public function show($slug)
    {
        $article = $this->articleRepository->findByCriteria(['article_slug' => $slug]);
        if (!$article) {
            return abort(404);
        }

        $article->load('documents');

        return new ArticleDetail($article);
    }

    public function edit($id)
    {
        $article = $this->articleRepository->find($id);
        $article->load('documents');

        return new ArticleDetail($article);
    }

    public function update(CreateRequest $request, $id)
    {
        $attributes = $request->all();
        $attributes['article_slug'] = Str::slug($request->article_title);

        $article = $this->articleRepository->find($id);

        return DB::transaction(function () use ($attributes, $article) {
            if ($article->documents) {
                $this->updateDocument($attributes, $article);
            }

            if (isset($attributes['documents']) && $attributes['documents']) {
                $this->uploads($attributes['documents'], $article, 'article');
            }

            return $article->update($attributes);
        });
    }

    public function trash($id)
    {
        $article = $this->articleRepository->find($id);

        return DB::transaction(function () use ($article) {
            return $this->articleRepository->trash($article->id);
        });
    }

    public function delete($id)
    {
        $article = $this->articleRepository->findTrashed($id);

        return DB::transaction(function () use ($article) {
            if ($article->documents) {
                foreach ($article->documents as $document) {
                    $path = str_replace(url('storage') . '/', '', $document->document_path);

                    Storage::delete($path);
                }

                $article->documents()->delete();
            }

            return $this->articleRepository->delete($article->id);
        });
    }

    public function updateDocument($attributes, $project)
    {
        $modelDocument = $project->documents();
        if (isset($attributes['old_documents'])) {
            $modelDocument = $modelDocument->whereNotIn('id', $attributes['old_documents']);
        }

        $documents = $modelDocument->get();
        foreach ($documents as $document) {
            $path = str_replace(url('storage') . '/', '', $document->document_path);
            Storage::delete($path);
        }

        return $modelDocument->delete();
    }
}
