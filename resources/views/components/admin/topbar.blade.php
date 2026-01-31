@props([
    'breadcrumbs' => null,
])
<!-- TOP HEADER BAR -->
<header id="header"
    class="fixed top-0 left-0 md:left-[260px] right-0 h-16 bg-white shadow-sm border-b border-[#EDEDED] flex items-center @if ($breadcrumbs) justify-between @else justify-end @endif px-4 md:px-8 z-40">

    @if ($breadcrumbs)
        <div class="flex items-center gap-3 text-sm">
            <button class="md:hidden text-brand-primary" aria-label="Open menu" data-sidebar-toggle>
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!$loop->last)
                    <a href="{{ $breadcrumb['url'] }}"
                        class="text-brand-primary font-medium">{{ $breadcrumb['label'] }}</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-500"></i>
                @else
                    <span class="text-gray-400">{{ $breadcrumb['label'] }}</span>
                @endif
            @endforeach
        </div>
    @endif
    <div class="flex items-center gap-6">
        <!-- Notification Bell -->
        <button class="text-brand-text hover:text-brand-primary transition-colors relative">
            <i class="fa-regular fa-bell text-lg"></i>
            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <!-- Admin Profile -->
        <div class="relative">
            <div class="flex items-center gap-3 cursor-pointer group" id="profileDropdownToggle">
                <img src="https://storage.googleapis.com/uxpilot-auth.appspot.com/avatars/avatar-2.jpg" alt="Admin Avatar"
                    class="w-8 h-8 rounded-full object-cover">
                <i
                    class="fa-solid fa-chevron-down text-xs text-brand-text group-hover:text-brand-primary transition-colors"></i>
            </div>

            <!-- Dropdown Menu -->
            <div id="profileDropdown"
                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>


</header>

<script>
    // Profile dropdown toggle
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('profileDropdownToggle');
        const dropdown = document.getElementById('profileDropdown');

        if (toggle && dropdown) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && !toggle.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
