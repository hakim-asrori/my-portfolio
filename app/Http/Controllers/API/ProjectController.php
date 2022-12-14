<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\ProjectInterface;
use App\Http\Requests\API\Project\CreateRequest;
use App\Http\Requests\API\Project\UpdateRequest;
use App\Http\Resources\Project\ProjectCollection;
use App\Http\Resources\Project\ProjectDetail;
use App\Http\Searches\ProjectSearch;
use App\Http\Traits\MultipleUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    use MultipleUpload;

    protected $projectRepository;

    public function __construct(ProjectInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index(Request $request)
    {
        $factory = app()->make(ProjectSearch::class);
        $projects = $factory->apply()->paginate($request->per_page);

        return new ProjectCollection($projects);
    }

    public function store(CreateRequest $request)
    {
        $attributes = $request->all();

        return DB::transaction(function () use ($attributes) {
            $project = $this->projectRepository->store($attributes);
            $this->uploads($attributes['documents'], $project, 'project');

            return $project;
        });
    }

    public function show($id)
    {
        $project = $this->projectRepository->find($id);
        $project->load('documents');

        return new ProjectDetail($project);
    }

    public function update(UpdateRequest $request, $id)
    {
        $attributes = $request->all();
        $project = $this->projectRepository->find($id);

        return DB::transaction(function () use ($attributes, $project) {
            if ($project->documents) {
                $this->updateDocument($attributes, $project);
            }

            if (isset($attributes['documents']) && $attributes['documents']) {
                $this->uploads($attributes['documents'], $project, 'project');
            }

            return $project->update($attributes);
        });
    }

    public function trash($id)
    {
        $project = $this->projectRepository->find($id);

        return DB::transaction(function () use ($project) {
            return $this->projectRepository->trash($project->id);
        });
    }

    public function delete($id)
    {
        $project = $this->projectRepository->findTrashed($id);

        return DB::transaction(function () use ($project) {
            if ($project->documents) {
                foreach ($project->documents as $document) {
                    $path = str_replace(url('storage') . '/', '', $document->document_path);
                    Storage::delete($path);
                }

                $project->documents()->delete();
            }

            return $this->projectRepository->delete($project->id);
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
