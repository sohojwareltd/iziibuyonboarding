@props([
    'breadcrumbs' => null,
])
<!-- TOP HEADER BAR -->
<header id="header"
    class="fixed top-0 left-[260px] right-0 h-16 bg-white shadow-sm border-b border-[#EDEDED] flex items-center @if ($breadcrumbs) justify-between @else justify-end @endif px-8 z-40">

    @if ($breadcrumbs)
        <div class="flex items-center gap-2 text-sm">
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
        <div class="flex items-center gap-3 cursor-pointer group">
            <img src="https://storage.googleapis.com/uxpilot-auth.appspot.com/avatars/avatar-2.jpg" alt="Admin Avatar"
                class="w-8 h-8 rounded-full object-cover">
            <i
                class="fa-solid fa-chevron-down text-xs text-brand-text group-hover:text-brand-primary transition-colors"></i>
        </div>
    </div>


</header>
