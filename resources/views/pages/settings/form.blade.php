@extends('app')

@section('content')
<div class="w-full bg-gray-100 py-10 px-4 sm:px-6 lg:px-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Site Settings</h1>
    <p class="text-gray-500 mb-8">Manage your website's configuration from one place.</p>
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full border border-gray-200">

        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="settings-tab-menu">
                <li class="mr-2">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 border-blue-600" data-tab="general">General</button>
                </li>
                <li class="mr-2">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" data-tab="socials">Socials & Media</button>
                </li>
                <li class="mr-2">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" data-tab="footer">Footer</button>
                </li>
                <li class="mr-2">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" data-tab="donations">Donations</button>
                </li>
            </ul>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="mt-5 mb-5 flex justify-end">
                <button type="submit" class="py-3 px-3 bg-blue-600 text-white text-lg font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Save All Settings
                </button>
            </div>
            <div id="tab-general" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Basic Information</h3>
                        <div>
                            <label for="site_name" class="block mb-2 text-base font-medium text-gray-700">Site Name</label>
                            <input id="site_name" value="{{ old('site_name', $settings->site_name) }}" name="site_name" type="text" placeholder="Your Site Name" class="w-full px-4 py-3 border @error('site_name') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('site_name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="site_email" class="block mb-2 text-base font-medium text-gray-700">Site Email</label>
                            <input id="site_email" value="{{ old('site_email', $settings->email) }}" name="site_email" type="email" placeholder="contact@example.com" class="w-full px-4 py-3 border @error('site_email') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('site_email')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-base font-medium text-gray-700">Phone Number</label>
                            <input id="phone" name="phone" value="{{ old('phone', $settings->phone) }}" type="text" placeholder="+880 123 456 7890" class="w-full px-4 py-3 border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('phone')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Visuals & Contact</h3>
                        <div>
                            <label for="site_address" class="block mb-2 text-base font-medium text-gray-700">Site Address</label>
                            <input id="site_address" value="{{ old('site_address', $settings->address) }}" name="site_address" type="text" placeholder="123 Main St, Anytown, USA" class="w-full px-4 py-3 border @error('site_address') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('site_address')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="logo" class="block mb-2 text-base font-medium text-gray-700">Logo</label>
                            <div class="flex items-center gap-4">
                                <img id="logo-preview" src="{{ $settings->logo_url ?? 'https://placehold.co/128x128/e2e8f0/718096?text=Logo' }}" alt="Logo Preview" class="h-16 w-16 object-contain rounded-md border border-gray-200 p-1 bg-gray-50">
                                <input id="logo" name="logo" type="file" accept="image/*" class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            </div>
                             @error('logo')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                         <div>
                            <label for="icon" class="block mb-2 text-base font-medium text-gray-700">Favicon</label>
                            <div class="flex items-center gap-4">
                                <img id="icon-preview" src="{{ $settings->icon_url ?? 'https://placehold.co/128x128/e2e8f0/718096?text=Icon' }}" alt="Favicon Preview" class="h-16 w-16 object-contain rounded-md border border-gray-200 p-1 bg-gray-50">
                                <input id="icon" name="icon" type="file" accept="image/x-icon,image/png,image/svg+xml" class="w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            </div>
                            @error('icon')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-socials" class="tab-content hidden">
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Primary Socials & Media</h3>
                        <div>
                            <label for="social_facebook" class="block mb-2 text-base font-medium text-gray-700">Facebook URL</label>
                            <input id="social_facebook" name="social_facebook" value="{{ old('social_facebook', $es->facebook) }}" type="url" placeholder="https://facebook.com/your-page" class="w-full px-4 py-3 border @error('social_facebook') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('social_facebook')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="social_twitter" class="block mb-2 text-base font-medium text-gray-700">Twitter (X) URL</label>
                            <input id="social_twitter" name="social_twitter" value="{{ old('social_twitter', $es->twitter) }}"  type="url" placeholder="https://twitter.com/your-profile" class="w-full px-4 py-3 border @error('social_twitter') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('social_twitter')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                         <div>
                            <label for="intro_video_url" class="block mb-2 text-base font-medium text-gray-700">Intro Video Embed URL</label>
                            <input id="intro_video_url" name="intro_video_url" value="{{ old('intro_video_url', $es->embedded_url) }}" type="url" placeholder="e.g., https://www.youtube.com/embed/your-video-id" class="w-full px-4 py-3 border @error('intro_video_url') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('intro_video_url')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Secondary Socials</h3>
                         <div>
                            <label for="social_instagram" class="block mb-2 text-base font-medium text-gray-700">Instagram URL</label>
                            <input id="social_instagram" name="social_instagram" value="{{ old('social_instagram', $es->instagram) }}"  type="url" placeholder="https://instagram.com/your-profile" class="w-full px-4 py-3 border @error('social_instagram') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('social_instagram')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                         <div>
                            <label for="social_youtube" class="block mb-2 text-base font-medium text-gray-700">Youtube URL</label>
                            <input id="social_youtube" name="social_youtube" value="{{ old('social_youtube', $es->youtube) }}"  type="url" placeholder="https://youtube.com/your-channel" class="w-full px-4 py-3 border @error('social_youtube') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('social_youtube')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-footer" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Copyright</h3>
                         <div>
                            <label for="site_title" class="block mb-2 text-base font-medium text-gray-700">Copyright Title</label>
                            <input id="site_title" name="cp_title" type="text" value="{{ old('cp_title', $es->cp_title) }}" placeholder="Your Awesome Site" class="w-full px-4 py-3 border @error('cp_title') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('cp_title')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                     <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Details</h3>
                         <div>
                            <label for="copyright_text" class="block mb-2 text-base font-medium text-gray-700">Copyright Text</label>
                            <textarea id="copyright_text" name="cp_text" rows="4" placeholder="© {{ date('Y') }} Your Company. All rights reserved." class="w-full px-4 py-3 border @error('cp_text') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('cp_text', $es->cp_text) }}</textarea>
                            @error('cp_text')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-donations" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Bank Account</h3>
                        <div>
                            <label for="bank_account_name" class="block mb-2 text-base font-medium text-gray-700">Bank Account Name</label>
                            <input id="bank_account_name" name="account_name" type="text" value="{{ old('account_name', $donation->account_name) }}" class="w-full px-4 py-3 border @error('account_name') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('account_name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="bank_account_number" class="block mb-2 text-base font-medium text-gray-700">Bank Account Number</label>
                            <input id="bank_account_number" name="account_number" type="text"  value="{{ old('account_number', $donation->account_number) }}" class="w-full px-4 py-3 border @error('account_number') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('account_number')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="bank_name" class="block mb-2 text-base font-medium text-gray-700">Bank Name</label>
                            <input id="bank_name" name="bank_name" type="text" value="{{ old('bank_name', $donation->bank) }}" class="w-full px-4 py-3 border @error('bank_name') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('bank_name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="bank_branch" class="block mb-2 text-base font-medium text-gray-700">Branch</label>
                            <input id="bank_branch" name="branch" type="text" value="{{ old('branch', $donation->branch) }}" class="w-full px-4 py-3 border @error('branch') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('branch')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                         <div>
                            <label for="bank_routing" class="block mb-2 text-base font-medium text-gray-700">Routing Number</label>
                            <input id="bank_routing" name="routing" type="text" value="{{ old('routing', $donation->routing) }}" class="w-full px-4 py-3 border @error('routing') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                             @error('routing')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                     <div class="space-y-6 p-6 border border-gray-200 rounded-xl">
                        <h3 class="text-xl font-semibold text-gray-700">Mobile Banking</h3>
                        <div>
                            <label for="donation_bkash" class="block mb-2 text-base font-medium text-gray-700">bKash Number</label>
                            <input id="donation_bkash" name="donation_bkash" value="{{ old('donation_bkash', $donation->bkash) }}" type="text" placeholder="e.g., 01xxxxxxxxx" class="w-full px-4 py-3 border @error('donation_bkash') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('donation_bkash')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="donation_nagad" class="block mb-2 text-base font-medium text-gray-700">Nagad Number</label>
                            <input id="donation_nagad" name="donation_nagad"  value="{{ old('donation_nagad', $donation->nagad) }}" type="text" placeholder="e.g., 01xxxxxxxxx" class="w-full px-4 py-3 border @error('donation_nagad') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('donation_nagad')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="donation_rocket" class="block mb-2 text-base font-medium text-gray-700">Rocket Number</label>
                            <input id="donation_rocket" name="donation_rocket" type="text" value="{{ old('donation_rocket', $donation->rocket) }}" placeholder="e.g., 01xxxxxxxxx" class="w-full px-4 py-3 border @error('donation_rocket') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('donation_rocket')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('script-stack')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('#settings-tab-menu button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetTab = this.dataset.tab;
                tabContents.forEach(content => content.classList.add('hidden'));
                document.querySelector(`#tab-${targetTab}`).classList.remove('hidden');

                tabButtons.forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-blue-600');
                    btn.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300');
                });
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('border-transparent');
            });
        });

        function setupImagePreview(inputId, previewId) {
            const inputElement = document.getElementById(inputId);
            const previewElement = document.getElementById(previewId);

            if (inputElement && previewElement) {
                inputElement.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewElement.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        setupImagePreview('logo', 'logo-preview');
        setupImagePreview('icon', 'icon-preview');
    });
</script>
@endpush
