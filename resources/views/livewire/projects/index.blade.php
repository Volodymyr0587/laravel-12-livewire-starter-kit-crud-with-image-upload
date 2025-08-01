<div class="p-4">

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Project Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create and manage your projects') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- button section --}}
    <div class="text-end mb-4">
        <flux:modal.trigger name="project-modal">
            <flux:button variant="primary" color="indigo" icon="plus-circle" class="cursor-pointer">
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

</div>
