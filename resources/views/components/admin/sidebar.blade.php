@props([
    'active' => null, // 'merchant-onboarding' etc
    'subactive' => null, // 'start' or 'requests'
])

<!-- LEFT NAVIGATION SIDEBAR -->
<nav id="sidebar" class="fixed left-0 top-0 w-[260px] h-full bg-brand-primary flex flex-col z-50">
    <!-- Logo Area -->
    <div class="p-6 pb-8">
        <svg width="160" height="40" viewBox="0 0 160 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="2iZii Logo">
            <path d="M20 10C20 4.47715 24.4772 0 30 0H10C4.47715 0 0 4.47715 0 10V30C0 35.5228 4.47715 40 10 40H30C24.4772 40 20 35.5228 20 30V10Z" fill="white"/>
            <circle cx="30" cy="10" r="4" fill="#FF7C00"/>
            <text x="40" y="28" fill="white" font-family="Inter" font-weight="bold" font-size="24">2iZii</text>
        </svg>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 px-0">
        <!-- MAIN Section -->
        <div class="mb-6">
            <h3 class="text-white/60 text-xs font-semibold uppercase tracking-wider px-6 mb-3">MAIN</h3>
            <ul class="space-y-1">
                <li>
                    <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-chart-line w-5 mr-3"></i>Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.onboarding.index') }}"
                       class="{{ $active === 'merchant-onboarding' ? 'nav-item-active text-white text-sm py-3 block font-semibold transition-colors' : 'nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors' }}">
                        <i class="fa-solid fa-user-plus w-5 mr-3"></i>Merchant Onboarding
                    </a>
                    @if($subactive)
                        <ul class="mt-1">
                            <li>
                                <a href="{{ route('admin.onboarding.start') }}"
                                   class="{{ $subactive === 'start' ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Start New Onboarding
                                </a>
                            </li>
                            <li>
                                <a href="#" class="{{ $subactive === 'requests' ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Onboarding Requests
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>
                <li>
                    <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-handshake w-5 mr-3"></i>Partners
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-cog w-5 mr-3"></i>Masters
                    </a>
                    @if($subactive)
                        <ul class="mt-1">
                            <li>
                                <a href="#" class="nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors">
                                    Solution Master
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors">
                                    Acquirer Master
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors">
                                    Payment Method Master
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors">
                                    KYC Field Configuration
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors">
                                    Document Types
                                </a>
                            </li>
                        </ul>
                    @else
                        <ul class="mt-1">
                            <li>
                                <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors pl-12">
                                    Solution Master
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors pl-12">
                                    Acquirer Master
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors pl-12">
                                    Payment Method Master
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors pl-12">
                                    KYC Field Configuration
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors pl-12">
                                    Document Types
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>

        <!-- SYSTEM Section -->
        <div>
            <h3 class="text-white/60 text-xs font-semibold uppercase tracking-wider px-6 mb-3">SYSTEM</h3>
            <ul class="space-y-1">
                <li>
                    <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-gear w-5 mr-3"></i>Settings
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-clipboard-list w-5 mr-3"></i>Audit Logs
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-users w-5 mr-3"></i>User Management
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

