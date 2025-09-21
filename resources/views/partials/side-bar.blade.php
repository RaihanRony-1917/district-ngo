<aside
  id="sidebar"
  class="sidebar-transition fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl border-r border-gray-200 lg:relative lg:translate-x-0 transform -translate-x-full"
>
  <div class="flex items-center justify-between p-6 border-b border-gray-200">
    <div class="flex items-center space-x-3">
        @if(isset($siteSettings) && $siteSettings->logo)
            <img src="{{ asset('storage/' . $siteSettings->logo) }}"
                 alt="Site Logo"
                 class="h-8 w-auto object-contain">
        @else
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <i data-lucide="layout-dashboard" class="w-5 h-5 text-white"></i>
            </div>
        @endif
    </div>
    <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700">
        <i data-lucide="x" class="w-6 h-6"></i>
    </button>
</div>


  <nav class="flex-1 px-4 py-6 space-y-2 custom-scrollbar overflow-y-auto">
    {{-- This uses a ternary operator with request()->routeIs() to apply classes conditionally. --}}
    {{-- SYNTAX: class="{{ request()->routeIs('route.name.*') ? 'active-classes' : 'inactive-classes' }}" --}}
    @foreach (config('sidebar')['items'] as $item)
        @php
            $isActive = false;
            foreach ($item['active_on'] ?? [] as $pattern) {
                if (request()->routeIs($pattern)) {
                    $isActive = true;
                    break;
                }
            }
        @endphp
       <a
            href="{{ route($item['route']) }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ $isActive ? 'bg-blue-600 text-white font-medium shadow-md' : 'text-gray-700 hover:bg-gray-100' }}"
        >
            <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>
            <span>{{ $item['text'] }}</span>
        </a>
    @endforeach
{{--
    <a
      href="{{ route('admin.settings') }}"
      class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.settings') ? 'bg-blue-600 text-white font-medium shadow-md' : 'text-gray-700 hover:bg-gray-100' }}"
    >
      <i data-lucide="settings" class="w-5 h-5"></i>
      <span>Settings</span>
    </a> --}}
    <div class="border-t border-gray-200 my-4"></div>

  </nav>
</aside>
