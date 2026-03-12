@props([
    'active' => null, // 'merchant-onboarding' etc
])

@php
    $isOnboardingActive = request()->routeIs('admin.onboarding.*');
    $isOnboardingExpanded = $isOnboardingActive;
    $isMastersActive = request()->routeIs('admin.masters.*') || request()->routeIs('admin.categories.*');
    $isMastersExpanded = $isMastersActive;
@endphp

<style>
    .nav-item-sub {
        padding-left: 44px;
    }
    .nav-item-sub-active {
        background: rgba(255,255,255,0.15);
        border-left: 4px solid #FF7C00;
        padding-left: 40px;
    }
    /* Mobile off-canvas helpers */
    #sidebar.sidebar-open {
        transform: translateX(0);
    }
</style>

<!-- LEFT NAVIGATION SIDEBAR -->
<nav id="sidebar" class="fixed left-0 top-0 w-[260px] h-full bg-brand-primary flex flex-col z-50 transform transition-transform duration-300 -translate-x-full md:translate-x-0 md:shadow-none shadow-xl">
    <!-- Logo Area -->
    <div class="p-6 pb-8 flex items-center justify-between">
        <x-app-logo variant="light" class="max-h-10" />
        <button type="button" class="md:hidden text-white/70 hover:text-white transition-colors" aria-label="Close menu" data-sidebar-close>
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 px-0 overflow-y-auto">
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
                    <div class="sidebar-menu-item">
                        <div class="flex items-center {{ $isOnboardingActive ? 'nav-item-active' : '' }}">
                            <a href="{{ route('admin.onboarding.index') }}"
                               class="{{ $isOnboardingActive ? 'text-white text-sm py-3 block font-semibold transition-colors' : 'nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors' }} flex items-center flex-1 px-6">
                                <i class="fa-solid fa-user-plus w-5 mr-3"></i>
                                <span>Merchant Onboarding</span>
                            </a>
                            <button type="button" 
                                    class="sidebar-toggle-btn px-4 py-3 text-white/70 hover:text-white hover:bg-white/10 transition-colors focus:outline-none"
                                    aria-label="Toggle submenu">
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 sidebar-chevron {{ $isOnboardingExpanded ? 'rotate-180' : '' }}"></i>
                            </button>
                        </div>
                        <ul class="sidebar-submenu overflow-hidden transition-all duration-300 {{ $isOnboardingExpanded ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                            <li>
                                <a href="{{ route('admin.onboarding.start') }}"
                                   class="{{ request()->routeIs('admin.onboarding.start') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Start New Onboarding
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.onboarding.index') }}"
                                   class="{{ request()->routeIs('admin.onboarding.index') || request()->routeIs('admin.onboarding.track') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Onboarding Requests
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('admin.partners.index') }}" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-handshake w-5 mr-3"></i>Partners
                    </a>
                </li>
                <li>
                    <div class="sidebar-menu-item">
                        <div class="flex items-center {{ $isMastersActive ? 'nav-item-active' : '' }}">
                            <a href="{{ route('admin.masters.solution-master') }}" 
                               class="{{ $isMastersActive ? 'text-white text-sm py-3 block font-semibold transition-colors' : 'nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors' }} flex items-center flex-1 px-6">
                                <i class="fa-solid fa-cog w-5 mr-3"></i>
                                <span>Masters</span>
                            </a>
                            <button type="button" 
                                    class="sidebar-toggle-btn px-4 py-3 text-white/70 hover:text-white hover:bg-white/10 transition-colors focus:outline-none sidebar-toggle"
                                    aria-label="Toggle submenu">
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 sidebar-chevron {{ $isMastersExpanded ? 'rotate-180' : '' }}"></i>
                            </button>
                        </div>
                        <ul class="sidebar-submenu overflow-hidden transition-all duration-300 {{ $isMastersExpanded ? 'max-h-[500px] opacity-100' : 'max-h-0 opacity-0' }}">
                            <li>
                                <a href="{{ route('admin.masters.countrys.index') }}" 
                                   class="{{ request()->routeIs('admin.masters.countrys.*') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Country Master
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.solution-master') }}" 
                                   class="{{ request()->routeIs('admin.masters.solution-master') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Solution Master
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.acquirer-master') }}" 
                                   class="{{ request()->routeIs('admin.masters.acquirer-master') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Acquirer Master
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.payment-method-master') }}" 
                                   class="{{ request()->routeIs('admin.masters.payment-method-master') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Payment Method Master
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.price-list-master') }}" 
                                   class="{{ request()->routeIs('admin.masters.price-list-master') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Price List Master
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.kyc-field-master') }}" 
                                   class="{{ request()->routeIs('admin.masters.kyc-field-master') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    KYC Field Configuration
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.kyc-section-master') }}" 
                                   class="{{ request()->routeIs('admin.masters.kyc-section-master') || request()->routeIs('admin.masters.kyc-sections.*') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    KYC Section Master
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.acquirer-field-mapping') }}" 
                                   class="{{ request()->routeIs('admin.masters.acquirer-field-mapping') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Acquirer Field Mapping
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.masters.document-type-master') }}" 
                                   class="{{ request()->routeIs('admin.masters.document-type-master') || request()->routeIs('admin.masters.document-types.*') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Document Types
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories.index') }}" 
                                   class="{{ request()->routeIs('admin.categories.*') ? 'nav-item-sub-active text-white text-sm py-2 block font-semibold transition-colors' : 'nav-item-sub text-white text-sm py-2 block hover:bg-white/10 transition-colors' }}">
                                    Category Master
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <!-- SYSTEM Section -->
        <div>
            <h3 class="text-white/60 text-xs font-semibold uppercase tracking-wider px-6 mb-3">SYSTEM</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'nav-item-active text-white text-sm py-3 block font-semibold px-6' : 'nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors' }}">
                        <i class="fa-solid fa-gear w-5 mr-3"></i>Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.audit-logs.index') }}" class="{{ request()->routeIs('admin.audit-logs.*') ? 'nav-item-active text-white text-sm py-3 block font-semibold px-6' : 'nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors' }}">
                        <i class="fa-solid fa-clipboard-list w-5 mr-3"></i>Audit Logs
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'nav-item-active text-white text-sm py-3 block font-semibold px-6' : 'nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors' }}">
                        <i class="fa-solid fa-icons w-5 mr-3"></i>Category Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-item text-white text-sm py-3 block hover:bg-white/10 transition-colors">
                        <i class="fa-solid fa-users w-5 mr-3"></i>User Management
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        const openSidebar = () => {
            sidebar.classList.add('sidebar-open');
            sidebar.classList.remove('-translate-x-full');
            overlay?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        const closeSidebar = () => {
            sidebar.classList.remove('sidebar-open');
            sidebar.classList.add('-translate-x-full');
            overlay?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        // Handle all collapsible menu toggles (both Merchant Onboarding and Masters)
        document.querySelectorAll('.sidebar-toggle-btn').forEach(toggleBtn => {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const menuItem = this.closest('.sidebar-menu-item');
                const submenu = menuItem.querySelector('.sidebar-submenu');
                const chevron = menuItem.querySelector('.sidebar-chevron');
                
                // Toggle submenu
                if (submenu.classList.contains('max-h-0')) {
                    submenu.classList.remove('max-h-0', 'opacity-0');
                    submenu.classList.add('max-h-[500px]', 'opacity-100');
                    chevron.classList.add('rotate-180');
                } else {
                    submenu.classList.remove('max-h-96', 'max-h-[500px]', 'opacity-100');
                    submenu.classList.add('max-h-0', 'opacity-0');
                    chevron.classList.remove('rotate-180');
                }
            });
        });

        // Mobile open/close controls
        document.querySelectorAll('[data-sidebar-toggle]').forEach(toggleBtn => {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (sidebar.classList.contains('sidebar-open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        });

        document.querySelectorAll('[data-sidebar-close]').forEach(closeBtn => {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeSidebar();
            });
        });

        overlay?.addEventListener('click', closeSidebar);

        // Reset state on resize so desktop view is always visible
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.remove('sidebar-open');
                overlay?.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else if (!sidebar.classList.contains('sidebar-open')) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>
