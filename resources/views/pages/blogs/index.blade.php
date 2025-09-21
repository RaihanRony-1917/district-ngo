@extends('app')
@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Blog Management</h1>
            <p class="text-gray-600">Manage your blog posts and drafts</p>
        </div>
       <a href="{{ route('admin.blogs.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add
        </a>
    </div>

    {{-- Stats Grid can be included here --}}
    {{-- @include('partials.blog-stats') --}}

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Blog Posts</h3>
        </div>

        {{-- Desktop Table View --}}
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($blogs as $blog)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . ($blog->image ?? 'placeholders/image.png')) }}"
                                     alt="Blog Image"
                                     class="w-16 h-12 object-cover rounded-md border">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                {{ $blog->title ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($blog->status)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $blog->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                        <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.blogs.toggle', $blog->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                                            @if($blog->status)
                                                <i data-lucide="toggle-left" class="w-4 h-4"></i> Unpublish
                                            @else
                                                <i data-lucide="toggle-right" class="w-4 h-4"></i> Publish
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                            <td colspan="5" class="text-center py-12 text-gray-500">No blog posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View --}}
        <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
            @forelse ($blogs as $blog)
            <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-4">
                <div class="flex items-start gap-4">
                    <img src="{{ asset('storage/' . ($blog->image ?? 'placeholders/image.png')) }}"
                         alt="Blog Image"
                         class="h-20 w-24 object-cover rounded-md border">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800">{{ $blog->title }}</h4>
                        <p class="text-sm text-gray-500">
                            Published on: {{ $blog->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex justify-between items-center border-t pt-3">
                    @if ($blog->status)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                    @endif
                    <div class="flex items-center gap-4 text-sm">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                            <i data-lucide="edit" class="w-4 h-4"></i> Edit
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                No blog posts found.
            </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $blogs->links() }}
        </div>
        </div>
</main>
@endsection
