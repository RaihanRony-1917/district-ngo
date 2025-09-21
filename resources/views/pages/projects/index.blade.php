@extends('app')
@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Project Management</h1>
            <p class="text-gray-600">Manage Projects and Categories</p>
        </div>
    </div>

    <!-- Nav Tabs -->
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tab-menu">
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 border-blue-600"
                    data-tab="projects">Projects</button>
            </li>
            <li class="mr-2">
                <button
                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                    data-tab="categories">Categories</button>
            </li>
        </ul>
    </div>

    <!-- Add Buttons -->
    {{-- <div class="flex justify-end gap-4 mb-4">
        <a href="{{ route('admin.projects.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">+ Add Project</a>
        <a href="{{ route('admin.project-categories.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">+ Add Category</a>
    </div> --}}

    <!-- Projects Table -->
    @include('partials.project-table')

    <!-- Categories Table -->
    @include('partials.categories-table')
</main>
@endsection

@push('script-stack')
<script>
    // JavaScript for tab switching
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('#tab-menu button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetTab = this.dataset.tab;

                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));
                // Show the target tab content
                document.querySelector(`#tab-${targetTab}`).classList.remove('hidden');

                // Reset styles for all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove(
                        'text-blue-600',
                        'border-blue-600',
                        'border-b-2'
                    );
                    btn.classList.add(
                        'border-transparent',
                        'hover:text-gray-600',
                        'hover:border-gray-300',
                        'text-gray-500'
                    );
                });

                // Set active styles for clicked button
                this.classList.add(
                    'text-blue-600',
                    'border-blue-600',
                    'border-b-2'
                );
                this.classList.remove(
                    'border-transparent',
                    'hover:text-gray-600',
                    'hover:border-gray-300',
                    'text-gray-500'
                );
            });
        });
    });
</script>


@endpush
