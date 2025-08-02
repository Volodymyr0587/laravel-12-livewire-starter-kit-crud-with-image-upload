<?php

namespace App\Livewire\Projects;

use App\Services\ProjectService;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function getAllProjects(ProjectService $projectService)
    {
        return $projectService->getAllProjects()
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function render(ProjectService $projectService)
    {
        $projects = $this->getAllProjects($projectService);

        return view('livewire.projects.index', compact('projects'));
    }
}
