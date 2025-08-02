<div class="p-4">

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Project Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create and manage your projects') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- button section --}}
    <div class="text-end mb-4">
        <flux:modal.trigger name="project-modal">
            <flux:button
                wire:click="$dispatch('open-project-modal', { mode: 'create' })"
                variant="primary" color="indigo" icon="plus-circle" class="cursor-pointer">
                Add Project
            </flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Render Form Component --}}
    <livewire:projects.form-modal />

    {{-- Flash message component --}}
    <div x-data="{ show: false, message: '', type: '' }"
        x-init="window.addEventListener('flash', e => {
        const data = e.detail[0];
        message = data.message;
        type = data.type;
        show = true;
        setTimeout(() => show = false, 4000);
        })"
        x-show="show"
        x-transition
        class="fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white z-50"
        :class="{
            'bg-emerald-600': type === 'success',
            'bg-red-600': type === 'error',
        }"
        style="display: none;"
    >
        <span x-text="message"></span>
    </div>

    {{-- Table for listing projects --}}
    <div class="overflow-x-auto border rounded-xl shadow-md">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold border-b">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Description</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Deadline</th>
                    <th class="px-13 py-4">Logo</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($projects as $project)
                <tr class="hover:bg-gray-50 hover:text-gray-700 transition">
                    <td class="p-4">{{ $loop->index + 1 }}</td>
                    <td class="p-4">{{ $project->name }}</td>
                    <td class="p-4">{{ $project->description }}</td>
                    <td class="p-4 capitalize">
                        @php
                            $statusColor = match ($project->status) {
                                'pending' => 'bg-yellow-300 text-yellow-800 border border-yellow-500',
                                'in-progress' => 'bg-blue-300 text-blue-800 border border-blue-500',
                                'completed' => 'bg-green-300 text-green-800 border border-green-500',
                                'cancelled' => 'bg-red-300 text-red-800 border border-red-500',
                            }
                        @endphp
                        <span class="px-3 py-1 rounded shadow-sm {{ $statusColor }}">{{ $project->status }}</span>
                    </td>
                    <td class="p-4">{{ $project->deadline }}</td>
                    <td class="p-4">
                        @if ($project->project_logo)
                            <img src="{{ asset('storage/' . $project->project_logo) }}" alt="{{ $project->name }}" class="h-18 w-32 rounded border">
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="p-4">
                        {{-- Project modal trigger --}}
                        <flux:modal.trigger name="project-modal">
                            {{-- view --}}
                            <flux:button
                                wire:click="$dispatch('open-project-modal', { mode: 'view', project: {{ $project }} })"
                                variant="primary" color="sky" icon="eye"
                                class="cursor-pointer">
                            </flux:button>
                            {{-- edit --}}
                            <flux:button
                                wire:click="$dispatch('open-project-modal', { mode: 'edit', project: {{ $project }} })"
                                variant="primary" color="blue" icon="pencil"
                                class="mx-1 cursor-pointer">
                            </flux:button>
                        </flux:modal.trigger>

                        {{-- delete --}}
                        <flux:modal.trigger name="delete-project">
                            <flux:button wire:click="$dispatch('delete-project', { id: {{ $project->id }} })" variant="primary" color="red" icon="trash" class="cursor-pointer"></flux:button>
                        </flux:modal.trigger>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-6 text-center">
                        <flux:text class="flex items-center justify-center text-red-500">
                            <flux.icon.exclamation-triangle class="mr-2" /> No projects found!
                        </flux:text>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Delete Project Modal --}}
    <flux:modal name="delete-project" class="min-w-[25rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this project.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteProject" type="submit" variant="danger">Delete project</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
