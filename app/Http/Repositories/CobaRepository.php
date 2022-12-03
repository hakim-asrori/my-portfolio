<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\CobaInterface;
use App\Http\Repositories\Repository;
use App\Models\Coba;

class CobaRepository extends Repository implements CobaInterface
{
	/** @var Coba */
	protected $coba;

	public function __construct(Coba $coba)
	{
		parent::__construct($coba);
		$this->coba = $coba;
	}

	// Write something awesome :)
}
