 @php
        $people = json_decode(file_get_contents(resource_path('views/pages/about/people.json')), false);
    @endphp
    <div id="tab-quotes" class="tab-content hidden">
        <form method="POST" action="{{ route('admin.about.quote.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md max-w-2xl">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Person Image</label>

                <img id="personImage" src="" alt="Person Image" class="w-32 h-32 object-cover rounded border border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Select Person</label>
                <select required name="lang_id" class="w-full border rounded p-2">
                    <option value="">-- Choose a Language --</option>
                    @foreach ($langs as $key => $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Select Person</label>
                <select name="person_id" id="person_id" class="w-full border rounded p-2">
                    <option value="">-- Choose a person --</option>
                    @foreach ($people as $key => $person)
                        <option value="{{ $person }}">{{ $person }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" id="quoteTitle" name="title" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Quote</label>
                <textarea id="quoteTextarea"  name="quote" rows="4" class="w-full border rounded p-2">{{ old('quote') }}</textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </form>
    </div>
