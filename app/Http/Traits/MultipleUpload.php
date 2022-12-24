<?php

namespace App\Http\Traits;

trait MultipleUpload
{
    protected function uploads($documents, $model, $folder)
    {
        foreach ($documents as $document) {
            $this->upload($document, $model, $folder);
        }
    }

    protected function upload($document, $model, $folder, $request = [])
    {
        $documentPath = $this->storageFile($document, $folder);
        $request['document_path'] = $documentPath;
        $request['document_name'] = $document->getClientOriginalName();
        $model->documents()->create($request);
    }

    protected function storageFile($document, $folder)
    {
        return $document->store($folder);
    }

    protected function uploadThumbnail($document, $model, $folder)
    {
        $this->upload($document, $model, $folder, ['document_thumbnail' => 1]);
    }
}
