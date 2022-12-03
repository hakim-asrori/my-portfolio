<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\ContactInterface;
use App\Http\Repositories\Repository;
use App\Models\Contact;

class ContactRepository extends Repository implements ContactInterface
{
	/** @var Contact */
	protected $contact;

	public function __construct(Contact $contact)
	{
		parent::__construct($contact);
		$this->contact = $contact;
	}

	// Write something awesome :)
}
