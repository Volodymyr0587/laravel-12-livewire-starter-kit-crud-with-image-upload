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

    public function saveProject($projectRequest)
    {
        return Project::create($projectRequest);
    }
}
