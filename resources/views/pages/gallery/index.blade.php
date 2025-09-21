@extends('app')
@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Gallery</h1>
            <p class="text-gray-600">Manage your images and albums</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.gallery.create') }}" class="nav-tab-btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Add Gallery</a>
            <a href="{{ route('admin.albums.create')}}" class="nav-tab-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Add Album</a>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="gallery-tab-menu">
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 border-blue-600" data-tab="gallery">Gallery</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" data-tab="albums">Albums</button>
            </li>
        </ul>
    </div>

    <!-- Gallery Grid -->
    <div id="tab-gallery" class="tab-content">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($gallery as $i => $item)
                <div class="relative group">
                    <img
                        src="{{ asset('storage/' . $item->image) }}"
                        alt="Gallery Image {{ $i }}"
                        class="rounded-lg w-full h-40 object-cover"
                    />
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                        <a href="{{ route('admin.gallery.edit', $item->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 rounded-full p-2 mr-2">
                            <i data-lucide="eye"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.gallery.destroy', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 rounded-full p-2">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Albums Table -->
    @include('partials.album-table')
</main>
@endsection

@push('script-stack')
<script>
    lucide.createIcons();

    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('#gallery-tab-menu button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetTab = this.dataset.tab;

                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));

                // Show the selected tab content
                document.querySelector(`#tab-${targetTab}`).classList.remove('hidden');

                // Reset styles for all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-blue-600');
                    btn.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                });

                // Activate clicked button styles
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
            });
        });
    });
</script>
@endpush
