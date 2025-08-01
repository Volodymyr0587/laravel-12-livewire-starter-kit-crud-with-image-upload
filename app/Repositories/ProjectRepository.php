<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Summary of saveProject
     * @param array $projectRequest
     * @return Project
     */
    public function saveProject($projectRequest): Project
    {
        return Project::create($projectRequest);
    }

    public function getProjectQuery()
    {
        return Project::query();
    }
}
