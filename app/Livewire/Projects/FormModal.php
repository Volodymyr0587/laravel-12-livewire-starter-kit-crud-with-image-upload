<?php

namespace App\Livewire\Projects;

use Livewire\Attributes\Validate;
use Livewire\Component;

class FormModal extends Component
{
    #[Validate('required|string|min:2|max:100')]
    public $name = null;

    #[Validate('required|string|min:2|max:255')]
    public $description = null;

    #[Validate('required|string')]
    public $deadline = null;

    #[Validate('required|string|in:pending,in-progress,completed,cancelled')]
    public $status = 'pending';

    #[Validate('nullable|image|max:5120')]
    public $project_logo = null;

    public function saveProject()
    {
        $validatedProjectRequest = $this->validate();


    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
