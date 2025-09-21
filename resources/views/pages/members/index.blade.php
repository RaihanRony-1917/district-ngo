@extends('app')
@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Team Management</h1>
            <p class="text-gray-600">
                Manage your team members and their roles
            </p>
        </div>
    </div>

    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tab-menu">
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 border-blue-600"
                    data-tab="members">Members</button>
            </li>
            <li class="mr-2">
                <button
                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                    data-tab="committee">Committee</button>
            </li>
        </ul>
    </div>

    {{-- MEMBERS TAB --}}
    <div id="tab-members" class="tab-content">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">All Members</h3>
                <a href="{{ route('admin.members.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Member
                </a>
            </div>

            {{-- Desktop Table View --}}
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($members as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.($member->image ?? 'placeholders/avatar.png')) }}" alt="Member photo">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $member->email }}</div>
                                <div class="text-sm text-gray-500">{{ $member->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $member->role }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">{{ $member->serial }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($member->status)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('admin.members.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                        <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                    </a>
                                    {{-- Status Toggle Form --}}
                                    <form method="POST" action="{{ route('admin.members.toggle', $member->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                                            @if($member->status)
                                                <i data-lucide="toggle-left" class="w-4 h-4"></i> Deactivate
                                            @else
                                                <i data-lucide="toggle-right" class="w-4 h-4"></i> Activate
                                            @endif
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.members.destroy', $member->id) }}" onsubmit="return confirm('Are you sure?');">
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
                        <tr><td colspan="7" class="text-center py-12 text-gray-500">No members found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
                @forelse ($members as $member)
                <div class="bg-white rounded-lg border border-gray-200 p-4 space-y-4">
                    <div class="flex items-center gap-4">
                        <img class="h-16 w-16 rounded-full object-cover border" src="{{ asset('storage/'.($member->image ?? 'placeholders/avatar.png')) }}" alt="Member photo">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800">{{ $member->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $member->role }}</p>
                            <p class="text-sm text-gray-500">{{ $member->email }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center border-t pt-3">
                        @if($member->status)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        @endif
                        <div class="flex items-center gap-4 text-sm">
                               <a href="{{ route('admin.members.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                <i data-lucide="edit" class="w-4 h-4"></i> Edit
                            </a>
                            {{-- Status Toggle Form --}}
                            <form method="POST" action="{{ route('admin.members.toggle', $member->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                                    @if($member->status)
                                        <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                    @else
                                        <i data-lucide="toggle-right" class="w-4 h-4"></i>
                                    @endif
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.members.destroy', $member->id) }}" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 flex items-center gap-1">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-gray-500">No members found.</div>
                @endforelse
            </div>

            <div class="p-4 border-t border-gray-200">
                {{ $members->links() }}
            </div>
        </div>
    </div>

    {{-- COMMITTEE TAB --}}
    <div id="tab-committee" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">All Committees</h3>
                <a href="{{ route('admin.committee.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>Committee
                </a>
            </div>

             {{-- Desktop Table View --}}
            <div class="overflow-x-auto hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($committees as $committee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $committee->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">{{ $committee->serial }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($committee->status)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('admin.committee.edit', $committee->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                        <i data-lucide="edit" class="w-4 h-4"></i> Edit
                                    </a>
                                    {{-- Status Toggle Form --}}
                                    <form method="POST" action="{{ route('admin.committee.toggle', $committee->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                                            @if($committee->status)
                                                <i data-lucide="toggle-left" class="w-4 h-4"></i> Deactivate
                                            @else
                                                <i data-lucide="toggle-right" class="w-4 h-4"></i> Activate
                                            @endif
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.committee.destroy', $committee->id) }}" onsubmit="return confirm('Are you sure?');">
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
                        <tr><td colspan="4" class="text-center py-12 text-gray-500">No committees found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
                @forelse ($committees as $committee)
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $committee->name }}</h4>
                            <p class="text-sm text-gray-500">Serial: <span class="font-medium text-gray-700">{{ $committee->serial }}</span></p>
                        </div>
                        @if($committee->status)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-sm mt-4 border-t pt-3">
                        <a href="{{ route('admin.committee.edit', $committee->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                            <i data-lucide="edit" class="w-4 h-4"></i> Edit
                        </a>
                        {{-- Status Toggle Form --}}
                        <form method="POST" action="{{ route('admin.committee.toggle', $committee->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
                                @if($committee->status)
                                    <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                @else
                                    <i data-lucide="toggle-right" class="w-4 h-4"></i>
                                @endif
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.committee.destroy', $committee->id) }}" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 flex items-center gap-1">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-gray-500">No committees found.</div>
                @endforelse
            </div>

            <div class="p-4 border-t border-gray-200">
                {{ $committees->links() }}
            </div>
        </div>
    </div>
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

                // Update button styles
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-blue-600');
                    btn.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                });
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('border-transparent');
            });
        });
    });
</script>
@endpush
