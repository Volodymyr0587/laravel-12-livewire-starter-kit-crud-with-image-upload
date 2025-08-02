<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

    public function getAllProjects()
    {
        return $this->projectRepository->getProjectQuery();
    }

    /**
     * Summary of updateProject
     * @param int $projectId
     * @param array $projectRequest
     */
    public function updateProject($projectId, $projectRequest)
    {
        $project = $this->getAllProjects()->find($projectId);

        if ($project) {

            if (!empty($projectRequest['project_logo'])) {

                $projectLogo = $projectRequest['project_logo'];

                // Upload image
                $projectLogoPath = $projectLogo->store('projects', 'public');

                $projectRequest['project_logo'] = $projectLogoPath;

                if ($project->project_logo && Storage::exists($project->project_logo)) {
                    Storage::delete($project->project_logo);
                }

                $project->project_logo = $projectLogoPath;
            }

            $project->name = $projectRequest['name'];
            $project->slug =  Str::slug($projectRequest['name']);
            $project->description = $projectRequest['description'];
            $project->status = $projectRequest['status'];
            $project->deadline = $projectRequest['deadline'];



            return $project->save();
        }
    }

    /**
     * Summary of deleteProject
     * @param int $projectId
     */
    public function deleteProject($projectId)
    {
        $project = $this->getAllProjects()->find($projectId);

        if ($project) {
            return $project->delete();
        }
    }
}
