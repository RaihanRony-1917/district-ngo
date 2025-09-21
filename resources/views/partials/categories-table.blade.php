<div id="tab-categories" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Project Categories</h3>
            <a href="{{ route('admin.project-categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add Category
            </a>
        </div>

        {{-- Desktop Table View (Hidden on small screens) --}}
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($projectCategories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{-- <img src="{{ asset('storage/' . ($category->image ?? 'placeholders/image.png')) }}" alt="{{ $category->name }}" class="h-12 w-12 object-cover rounded-md border border-gray-200"> --}}
                            <img src="{{ supaUrl(($category->image ?? 'placeholders/image.png')) }}" alt="{{ $category->name }}" class="h-12 w-12 object-cover rounded-md border border-gray-200">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-xs">{{ $category->short_text }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                             @if ($category->status)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.project-categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                    <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                </a>
                                {{-- Status Toggle Form --}}
                                <form method="POST" action="{{ route('admin.project-categories.toggle', $category->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                                        @if($category->status)
                                            <i data-lucide="toggle-left" class="w-4 h-4"></i> Deactivate
                                        @else
                                            <i data-lucide="toggle-right" class="w-4 h-4"></i> Activate
                                        @endif
                                    </button>
                                </form>
                                <form action="{{ route('admin.project-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                        <td colspan="5" class="text-center py-12 text-gray-500">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View (Visible on small screens, hidden on md and up) --}}
        <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
            @forelse ($projectCategories as $category)
            <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-4">
                <div class="flex items-center gap-4">
                    {{-- <img src="{{ asset('storage/' . ($category->image ?? 'placeholders/image.png')) }}" alt="{{ $category->name }}" class="h-16 w-16 object-cover rounded-md border"> --}}
                    <img src="{{ supaUrl(($category->image ?? 'placeholders/image.png')) }}" alt="{{ $category->name }}" class="h-16 w-16 object-cover rounded-md border">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">{{ $category->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $category->short_text }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-center border-t pt-3">
                    <div>
                        @if ($category->status)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <a href="{{ route('admin.project-categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900">
                            <i data-lucide="edit" class="w-5 h-5"></i>
                        </a>
                         {{-- Status Toggle Form --}}
                        <form method="POST" action="{{ route('admin.project-categories.toggle', $category->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-gray-600 hover:text-gray-900">
                                @if($category->status)
                                    <i data-lucide="toggle-left" class="w-5 h-5"></i>
                                @else
                                    <i data-lucide="toggle-right" class="w-5 h-5"></i>
                                @endif
                            </button>
                        </form>
                        <form action="{{ route('admin.project-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                No categories found.
            </div>
            @endforelse
        </div>
    </div>
</div>
