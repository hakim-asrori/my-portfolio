<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\DocumentInterface;
use App\Http\Resources\Document\DocumentCollection;
use App\Http\Searches\DocumentSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    protected $documentRepository;

    public function __construct(DocumentInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function index(Request $request)
    {
        $factory = app()->make(DocumentSearch::class);
        $documents = $factory->apply()->paginate($request->per_page);

        return new DocumentCollection($documents);
    }

    public function trash($id)
    {
        $project = $this->documentRepository->find($id);

        return DB::transaction(function () use ($project) {
            return $this->documentRepository->trash($project->id);
        });
    }
}
