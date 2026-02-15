@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acquirer Field Mapping - 2iZii</title>
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
            border-radius: 0.5rem;
            padding: 0.625rem 0.75rem;
            color: #2D3A74;
            outline: none;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        .form-input:focus {
            border-color: #2D3A74;
            box-shadow: 0 0 0 2px rgba(45,58,116,0.12);
        }

        /* Requirement Toggle */
        .requirement-toggle {
            display: flex;
            background-color: #F3F4F6;
            border-radius: 0.5rem;
            padding: 3px;
            gap: 2px;
        }
        .requirement-toggle button {
            padding: 0.4rem 0.625rem;
            border-radius: 0.375rem;
            font-size: 0.6875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            border: none;
            cursor: pointer;
            background: transparent;
            color: #9CA3AF;
            letter-spacing: 0.01em;
        }
        .requirement-toggle button:hover { color: #6B7280; background: rgba(255,255,255,0.5); }
        .requirement-toggle button.active {
            background: white;
            color: #059669;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 0 0 1px rgba(5,150,105,0.1);
            font-weight: 600;
        }
        .requirement-toggle button.optional-active {
            background: white;
            color: #D97706;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 0 0 1px rgba(217,119,6,0.1);
            font-weight: 600;
        }
        .requirement-toggle button.hidden-active {
            background: white;
            color: #DC2626;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 0 0 1px rgba(220,38,38,0.1);
            font-weight: 600;
        }

        /* Field Rows */
        .field-row { transition: all 0.15s ease; }
        .field-row:hover { background-color: #FAFBFC; }

        /* Visibility Checkbox */
        .visibility-checkbox {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }
        .visibility-checkbox:hover { background-color: #F3F4F6; border-color: #E5E7EB; }
        .visibility-checkbox input[type="checkbox"] {
            width: 15px;
            height: 15px;
            border: 2px solid #D1D5DB;
            border-radius: 4px;
            cursor: pointer;
            flex-shrink: 0;
            accent-color: #4055A8;
        }
        .visibility-checkbox span {
            font-size: 0.75rem;
            color: #374151;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Drag Handle */
        .drag-handle { cursor: grab; transition: color 0.2s; }
        .drag-handle:hover { color: #4055A8; }

        /* Preview Tabs */
        .preview-tabs {
            display: flex;
            background-color: #E5E7EB;
            border-radius: 0.375rem;
            padding: 2px;
        }
        .preview-tabs button {
            padding: 0.375rem 0.75rem;
            border-radius: 0.3rem;
            font-size: 0.6875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            border: none;
            cursor: pointer;
            background: transparent;
            color: #6B7280;
        }
        .preview-tabs button.active {
            background: white;
            color: #2D3A74;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06);
            font-weight: 600;
        }

        /* Section Animations */
        .section-content {
            display: block;
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.2s ease;
            max-height: 2000px;
            opacity: 1;
        }
        .section-content.collapsed {
            max-height: 0;
            opacity: 0;
        }
        .section-chevron { transition: transform 0.25s ease; }

        /* Section Progress Bar */
        .section-progress {
            height: 3px;
            background: #E5E7EB;
            border-radius: 2px;
            overflow: hidden;
        }
        .section-progress-fill {
            height: 100%;
            border-radius: 2px;
            transition: width 0.4s ease;
        }

        /* Stats Card Hover */
        .stat-card { transition: all 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }

        /* Data Type Badge */
        .data-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        /* Search Field */
        .field-search {
            position: relative;
        }
        .field-search input {
            padding-left: 2.25rem;
            background: white;
        }
        .field-search i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 0.8rem;
        }

        /* Preview Input Styling */
        .preview-input {
            width: 100%;
            border: 1px solid #E5E7EB;
            border-radius: 0.375rem;
            padding: 0.5rem 0.625rem;
            color: #9CA3AF;
            font-size: 0.8125rem;
            background: #FAFBFC;
        }
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral">

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Acquirer Field Mapping', 'url' => route('admin.masters.acquirer-field-mapping')],
        ]" />

        @php
            $totalFields = $kycSections->sum(fn($s) => $s->kycFields->count());
            $totalMandatory = $kycSections->sum(fn($s) => $s->kycFields->where('is_required', true)->count());
            $totalOptional = $totalFields - $totalMandatory;
            $totalSections = $kycSections->count();
        @endphp

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral pb-24">
            <div class="p-4 md:p-8">
                <div class="bg-brand-neutral">
                    <div class="max-w-[1400px] mx-auto">

                        <!-- Page Header -->
                        <div class="mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="bg-gradient-to-br from-brand-cta to-orange-500 text-white w-12 h-12 rounded-xl shadow-lg flex items-center justify-center">
                                        <i class="fa-solid fa-sliders text-lg"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-brand-primary leading-tight">Acquirer Field Mapping</h1>
                                        <p class="text-sm text-brand-text mt-0.5">Configure which KYC fields are required per acquirer and country</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                        Last saved: Feb 11, 2026
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Summary -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                            <div class="stat-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-layer-group text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-brand-primary">{{ $totalSections }}</div>
                                        <div class="text-xs text-gray-500 font-medium">Sections</div>
                                    </div>
                                </div>
                            </div>
                            <div class="stat-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-input-text text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-brand-primary">{{ $totalFields }}</div>
                                        <div class="text-xs text-gray-500 font-medium">Total Fields</div>
                                    </div>
                                </div>
                            </div>
                            <div class="stat-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-asterisk text-emerald-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-emerald-600">{{ $totalMandatory }}</div>
                                        <div class="text-xs text-gray-500 font-medium">Mandatory</div>
                                    </div>
                                </div>
                            </div>
                            <div class="stat-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-circle-minus text-amber-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-amber-600">{{ $totalOptional }}</div>
                                        <div class="text-xs text-gray-500 font-medium">Optional</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration Controls -->
                        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                                <div class="w-full sm:w-64">
                                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-building-columns text-brand-cta text-xs"></i>
                                        Acquirer
                                    </label>
                                    <select id="acquirer-select" class="form-input">
                                        <option value="">Select Acquirer...</option>
                                        @foreach ($acquirers as $acquirer)
                                            <option value="{{ $acquirer->id }}">{{ $acquirer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full sm:w-64">
                                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-globe text-brand-secondary text-xs"></i>
                                        Country
                                    </label>
                                    <select id="country-select" class="form-input">
                                        <option value="">Select Country...</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button id="load-mapping-btn" class="w-full sm:w-auto bg-gradient-to-r from-brand-primary to-brand-secondary text-white px-6 py-[0.625rem] rounded-lg shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 font-semibold text-sm">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                    Load Mapping
                                </button>
                            </div>
                        </div>

                        <!-- Main Content: Field Mapping and Preview -->
                        <div class="flex flex-col lg:flex-row gap-6 items-start">
                            <!-- Left Panel: Field Mapping Configuration -->
                            <div class="flex-1 min-w-0">
                                <!-- Toolbar -->
                                <div class="bg-white border border-gray-200 rounded-t-xl px-5 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <div class="field-search">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input id="field-search-input" type="text" class="form-input text-sm w-52" placeholder="Search fields..." oninput="filterFields(this.value)">
                                        </div>
                                        <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                                        <button onclick="toggleAllSections(true)" class="text-xs text-gray-500 hover:text-brand-primary font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-gray-50 transition-all" title="Expand All">
                                            <i class="fa-solid fa-angles-down text-[10px]"></i>
                                            Expand All
                                        </button>
                                        <button onclick="toggleAllSections(false)" class="text-xs text-gray-500 hover:text-brand-primary font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-gray-50 transition-all" title="Collapse All">
                                            <i class="fa-solid fa-angles-up text-[10px]"></i>
                                            Collapse
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button class="text-xs text-gray-500 hover:text-green-600 font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-green-50 transition-all">
                                            <i class="fa-solid fa-check-double text-[10px]"></i>
                                            All Mandatory
                                        </button>
                                        <button class="text-xs text-gray-500 hover:text-red-600 font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-red-50 transition-all">
                                            <i class="fa-solid fa-eye-slash text-[10px]"></i>
                                            Hide All
                                        </button>
                                        <div class="h-5 w-px bg-gray-200"></div>
                                        <button class="text-xs text-gray-500 hover:text-brand-primary font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-gray-50 transition-all">
                                            <i class="fa-solid fa-file-export text-[10px]"></i>
                                            Export
                                        </button>
                                    </div>
                                </div>

                                <!-- Column Headers -->
                                <div class="overflow-x-auto">
                                    <div class="bg-gradient-to-r from-brand-primary to-brand-secondary text-white px-5 py-3 flex items-center gap-3 min-w-[880px] sticky top-0 z-10 shadow-sm">
                                        <div class="w-8 flex items-center justify-center">
                                            <i class="fa-solid fa-grip-vertical text-[10px] opacity-40"></i>
                                        </div>
                                        <div class="flex-1">
                                            <span class="text-[11px] font-bold uppercase tracking-wider opacity-90">Field Name</span>
                                        </div>
                                        <div class="w-20 text-center">
                                            <span class="text-[11px] font-bold uppercase tracking-wider opacity-90">Type</span>
                                        </div>
                                        <div class="w-48">
                                            <span class="text-[11px] font-bold uppercase tracking-wider opacity-90">Requirement</span>
                                        </div>
                                        <div class="w-64">
                                            <span class="text-[11px] font-bold uppercase tracking-wider opacity-90 flex items-center gap-1.5">
                                                Visibility
                                                <i class="fa-solid fa-circle-info text-[9px] opacity-50" title="Which roles can see this field"></i>
                                            </span>
                                        </div>
                                        <div class="w-16 text-center">
                                            <span class="text-[11px] font-bold uppercase tracking-wider opacity-90">Action</span>
                                        </div>
                                    </div>

                                    @php
                                        $sectionColors = [
                                            ['from' => 'from-blue-50', 'to' => 'to-indigo-50', 'hover_from' => 'hover:from-blue-100', 'hover_to' => 'hover:to-indigo-100', 'border' => 'border-blue-200', 'badge_border' => 'border-blue-300', 'badge_bg' => 'bg-blue-50', 'badge_text' => 'text-blue-700', 'progress' => 'bg-blue-500'],
                                            ['from' => 'from-purple-50', 'to' => 'to-pink-50', 'hover_from' => 'hover:from-purple-100', 'hover_to' => 'hover:to-pink-100', 'border' => 'border-purple-200', 'badge_border' => 'border-purple-300', 'badge_bg' => 'bg-purple-50', 'badge_text' => 'text-purple-700', 'progress' => 'bg-purple-500'],
                                            ['from' => 'from-green-50', 'to' => 'to-teal-50', 'hover_from' => 'hover:from-green-100', 'hover_to' => 'hover:to-teal-100', 'border' => 'border-green-200', 'badge_border' => 'border-green-300', 'badge_bg' => 'bg-green-50', 'badge_text' => 'text-green-700', 'progress' => 'bg-green-500'],
                                            ['from' => 'from-amber-50', 'to' => 'to-orange-50', 'hover_from' => 'hover:from-amber-100', 'hover_to' => 'hover:to-orange-100', 'border' => 'border-amber-200', 'badge_border' => 'border-amber-300', 'badge_bg' => 'bg-amber-50', 'badge_text' => 'text-amber-700', 'progress' => 'bg-amber-500'],
                                            ['from' => 'from-rose-50', 'to' => 'to-red-50', 'hover_from' => 'hover:from-rose-100', 'hover_to' => 'hover:to-red-100', 'border' => 'border-rose-200', 'badge_border' => 'border-rose-300', 'badge_bg' => 'bg-rose-50', 'badge_text' => 'text-rose-700', 'progress' => 'bg-rose-500'],
                                            ['from' => 'from-cyan-50', 'to' => 'to-sky-50', 'hover_from' => 'hover:from-cyan-100', 'hover_to' => 'hover:to-sky-100', 'border' => 'border-cyan-200', 'badge_border' => 'border-cyan-300', 'badge_bg' => 'bg-cyan-50', 'badge_text' => 'text-cyan-700', 'progress' => 'bg-cyan-500'],
                                            ['from' => 'from-emerald-50', 'to' => 'to-lime-50', 'hover_from' => 'hover:from-emerald-100', 'hover_to' => 'hover:to-lime-100', 'border' => 'border-emerald-200', 'badge_border' => 'border-emerald-300', 'badge_bg' => 'bg-emerald-50', 'badge_text' => 'text-emerald-700', 'progress' => 'bg-emerald-500'],
                                            ['from' => 'from-violet-50', 'to' => 'to-fuchsia-50', 'hover_from' => 'hover:from-violet-100', 'hover_to' => 'hover:to-fuchsia-100', 'border' => 'border-violet-200', 'badge_border' => 'border-violet-300', 'badge_bg' => 'bg-violet-50', 'badge_text' => 'text-violet-700', 'progress' => 'bg-violet-500'],
                                        ];
                                        $sectionIcons = [
                                            'company-information' => 'fa-building',
                                            'beneficial-owners' => 'fa-users',
                                            'board-members-gm' => 'fa-user-tie',
                                            'contact-person' => 'fa-address-card',
                                            'purpose-of-service' => 'fa-bullseye',
                                            'sales-channels' => 'fa-store',
                                            'bank-information' => 'fa-landmark',
                                            'authorized-signatories' => 'fa-file-signature',
                                        ];
                                        $dataTypeStyles = [
                                            'text' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'fa-font'],
                                            'email' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'icon' => 'fa-envelope'],
                                            'tel' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'icon' => 'fa-phone'],
                                            'number' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'icon' => 'fa-hashtag'],
                                            'date' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'icon' => 'fa-calendar'],
                                            'dropdown' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'icon' => 'fa-caret-down'],
                                            'textarea' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-700', 'icon' => 'fa-align-left'],
                                            'file' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'icon' => 'fa-paperclip'],
                                            'url' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'icon' => 'fa-link'],
                                            'checkbox' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'icon' => 'fa-square-check'],
                                            'radio' => ['bg' => 'bg-pink-50', 'text' => 'text-pink-700', 'icon' => 'fa-circle-dot'],
                                            'multi-select' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-700', 'icon' => 'fa-list-check'],
                                            'country' => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-700', 'icon' => 'fa-globe'],
                                            'currency' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'icon' => 'fa-coins'],
                                            'address' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'icon' => 'fa-location-dot'],
                                            'signature' => ['bg' => 'bg-fuchsia-50', 'text' => 'text-fuchsia-700', 'icon' => 'fa-signature'],
                                            'password' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'icon' => 'fa-lock'],
                                            'time' => ['bg' => 'bg-lime-50', 'text' => 'text-lime-700', 'icon' => 'fa-clock'],
                                            'datetime-local' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'icon' => 'fa-calendar-clock'],
                                        ];
                                    @endphp

                                    <!-- Field Sections -->
                                    <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl overflow-hidden min-w-[880px] divide-y divide-gray-100">
                                        @foreach ($kycSections as $sIndex => $section)
                                            @php
                                                $color = $sectionColors[$sIndex % count($sectionColors)];
                                                $icon = $sectionIcons[$section->slug] ?? 'fa-folder';
                                                $fieldCount = $section->kycFields->count();
                                                $mandatoryCount = $section->kycFields->where('is_required', true)->count();
                                                $optionalCount = $fieldCount - $mandatoryCount;
                                                $isFirst = $sIndex === 0;
                                                $mandatoryPct = $fieldCount > 0 ? round(($mandatoryCount / $fieldCount) * 100) : 0;
                                            @endphp
                                            <div class="field-section" data-section-name="{{ Str::lower($section->name) }}">
                                                {{-- Section Header --}}
                                                <div class="section-header bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} border-b {{ $color['border'] }} px-5 py-3.5 flex items-center justify-between {{ $color['hover_from'] }} {{ $color['hover_to'] }} transition-all group" onclick="toggleSection(this)">
                                                    <div class="flex items-center gap-3">
                                                        <i class="fa-solid {{ $isFirst ? 'fa-chevron-down' : 'fa-chevron-right' }} text-xs text-brand-secondary section-chevron"></i>
                                                        <div class="w-7 h-7 bg-white/70 rounded-lg flex items-center justify-center shadow-sm">
                                                            <i class="fa-solid {{ $icon }} text-brand-cta text-xs"></i>
                                                        </div>
                                                        <span class="font-bold text-brand-primary text-sm">{{ $section->name }}</span>
                                                        <span class="{{ $color['badge_bg'] }} {{ $color['badge_text'] }} px-2 py-0.5 rounded-md text-[10px] font-bold">{{ $fieldCount }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-4">
                                                        {{-- Mini progress bar --}}
                                                        @if ($fieldCount > 0)
                                                            <div class="hidden sm:flex items-center gap-2">
                                                                <div class="section-progress w-20">
                                                                    <div class="section-progress-fill {{ $color['progress'] }}" style="width: {{ $mandatoryPct }}%"></div>
                                                                </div>
                                                                <span class="text-[10px] text-gray-500 font-medium tabular-nums">{{ $mandatoryCount }}/{{ $fieldCount }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="text-[11px] text-gray-500 font-medium">
                                                            @if ($fieldCount > 0)
                                                                <span class="text-emerald-600 font-semibold">{{ $mandatoryCount }}</span> req
                                                                <span class="text-gray-300 mx-0.5">&middot;</span>
                                                                <span class="text-amber-600 font-semibold">{{ $optionalCount }}</span> opt
                                                            @else
                                                                <span class="text-gray-400 italic">Empty</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Section Content --}}
                                                <div class="section-content {{ $isFirst ? '' : 'collapsed' }}">
                                                    @forelse ($section->kycFields as $field)
                                                        @php
                                                            $dtStyle = $dataTypeStyles[$field->data_type] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'fa-code'];
                                                        @endphp
                                                        <div class="field-row px-5 py-3.5 flex items-center gap-3 border-b border-gray-100 odd:bg-white even:bg-gray-50/60 hover:bg-blue-50/40" data-field-name="{{ Str::lower($field->field_name) }} {{ Str::lower($field->internal_key) }}">
                                                            <div class="w-8 flex items-center justify-center">
                                                                <i class="fa-solid fa-grip-vertical text-gray-300 drag-handle text-xs"></i>
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <div class="flex items-center gap-2 mb-0.5">
                                                                    <span class="font-semibold text-gray-800 text-sm truncate">{{ $field->field_name }}</span>
                                                                    @if ($field->is_required)
                                                                        <span class="flex-shrink-0 bg-emerald-100 text-emerald-700 px-1.5 py-px rounded text-[10px] font-bold flex items-center gap-0.5">
                                                                            <i class="fa-solid fa-asterisk" style="font-size: 6px;"></i>
                                                                            REQ
                                                                        </span>
                                                                    @else
                                                                        <span class="flex-shrink-0 bg-amber-100 text-amber-700 px-1.5 py-px rounded text-[10px] font-bold">OPT</span>
                                                                    @endif
                                                                    @if ($field->sensitivity_level === 'highly-sensitive')
                                                                        <span class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full" title="Highly Sensitive"></span>
                                                                    @elseif ($field->sensitivity_level === 'sensitive')
                                                                        <span class="flex-shrink-0 w-2 h-2 bg-amber-400 rounded-full" title="Sensitive"></span>
                                                                    @endif
                                                                </div>
                                                                <div class="font-mono text-[11px] text-gray-400 truncate">{{ $field->internal_key }}</div>
                                                            </div>
                                                            <div class="w-20 flex justify-center">
                                                                <span class="data-type-badge {{ $dtStyle['bg'] }} {{ $dtStyle['text'] }}">
                                                                    <i class="fa-solid {{ $dtStyle['icon'] }}" style="font-size: 8px;"></i>
                                                                    {{ Str::limit($field->data_type, 8) }}
                                                                </span>
                                                            </div>
                                                            <div class="w-52">
                                                                <div class="requirement-toggle" data-field-id="{{ $field->id }}">
                                                                    <button class="{{ $field->is_required ? 'active' : '' }}" onclick="setRequirement(this, 'mandatory')">Mandatory</button>
                                                                    <button class="{{ !$field->is_required ? 'optional-active' : '' }}" onclick="setRequirement(this, 'optional')">Optional</button>
                                                                    <button onclick="setRequirement(this, 'hidden')">Hidden</button>
                                                                </div>
                                                            </div>
                                                            <div class="w-64">
                                                                <div class="flex items-center gap-2">
                                                                    <label class="visibility-checkbox">
                                                                        <input type="checkbox" {{ $field->visible_to_merchant ? 'checked' : '' }} data-field-id="{{ $field->id }}" data-role="merchant">
                                                                        <span>Merchant</span>
                                                                    </label>
                                                                    <label class="visibility-checkbox">
                                                                        <input type="checkbox" {{ $field->visible_to_admin ? 'checked' : '' }} data-field-id="{{ $field->id }}" data-role="admin">
                                                                        <span>Admin</span>
                                                                    </label>
                                                                    <label class="visibility-checkbox">
                                                                        <input type="checkbox" {{ $field->visible_to_partner ? 'checked' : '' }} data-field-id="{{ $field->id }}" data-role="partner">
                                                                        <span>Partner</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="w-16 text-center">
                                                                <button class="text-brand-secondary hover:text-brand-primary text-sm hover:bg-gray-100 w-8 h-8 rounded-lg transition-all inline-flex items-center justify-center" title="Configure field">
                                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="px-5 py-10 text-center">
                                                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                                <i class="fa-solid fa-inbox text-gray-300 text-lg"></i>
                                                            </div>
                                                            <p class="text-sm text-gray-400 font-medium">No KYC fields in this section</p>
                                                            <p class="text-xs text-gray-300 mt-1">Add fields from the KYC Field Master</p>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Right Panel: Live Preview (Sticky) -->
                            <div class="w-full lg:w-[340px] flex-shrink-0 lg:sticky lg:top-20">
                                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                    <!-- Preview Header -->
                                    <div class="bg-gray-50 border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-eye text-brand-secondary text-xs"></i>
                                            <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Preview</span>
                                        </div>
                                        <div class="preview-tabs">
                                            <button class="active" onclick="switchPreview(this, 'merchant')">Merchant</button>
                                            <button onclick="switchPreview(this, 'admin')">Admin</button>
                                            <button onclick="switchPreview(this, 'partner')">Partner</button>
                                        </div>
                                    </div>

                                    <!-- Preview Content -->
                                    <div class="p-4 bg-gradient-to-b from-gray-50 to-gray-100 max-h-[calc(100vh-8rem)] overflow-y-auto">
                                        {{-- Phone-like frame --}}
                                        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
                                            {{-- Mini header --}}
                                            <div class="bg-brand-primary px-4 py-3">
                                                <div class="text-white text-xs font-semibold">KYC Application Form</div>
                                                <div class="text-white/60 text-[10px] mt-0.5">Merchant view</div>
                                            </div>

                                            <div class="p-4 space-y-4">
                                                @foreach ($kycSections as $section)
                                                    @if ($section->kycFields->where('visible_to_merchant', true)->count() > 0)
                                                        <div>
                                                            <div class="flex items-center gap-2 mb-3 pb-2 border-b border-gray-100">
                                                                <div class="w-1 h-4 bg-brand-cta rounded-full"></div>
                                                                <h4 class="text-xs font-bold text-brand-primary uppercase tracking-wide">{{ $section->name }}</h4>
                                                            </div>
                                                            <div class="space-y-3">
                                                                @foreach ($section->kycFields->where('visible_to_merchant', true) as $field)
                                                                    <div>
                                                                        <label class="block text-[11px] font-medium text-gray-600 mb-1">
                                                                            {{ $field->field_name }}
                                                                            @if ($field->is_required)
                                                                                <span class="text-red-500">*</span>
                                                                            @endif
                                                                        </label>
                                                                        @switch($field->data_type)
                                                                            @case('textarea')
                                                                                <textarea class="preview-input resize-none" rows="2" placeholder="{{ $field->field_name }}..." disabled></textarea>
                                                                                @break
                                                                            @case('dropdown')
                                                                            @case('multi-select')
                                                                            @case('country')
                                                                            @case('currency')
                                                                                <select class="preview-input" disabled>
                                                                                    <option>Select...</option>
                                                                                </select>
                                                                                @break
                                                                            @case('file')
                                                                            @case('signature')
                                                                                <div class="preview-input flex items-center gap-2 text-gray-400">
                                                                                    <i class="fa-solid fa-cloud-arrow-up text-[10px]"></i>
                                                                                    <span>Upload file...</span>
                                                                                </div>
                                                                                @break
                                                                            @case('checkbox')
                                                                                <label class="flex items-center gap-2">
                                                                                    <input type="checkbox" class="w-3.5 h-3.5 rounded border-gray-300" disabled>
                                                                                    <span class="text-xs text-gray-500">{{ $field->field_name }}</span>
                                                                                </label>
                                                                                @break
                                                                            @case('radio')
                                                                                <label class="flex items-center gap-2">
                                                                                    <input type="radio" class="w-3.5 h-3.5 border-gray-300" disabled>
                                                                                    <span class="text-xs text-gray-500">{{ $field->field_name }}</span>
                                                                                </label>
                                                                                @break
                                                                            @default
                                                                                <input type="{{ $field->data_type }}" class="preview-input" placeholder="{{ $field->field_name }}..." disabled>
                                                                        @endswitch
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach

                                                {{-- Mini submit button --}}
                                                <div class="pt-3 border-t border-gray-100">
                                                    <div class="bg-gray-200 text-gray-400 text-center py-2 rounded-lg text-xs font-semibold">
                                                        Submit Application
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Bottom Footer -->
        <div class="fixed bottom-0 left-0 md:left-[260px] right-0 bg-white/95 backdrop-blur-sm border-t border-gray-200 shadow-lg px-4 md:px-8 py-3 flex items-center justify-between z-40">
            <div class="flex items-center gap-3">
                <button class="text-gray-500 hover:text-brand-primary font-medium text-sm transition-colors">Cancel</button>
                <span class="text-xs text-gray-300">|</span>
                <span class="text-xs text-gray-400" id="change-indicator">No unsaved changes</span>
            </div>
            <div class="flex items-center gap-3">
                <button class="border border-gray-300 text-gray-600 px-5 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors text-sm">
                    Save Draft
                </button>
                <button class="bg-gradient-to-r from-brand-cta to-orange-500 text-white px-6 py-2 rounded-lg font-semibold shadow-sm hover:shadow-md transition-all text-sm">
                    <i class="fa-solid fa-check mr-1.5"></i>
                    Save Mapping
                </button>
            </div>
        </div>

        <script>
            // Toggle individual section
            function toggleSection(header) {
                const section = header.closest('.field-section');
                const content = section.querySelector('.section-content');
                const chevron = header.querySelector('.section-chevron');

                content.classList.toggle('collapsed');
                if (content.classList.contains('collapsed')) {
                    chevron.classList.remove('fa-chevron-down');
                    chevron.classList.add('fa-chevron-right');
                } else {
                    chevron.classList.remove('fa-chevron-right');
                    chevron.classList.add('fa-chevron-down');
                }
            }

            // Expand / Collapse all sections
            function toggleAllSections(expand) {
                document.querySelectorAll('.field-section').forEach(section => {
                    const content = section.querySelector('.section-content');
                    const chevron = section.querySelector('.section-chevron');
                    if (expand) {
                        content.classList.remove('collapsed');
                        chevron.classList.remove('fa-chevron-right');
                        chevron.classList.add('fa-chevron-down');
                    } else {
                        content.classList.add('collapsed');
                        chevron.classList.remove('fa-chevron-down');
                        chevron.classList.add('fa-chevron-right');
                    }
                });
            }

            // Requirement toggle
            function setRequirement(button, type) {
                const toggle = button.closest('.requirement-toggle');
                toggle.querySelectorAll('button').forEach(btn => {
                    btn.classList.remove('active', 'optional-active', 'hidden-active');
                });
                if (type === 'hidden') {
                    button.classList.add('hidden-active');
                } else if (type === 'optional') {
                    button.classList.add('optional-active');
                } else {
                    button.classList.add('active');
                }
                markUnsaved();
            }

            // Preview tab switch
            function switchPreview(button, view) {
                document.querySelectorAll('.preview-tabs button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            }

            // Search / filter fields
            function filterFields(query) {
                const q = query.toLowerCase().trim();
                document.querySelectorAll('.field-row').forEach(row => {
                    const name = row.getAttribute('data-field-name') || '';
                    row.style.display = (!q || name.includes(q)) ? '' : 'none';
                });
                // Also show/hide empty sections
                document.querySelectorAll('.field-section').forEach(section => {
                    const visibleFields = section.querySelectorAll('.field-row[style=""], .field-row:not([style])');
                    const sectionName = section.getAttribute('data-section-name') || '';
                    if (!q || visibleFields.length > 0 || sectionName.includes(q)) {
                        section.style.display = '';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }

            // Unsaved changes indicator
            function markUnsaved() {
                const indicator = document.getElementById('change-indicator');
                if (indicator) {
                    indicator.textContent = 'Unsaved changes';
                    indicator.classList.remove('text-gray-400');
                    indicator.classList.add('text-amber-600');
                }
            }

            // Mark unsaved on any checkbox change
            document.querySelectorAll('.visibility-checkbox input').forEach(cb => {
                cb.addEventListener('change', markUnsaved);
            });
        </script>

    </body>
@endsection
