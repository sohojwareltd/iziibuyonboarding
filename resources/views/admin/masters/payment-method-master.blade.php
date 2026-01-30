@extends('layouts.admin')

@section('title', 'Payment Method Master - 2iZii')

@push('head')
    <style>
        /* Drawer animations */
        #payment-method-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            max-width: 520px;
            height: 100vh;
            background: white;
            z-index: 50;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        #payment-method-drawer.drawer-open {
            transform: translateX(0) !important;
        }

        #payment-method-drawer.drawer-closed {
            transform: translateX(100%) !important;
            pointer-events: none;
        }

        /* Overlay styles */
        #drawer-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            transition: opacity 0.3s ease-in-out;
            opacity: 1;
        }

        #drawer-overlay.hidden {
            display: none !important;
            opacity: 0;
            pointer-events: none;
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            background-color: #28A745;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            top: 2px;
            left: 20px;
            transition: left 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch.inactive {
            background-color: #E5E7EB;
        }

        .toggle-switch.inactive::after {
            left: 2px;
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
    </style>
@endpush

@section('body')

    <x-admin.sidebar active="masters" />

    <x-admin.topbar :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => '#'],
        ['label' => 'Payment Method Master', 'url' => route('admin.masters.payment-method-master')],
    ]" />

    <!-- MAIN CONTENT AREA -->
    <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral">
        <div class="p-8">

            <!-- Page Content -->
            <div class="bg-brand-neutral p-8">
                <div class="max-w-[1200px] mx-auto">
                    <!-- Page Title and Add Button -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-semibold text-brand-primary mb-1">Payment Method Master</h1>
                            <p class="text-sm text-gray-500">Manage all payment methods, cards, and wallets available on the
                                platform.</p>
                        </div>
                        <button onclick="openDrawer()"
                            class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span class="font-medium">Add Payment Method</span>
                        </button>
                    </div>



                    <!-- Search and Filters -->
                    <div class="bg-white border border-gray-200 rounded-t-xl p-4">
                        <form method="GET" action="{{ route('admin.masters.payment-method-master') }}" class="space-y-4">
                            <!-- Search Bar and Filter Button -->
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                                <div class="relative flex-1 max-w-[384px]">
                                    <i
                                        class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input type="text" name="search" placeholder="Search payment methods..."
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
                                </div>
                            </div>

                            <!-- Active Filters Display -->
                            @if (request()->has('search') || request()->has('category') || request()->has('status') || request()->has('country'))
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
                                    @if (request('category'))
                                        <div class="filter-badge">
                                            <i class="fa-solid fa-layer-group text-xs"></i>
                                            <span>Category: {{ ucfirst(request('category')) }}</span>
                                            <button type="button" onclick="clearCategoryFilter()">
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
                                    <!-- Category Filter -->
                                    <div class="filter-group flex-1 w-full sm:w-auto">
                                        <label>
                                            <i class="fa-solid fa-layer-group"></i>
                                            Category
                                        </label>
                                        <select name="category"
                                            class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                            <option value="">All Categories</option>
                                            <option value="card" {{ request('category') == 'card' ? 'selected' : '' }}>
                                                Card</option>
                                            <option value="wallet" {{ request('category') == 'wallet' ? 'selected' : '' }}>
                                                Wallet</option>
                                            <option value="bank" {{ request('category') == 'bank' ? 'selected' : '' }}>
                                                Bank Transfer</option>
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
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
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
                                        <button type="submit" class="filter-btn-apply !p-2.5 !px-4 flex-1 sm:flex-none"
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
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Payment Method</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Category</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Country</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Acquirers</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Solutions</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($paymentMethods as $method)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-6 bg-gray-100 border border-gray-200 rounded flex items-center justify-center">
                                                    @if (str_contains(strtolower($method->name), 'visa'))
                                                        <i class="fa-brands fa-cc-visa text-blue-600 text-lg"></i>
                                                    @elseif(str_contains(strtolower($method->name), 'mastercard'))
                                                        <i class="fa-brands fa-cc-mastercard text-red-600 text-lg"></i>
                                                    @elseif(str_contains(strtolower($method->name), 'amex') || str_contains(strtolower($method->name), 'american'))
                                                        <i class="fa-brands fa-cc-amex text-blue-500 text-lg"></i>
                                                    @elseif(str_contains(strtolower($method->name), 'paypal'))
                                                        <i class="fa-brands fa-cc-paypal text-blue-700 text-lg"></i>
                                                    @elseif(str_contains(strtolower($method->name), 'apple'))
                                                        <i class="fa-brands fa-apple-pay text-gray-800 text-lg"></i>
                                                    @elseif(str_contains(strtolower($method->name), 'google'))
                                                        <i class="fa-brands fa-google-pay text-gray-600 text-lg"></i>
                                                    @else
                                                        <i class="fa-solid fa-credit-card text-gray-400 text-sm"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $method->name }}</div>
                                                    <div class="text-xs text-gray-400">{{ $method->display_label }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="@if ($method->category == 'card') bg-blue-100 text-blue-700 @elseif($method->category == 'wallet') bg-purple-100 text-purple-700 @else bg-green-100 text-green-700 @endif px-2.5 py-0.5 rounded-full text-xs font-medium capitalize">{{ $method->category }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($method->supported_countries && count($method->supported_countries) > 0)
                                                <span class="text-gray-600 text-sm">{{ $method->supported_countries[0] }}
                                                    @if (count($method->supported_countries) > 1)
                                                        +{{ count($method->supported_countries) - 1 }}
                                                    @endif
                                                </span>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                @if ($method->supported_acquirers && count($method->supported_acquirers) > 0)
                                                    @foreach (array_slice($method->supported_acquirers, 0, 2) as $acq)
                                                        <span
                                                            class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">{{ $acq['name'] ?? '' }}</span>
                                                    @endforeach
                                                    @if (count($method->supported_acquirers) > 2)
                                                        <span
                                                            class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">+{{ count($method->supported_acquirers) - 2 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400 text-xs">—</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                @if ($method->supported_solutions && count($method->supported_solutions) > 0)
                                                    @foreach (array_slice($method->supported_solutions, 0, 2) as $solId)
                                                        @php $solution = $solutions->find($solId); @endphp
                                                        @if ($solution)
                                                            <span
                                                                class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">{{ $solution->name }}</span>
                                                        @endif
                                                    @endforeach
                                                    @if (count($method->supported_solutions) > 2)
                                                        <span
                                                            class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">+{{ count($method->supported_solutions) - 2 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400 text-xs">—</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="@if ($method->is_active) bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif px-2.5 py-0.5 rounded-full text-xs font-medium">{{ $method->is_active ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button onclick="editPaymentMethod({{ $method->id }})"
                                                    class="text-gray-400 hover:text-brand-primary p-2">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button
                                                    onclick="deletePaymentMethod({{ $method->id }}, '{{ $method->name }}')"
                                                    class="text-gray-400 hover:text-red-500 p-2">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <p class="text-sm">No payment methods found. Create one to get started.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                Showing <span
                                    class="font-medium text-gray-900">{{ ($paymentMethods->currentPage() - 1) * $paymentMethods->perPage() + 1 }}</span>
                                to <span
                                    class="font-medium text-gray-900">{{ min($paymentMethods->currentPage() * $paymentMethods->perPage(), $paymentMethods->total()) }}</span>
                                of <span class="font-medium text-gray-900">{{ $paymentMethods->total() }}</span> results
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                {{ $paymentMethods->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Right Drawer for Add/Edit Payment Method -->
    <div id="payment-method-drawer" class="drawer-closed overflow-y-auto">
        <div class="flex flex-col h-full">
            <!-- Drawer Header -->
            <div class="border-b border-gray-200 px-6 py-5 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-brand-primary" id="drawer-title">Add Payment Method</h2>
                <button onclick="closeDrawer()"
                    class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Drawer Content -->
            <form id="payment-method-form" class="flex-1 overflow-y-auto p-6 flex flex-col">
                <div class="space-y-8 flex-1">
                    <!-- Basic Information Section -->
                    <div class="space-y-4">
                        <div class="pb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Basic Information</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" class="form-input"
                                placeholder="e.g. Visa" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Display Label <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="display_label" name="display_label" class="form-input"
                                placeholder="e.g. Visa Card Payments" required>
                            <p class="text-xs text-gray-500 mt-1">Visible to merchants during onboarding</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category <span
                                    class="text-red-500">*</span></label>
                            <select id="category" name="category" class="form-input" required>
                                <option value="">Select Category</option>
                                <option value="card">Card</option>
                                <option value="wallet">Wallet</option>
                                <option value="bank">Bank Transfer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="description" name="description" class="form-input resize-y" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Supported Country Section -->
                    <div class="space-y-4 border-t border-gray-200 pt-4">
                        <div class="pb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Country</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Countries</label>
                            <div id="countries-container"
                                class="border border-gray-200 rounded-lg p-2 flex flex-wrap gap-2 min-h-[42px]">
                                <input type="text" id="country-input" placeholder="Add country..."
                                    class="flex-1 min-w-[120px] border-0 outline-none text-sm bg-transparent"
                                    onkeypress="handleCountryInput(event)">
                            </div>
                            <input type="hidden" id="supported_countries" name="supported_countries" value="[]">
                        </div>
                    </div>

                    <!-- Supported Acquirers Section -->
                    <div class="space-y-4 border-t border-gray-200 pt-4">
                        <div class="pb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Acquirers</h3>
                        </div>

                        <div id="acquirers-container" class="space-y-3">
                            @foreach ($acquirers as $acquirer)
                                <div class="border border-gray-200 rounded-lg p-3">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox"
                                            class="acquirer-checkbox w-4 h-4 border-gray-400 rounded mt-0.5"
                                            value="{{ $acquirer->id }}" data-name="{{ $acquirer->name }}"
                                            onchange="toggleAcquirerTypes(this)">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900 text-sm mb-2">{{ $acquirer->name }}
                                            </div>
                                            <div class="flex gap-4 ml-7 acquirer-types"
                                                data-acquirer-id="{{ $acquirer->id }}" style="display: none;">
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox"
                                                        class="acquirer-type-checkbox w-3 h-3 border-gray-400 rounded"
                                                        data-acquirer-id="{{ $acquirer->id }}" value="online">
                                                    <span class="text-xs text-gray-600">Online</span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox"
                                                        class="acquirer-type-checkbox w-3 h-3 border-gray-400 rounded"
                                                        data-acquirer-id="{{ $acquirer->id }}" value="pos">
                                                    <span class="text-xs text-gray-600">POS</span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox"
                                                        class="acquirer-type-checkbox w-3 h-3 border-gray-400 rounded"
                                                        data-acquirer-id="{{ $acquirer->id }}" value="recurring">
                                                    <span class="text-xs text-gray-600">Recurring</span>
                                                </label>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="supported_acquirers" name="supported_acquirers" value="[]">
                    </div>

                    <!-- Supported Solutions Section -->
                    <div class="space-y-4 border-t border-gray-200 pt-4">
                        <div class="pb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Solutions</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($solutions as $solution)
                                <label
                                    class="border border-gray-200 rounded-lg p-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" class="solution-checkbox w-4 h-4 border-gray-400 rounded"
                                        value="{{ $solution->id }}">
                                    <span class="text-sm text-gray-900">{{ $solution->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Method Details Section -->
                    <div class="space-y-4 border-t border-gray-200 pt-4">
                        <div class="pb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Payment Method Details</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Scheme</label>
                            <select id="scheme" name="scheme" class="form-input">
                                <option value="">Select Scheme</option>
                                <option value="visa">Visa</option>
                                <option value="mastercard">Mastercard</option>
                                <option value="amex">Amex</option>
                                <option value="discover">Discover</option>
                                <option value="jcb">JCB</option>
                            </select>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                            <span class="text-sm text-gray-700 font-medium">Supports 3DS</span>
                            <div class="toggle-switch inactive" id="supports_3ds-toggle"
                                onclick="toggleField('supports_3ds')"></div>
                            <input type="hidden" id="supports_3ds" name="supports_3ds" value="0">
                        </div>

                        <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                            <span class="text-sm text-gray-700 font-medium">Allows Tokenization</span>
                            <div class="toggle-switch inactive" id="allows_tokenization-toggle"
                                onclick="toggleField('allows_tokenization')"></div>
                            <input type="hidden" id="allows_tokenization" name="allows_tokenization" value="0">
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div class="space-y-4 border-t border-gray-200 pt-4">
                        <div class="pb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Status</h3>
                        </div>

                        <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-1">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Active Status</div>
                                    <div class="text-xs text-gray-500">Enable this payment method</div>
                                </div>
                                <div class="toggle-switch" id="is_active-toggle" onclick="toggleField('is_active')">
                                </div>
                                <input type="hidden" id="is_active" name="is_active" value="1">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                            <textarea id="notes" name="notes" class="form-input resize-y" rows="2"
                                placeholder="Add any notes or reason..."></textarea>
                        </div>
                    </div>

                    <!-- Compliance Tags Section -->
                    <div class="space-y-3 border-t border-gray-200 pt-4">
                        <div class="pb-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Compliance Tags</h3>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                            <span class="text-sm text-gray-700">Requires Additional Documents</span>
                            <div class="toggle-switch inactive" id="requires_additional_documents-toggle"
                                onclick="toggleField('requires_additional_documents')"></div>
                            <input type="hidden" id="requires_additional_documents" name="requires_additional_documents"
                                value="0">
                        </div>

                        <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                            <span class="text-sm text-gray-700">Requires Acquirer Configuration</span>
                            <div class="toggle-switch inactive" id="requires_acquirer_configuration-toggle"
                                onclick="toggleField('requires_acquirer_configuration')"></div>
                            <input type="hidden" id="requires_acquirer_configuration"
                                name="requires_acquirer_configuration" value="0">
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-0 py-4 flex items-center justify-between bg-white mt-8">
                    <button type="button" onclick="closeDrawer()"
                        class="text-brand-secondary font-medium hover:text-brand-primary">Cancel</button>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Payment Method
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Overlay -->
    <div id="drawer-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"
        onclick="closeDrawer()"></div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal"
        class="fixed inset-0 bg-black bg-opacity-50 z-[70] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-scale-in">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                    <i class="fa-solid fa-trash-can text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-brand-primary text-center mb-2">Delete Payment Method</h3>
                <p class="text-gray-600 text-center mb-6">
                    Are you sure you want to delete <span id="delete-payment-method-name"
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
@endsection

@push('head')
    <style>
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

        .drawer-open {
            transform: translateX(0);
        }

        .drawer-closed {
            transform: translateX(100%);
        }
    </style>
@endpush

@push('scripts')
    <script>
        let supportedCountries = [];
        let deletePaymentMethodId = null;

        function toggleFilters() {
            const filterPanel = document.getElementById('filter-panel');
            const filterArrow = document.getElementById('filter-arrow');
            filterPanel.classList.toggle('hidden');
            filterArrow.style.transform = filterPanel.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        function clearAllFilters() {
            window.location.href = '{{ route('admin.masters.payment-method-master') }}';
        }

        function clearSearchFilter() {
            const params = new URLSearchParams(window.location.search);
            params.delete('search');
            window.location.href = `?${params.toString()}`;
        }

        function clearCategoryFilter() {
            const params = new URLSearchParams(window.location.search);
            params.delete('category');
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

        function openDrawer() {
            const overlay = document.getElementById('drawer-overlay');
            overlay.classList.remove('hidden');

            setTimeout(() => {
                resetForm();
                document.getElementById('drawer-title').textContent = 'Add Payment Method';
                document.getElementById('payment-method-form').dataset.mode = 'create';
                document.getElementById('payment-method-drawer').classList.remove('drawer-closed');
                document.getElementById('payment-method-drawer').classList.add('drawer-open');
            }, 10);
        }

        function closeDrawer() {
            document.getElementById('payment-method-drawer').classList.remove('drawer-open');
            document.getElementById('payment-method-drawer').classList.add('drawer-closed');

            setTimeout(() => {
                document.getElementById('drawer-overlay').classList.add('hidden');
                resetForm();
            }, 300);
        }

        function resetForm() {
            document.getElementById('payment-method-form').reset();
            supportedCountries = [];
            document.getElementById('countries-container').innerHTML =
                '<input type="text" id="country-input" placeholder="Add country..." class="flex-1 min-w-[120px] border-0 outline-none text-sm bg-transparent" onkeypress="handleCountryInput(event)">';

            // Reset all toggles
            ['supports_3ds', 'allows_tokenization', 'requires_additional_documents', 'requires_acquirer_configuration']
            .forEach(field => {
                document.getElementById(field + '-toggle').classList.add('inactive');
                document.getElementById(field).value = '0';
            });
            document.getElementById('is_active-toggle').classList.remove('inactive');
            document.getElementById('is_active').value = '1';

            // Reset acquirers
            document.querySelectorAll('.acquirer-checkbox').forEach(cb => {
                cb.checked = false;
                const acquirerId = cb.value;
                document.querySelector(`[data-acquirer-id="${acquirerId}"].acquirer-types`).style.display = 'none';
            });
            document.querySelectorAll('.acquirer-type-checkbox').forEach(cb => cb.checked = false);

            // Reset solutions
            document.querySelectorAll('.solution-checkbox').forEach(cb => cb.checked = false);
        }

        function toggleField(fieldName) {
            const toggle = document.getElementById(fieldName + '-toggle');
            const input = document.getElementById(fieldName);

            if (toggle.classList.contains('inactive')) {
                toggle.classList.remove('inactive');
                input.value = '1';
            } else {
                toggle.classList.add('inactive');
                input.value = '0';
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

        function createCountryInput() {
            const input = document.createElement('input');
            input.type = 'text';
            input.id = 'country-input';
            input.placeholder = 'Add country...';
            input.className = 'flex-1 min-w-[120px] border-0 outline-none text-sm bg-transparent';
            input.onkeypress = function(e) {
                handleCountryInput(e);
            };
            return input;
        }

        function toggleAcquirerTypes(checkbox) {
            const acquirerId = checkbox.value;
            const typesContainer = document.querySelector(`[data-acquirer-id="${acquirerId}"].acquirer-types`);

            if (checkbox.checked) {
                typesContainer.style.display = 'flex';
            } else {
                typesContainer.style.display = 'none';
                // Uncheck all type checkboxes
                typesContainer.querySelectorAll('.acquirer-type-checkbox').forEach(cb => cb.checked = false);
            }
            updateSupportedAcquirers();
        }

        function updateSupportedAcquirers() {
            const supportedAcquirers = [];

            document.querySelectorAll('.acquirer-checkbox:checked').forEach(checkbox => {
                const acquirerId = parseInt(checkbox.value);
                const acquirerName = checkbox.dataset.name;
                const types = [];

                document.querySelectorAll(`.acquirer-type-checkbox[data-acquirer-id="${acquirerId}"]:checked`)
                    .forEach(typeCheckbox => {
                        types.push(typeCheckbox.value);
                    });

                supportedAcquirers.push({
                    id: acquirerId,
                    name: acquirerName,
                    types: types
                });
            });

            document.getElementById('supported_acquirers').value = JSON.stringify(supportedAcquirers);
        }

        // Update acquirers when type checkboxes change
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.acquirer-type-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSupportedAcquirers);
            });
        });

        function editPaymentMethod(id) {
            const overlay = document.getElementById('drawer-overlay');
            overlay.classList.remove('hidden');

            fetch(`{{ url('admin/masters/payment-methods') }}/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setTimeout(() => {
                            populateForm(data.data);
                            document.getElementById('drawer-title').textContent = 'Edit Payment Method';
                            document.getElementById('payment-method-form').dataset.mode = 'edit';
                            document.getElementById('payment-method-form').dataset.id = id;
                            document.getElementById('payment-method-drawer').classList.remove('drawer-closed');
                            document.getElementById('payment-method-drawer').classList.add('drawer-open');
                        }, 10);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading payment method', 'error');
                    overlay.classList.add('hidden');
                });
        }

        function populateForm(method) {
            document.getElementById('name').value = method.name;
            document.getElementById('display_label').value = method.display_label;
            document.getElementById('category').value = method.category;
            document.getElementById('description').value = method.description || '';
            document.getElementById('scheme').value = method.scheme || '';
            document.getElementById('notes').value = method.notes || '';

            // Set toggles
            setToggleState('supports_3ds', method.supports_3ds);
            setToggleState('allows_tokenization', method.allows_tokenization);
            setToggleState('is_active', method.is_active);
            setToggleState('requires_additional_documents', method.requires_additional_documents);
            setToggleState('requires_acquirer_configuration', method.requires_acquirer_configuration);

            // Set countries
            supportedCountries = method.supported_countries || [];
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

            // Set acquirers
            const supportedAcquirers = method.supported_acquirers || [];
            document.querySelectorAll('.acquirer-checkbox').forEach(checkbox => {
                const acquirerId = parseInt(checkbox.value);
                const acquirer = supportedAcquirers.find(a => a.id === acquirerId);

                if (acquirer) {
                    checkbox.checked = true;
                    const typesContainer = document.querySelector(
                        `[data-acquirer-id="${acquirerId}"].acquirer-types`);
                    typesContainer.style.display = 'flex';

                    acquirer.types.forEach(type => {
                        const typeCheckbox = document.querySelector(
                            `.acquirer-type-checkbox[data-acquirer-id="${acquirerId}"][value="${type}"]`
                            );
                        if (typeCheckbox) {
                            typeCheckbox.checked = true;
                        }
                    });
                }
            });
            document.getElementById('supported_acquirers').value = JSON.stringify(supportedAcquirers);

            // Set solutions
            const solutionIds = method.supported_solutions || [];
            document.querySelectorAll('.solution-checkbox').forEach(checkbox => {
                checkbox.checked = solutionIds.includes(parseInt(checkbox.value));
            });
        }

        function setToggleState(fieldName, value) {
            const toggle = document.getElementById(fieldName + '-toggle');
            const input = document.getElementById(fieldName);

            if (value) {
                toggle.classList.remove('inactive');
                input.value = '1';
            } else {
                toggle.classList.add('inactive');
                input.value = '0';
            }
        }

        function deletePaymentMethod(id, name) {
            deletePaymentMethodId = id;
            document.getElementById('delete-payment-method-name').textContent = name;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            deletePaymentMethodId = null;
        }

        function confirmDelete() {
            if (!deletePaymentMethodId) return;

            fetch(`{{ url('admin/masters/payment-methods') }}/${deletePaymentMethodId}`, {
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
                        showNotification('Payment method deleted successfully', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        closeDeleteModal();
                        showNotification(data.message || 'Error deleting payment method', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    closeDeleteModal();
                    showNotification('Error deleting payment method', 'error');
                });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className =
                `fixed top-4 right-4 px-4 py-3 rounded-lg text-white max-w-md z-[100] ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.style.whiteSpace = 'pre-wrap';
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), type === 'success' ? 3000 : 5000);
        }

        // Form submission
        document.getElementById('payment-method-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const mode = this.dataset.mode;
            const id = this.dataset.id;
            const formData = new FormData(this);

            // Prepare solutions
            const solutions = Array.from(document.querySelectorAll('.solution-checkbox:checked')).map(c => parseInt(
                c.value));
            formData.set('supported_solutions', JSON.stringify(solutions));

            // Acquirers are already set by updateSupportedAcquirers

            let url;
            let method = 'POST';

            if (mode === 'create') {
                url = '{{ url('admin/masters/payment-methods') }}';
            } else {
                url = `{{ url('admin/masters/payment-methods') }}/${id}`;
                formData.append('_method', 'PUT');
            }

            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ||
                '{{ csrf_token() }}');

            fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const successMessage = data.message || 'Payment method saved successfully';
                        window.location.href =
                            `{{ route('admin.masters.payment-method-master') }}?success=${encodeURIComponent(successMessage)}`;
                    } else {
                        if (data.errors) {
                            let errorMsg = 'Validation errors:\n';
                            for (let field in data.errors) {
                                errorMsg += `${field}: ${data.errors[field].join(', ')}\n`;
                            }
                            showNotification(errorMsg, 'error');
                        } else {
                            showNotification(data.message || 'Error saving payment method', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error saving payment method: ' + error.message, 'error');
                });
        });

        // Add CSRF token to meta
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.setAttribute('name', 'csrf-token');
            meta.setAttribute('content', '{{ csrf_token() }}');
            document.head.appendChild(meta);
        }
    </script>
@endpush
