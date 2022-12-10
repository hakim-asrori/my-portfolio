<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\DocumentInterface;
use App\Http\Repositories\Repository;
use App\Models\Document;

class DocumentRepository extends Repository implements DocumentInterface
{
	/** @var Document */
	protected $document;

	public function __construct(Document $document)
	{
		parent::__construct($document);
		$this->document = $document;
	}

	// Write something awesome :)
}
