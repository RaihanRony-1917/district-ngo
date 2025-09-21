@extends('app')

@section('content')
<main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Organization Settings</h1>
        <p class="text-gray-600">Manage mission, vision and quotes content</p>
    </div>

    <!-- Tabs -->
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tab-menu">
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 text-blue-600 border-blue-600" data-tab="mission">Mission</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" data-tab="vision">Vision</button>
            </li>
            {{-- <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300" data-tab="quotes">Quotes</button>
            </li> --}}
        </ul>
    </div>

    <!-- Tab Contents -->
    <div id="tab-mission" class="tab-content">
        <div>
            <form  class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 rounded "
                method="POST" action="{{ route('admin.about.mission.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg">
                    <label class="block text-gray-700 font-medium mb-2">Mission Image</label>
                    @if (!empty($about->mission_img))
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Current Image:</p>
                            {{-- <img src="{{ Storage::url($about->mission_img) }}" alt="Current Image" --}}
                            <img src="{{ supaUrl($about->mission_img) }}" alt="Current Image"
                                class="max-h-48 rounded-md border border-gray-300 object-contain">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-200 text-gray-500 rounded p-2" onchange="previewMissionImage(event)">
                    <img id="missionPreview" src="#" alt="Mission Image Preview" class="mt-2 w-32 h-32 object-cover rounded border border-gray-300 hidden">
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg">
                    <div class="flex justify-between mb-2">
                        <div class="border-b border-gray-200">
                            <h3 class="text-lg font-semibold">Mission Content</h3>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $mission->title) }}" class="w-full  border border-gray-200 shadow-sm rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Content</label>
                        <textarea name="content" rows="5" class="w-full border  border-gray-200 shadow-sm rounded p-2">{{ old('content', $mission->content) }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="tab-vision" class="tab-content hidden">
        <div >
            <form class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 rounded"
            method="POST" action="{{ route('admin.about.vision.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg">
                    <label class="block text-gray-700 font-medium mb-2">Vision Image</label>

                     @if (!empty($about->vision_img))
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-1">Current Image:</p>
                        {{-- <img src="{{ asset('storage/' . $about->vision_img) }}" alt="Current Image" --}}
                        <img src="{{ supaUrl($about->vision_img) }}" alt="Current Image"
                            class="max-h-48 rounded-md border border-gray-300 object-contain">
                    </div>
                @endif
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-200 text-gray-500 rounded p-2" onchange="previewVisionImage(event)">
                    <img id="visionPreview" src="#" alt="Vision Image Preview" class="mt-2 w-32 h-32 object-cover rounded border border-gray-300 hidden">
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200  shadow-lg">
                    <div class="flex justify-between mb-2">
                        <div class="border-b border-gray-200">
                            <h3 class="text-lg font-semibold">Vision Content</h3>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $vision->title) }}" class="w-full border border-gray-200 shadow-sm rounded p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Content</label>
                        <textarea name="content" rows="5" class="w-full border  border-gray-200 shadow-sm rounded p-2">{{ old('content', $vision->content) }}</textarea>
                    </div>
                </div>

            </form>
        </div>
    </div>
    {{-- @include('partials.quotes-tab') --}}
</main>
@endsection

@push('script-stack')
<script>
    function previewMissionImage(event) {
        const input = event.target;
        const preview = document.getElementById('missionPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewVisionImage(event) {
        const input = event.target;
        const preview = document.getElementById('visionPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#tab-menu button').forEach(btn => {
            btn.addEventListener('click', function () {
                const targetTab = this.dataset.tab;

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(tab =>
                    tab.classList.add('hidden')
                );

                // Show selected tab content
                document.querySelector(`#tab-${targetTab}`).classList.remove('hidden');

                // Reset styles for all tab buttons
                document.querySelectorAll('#tab-menu button').forEach(b => {
                    b.classList.remove('text-blue-600', 'border-blue-600');
                    b.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                });

                // Apply active styles to the clicked tab
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
            });
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $('#person_id').on('change', function () {
        const personId = $(this).val();

        if (!personId) return;

        $.ajax({
            url: "{{ route('admin.about.person.quote') }}",
            type: "POST",
            data: {
                person: personId,
                lang: 'bn',
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                console.log(data);
                if (data.image) {
                    $('#personImage').attr('src', data.image);
                }
                if (data.person) {
                    $('#quoteTitle').val(data.person.title);
                    $('#quoteTextarea').val(data.person.quote);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching person data:", error);
                console.log(xhr.responseText); // This shows the Laravel error message
            }
        });
    });

</script>

@endpush
