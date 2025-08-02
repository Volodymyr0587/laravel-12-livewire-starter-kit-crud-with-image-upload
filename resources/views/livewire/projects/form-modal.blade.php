<flux:modal name="project-modal" class="md:w-[32rem]">
    <form wire:submit="saveProject" class="space-y-6">
        <div>
            <flux:heading class="font-bold" size="lg">{{ $isView ? 'Project Details' : ($projectId ? 'Update ' : 'Create ') . 'Project' }}</flux:heading>
            <flux:text class="mt-2">Add a new project using the form below.</flux:text>
        </div>

        {{-- Project name --}}
        <div class="form-group">
            <flux:input :disabled="$isView" wire:model="name" label="Project Name" placeholder="Enter project name" />
        </div>

        {{-- Project description --}}
        <div class="form-group">
            <flux:textarea :disabled="$isView" wire:model="description" label="Description" placeholder="Short project description" rows="3" />
        </div>

        {{-- Deadline --}}
        <div class="form-group">
            <flux:input :disabled="$isView" wire:model="deadline" label="Deadline" type="date" />
        </div>

        {{-- Status --}}
        <div class="form-group">
            <flux:select :disabled="$isView" wire:model="status" label="Status" placeholder="Select status...">
                <flux:select.option value="pending">Pending</flux:select.option>
                <flux:select.option value="in-progress">In-Progress</flux:select.option>
                <flux:select.option value="completed">Completed</flux:select.option>
                <flux:select.option value="cancelled">Cancelled</flux:select.option>
            </flux:select>
        </div>

        {{-- Project logo --}}
        <div class="form-group">

            @if (!$isView)
            <flux:input wire:model="project_logo" type="file" label="Project Logo" accept="image/*" class="cursor-pointer" />
            @endif

            {{-- Preview --}}
            @if ($project_logo && !$errors->has('project_logo'))
                <img src="{{ $project_logo->temporaryUrl() }}" class="mt-2 w-75 h-40 rounded" />
            @elseif ($projectId && $existingImage)
                <img src="{{ asset('storage/' . $existingImage) }}" class="mt-2 w-75 h-40 rounded" />
            @endif
        </div>

        {{-- BUttons --}}
        <div class="flex justify-end pt-4">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost" class="mr-2 cursor-pointer">Cancel</flux:button>
            </flux:modal.close>
            @if(!$isView)
            <flux:button type="submit" variant="primary" color="indigo" class="cursor-pointer">
                {{ $projectId ? 'Update Project' : 'Save Project' }}
            </flux:button>
            @endif
        </div>
    </form>
</flux:modal>

