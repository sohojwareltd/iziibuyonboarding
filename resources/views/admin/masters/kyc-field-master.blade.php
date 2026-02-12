@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Field Master - 2iZii</title>
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
                        mono: ['Liberation Mono', 'monospace'],
                    }
                }
            }
        }
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        ::-webkit-scrollbar-track { background: transparent; }
        .nav-item-active {
            background: rgba(255,255,255,0.15);
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
            background: rgba(255,255,255,0.15);
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
            padding: 0.625rem 0.75rem;
            color: #2D3A74;
            outline: none;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        .form-input:focus {
            border-color: #2D3A74;
            box-shadow: 0 0 0 1px #2D3A74;
        }
        .form-input-prefix {
            background-color: #F9FAFB;
            border: 1px solid #D1D5DB;
            border-right: none;
            border-radius: 0.375rem 0 0 0.375rem;
            padding: 0.625rem 0.75rem;
            color: #6B7280;
            font-size: 0.875rem;
        }
        .form-input-with-prefix {
            border-radius: 0 0.375rem 0.375rem 0;
        }
        .toggle-switch {
            position: relative;
            width: 48px;
            height: 24px;
            background-color: #D1D5DB;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            background-color: white;
            border: 4px solid #D1D5DB;
            border-radius: 50%;
            top: 0;
            left: 0;
            transition: left 0.2s, border-color 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .toggle-switch.active {
            background-color: #2D3A74;
        }
        .toggle-switch.active::after {
            left: 24px;
            border-color: #2D3A74;
        }
        .section-number {
            width: 24px;
            height: 24px;
            background-color: #EFF6FF;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2D3A74;
            font-size: 12px;
            font-weight: 600;
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
@endsection

@section('body')
    <body class="bg-brand-neutral">

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'KYC Field Master', 'url' => route('admin.masters.kyc-field-master')],
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
                                <h1 class="text-2xl font-semibold text-brand-primary mb-1">KYC Field Master</h1>
                                <p class="text-sm text-gray-500">Manage and configure KYC data fields for merchant onboarding.</p>
                            </div>
                            <button onclick="openDrawer()" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2 self-start md:self-auto">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add KYC Field</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-4">
                            <form method="GET" action="{{ route('admin.masters.kyc-field-master') }}" class="space-y-4">
                                <!-- Search Bar and Filter Button -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                                    <div class="relative flex-1 max-w-[384px]">
                                        <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                        <input type="text" name="search" placeholder="Search KYC fields..."
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
                                        <a href="{{ route('admin.masters.kyc-field-master.export', request()->query()) }}"
                                            class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                            <i class="fa-solid fa-download text-sm"></i>
                                            Export
                                        </a>
                                    </div>
                                </div>

                                <!-- Active Filters Display -->
                                @if (request()->has('search') || request()->has('kyc_section') || request()->has('data_type') || request()->has('sensitivity_level') || request()->has('status'))
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
                                        @if (request('kyc_section'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-layer-group text-xs"></i>
                                                <span>Section: {{ $kycSections->firstWhere('id', request('kyc_section'))->name ?? request('kyc_section') }}</span>
                                                <button type="button" onclick="clearSectionFilter()">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (request('data_type'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-code text-xs"></i>
                                                <span>Type: {{ ucfirst(request('data_type')) }}</span>
                                                <button type="button" onclick="clearDataTypeFilter()">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </div>
                                        @endif
                                        @if (request('sensitivity_level'))
                                            <div class="filter-badge">
                                                <i class="fa-solid fa-shield-halved text-xs"></i>
                                                <span>Sensitivity: {{ ucfirst(str_replace('-', ' ', request('sensitivity_level'))) }}</span>
                                                <button type="button" onclick="clearSensitivityFilter()">
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
                                    </div>
                                @endif

                                <!-- Filter Panel -->
                                <div id="filter-panel"
                                    class="hidden bg-gradient-to-b from-[#fafbfc] to-white rounded-lg border border-gray-100 p-4">
                                    <div class="flex flex-col sm:flex-row items-end gap-3">
                                        <!-- Section Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-layer-group"></i>
                                                Section
                                            </label>
                                            <select name="kyc_section"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Sections</option>
                                                @foreach ($kycSections as $section)
                                                    <option value="{{ $section->id }}" {{ request('kyc_section') == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Data Type Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-code"></i>
                                                Data Type
                                            </label>
                                            <select name="data_type"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Types</option>
                                                <option value="text" {{ request('data_type') == 'text' ? 'selected' : '' }}>Text</option>
                                                <option value="date" {{ request('data_type') == 'date' ? 'selected' : '' }}>Date</option>
                                                <option value="number" {{ request('data_type') == 'number' ? 'selected' : '' }}>Number</option>
                                                <option value="email" {{ request('data_type') == 'email' ? 'selected' : '' }}>Email</option>
                                                <option value="tel" {{ request('data_type') == 'tel' ? 'selected' : '' }}>Phone</option>
                                                <option value="url" {{ request('data_type') == 'url' ? 'selected' : '' }}>URL</option>
                                                <option value="password" {{ request('data_type') == 'password' ? 'selected' : '' }}>Password</option>
                                                <option value="time" {{ request('data_type') == 'time' ? 'selected' : '' }}>Time</option>
                                                <option value="datetime-local" {{ request('data_type') == 'datetime-local' ? 'selected' : '' }}>Date & Time</option>
                                                <option value="file" {{ request('data_type') == 'file' ? 'selected' : '' }}>File Upload</option>
                                                <option value="dropdown" {{ request('data_type') == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                                <option value="multi-select" {{ request('data_type') == 'multi-select' ? 'selected' : '' }}>Multi-Select</option>
                                                <option value="checkbox" {{ request('data_type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                <option value="radio" {{ request('data_type') == 'radio' ? 'selected' : '' }}>Radio</option>
                                                <option value="textarea" {{ request('data_type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                                <option value="country" {{ request('data_type') == 'country' ? 'selected' : '' }}>Country</option>
                                                <option value="currency" {{ request('data_type') == 'currency' ? 'selected' : '' }}>Currency</option>
                                                <option value="address" {{ request('data_type') == 'address' ? 'selected' : '' }}>Address</option>
                                                <option value="signature" {{ request('data_type') == 'signature' ? 'selected' : '' }}>Signature</option>
                                            </select>
                                        </div>

                                        <!-- Sensitivity Filter -->
                                        <div class="filter-group flex-1 w-full sm:w-auto">
                                            <label>
                                                <i class="fa-solid fa-shield-halved"></i>
                                                Sensitivity
                                            </label>
                                            <select name="sensitivity_level"
                                                class="form-input text-sm bg-white border-2 border-gray-100 focus:border-orange-400 w-full">
                                                <option value="">All Levels</option>
                                                <option value="normal" {{ request('sensitivity_level') == 'normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="sensitive" {{ request('sensitivity_level') == 'sensitive' ? 'selected' : '' }}>Sensitive</option>
                                                <option value="highly-sensitive" {{ request('sensitivity_level') == 'highly-sensitive' ? 'selected' : '' }}>Highly Sensitive</option>
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
                                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100 min-w-[900px]">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            <div class="flex items-center gap-1">
                                                <span>Field Name</span>
                                                <i class="fa-solid fa-chevron-up text-[10px] text-gray-400"></i>
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">Internal Key</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">Data Type</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            <div class="leading-tight">
                                                <div>KYC</div>
                                                <div>Section</div>
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">Sensitivity</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">Visibility</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($kycFields as $field)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">{{ $field->field_name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-xs text-gray-600">{{ $field->internal_key }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-900 px-2.5 py-1 rounded-full text-xs font-medium capitalize">{{ $field->data_type }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-700 text-sm">{{ $field->kycSection->name ?? '—' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($field->sensitivity_level === 'highly-sensitive')
                                                <div class="flex items-center gap-1">
                                                    <i class="fa-solid fa-lock text-red-600 text-xs"></i>
                                                    <span class="text-red-600 text-xs font-medium">Highly Sensitive</span>
                                                </div>
                                            @elseif($field->sensitivity_level === 'sensitive')
                                                <div class="flex items-center gap-1">
                                                    <i class="fa-solid fa-triangle-exclamation text-yellow-600 text-xs"></i>
                                                    <span class="text-yellow-600 text-xs font-medium">Sensitive</span>
                                                </div>
                                            @else
                                                <span class="text-gray-600 text-xs font-medium">Normal</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-0">
                                                @if($field->visible_to_merchant)
                                                    <span class="bg-blue-100 border-2 border-white text-blue-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium" title="Visible to Merchant">M</span>
                                                @endif
                                                @if($field->visible_to_admin)
                                                    <span class="bg-purple-100 border-2 border-white text-purple-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium {{ $field->visible_to_merchant ? '-ml-1' : '' }}" title="Visible to Admin">A</span>
                                                @endif
                                                @if($field->visible_to_partner)
                                                    <span class="bg-green-100 border-2 border-white text-green-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium -ml-1" title="Visible to Partner">P</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($field->status === 'active')
                                                <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Active</span>
                                            @elseif($field->status === 'draft')
                                                <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full text-xs font-medium">Draft</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full text-xs font-medium">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <button onclick="editKYCField({{ $field->id }})" class="text-gray-400 hover:text-brand-primary transition-colors">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button onclick="deleteKYCField({{ $field->id }}, '{{ $field->field_name }}')" class="text-gray-400 hover:text-red-500 transition-colors">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                            <p>No KYC fields found. Click "Add KYC Field" to create one.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
                                {{ $kycFields->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit KYC Field -->
        <div id="kyc-field-drawer" class="fixed top-0 right-0 w-full max-w-[580px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="mb-2">
                        <h2 id="drawer-title" class="text-xl font-semibold text-brand-primary">Add New KYC Field</h2>
                        <p class="text-xs text-gray-500 mt-1">Configure field properties, validation, and visibility.</p>
                    </div>
                    <button onclick="closeDrawer()" class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <form id="kyc-field-form" class="space-y-8" data-mode="create" data-id="">
                        <!-- Section 1: Basic Information -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-2">
                                <div class="section-number">1</div>
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Basic Information</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Field Name <span class="text-red-500">*</span></label>
                                <input type="text" id="field-name" name="field_name" class="form-input" placeholder="e.g. Beneficial Owner Name" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Internal Key</label>
                                <div class="flex">
                                    <span class="form-input-prefix">kyc_</span>
                                    <input type="text" id="internal-key" name="internal_key" class="form-input form-input-with-prefix" placeholder="beneficial_owner_name" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">KYC Section <span class="text-red-500">*</span></label>
                                <select id="kyc-section" name="kyc_section_id" class="form-input" required>
                                    <option value="">Select a section</option>
                                    @foreach ($kycSections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" class="form-input resize-y" rows="3" placeholder="Optional description for internal reference..."></textarea>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Section 2: Field Properties -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-2">
                                <div class="section-number">2</div>
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Field Properties</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Data Type <span class="text-red-500">*</span></label>
                                <select id="data-type" name="data_type" class="form-input" required>
                                    <option value="">Select a type</option>
                                    <option value="text">Text</option>
                                    <option value="date">Date</option>
                                    <option value="number">Number</option>
                                    <option value="email">Email</option>
                                    <option value="tel">Phone</option>
                                    <option value="url">URL</option>
                                    <option value="password">Password</option>
                                    <option value="time">Time</option>
                                    <option value="datetime-local">Date & Time</option>
                                    <option value="file">File Upload</option>
                                    <option value="dropdown">Dropdown</option>
                                    <option value="multi-select">Multi-Select</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="radio">Radio</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="country">Country</option>
                                    <option value="currency">Currency</option>
                                    <option value="address">Address</option>
                                    <option value="signature">Signature</option>
                                </select>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Section 3: Validation Rules -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-2">
                                <div class="section-number">3</div>
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Validation Rules</h3>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Is Required? <span class="text-red-500">*</span></label>
                                <div class="toggle-switch" id="required-toggle" onclick="toggleRequired()"></div>
                                <input type="hidden" id="is-required" name="is_required" value="0">
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Section 4: Sensitivity & Visibility Control -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-2">
                                <div class="section-number">4</div>
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Sensitivity & Visibility Control</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sensitivity Level <span class="text-red-500">*</span></label>
                                <select id="sensitivity-level" name="sensitivity_level" class="form-input" required>
                                    <option value="">Select a level</option>
                                    <option value="normal">Normal</option>
                                    <option value="sensitive">Sensitive</option>
                                    <option value="highly-sensitive">Highly Sensitive</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Visibility Controls</label>
                                <div class="space-y-2.5">
                                    <label class="flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" id="visible-merchant" name="visible_to_merchant" value="1" class="w-4 h-4 border-gray-400 rounded text-blue-600">
                                        <span class="text-sm text-gray-700">Visible to Merchant</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" id="visible-admin" name="visible_to_admin" value="1" class="w-4 h-4 border-gray-400 rounded text-blue-600">
                                        <span class="text-sm text-gray-700">Visible to Admin</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" id="visible-partner" name="visible_to_partner" value="1" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Visible to Partner</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Section 5: System Configuration -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-2">
                                <div class="section-number">5</div>
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">System Configuration</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                                <input type="number" id="sort-order" name="sort_order" class="form-input" placeholder="100" value="100" required>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Status</label>
                                <div class="toggle-switch active" id="status-toggle" onclick="toggleStatus()"></div>
                                <input type="hidden" id="status" name="status" value="active">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()" class="text-brand-primary font-medium hover:text-brand-secondary">Cancel</button>
                    <div class="flex gap-3">
                        <button type="button" id="save-draft-btn" class="border-2 border-brand-accent text-brand-accent px-5 py-2.5 rounded-lg font-medium hover:bg-orange-50 transition-colors" style="display: none;">
                            Save Draft
                        </button>
                        <button type="button" id="save-field-btn" form="kyc-field-form" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Field
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay" class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeDrawer()"></div>

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[70] hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-scale-in">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                        <i class="fa-solid fa-trash-can text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-primary text-center mb-2">Delete KYC Field</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Are you sure you want to delete <span id="delete-field-name" class="font-semibold text-brand-primary"></span>? This action cannot be undone.
                    </p>
                    <div class="flex gap-3">
                        <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button id="confirm-delete-btn" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors shadow-sm">
                            <i class="fa-solid fa-trash-can mr-2"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentDeleteId = null;

            function toggleFilters() {
                const filterPanel = document.getElementById('filter-panel');
                const filterArrow = document.getElementById('filter-arrow');
                filterPanel.classList.toggle('hidden');
                filterArrow.style.transform = filterPanel.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }

            function clearAllFilters() {
                window.location.href = '{{ route('admin.masters.kyc-field-master') }}';
            }

            function clearSearchFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('search');
                window.location.href = `?${params.toString()}`;
            }

            function clearSectionFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('kyc_section');
                window.location.href = `?${params.toString()}`;
            }

            function clearDataTypeFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('data_type');
                window.location.href = `?${params.toString()}`;
            }

            function clearSensitivityFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('sensitivity_level');
                window.location.href = `?${params.toString()}`;
            }

            function clearStatusFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('status');
                window.location.href = `?${params.toString()}`;
            }

            function openDrawer() {
                resetForm();
                document.getElementById('kyc-field-form').dataset.mode = 'create';
                document.getElementById('drawer-title').textContent = 'Add New KYC Field';
                document.getElementById('kyc-field-drawer').classList.remove('drawer-closed');
                document.getElementById('kyc-field-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function closeDrawer() {
                document.getElementById('kyc-field-drawer').classList.remove('drawer-open');
                document.getElementById('kyc-field-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
            }

            function resetForm() {
                document.getElementById('kyc-field-form').reset();
                document.getElementById('kyc-field-form').dataset.id = '';
                document.getElementById('kyc-field-form').dataset.mode = 'create';
                document.getElementById('required-toggle').classList.remove('active');
                document.getElementById('is-required').value = '0';
                document.getElementById('status-toggle').classList.add('active');
                document.getElementById('status').value = 'active';
                document.getElementById('sort-order').value = '100';
                document.getElementById('visible-merchant').checked = true;
                document.getElementById('visible-admin').checked = true;
                document.getElementById('visible-partner').checked = false;
            }

            function toggleRequired() {
                const toggle = document.getElementById('required-toggle');
                toggle.classList.toggle('active');
                document.getElementById('is-required').value = toggle.classList.contains('active') ? '1' : '0';
            }

            function toggleStatus() {
                const toggle = document.getElementById('status-toggle');
                toggle.classList.toggle('active');
                document.getElementById('status').value = toggle.classList.contains('active') ? 'active' : 'draft';
            }

            function editKYCField(id) {
                fetch(`/admin/masters/kyc-fields/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched data:', data);
                    
                    // First, reset the form without calling openDrawer (openDrawer will be called at the end)
                    document.getElementById('kyc-field-form').reset();
                    document.getElementById('kyc-field-form').dataset.mode = 'edit';
                    document.getElementById('kyc-field-form').dataset.id = data.id;
                    
                    // Now populate the form with the fetched data
                    document.getElementById('field-name').value = data.field_name;
                    document.getElementById('internal-key').value = data.internal_key;
                    document.getElementById('kyc-section').value = data.kyc_section_id;
                    document.getElementById('description').value = data.description || '';
                    document.getElementById('data-type').value = data.data_type;
                    document.getElementById('sensitivity-level').value = data.sensitivity_level;
                    document.getElementById('sort-order').value = data.sort_order;
                    
                    // Toggle required
                    const requiredToggle = document.getElementById('required-toggle');
                    if (data.is_required) {
                        requiredToggle.classList.add('active');
                        document.getElementById('is-required').value = '1';
                    } else {
                        requiredToggle.classList.remove('active');
                        document.getElementById('is-required').value = '0';
                    }
                    
                    // Toggle status
                    const statusToggle = document.getElementById('status-toggle');
                    if (data.status === 'active') {
                        statusToggle.classList.add('active');
                        document.getElementById('status').value = 'active';
                    } else {
                        statusToggle.classList.remove('active');
                        document.getElementById('status').value = data.status;
                    }
                    
                    // Visibility checkboxes
                    document.getElementById('visible-merchant').checked = data.visible_to_merchant;
                    document.getElementById('visible-admin').checked = data.visible_to_admin;
                    document.getElementById('visible-partner').checked = data.visible_to_partner;
                    
                    // Update drawer title
                    document.getElementById('drawer-title').textContent = 'Edit KYC Field';
                    
                    // Now open the drawer (without calling resetForm)
                    document.getElementById('kyc-field-drawer').classList.remove('drawer-closed');
                    document.getElementById('kyc-field-drawer').classList.add('drawer-open');
                    document.getElementById('drawer-overlay').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading KYC field', 'error');
                });
            }

            function deleteKYCField(id, name) {
                currentDeleteId = id;
                document.getElementById('delete-field-name').textContent = name;
                document.getElementById('delete-modal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('delete-modal').classList.add('hidden');
                currentDeleteId = null;
            }

            document.getElementById('confirm-delete-btn').addEventListener('click', function() {
                if (!currentDeleteId) return;
                
                fetch(`/admin/masters/kyc-fields/${currentDeleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error deleting KYC field', 'error');
                    closeDeleteModal();
                });
            });

            document.getElementById('kyc-field-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const mode = this.dataset.mode;
                const fieldId = this.dataset.id;
                const url = mode === 'edit' ? `/admin/masters/kyc-fields/${fieldId}` : '/admin/masters/kyc-fields';
                const method = mode === 'edit' ? 'PUT' : 'POST';
                
                // Prepare form data
                const formData = new FormData(this);
                formData.append('_method', method);
                
                // Ensure checkbox values are captured correctly
                formData.set('is_required', document.getElementById('required-toggle').classList.contains('active') ? '1' : '0');
                formData.set('visible_to_merchant', document.getElementById('visible-merchant').checked ? '1' : '0');
                formData.set('visible_to_admin', document.getElementById('visible-admin').checked ? '1' : '0');
                formData.set('visible_to_partner', document.getElementById('visible-partner').checked ? '1' : '0');
                formData.set('status', document.getElementById('status-toggle').classList.contains('active') ? 'active' : 'draft');
                
                // Debug: Log form data
                console.log('Form Mode:', mode);
                console.log('Field ID:', fieldId);
                console.log('URL:', url);
                console.log('Form Data:', Object.fromEntries(formData));
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok && response.status !== 422) {
                        return response.text().then(text => {
                            throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        showNotification(data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else if (data.errors) {
                        console.log('Validation errors:', data.errors);
                        Object.keys(data.errors).forEach(field => {
                            showNotification(`${field}: ${data.errors[field][0]}`, 'error');
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification(error.message || 'Error saving KYC field', 'error');
                });
            });

            // Handle save button click
            document.getElementById('save-field-btn').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('kyc-field-form').dispatchEvent(new Event('submit'));
            });

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 max-w-sm px-6 py-4 rounded-lg shadow-lg text-white z-50 animate-fade-in ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, type === 'success' ? 3000 : 5000);
            }

            // Add CSRF token meta tag if not present
            if (!document.querySelector('meta[name="csrf-token"]')) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }
        </script>

    </body>
@endsection
