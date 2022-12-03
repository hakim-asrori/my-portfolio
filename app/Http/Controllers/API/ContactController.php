<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\ContactInterface;
use App\Http\Requests\API\Contact\CreateRequest;
use App\Http\Resources\API\Contact\ContactCollection;
use App\Http\Resources\API\Contact\ContactDetail;
use App\Http\Searches\ContactSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index(Request $request)
    {
        $factory = app()->make(ContactSearch::class);
        $contacts = $factory->apply()->paginate($request->per_page);

        return new ContactCollection($contacts);
    }

    public function store(CreateRequest $createRequest)
    {
        return DB::transaction(function () use ($createRequest) {
            return $this->contactRepository->store($createRequest->all());
        });
    }

    public function show($id)
    {
        $contact = $this->contactRepository->find($id);

        return new ContactDetail($contact);
    }

    public function trash($id)
    {
        return DB::transaction(function () use ($id) {
            $contact = $this->contactRepository->find($id);
            $this->contactRepository->trash($id);

            return new ContactDetail($contact);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $contact = $this->contactRepository->findTrashed($id);
            $this->contactRepository->delete($id);

            return new ContactDetail($contact);
        });
    }
}
