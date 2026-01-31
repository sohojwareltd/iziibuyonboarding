@extends('layouts.admin')

@section('title', 'Price List Master - 2iZii')

@push('head')
    <style>
        /* Drawer animations */
        #price-list-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            max-width: 600px;
            height: 100vh;
            background: white;
            z-index: 50;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        }

        #price-list-drawer.drawer-open {
            transform: translateX(0) !important;
        }

        #price-list-drawer.drawer-closed {
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
            ['label' => 'Masters', 'url' => '#'],
            ['label' => 'Price List Master', 'url' => route('admin.masters.price-list-master')],
        ]"   />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral">
            <div class="p-8">
            
                <!-- Page Content -->
                <div class="bg-brand-neutral p-8">
                    <div class="max-w-[1280px] mx-auto">
                        <!-- Page Title and Add Button -->
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h1 class="text-2xl font-semibold text-brand-primary mb-1">Price List Master</h1>
                                <p class="text-sm text-gray-500">Manage global pricing strategies, commissions, and fees.</p>
                            </div>
                            <button onclick="openDrawer()" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Price List</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-4">
                            <form method="GET" action="{{ route('admin.masters.price-list-master') }}" class="space-y-4">
                                <!-- Search Bar and Filter Button -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                                    <div class="relative flex-1 max-w-[384px]">
                                        <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                        <input type="text" name="search" placeholder="Search price lists..."
                                            value="{{ request('search') }}"
                                            class="form-input pl-10 bg-white border-gray-200 focus:bg-white w-full">
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="toggleFilters()"
                                            class="bg-white border-2 border-gray-200 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-semibold hover:border-orange-300 hover:text-brand-accent transition-all flex items-center gap-2 whitespace-nowrap">
                                            <i class="fa-solid fa-filter text-sm"></i>
                                            <span>Advanced Filters</span>
                                            <i id="filter-arrow" class="fa-solid fa-chevron-down text-xs transition-transform"></i>
                                        </button>
                                        <a href="{{ route('admin.masters.price-list-master.export', request()->query()) }}"
                                            class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                            <i class="fa-solid fa-download text-sm"></i>
                                            Export
                                        </a>
                                    </div>
                                </div>

                                <!-- Active Filters Display -->
                                @if (request()->has('search') || request()->has('type') || request()->has('status') || request()->has('currency') || request()->has('assignment_level'))
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
                                        @if (request('type'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-layer-group text-xs"></i>
                                                <span>Type: {{ str_replace('-', ' ', ucwords(request('type'), '-')) }}</span>
                                                <button type="button" onclick="clearTypeFilter()">
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
                                        @if (request('currency'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-coins text-xs"></i>
                                                <span>Currency: {{ request('currency') }}</span>
                                                <button type="button" onclick="clearCurrencyFilter()">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (request('assignment_level'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-sitemap text-xs"></i>
                                                <span>Scope: {{ ucfirst(request('assignment_level')) }}</span>
                                                <button type="button" onclick="clearAssignmentFilter()">
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
                                        <!-- Type Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-layer-group"></i>
                                                Type
                                            </label>
                                            <select name="type"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Types</option>
                                                <option value="merchant-selling" {{ request('type') == 'merchant-selling' ? 'selected' : '' }}>
                                                    Merchant Selling</option>
                                                <option value="acquirer-cost" {{ request('type') == 'acquirer-cost' ? 'selected' : '' }}>
                                                    Acquirer Cost</option>
                                                <option value="partner-kickback" {{ request('type') == 'partner-kickback' ? 'selected' : '' }}>
                                                    Partner Kickback</option>
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
                                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                                                    Draft</option>
                                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>

                                        <!-- Currency Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-coins"></i>
                                                Currency
                                            </label>
                                            <select name="currency"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Currencies</option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency }}" {{ request('currency') == $currency ? 'selected' : '' }}>
                                                        {{ $currency }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Scope Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-sitemap"></i>
                                                Scope
                                            </label>
                                            <select name="assignment_level"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Scopes</option>
                                                <option value="global" {{ request('assignment_level') == 'global' ? 'selected' : '' }}>
                                                    Global</option>
                                                <option value="country" {{ request('assignment_level') == 'country' ? 'selected' : '' }}>
                                                    Country</option>
                                                <option value="solution" {{ request('assignment_level') == 'solution' ? 'selected' : '' }}>
                                                    Solution</option>
                                                <option value="acquirer" {{ request('assignment_level') == 'acquirer' ? 'selected' : '' }}>
                                                    Acquirer</option>
                                                <option value="merchant" {{ request('assignment_level') == 'merchant' ? 'selected' : '' }}>
                                                    Merchant</option>
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
                                <thead class="bg-[#f5f6fa]">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider flex items-center gap-1">
                                            Price List Name
                                            <i class="fa-solid fa-chevron-up text-[10px]"></i>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Scope</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Effective Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-[#ececec]">
                                    @forelse($priceLists as $priceList)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">{{ $priceList->name }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5">{{ $priceList->currency }} • Version {{ $priceList->version }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#eff6ff] text-[#1d4ed8] px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                {{ str_replace('-', ' ', ucwords($priceList->type, '-')) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] text-[#475569] px-2 py-0.5 rounded text-xs font-medium flex items-center gap-1 w-fit">
                                                @if($priceList->assignment_level === 'global')
                                                    <i class="fa-solid fa-globe text-[10px]"></i>
                                                @elseif($priceList->assignment_level === 'country')
                                                    <i class="fa-solid fa-flag text-[10px]"></i>
                                                @elseif($priceList->assignment_level === 'solution')
                                                    <i class="fa-solid fa-cube text-[10px]"></i>
                                                @elseif($priceList->assignment_level === 'acquirer')
                                                    <i class="fa-solid fa-building text-[10px]"></i>
                                                @else
                                                    <i class="fa-solid fa-store text-[10px]"></i>
                                                @endif
                                                {{ ucfirst($priceList->assignment_level) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">
                                                <div>From: <span class="font-medium text-gray-900">{{ optional($priceList->effective_from)->format('M d, Y') ?? '—' }}</span></div>
                                                <div class="text-xs text-gray-400 mt-0.5">To: {{ optional($priceList->effective_to)->format('M d, Y') ?? 'Indefinite' }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="@if($priceList->status === 'active') bg-[#f0fdf4] border border-[#dcfce7] text-[#28a745] @elseif($priceList->status === 'draft') bg-[#fff7ed] border border-[#fed7aa] text-[#ea580c] @else bg-[#ececec] border border-[#d1d5db] text-[#64748b] @endif px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                {{ ucfirst($priceList->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button onclick="editPriceList({{ $priceList->id }})" class="text-gray-400 hover:text-brand-primary p-2">
                                                    <i class="fa-solid fa-pen text-sm"></i> Edit
                                                </button>
                                                <button onclick="deletePriceList({{ $priceList->id }}, '{{ $priceList->name }}')" class="text-gray-400 hover:text-red-500 p-2">
                                                    <i class="fa-solid fa-trash text-sm"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <p class="text-sm">No price lists found. Create one to get started.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="bg-white border-t border-gray-200 px-4 py-4 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium text-gray-900">{{ ($priceLists->currentPage() - 1) * $priceLists->perPage() + 1 }}</span> to <span class="font-medium text-gray-900">{{ min($priceLists->currentPage() * $priceLists->perPage(), $priceLists->total()) }}</span> of <span class="font-medium text-gray-900">{{ $priceLists->total() }}</span> results
                                </div>
                                <div class="flex items-center gap-2">
                                    {{ $priceLists->links('pagination::tailwind') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit Price List -->
        <div id="price-list-drawer" class="drawer-closed overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-brand-primary" id="drawer-title">Add Price List</h2>
                    <button onclick="closeDrawer()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <form id="price-list-form" class="flex-1 overflow-y-auto bg-[#f7f8fa] p-6 flex flex-col">
                    <input type="hidden" id="assignment_level" name="assignment_level" value="global">
                    <input type="hidden" id="assignment_rules" name="assignment_rules" value="[]">
                    <input type="hidden" id="price_lines" name="price_lines" value="[]">
                    <input type="hidden" id="version" name="version" value="1.0">
                    <input type="hidden" id="effective_from" name="effective_from" value="">
                    <input type="hidden" id="effective_to" name="effective_to" value="">

                    <div class="space-y-8 flex-1">
                        <!-- Section 1: Price List Information -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-[#eff6ff] w-8 h-8 rounded-full flex items-center justify-center">
                                    <span class="text-[#4055a8] text-sm font-semibold">1</span>
                                </div>
                                <h3 class="text-base font-medium text-gray-900">Price List Information</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">
                                        Price List Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" class="form-input" placeholder="e.g. Standard Merchant Pricing 2025" required>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">
                                            Type <span class="text-red-500">*</span>
                                        </label>
                                        <select id="type" name="type" class="form-input" required>
                                            <option value="">Select type</option>
                                            <option value="merchant-selling">Merchant Selling Price</option>
                                            <option value="acquirer-cost">Acquirer Cost</option>
                                            <option value="partner-kickback">Partner Kickback</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">
                                            Currency <span class="text-red-500">*</span>
                                        </label>
                                        <select id="currency" name="currency" class="form-input" required>
                                            <option value="">Select currency</option>
                                            <option value="EUR">EUR - Euro</option>
                                            <option value="USD">USD - US Dollar</option>
                                            <option value="GBP">GBP - British Pound</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">Status</label>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="status" value="active" checked class="w-4 h-4 border-[#0075ff] text-[#0075ff] focus:ring-[#0075ff]">
                                            <span class="text-sm text-gray-700">Active</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="status" value="draft" class="w-4 h-4 border-gray-400 text-gray-400 focus:ring-gray-400">
                                            <span class="text-sm text-gray-700">Draft</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="status" value="inactive" class="w-4 h-4 border-gray-400 text-gray-400 focus:ring-gray-400">
                                            <span class="text-sm text-gray-700">Inactive</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Scope / Assignment Rules -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-[#eff6ff] w-8 h-8 rounded-full flex items-center justify-center">
                                    <span class="text-[#4055a8] text-sm font-semibold">2</span>
                                </div>
                                <h3 class="text-base font-medium text-gray-900">Scope / Assignment Rules</h3>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">
                                    Assignment Level <span class="text-red-500">*</span>
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" class="assignment-level-btn active" onclick="setAssignmentLevel(this, 'global')">
                                        <i class="fa-solid fa-globe text-xs"></i>
                                        Global
                                    </button>
                                    <button type="button" class="assignment-level-btn" onclick="setAssignmentLevel(this, 'country')">
                                        <i class="fa-solid fa-flag text-xs"></i>
                                        Per Country
                                    </button>
                                    <button type="button" class="assignment-level-btn" onclick="setAssignmentLevel(this, 'solution')">
                                        <i class="fa-solid fa-cube text-xs"></i>
                                        Per Solution
                                    </button>
                                    <button type="button" class="assignment-level-btn" onclick="setAssignmentLevel(this, 'acquirer')">
                                        <i class="fa-solid fa-building text-xs"></i>
                                        Per Acquirer
                                    </button>
                                    <button type="button" class="assignment-level-btn" onclick="setAssignmentLevel(this, 'merchant')">
                                        <i class="fa-solid fa-store text-xs"></i>
                                        Per Merchant
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Price List Lines -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-[#eff6ff] w-8 h-8 rounded-full flex items-center justify-center">
                                        <span class="text-[#4055a8] text-sm font-semibold">3</span>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-900">Price List Lines</h3>
                                </div>
                                <button type="button" onclick="addPriceLine()" class="text-[#4055a8] text-xs font-medium flex items-center gap-1 hover:text-[#2d3a74]">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                    Add Line
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-[#f7f8fa] border-b border-gray-200">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Payment Method</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">% Fee</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Fixed Fee</th>
                                            <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase w-6"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="price-lines-tbody">
                                        <tr class="border-b border-[#ececec]">
                                            <td class="px-3 py-2">
                                                <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5 price-line-method">
                                                    <option>Visa Credit</option>
                                                    <option>Mastercard</option>
                                                    <option>Amex</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2">
                                                <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5 price-line-type">
                                                    <option>Card Present</option>
                                                    <option>Card Not Present</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" class="form-input text-sm py-1.5 price-line-percent" placeholder="2.50" value="2.50">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" class="form-input text-sm py-1.5 price-line-fixed" placeholder="0.25" value="0.25">
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <button type="button" onclick="removePriceLine(this)" class="text-gray-400 hover:text-red-500">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section 4: Versioning & Control -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-[#eff6ff] w-8 h-8 rounded-full flex items-center justify-center">
                                    <span class="text-[#4055a8] text-sm font-semibold">4</span>
                                </div>
                                <h3 class="text-base font-medium text-gray-900">Versioning & Control</h3>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-[#64748b] mb-1">Version Number</label>
                                    <input type="text" class="form-input bg-[#f7f8fa] border-gray-200" value="1.0" disabled>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-[#64748b] mb-1">Created On</label>
                                    <input type="text" class="form-input bg-[#f7f8fa] border-gray-200" value="{{ now()->format('M d, Y') }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button type="button" onclick="closeDrawer()" class="text-[#4055a8] font-medium hover:text-[#2d3a74]">Cancel</button>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Price List
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[70] hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                        <i class="fa-solid fa-trash-can text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-primary text-center mb-2">Delete Price List</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Are you sure you want to delete <span id="delete-price-list-name" class="font-semibold text-brand-primary"></span>? This action cannot be undone.
                    </p>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="button" onclick="confirmDelete()" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors shadow-sm">
                            <i class="fa-solid fa-trash-can mr-2"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300" onclick="closeDrawer()"></div>
@endsection

@push('scripts')
    <script>
        let deletePriceListId = null;

        function toggleFilters() {
            const filterPanel = document.getElementById('filter-panel');
            const filterArrow = document.getElementById('filter-arrow');
            filterPanel.classList.toggle('hidden');
            filterArrow.style.transform = filterPanel.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        function clearAllFilters() {
            window.location.href = '{{ route('admin.masters.price-list-master') }}';
        }

        function clearSearchFilter() {
            const params = new URLSearchParams(window.location.search);
            params.delete('search');
            window.location.href = `?${params.toString()}`;
        }

        function clearTypeFilter() {
            const params = new URLSearchParams(window.location.search);
            params.delete('type');
            window.location.href = `?${params.toString()}`;
        }

        function clearStatusFilter() {
            const params = new URLSearchParams(window.location.search);
            params.delete('status');
            window.location.href = `?${params.toString()}`;
        }

        function clearCurrencyFilter() {
            const params = new URLSearchParams(window.location.search);
            params.delete('currency');
            window.location.href = `?${params.toString()}`;
        }

        function clearAssignmentFilter() {
            const params = new URLSearchParams(window.location.search);
            params.delete('assignment_level');
            window.location.href = `?${params.toString()}`;
        }

        function openDrawer() {
            const overlay = document.getElementById('drawer-overlay');
            overlay.classList.remove('hidden');
            
            setTimeout(() => {
                resetForm();
                document.getElementById('drawer-title').textContent = 'Add Price List';
                document.getElementById('price-list-form').dataset.mode = 'create';
                document.getElementById('price-list-drawer').classList.remove('drawer-closed');
                document.getElementById('price-list-drawer').classList.add('drawer-open');
            }, 10);
        }

        function closeDrawer() {
            document.getElementById('price-list-drawer').classList.remove('drawer-open');
            document.getElementById('price-list-drawer').classList.add('drawer-closed');
            
            setTimeout(() => {
                document.getElementById('drawer-overlay').classList.add('hidden');
                resetForm();
            }, 300);
        }

        function resetForm() {
            document.getElementById('price-list-form').reset();
            document.getElementById('assignment_level').value = 'global';
            document.getElementById('assignment_rules').value = '[]';
            document.getElementById('price_lines').value = '[]';
            document.getElementById('version').value = '1.0';
            document.getElementById('effective_from').value = '';
            document.getElementById('effective_to').value = '';

            document.querySelectorAll('.assignment-level-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector('.assignment-level-btn')?.classList.add('active');

            const tbody = document.getElementById('price-lines-tbody');
            tbody.innerHTML = '';
            addPriceLine();
        }

        function setAssignmentLevel(button, level) {
            document.querySelectorAll('.assignment-level-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
            document.getElementById('assignment_level').value = level;
        }

        function addPriceLine() {
            const tbody = document.getElementById('price-lines-tbody');
            const newRow = document.createElement('tr');
            newRow.className = 'border-b border-[#ececec]';
            newRow.innerHTML = `
                <td class="px-3 py-2">
                    <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5 price-line-method">
                        <option>Visa Credit</option>
                        <option>Mastercard</option>
                        <option>Amex</option>
                    </select>
                </td>
                <td class="px-3 py-2">
                    <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5 price-line-type">
                        <option>Card Present</option>
                        <option>Card Not Present</option>
                    </select>
                </td>
                <td class="px-3 py-2">
                    <input type="text" class="form-input text-sm py-1.5 price-line-percent" placeholder="0.00">
                </td>
                <td class="px-3 py-2">
                    <input type="text" class="form-input text-sm py-1.5 price-line-fixed" placeholder="0.00">
                </td>
                <td class="px-3 py-2 text-center">
                    <button type="button" onclick="removePriceLine(this)" class="text-gray-400 hover:text-red-500">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
        }

        function removePriceLine(button) {
            button.closest('tr').remove();
        }

        function collectPriceLines() {
            const rows = document.querySelectorAll('#price-lines-tbody tr');
            const lines = [];
            rows.forEach(row => {
                const method = row.querySelector('.price-line-method')?.value || '';
                const lineType = row.querySelector('.price-line-type')?.value || '';
                const percentFee = row.querySelector('.price-line-percent')?.value || '';
                const fixedFee = row.querySelector('.price-line-fixed')?.value || '';

                if (method || lineType || percentFee || fixedFee) {
                    lines.push({
                        payment_method: method,
                        line_type: lineType,
                        percent_fee: percentFee === '' ? null : parseFloat(percentFee),
                        fixed_fee: fixedFee === '' ? null : parseFloat(fixedFee),
                    });
                }
            });
            return lines;
        }

        function editPriceList(id) {
            const overlay = document.getElementById('drawer-overlay');
            overlay.classList.remove('hidden');
            
            fetch(`{{ url('admin/masters/price-lists') }}/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setTimeout(() => {
                            populateForm(data.data);
                            document.getElementById('drawer-title').textContent = 'Edit Price List';
                            document.getElementById('price-list-form').dataset.mode = 'edit';
                            document.getElementById('price-list-form').dataset.id = id;
                            document.getElementById('price-list-drawer').classList.remove('drawer-closed');
                            document.getElementById('price-list-drawer').classList.add('drawer-open');
                        }, 10);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading price list', 'error');
                    overlay.classList.add('hidden');
                });
        }

        function populateForm(data) {
            document.getElementById('name').value = data.name || '';
            document.getElementById('type').value = data.type || '';
            document.getElementById('currency').value = data.currency || '';
            document.querySelectorAll('input[name="status"]').forEach(radio => {
                radio.checked = radio.value === (data.status || 'active');
            });

            document.getElementById('assignment_level').value = data.assignment_level || 'global';
            document.querySelectorAll('.assignment-level-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.assignment-level-btn[onclick*="'${data.assignment_level || 'global'}'"]`)?.classList.add('active');

            document.getElementById('assignment_rules').value = JSON.stringify(data.assignment_rules || []);
            document.getElementById('version').value = data.version || '1.0';
            document.getElementById('effective_from').value = data.effective_from || '';
            document.getElementById('effective_to').value = data.effective_to || '';

            const tbody = document.getElementById('price-lines-tbody');
            tbody.innerHTML = '';
            const lines = data.price_lines || [];
            if (lines.length === 0) {
                addPriceLine();
            } else {
                lines.forEach(line => {
                    addPriceLine();
                    const row = tbody.lastElementChild;
                    row.querySelector('.price-line-method').value = line.payment_method || '';
                    row.querySelector('.price-line-type').value = line.line_type || '';
                    row.querySelector('.price-line-percent').value = line.percent_fee ?? '';
                    row.querySelector('.price-line-fixed').value = line.fixed_fee ?? '';
                });
            }
        }

        function deletePriceList(id, name) {
            deletePriceListId = id;
            document.getElementById('delete-price-list-name').textContent = name;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            deletePriceListId = null;
        }

        function confirmDelete() {
            if (!deletePriceListId) return;

            fetch(`{{ url('admin/masters/price-lists') }}/${deletePriceListId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteModal();
                    showNotification('Price list deleted successfully', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    closeDeleteModal();
                    showNotification(data.message || 'Error deleting price list', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                closeDeleteModal();
                showNotification('Error deleting price list', 'error');
            });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-3 rounded-lg text-white max-w-md z-[100] ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.style.whiteSpace = 'pre-wrap';
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), type === 'success' ? 3000 : 5000);
        }

        document.getElementById('price-list-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const mode = this.dataset.mode;
            const id = this.dataset.id;
            const formData = new FormData(this);

            const priceLines = collectPriceLines();
            formData.set('price_lines', JSON.stringify(priceLines));

            let url;
            let method = 'POST';

            if (mode === 'create') {
                url = '{{ url("admin/masters/price-lists") }}';
            } else {
                url = `{{ url('admin/masters/price-lists') }}/${id}`;
                formData.append('_method', 'PUT');
            }

            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');

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
                        showNotification(data.message || 'Error saving price list', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error saving price list: ' + error.message, 'error');
            });
        });

        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.setAttribute('name', 'csrf-token');
            meta.setAttribute('content', '{{ csrf_token() }}');
            document.head.appendChild(meta);
        }
    </script>
@endpush
