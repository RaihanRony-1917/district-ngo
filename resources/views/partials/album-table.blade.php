<div id="tab-albums" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Albums</h3>
            <a href="{{ route('admin.albums.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Create Album
            </a>
        </div>

        {{-- Desktop Table View (Hidden on small screens) --}}
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($albums as $album)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/' . ($album->image ?? 'placeholders/image.png')) }}" alt="{{ $album->name }}" class="h-16 w-16 object-cover rounded-md border border-gray-200">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $album->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">{{ $album->serial }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                             @if ($album->status)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.albums.edit', $album->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                    <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                </a>
                                <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this album?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 flex items-center gap-1">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-500">No albums found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View (Visible on small screens, hidden on md and up) --}}
        <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
            @forelse ($albums as $album)
            <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . ($album->image ?? 'placeholders/image.png')) }}" alt="{{ $album->name }}" class="h-20 w-20 object-cover rounded-md border">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">{{ $album->name }}</h4>
                        <p class="text-sm text-gray-500">Serial: <span class="font-medium text-gray-700">{{ $album->serial }}</span></p>
                    </div>
                </div>

                <div class="flex justify-between items-center border-t pt-3">
                    <div>
                        @if ($album->status)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <a href="{{ route('admin.albums.edit', $album->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                            <i data-lucide="edit" class="w-4 h-4"></i> Edit
                        </a>
                        <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 flex items-center gap-1">
                                <i data-lucide="trash-2" class="w-4 h-4"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                No albums found.
            </div>
            @endforelse
        </div>
    </div>
</div>
