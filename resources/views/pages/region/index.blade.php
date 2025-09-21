@extends('app')

@section('content')
<div class="w-full min-h-screen bg-gray-100 p-6 space-y-10">

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Educational Statistics</h2>
          @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 p-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.dagan.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <div>
                <label for="school" class="block text-gray-700 font-medium mb-2">School</label>
                <input type="number" id="school" name="school"
                    value="{{ old('school', $edu->school) }}"
                class="w-full p-3 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="college" class="block text-gray-700 font-medium mb-2">Colleges</label>
                <input type="number" id="college" name="college"
                    value="{{ old('college', $edu->college) }}"
                class="w-full p-3 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="madrasha" class="block text-gray-700 font-medium mb-2">Madrashas</label>
                <input type="number" id="madrasha" name="madrasha"
                    value="{{ old('madrasha', $edu->madrasha) }}"
                class="w-full p-3 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="pass_rate" class="block text-gray-700 font-medium mb-2">Passing Rate (%)</label>
                <input type="number" id="pass_rate" name="pass_rate" step="0.5"
                    value="{{ old('pass_rate', $edu->pass_rate) }}"
                class="w-full p-3 border border-gray-300 rounded-md" required>
            </div>

            <div class="md:col-span-2 text-right mt-4">
                <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-md hover:bg-blue-700 transition">Submit</button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <div>
            <div class="flex space-x-4 mb-6">
                <button onclick="showTab(event, 'historical')" class="tab-button active-tab">Historical Places</button>
                <button onclick="showTab(event, 'notable')" class="tab-button">Notable People</button>
            </div>

            <div id="historical" class="tab-content">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.dagan.places.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                        Add Historical Place
                    </a>
                </div>
                <table class="w-full text-left border">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="p-3">Image</th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Serial</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historicals as $item)
                        <tr class="border-t">
                            <td class="p-3">
                                {{-- <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="h-16 rounded object-cover"> --}}
                                <img src="{{ supaUrl($item->image) }}" alt="{{ $item->name }}" class="h-16 rounded object-cover">
                            </td>
                            <td class="p-3">{{ $item->name }}</td>
                            <td class="p-3">{{ $item->serial }}</td>
                            <td class="p-3 space-x-2">
                                <a href="{{ route('admin.dagan.edit.place', $item->id) }}" class="text-indigo-600 hover:underline">Edit</a>

                                <form action="{{ route('admin.dagan.places.toggle', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:underline">
                                        {{ $item->status ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.dagan.places.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $historicals->links() }}
                </div>
                </div>

            <div id="notable" class="tab-content hidden">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.dagan.people.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Add Notable Person</a>
                </div>
                <table class="w-full text-left border">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="p-3">Image</th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Serial</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notables as $person)
                        <tr class="border-t">
                            <td class="p-3">
                                {{-- <img src="{{ asset('storage/' . $person->image) }}" alt="{{ $person->name }}" class="h-16 rounded object-cover"> --}}
                                <img src="{{ supaUrl($person->image) }}" alt="{{ $person->name }}" class="h-16 rounded object-cover">
                            </td>
                            <td class="p-3">{{ $person->name }}</td>
                            <td class="p-3">{{ $person->serial }}</td>
                            <td class="p-3 space-x-2">
                                <a href="{{ route('admin.dagan.people.edit', $person->id) }}" class="text-indigo-600 hover:underline">Edit</a>

                                <form action="{{ route('admin.dagan.people.toggle', $person->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:underline">
                                        {{ $person->status ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.dagan.people.destroy', $person->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $notables->links() }}
                </div>
                </div>
        </div>
    </div>
</div>
@endsection

@push('style-stack')
<style>
    .tab-button {
        padding: 0.5rem 1.25rem; /* px-5 py-2 */
        border-radius: 9999px;   /* rounded-full */
        border: 1px solid #D1D5DB; /* border-gray-300 */
        color: #4B5563;          /* text-gray-600 */
        background-color: white;
        transition: background-color 0.2s;
    }

    .tab-button:hover {
        background-color: #F3F4F6; /* bg-gray-100 */
    }

    .tab-button.active-tab {
        background-color: #2563EB; /* bg-blue-600 */
        color: white;
        border-color: #2563EB;     /* border-blue-600 */
    }
</style>
@endpush


@push('script-stack')
<script>
    function showTab(event, tabId) {
        event.preventDefault();

        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));

        // Show selected tab content
        document.getElementById(tabId).classList.remove('hidden');

        // Remove active-tab class from all buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active-tab');
        });

        // Add active-tab class to the clicked button
        event.currentTarget.classList.add('active-tab');
    }
</script>
@endpush
