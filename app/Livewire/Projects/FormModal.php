<?php

namespace App\Livewire\Projects;

use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use App\Services\ProjectService;
use Livewire\Attributes\Validate;

class FormModal extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:2|max:100')]
    public $name = null;

    #[Validate('required|string|min:2|max:255')]
    public $description = null;

    #[Validate('required|date|after:today')]
    public $deadline = null;

    #[Validate('required|string|in:pending,in-progress,completed,cancelled')]
    public $status = 'pending';

    #[Validate('nullable|image|max:5120')]
    public $project_logo = null;

    public function messages()
    {
        return [
            'deadline.after' => 'The deadline must be a date after today. Today is ' . Carbon::today()->format('d M Y') . '.',
        ];
    }

    public function saveProject(ProjectService $projectService)
    {
        $validatedProjectRequest = $this->validate();

        $projectService->saveProject($validatedProjectRequest);

        $this->reset();

        $this->dispatch('flash', [
            'message' => 'Project created successfully!',
            'type' => 'success',
        ]);

        Flux::modal('project-modal')->close();
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
