@extends('app')
@section('content')
    <!-- Main Dashboard Content -->
    <main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Slide Management</h1>
                <p class="text-gray-600">
                    Manage your Frontend Slides
                </p>
            </div>
            <a href="{{ route('admin.slides.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Add Slide
            </a>
        </div>

        <!-- Slides Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">All Slides</h3>
            </div>

            {{-- Desktop Table View (Hidden on small screens) --}}
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caption</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($slides as $slide)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img class="h-12 w-20 object-cover rounded-md border border-gray-200"
                                        {{-- src="{{ asset('storage/' . ($slide->image ?? 'placeholders/image.png')) }}" --}}
                                        src="{{ supaUrl($slide->image) }}"
                                        alt="Slide Image">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                    {{ $slide->caption }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                    {{ $slide->serial }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($slide->status)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('admin.slides.edit', $slide->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                            <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.slides.toggle', $slide->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                                                 @if($slide->status)
                                                    <i data-lucide="toggle-left" class="w-4 h-4"></i> Deactivate
                                                @else
                                                    <i data-lucide="toggle-right" class="w-4 h-4"></i> Activate
                                                @endif
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.slides.destroy', $slide->id) }}" onsubmit="return confirm('Are you sure you want to delete this slide?');">
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
                                <td colspan="5" class="text-center py-12 text-gray-500">
                                    No slides found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View (Visible on small screens, hidden on md and up) --}}
            <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
                @forelse ($slides as $slide)
                <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-4">
                    <div class="flex items-start gap-4">
                        <img class="h-20 w-32 object-cover rounded-md border"
                            src="{{ asset('storage/' . ($slide->image ?? 'placeholders/image.png')) }}"
                            alt="Slide Image">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800">{{ $slide->caption }}</h4>
                            <p class="text-sm text-gray-500">Serial: <span class="font-medium text-gray-700">{{ $slide->serial }}</span></p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center border-t pt-3">
                        <div>
                            @if ($slide->status)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-4 text-sm">
                            <a href="{{ route('admin.slides.edit', $slide->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                <i data-lucide="edit" class="w-4 h-4"></i> Edit
                            </a>
                            <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                    No slides found.
                </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection

@push('more-content-stack')
    {{-- Your existing modal and overlay code can remain here --}}
    <div id="add-invoice-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        {{-- Modal Content --}}
    </div>
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>
@endpush
