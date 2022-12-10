<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Interfaces\ProjectInterface;
use App\Http\Repositories\Repository;
use App\Models\Project;

class ProjectRepository extends Repository implements ProjectInterface
{
	/** @var Project */
	protected $project;

	public function __construct(Project $project)
	{
		parent::__construct($project);
		$this->project = $project;
	}

	// Write something awesome :)
}
