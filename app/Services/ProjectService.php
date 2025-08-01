<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Str;

class ProjectService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected ProjectRepository $projectRepository)
    {
        //
    }

    public function saveProject($projectRequest)
    {
        if (!empty($projectRequest['project_logo'])) {

            $projectLogo = $projectRequest['project_logo'];

            // Upload image
            $projectLogoPath = $projectLogo->store('projects', 'public');

            $projectRequest['project_logo'] = $projectLogoPath;
        }

        $projectRequest['slug'] = Str::slug($projectRequest['name']);

        return $this->projectRepository->saveProject($projectRequest);
    }
}
