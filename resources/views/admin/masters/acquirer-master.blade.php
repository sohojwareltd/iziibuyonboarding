@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acquirer Master - 2iZii</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#2D3A74',
                            cta: '#FF7C00',
                            ctaHover: '#E56D00',
                            secondary: '#4055A8',
                            neutral: '#F7F8FA',
                            text: '#6A6A6A',
                            textLight: '#9A9A9A',
                            border: '#D1D5DB',
                            dark: '#2D3A74',
                            accent: '#FFA439',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
        window.FontAwesomeConfig = {
            autoReplaceSvg: 'nest'
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        .nav-item-active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #FF7C00;
            padding-left: 20px;
        }

        .nav-item {
            padding-left: 24px;
        }

        .nav-item-sub {
            padding-left: 44px;
        }

        .nav-item-sub-active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #FF7C00;
            padding-left: 40px;
        }

        .drawer-open {
            transform: translateX(0);
        }

        .drawer-closed {
            transform: translateX(100%);
        }

        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }

        .form-input {
            width: 100%;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            color: #2D3A74;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: #2D3A74;
            box-shadow: 0 0 0 1px #2D3A74;
        }

        .toggle-switch {
            position: relative;
            width: 40px;
            height: 24px;
            background-color: #28A745;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            background-color: white;
            border-radius: 50%;
            top: 4px;
            left: 20px;
            transition: left 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch.inactive {
            background-color: #CBD5E1;
        }

        .toggle-switch.inactive::after {
            left: 4px;
        }

        @keyframes scale-in {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scale-in {
            animation: scale-in 0.2s ease-out;
        }

        /* Filter panel styles */
        #filter-panel {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Active filters badges */
        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #FF9900 0%, #FF7200 100%);
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.813rem;
            font-weight: 500;
        }

        .filter-badge button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            margin-left: 0.25rem;
            display: flex;
            align-items: center;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .filter-badge button:hover {
            opacity: 1;
        }

        /* Filter input group styling */
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #4B5563;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group label i {
            color: #FF9900;
            font-size: 0.75rem;
        }

        .filter-btn-reset {
            background: white;
            border: 2px solid #E5E7EB;
            color: #6B7280;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn-reset:hover {
            border-color: #D1D5DB;
            background: #F9FAFB;
        }

        .filter-btn-apply {
            background: linear-gradient(135deg, #FF9900 0%, #FF7200 100%);
            border: none;
            color: white;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(255, 153, 0, 0.2);
        }

        .filter-btn-apply:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(255, 153, 0, 0.3);
        }

        /* Single-row filter layout */
        #filter-panel .filter-group {
            margin-bottom: 0;
        }

        /* Toast notifications */
        #toast-container {
            position: fixed;
            top: 1.25rem;
            right: 1rem;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            pointer-events: none;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            min-width: 280px;
            max-width: 420px;
            padding: 0.75rem 0.875rem;
            border-radius: 0.75rem;
            color: #FFFFFF;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            animation: toast-in 0.25s ease-out;
            pointer-events: auto;
        }

        .toast-success {
            background: linear-gradient(135deg, #16A34A 0%, #22C55E 100%);
        }

        .toast-error {
            background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
        }

        .toast-icon {
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-title {
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .toast-message {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        @keyframes toast-in {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('body')

    <body class="bg-brand-neutral">

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Acquirer Master', 'url' => route('admin.masters.acquirer-master')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">


                <!-- Page Content -->
                <div class="bg-brand-neutral p-4 md:p-8">
                    <div class="max-w-[1200px] mx-auto">
                        <!-- Page Title and Add Button -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-brand-primary mb-1">Acquirer Master</h1>
                                <p class="text-sm text-gray-500">Manage acquirer configurations, API endpoints, and solution
                                    mappings.</p>
                            </div>
                            <button onclick="openDrawer()"
                                class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2 self-start md:self-auto">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Acquirer</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-4">
                            <form method="GET" action="{{ route('admin.masters.acquirer-master') }}" class="space-y-4">
                                <!-- Search Bar and Filter Button -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                                    <div class="relative flex-1 max-w-[384px]">
                                        <i
                                            class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                        <input type="text" name="search" placeholder="Search acquirers..."
                                            value="{{ request('search') }}"
                                            class="form-input pl-10 bg-white border-gray-200 focus:bg-white w-full">
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="toggleFilters()"
                                            class="bg-white border-2 border-gray-200 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-semibold hover:border-orange-300 hover:text-brand-accent transition-all flex items-center gap-2 whitespace-nowrap">
                                            <i class="fa-solid fa-filter text-sm"></i>
                                            <span>Advanced Filters</span>
                                            <i id="filter-arrow"
                                                class="fa-solid fa-chevron-down text-xs transition-transform"></i>
                                        </button>

                                        <a href="{{ route('admin.masters.acquirer-master.export', request()->query()) }}"
                                            class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                            <i class="fa-solid fa-download text-sm"></i>
                                            Export
                                        </a>
                                    </div>
                                </div>

                                <!-- Active Filters Display -->
                                @if (request()->has('search') || request()->has('mode') || request()->has('status') || request()->has('country'))
                                    <div class="active-filters">
                                        @if (request('search'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                                <span>{{ request('search') }}</span>
                                                <button type="button" onclick="clearSearchFilter()">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (request('mode'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-cog text-xs"></i>
                                                <span>Mode: {{ ucfirst(request('mode')) }}</span>
                                                <button type="button" onclick="clearModeFilter()">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (request('status'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-circle-half-stroke text-xs"></i>
                                                <span>Status: {{ ucfirst(request('status')) }}</span>
                                                <button type="button" onclick="clearStatusFilter()">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (request('country'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-map-pin text-xs"></i>
                                                <span>{{ request('country') }}</span>
                                                <button type="button" onclick="clearCountryFilter()">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Filter Panel -->
                                <div id="filter-panel"
                                    class="hidden bg-gradient-to-b from-[#fafbfc] to-white rounded-lg border border-gray-100 p-4">
                                    <div class="flex flex-col sm:flex-row items-end gap-3">
                                        <!-- Mode Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-cog"></i>
                                                Mode
                                            </label>
                                            <select name="mode"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Modes</option>
                                                <option value="email" {{ request('mode') == 'email' ? 'selected' : '' }}>
                                                    Email</option>
                                                <option value="api" {{ request('mode') == 'api' ? 'selected' : '' }}>API
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Status Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-circle-half-stroke"></i>
                                                Status
                                            </label>
                                            <select name="status"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Status</option>
                                                <option value="active"
                                                    {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive"
                                                    {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Country Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-map-pin"></i>
                                                Country
                                            </label>
                                            <select name="country"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Countries</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country }}"
                                                        {{ request('country') == $country ? 'selected' : '' }}>
                                                        {{ $country }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filter Controls -->
                                        <div class="flex gap-2 flex-shrink-0 w-full sm:w-auto">
                                            <button type="button" class="filter-btn-reset !p-2.5 !px-3 flex-1 sm:flex-none"
                                                onclick="clearAllFilters()" title="Clear All">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                            </button>
                                            <button type="submit"
                                                class="filter-btn-apply !p-2.5 !px-4 flex-1 sm:flex-none"
                                                title="Apply Filters">
                                                <i class="fa-solid fa-check text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Table -->
                        <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 min-w-[800px]">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left">
                                                <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1">
                                                Acquirer Name
                                                <i class="fa-solid fa-arrow-up-down text-[10px]"></i>
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                Mode</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                Supported Solutions</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                Contact / API</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th
                                                class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($acquirers as $acquirer)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-7">
                                                    <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="font-medium text-brand-primary">{{ $acquirer->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-400 mt-0.5">Updated
                                                        {{ $acquirer->updated_at->diffForHumans() }}</div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="@if ($acquirer->mode == 'email') bg-purple-100 text-purple-700 @else bg-blue-100 text-blue-700 @endif px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                        {{ ucfirst($acquirer->mode) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex gap-1 flex-wrap">
                                                        @if ($acquirer->supported_solutions)
                                                            @php
                                                                $solutionIds = is_string($acquirer->supported_solutions)
                                                                    ? json_decode($acquirer->supported_solutions)
                                                                    : $acquirer->supported_solutions;
                                                                $solutionCount = count($solutionIds);
                                                            @endphp
                                                            @foreach (array_slice($solutionIds, 0, 2) as $solutionId)
                                                                @php $solution = $solutions->find($solutionId); @endphp
                                                                @if ($solution)
                                                                    <span
                                                                        class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">{{ $solution->name }}</span>
                                                                @endif
                                                            @endforeach
                                                            @if ($solutionCount > 2)
                                                                <span
                                                                    class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">+{{ $solutionCount - 2 }}</span>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-400 text-xs">—</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if ($acquirer->mode == 'email')
                                                        <span
                                                            class="text-gray-600 text-sm">{{ $acquirer->email_recipient ?? '—' }}</span>
                                                    @else
                                                        <span class="text-gray-600 text-xs font-mono">API Configured</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="@if ($acquirer->is_active) bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                        <span
                                                            class="w-1.5 h-1.5 @if ($acquirer->is_active) bg-green-600 @else bg-red-600 @endif rounded-full"></span>
                                                        {{ $acquirer->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-4">
                                                        <button onclick="editAcquirer({{ $acquirer->id }})"
                                                            class="text-brand-secondary text-xs font-medium hover:underline"><i
                                                                class="fa-solid fa-pen text-sm"></i></button>
                                                        <button onclick="deleteAcquirer({{ $acquirer->id }})"
                                                            class="text-red-500 text-xs font-medium hover:underline"><i
                                                                class="fa-solid fa-trash text-sm"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                                    <p class="text-sm">No acquirers found. Create one to get started.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div
                                class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="text-xs text-gray-500">
                                    Showing <span
                                        class="font-medium text-gray-900">{{ ($acquirers->currentPage() - 1) * $acquirers->perPage() + 1 }}</span>
                                    to <span
                                        class="font-medium text-gray-900">{{ min($acquirers->currentPage() * $acquirers->perPage(), $acquirers->total()) }}</span>
                                    of <span class="font-medium text-gray-900">{{ $acquirers->total() }}</span> results
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    {{ $acquirers->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit Acquirer -->
        <div id="acquirer-drawer"
            class="fixed top-0 right-0 w-full max-w-[520px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-brand-primary" id="drawer-title">Add Acquirer</h2>
                    <button onclick="closeDrawer()"
                        class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <form id="acquirer-form" class="flex-1 overflow-y-auto p-6 flex flex-col">
                    <div class="space-y-8 flex-1">
                        <!-- Acquirer Information Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Acquirer Information
                                </h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Acquirer Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" class="form-input"
                                    placeholder="e.g. Elavon" required>
                                <span class="error-message text-red-500 text-xs mt-1 hidden"></span>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mode <span
                                            class="text-red-500">*</span></label>
                                    <select name="mode" id="mode" class="form-input" required
                                        onchange="toggleModeFields()">
                                        <option value="">Select Mode</option>
                                        <option value="email">Email</option>
                                        <option value="api">API</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span
                                            class="text-red-500">*</span></label>
                                    <div class="flex items-center gap-3 h-[38px]">
                                        <div class="toggle-switch" id="status-toggle" onclick="toggleStatus()"></div>
                                        <span class="text-sm text-gray-700 font-medium" id="status-label">Active</span>
                                        <input type="hidden" name="is_active" id="is_active" value="1">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" id="description" class="form-input resize-y" rows="3"
                                    placeholder="Brief description of the acquirer"></textarea>
                            </div>
                        </div>

                        <!-- Supported Countries Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Countries
                                </h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Countries</label>
                                <div class="border border-gray-200 rounded-lg p-2 flex flex-wrap gap-2 min-h-[42px]"
                                    id="countries-container">
                                    <input type="text" id="country-input" placeholder="Add country..."
                                        class="flex-1 min-w-[100px] border-0 outline-none text-xs bg-transparent"
                                        onkeypress="handleCountryInput(event)">
                                </div>
                                <input type="hidden" name="supported_countries" id="supported_countries"
                                    value="[]">
                            </div>
                        </div>

                        <!-- Supported Solutions Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Solutions
                                </h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Solutions</label>
                                <div class="bg-white border border-gray-200 rounded-lg p-3" id="solutions-container">
                                    @foreach ($solutions as $solution)
                                        <label class="flex items-center gap-2 mb-2">
                                            <input type="checkbox" name="supported_solutions[]"
                                                value="{{ $solution->id }}"
                                                class="solution-checkbox w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-700">{{ $solution->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Email Configuration Section -->
                        <div class="space-y-4" id="email-config" style="display: none;">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Email Configuration
                                </h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Recipient(s) <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email_recipient" id="email_recipient" class="form-input"
                                    placeholder="kyc@acquirer.com">
                                <span class="error-message text-red-500 text-xs mt-1 hidden"></span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Subject Template <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="email_subject_template" id="email_subject_template"
                                    class="form-input" placeholder="KYC Application - {merchant_name}">
                                <span class="error-message text-red-500 text-xs mt-1 hidden"></span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Body Template <span
                                        class="text-red-500">*</span></label>
                                <textarea name="email_body_template" id="email_body_template" class="form-input resize-y" rows="4"
                                    placeholder="Dear Team, Please find attached..."></textarea>
                                <span class="error-message text-red-500 text-xs mt-1 hidden"></span>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Attachment Format</label>
                                    <select name="attachment_format" id="attachment_format" class="form-input">
                                        <option value="pdf">PDF</option>
                                        <option value="zip">ZIP</option>
                                    </select>
                                </div>
                                <div class="flex-1 flex items-end">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="secure_email_required" id="secure_email_required"
                                            class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Secure Email Required</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Compliance Configuration Section -->
                        <div class="space-y-3">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Compliance
                                    Configuration</h3>
                            </div>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="requires_beneficial_owner_data"
                                    id="requires_beneficial_owner_data" class="w-4 h-4 border-gray-400 rounded">
                                <span class="text-sm text-gray-700">Requires Beneficial Owner Data</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="requires_board_member_data" id="requires_board_member_data"
                                    class="w-4 h-4 border-gray-400 rounded">
                                <span class="text-sm text-gray-700">Requires Board Member Data</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="requires_signatories" id="requires_signatories"
                                    class="w-4 h-4 border-gray-400 rounded" checked>
                                <span class="text-sm text-gray-700">Requires Signatories</span>
                            </label>
                        </div>
                    </div>

                    <!-- Drawer Footer -->
                    <div class="border-t border-gray-200 px-0 py-4 flex items-center justify-between bg-white mt-8">
                        <button type="button" onclick="closeDrawer()"
                            class="text-brand-primary font-medium hover:text-brand-primary/80">Cancel</button>
                        <div class="flex gap-3">
                            <button type="button" id="save-draft-btn"
                                class="border-2 border-brand-accent text-brand-accent px-5 py-3 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                                Save Draft
                            </button>
                            <button type="submit"
                                class="bg-brand-accent text-white px-5 py-3 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                                Save Acquirer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay"
            class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-40 hidden"
            onclick="closeDrawer()"></div>

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-scale-in">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                        <i class="fa-solid fa-trash-can text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-primary text-center mb-2">Delete Acquirer</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Are you sure you want to delete <span id="delete-acquirer-name"
                            class="font-semibold text-brand-primary"></span>? This action cannot be undone.
                    </p>
                    <div class="flex gap-3">
                        <button onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button onclick="confirmDelete()"
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors shadow-sm">
                            <i class="fa-solid fa-trash-can mr-2"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const currentAcquirerId = null;
            let supportedCountries = [];

            function openDrawer() {
                resetForm();
                document.getElementById('drawer-title').textContent = 'Add Acquirer';
                document.getElementById('acquirer-form').dataset.mode = 'create';
                document.getElementById('acquirer-drawer').classList.remove('drawer-closed');
                document.getElementById('acquirer-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function closeDrawer() {
                document.getElementById('acquirer-drawer').classList.remove('drawer-open');
                document.getElementById('acquirer-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
                resetForm();
            }

            function resetForm() {
                document.getElementById('acquirer-form').reset();
                supportedCountries = [];
                document.getElementById('countries-container').innerHTML =
                    '<input type="text" id="country-input" placeholder="Add country..." class="flex-1 min-w-[100px] border-0 outline-none text-xs bg-transparent" onkeypress="handleCountryInput(event)">';
                document.getElementById('status-toggle').classList.remove('inactive');
                document.getElementById('status-label').textContent = 'Active';
                document.getElementById('is_active').value = '1';
                document.getElementById('requires_signatories').checked = true;
                toggleModeFields();
            }

            function toggleStatus() {
                const toggle = document.getElementById('status-toggle');
                const label = document.getElementById('status-label');

                if (toggle.classList.contains('inactive')) {
                    toggle.classList.remove('inactive');
                    label.textContent = 'Active';
                    document.getElementById('is_active').value = '1';
                } else {
                    toggle.classList.add('inactive');
                    label.textContent = 'Inactive';
                    document.getElementById('is_active').value = '0';
                }
            }

            function toggleModeFields() {
                const mode = document.getElementById('mode').value;
                const emailConfig = document.getElementById('email-config');

                if (mode === 'email') {
                    emailConfig.style.display = 'block';
                    document.getElementById('email_recipient').required = true;
                    document.getElementById('email_subject_template').required = true;
                    document.getElementById('email_body_template').required = true;
                } else {
                    emailConfig.style.display = 'none';
                    document.getElementById('email_recipient').required = false;
                    document.getElementById('email_subject_template').required = false;
                    document.getElementById('email_body_template').required = false;
                }
            }

            function handleCountryInput(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const input = event.target;
                    const country = input.value.trim();

                    if (country && !supportedCountries.includes(country)) {
                        supportedCountries.push(country);
                        addCountryTag(country);
                        input.value = '';
                    }
                }
            }

            function addCountryTag(country) {
                const container = document.getElementById('countries-container');
                const tag = document.createElement('span');
                tag.className = 'bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1';
                tag.innerHTML = `
                    ${country}
                    <button type="button" class="text-blue-600 hover:text-blue-800" onclick="removeCountry('${country}')">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                `;
                container.insertBefore(tag, container.lastChild);
                document.getElementById('supported_countries').value = JSON.stringify(supportedCountries);
            }

            function removeCountry(country) {
                supportedCountries = supportedCountries.filter(c => c !== country);
                document.getElementById('supported_countries').value = JSON.stringify(supportedCountries);

                const tags = document.querySelectorAll('#countries-container span');
                tags.forEach(tag => {
                    if (tag.textContent.includes(country)) {
                        tag.remove();
                    }
                });
            }

            function editAcquirer(id) {
                console.log('Edit acquirer clicked, ID:', id);
                fetch(`{{ url('admin/masters/acquirers') }}/${id}`)
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data received:', data);
                        if (data.success) {
                            console.log('Populating form with:', data.data);
                            populateForm(data.data);
                            document.getElementById('drawer-title').textContent = 'Edit Acquirer';
                            document.getElementById('acquirer-form').dataset.mode = 'edit';
                            document.getElementById('acquirer-form').dataset.id = id;
                            // Open drawer without resetting form
                            document.getElementById('acquirer-drawer').classList.remove('drawer-closed');
                            document.getElementById('acquirer-drawer').classList.add('drawer-open');
                            document.getElementById('drawer-overlay').classList.remove('hidden');
                            console.log('Drawer opened for editing');
                        } else {
                            console.error('API returned success: false');
                            showNotification('Error loading acquirer data', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading acquirer:', error);
                        showNotification('Error loading acquirer: ' + error.message, 'error');
                    });
            }

            function populateForm(acquirer) {
                console.log('populateForm called with:', acquirer);
                document.getElementById('name').value = acquirer.name;
                document.getElementById('mode').value = acquirer.mode;
                document.getElementById('description').value = acquirer.description || '';
                document.getElementById('email_recipient').value = acquirer.email_recipient || '';
                document.getElementById('email_subject_template').value = acquirer.email_subject_template || '';
                document.getElementById('email_body_template').value = acquirer.email_body_template || '';
                document.getElementById('attachment_format').value = acquirer.attachment_format || 'pdf';
                document.getElementById('secure_email_required').checked = acquirer.secure_email_required;
                document.getElementById('requires_beneficial_owner_data').checked = acquirer.requires_beneficial_owner_data;
                document.getElementById('requires_board_member_data').checked = acquirer.requires_board_member_data;
                document.getElementById('requires_signatories').checked = acquirer.requires_signatories;

                // Set status
                const isActive = acquirer.is_active;
                const toggle = document.getElementById('status-toggle');
                const label = document.getElementById('status-label');
                document.getElementById('is_active').value = isActive ? '1' : '0';

                if (!isActive) {
                    toggle.classList.add('inactive');
                    label.textContent = 'Inactive';
                } else {
                    toggle.classList.remove('inactive');
                    label.textContent = 'Active';
                }

                // Set countries
                supportedCountries = acquirer.supported_countries || [];
                console.log('Setting countries:', supportedCountries);
                const countriesContainer = document.getElementById('countries-container');
                countriesContainer.innerHTML = '';
                supportedCountries.forEach(country => {
                    const tag = document.createElement('span');
                    tag.className = 'bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1';
                    tag.innerHTML = `
                        ${country}
                        <button type="button" class="text-blue-600 hover:text-blue-800" onclick="removeCountry('${country}')">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    `;
                    countriesContainer.appendChild(tag);
                });
                countriesContainer.appendChild(createCountryInput());
                document.getElementById('supported_countries').value = JSON.stringify(supportedCountries);

                // Set solutions
                const solutionIds = acquirer.supported_solutions || [];
                console.log('Setting solutions:', solutionIds);
                document.querySelectorAll('.solution-checkbox').forEach(checkbox => {
                    checkbox.checked = solutionIds.includes(parseInt(checkbox.value));
                });

                toggleModeFields();
                console.log('Form populated successfully');
            }

            function createCountryInput() {
                const input = document.createElement('input');
                input.type = 'text';
                input.id = 'country-input';
                input.placeholder = 'Add country...';
                input.className = 'flex-1 min-w-[100px] border-0 outline-none text-xs bg-transparent';
                input.onkeypress = function(e) {
                    handleCountryInput(e);
                };
                return input;
            }

            let deleteAcquirerId = null;

            function deleteAcquirer(id) {
                deleteAcquirerId = id;
                // Get acquirer name from the table row
                const row = event.target.closest('tr');
                const acquirerName = row?.querySelector('.font-medium')?.textContent || 'this acquirer';
                document.getElementById('delete-acquirer-name').textContent = acquirerName;
                document.getElementById('delete-modal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('delete-modal').classList.add('hidden');
                deleteAcquirerId = null;
            }

            function confirmDelete() {
                if (!deleteAcquirerId) return;

                fetch(`{{ url('admin/masters/acquirers') }}/${deleteAcquirerId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                                '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            closeDeleteModal();
                            showNotification('Acquirer deleted successfully', 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            closeDeleteModal();
                            showNotification(data.message || 'Error deleting acquirer', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        closeDeleteModal();
                        showNotification('Error deleting acquirer', 'error');
                    });
            }

            function showNotification(message, type) {
                let container = document.getElementById('toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'toast-container';
                    document.body.appendChild(container);
                }

                const notification = document.createElement('div');
                const isSuccess = type === 'success';
                notification.className = `toast ${isSuccess ? 'toast-success' : 'toast-error'}`;
                notification.innerHTML = `
                    <div class="toast-icon">
                        <i class="fa-solid ${isSuccess ? 'fa-check' : 'fa-xmark'} text-sm"></i>
                    </div>
                    <div>
                        <div class="toast-title">${isSuccess ? 'Success' : 'Error'}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                `;
                container.appendChild(notification);
                setTimeout(() => notification.remove(), isSuccess ? 3200 : 4500);
            }

            // Form submission
            document.getElementById('acquirer-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const mode = this.dataset.mode;
                const id = this.dataset.id;
                const formData = new FormData(this);

                // Prepare solutions
                const solutions = Array.from(document.querySelectorAll('.solution-checkbox:checked')).map(c => c.value);
                formData.set('supported_solutions', JSON.stringify(solutions));

                // Handle checkboxes - FormData doesn't include unchecked checkboxes
                formData.set('secure_email_required', document.getElementById('secure_email_required').checked ? '1' :
                    '0');
                formData.set('requires_beneficial_owner_data', document.getElementById('requires_beneficial_owner_data')
                    .checked ? '1' : '0');
                formData.set('requires_board_member_data', document.getElementById('requires_board_member_data')
                    .checked ? '1' : '0');
                formData.set('requires_signatories', document.getElementById('requires_signatories').checked ? '1' :
                    '0');

                let url;
                let method = 'POST';

                if (mode === 'create') {
                    url = '{{ url('admin/masters/acquirers') }}';
                } else {
                    url = `{{ url('admin/masters/acquirers') }}/${id}`;
                    formData.append('_method', 'PUT');
                }

                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ||
                    '{{ csrf_token() }}');

                console.log('Submitting form:', {
                    mode: mode,
                    id: id,
                    url: url,
                    data: Object.fromEntries(formData)
                });

                fetch(url, {
                        method: method,
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            showNotification(data.message, 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            if (data.errors) {
                                let errorMsg = 'Validation errors:\n';
                                for (let field in data.errors) {
                                    errorMsg += `${field}: ${data.errors[field].join(', ')}\n`;
                                }
                                showNotification(errorMsg, 'error');
                            } else {
                                showNotification(data.message || 'Error saving acquirer', 'error');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error saving acquirer: ' + error.message, 'error');
                    });
            });

            // Filter functions
            function toggleFilters() {
                const filterPanel = document.getElementById('filter-panel');
                const filterArrow = document.getElementById('filter-arrow');
                filterPanel.classList.toggle('hidden');
                filterArrow.style.transform = filterPanel.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }

            function clearAllFilters() {
                window.location.href = '{{ route('admin.masters.acquirer-master') }}';
            }

            function clearSearchFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('search');
                window.location.href = `?${params.toString()}`;
            }

            function clearModeFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('mode');
                window.location.href = `?${params.toString()}`;
            }

            function clearStatusFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('status');
                window.location.href = `?${params.toString()}`;
            }

            function clearCountryFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('country');
                window.location.href = `?${params.toString()}`;
            }

            // Add CSRF token to meta
            if (!document.querySelector('meta[name="csrf-token"]')) {
                const meta = document.createElement('meta');
                meta.setAttribute('name', 'csrf-token');
                meta.setAttribute('content', '{{ csrf_token() }}');
                document.head.appendChild(meta);
            }
        </script>

    </body>
@endsection
