@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acquirer Field Mapping - 2iZii</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    screens: {
                        'xs': '475px',
                    },
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
        .field-row[draggable="true"] { cursor: grab; }
        .field-row.is-dragging {
            opacity: 0.55;
            box-shadow: 0 10px 30px rgba(64, 85, 168, 0.18);
        }
        .section-dropzone {
            min-height: 24px;
            transition: background-color 0.15s ease, box-shadow 0.15s ease;
        }
        .section-dropzone.drag-over,
        .field-section.drag-over .section-header {
            background-color: rgba(64, 85, 168, 0.08);
            box-shadow: inset 0 0 0 1px rgba(64, 85, 168, 0.18);
        }
        .drop-placeholder {
            height: 52px;
            margin: 8px 12px;
            border: 2px dashed #93C5FD;
            border-radius: 12px;
            background: rgba(147, 197, 253, 0.12);
        }

        .section-drag-handle {
            cursor: grab;
            color: #9CA3AF;
            transition: color 0.2s ease;
        }
        .section-drag-handle:hover {
            color: #4055A8;
        }
        .field-section.is-dragging-section {
            opacity: 0.6;
        }
        .section-drop-placeholder {
            height: 62px;
            margin: 8px 0;
            border: 2px dashed #93C5FD;
            border-radius: 12px;
            background: rgba(147, 197, 253, 0.12);
        }

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

        /* Prevent horizontal scroll on mobile */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
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
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral pb-24 overflow-x-hidden">
            <div class="p-4 md:p-8 overflow-x-hidden">
                <div class="bg-brand-neutral overflow-x-hidden">
                    <div class="max-w-[1400px] mx-auto overflow-x-hidden">

                        <!-- Page Header -->
                        <div class="mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0 flex-1">
                                    <div class="bg-gradient-to-br from-brand-cta to-orange-500 text-white w-12 h-12 rounded-xl shadow-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-sliders text-lg"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h1 class="text-2xl font-bold text-brand-primary leading-tight">Acquirer Field Mapping</h1>
                                        <p class="text-sm text-brand-text mt-0.5">Configure which KYC fields are required per acquirer and country</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <div id="mapping-save-status" class="bg-slate-50 border border-slate-200 text-slate-700 px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2 transition-all">
                                        <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                        <span>Loaded from KYC Field Master</span>
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
                        {{-- <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm">
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
                        </div> --}}

                        <!-- Main Content: Field Mapping and Preview -->
                        <div class="flex flex-col lg:flex-row gap-6 items-start overflow-x-hidden">
                            <!-- Left Panel: Field Mapping Configuration -->
                            <div class="flex-1 min-w-0 overflow-x-hidden">
                                <!-- Toolbar -->
                                <div class="bg-white border border-gray-200 rounded-t-xl px-3 sm:px-5 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <div class="field-search w-full sm:w-auto">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input id="field-search-input" type="text" class="form-input text-sm w-full sm:w-52" placeholder="Search fields..." oninput="filterFields(this.value)">
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
                                    {{-- <div class="flex flex-wrap items-center gap-2">
                                        <button class="text-xs text-gray-500 hover:text-green-600 font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-green-50 transition-all">
                                            <i class="fa-solid fa-check-double text-[10px]"></i>
                                            <span class="hidden xs:inline">All Mandatory</span>
                                        </button>
                                        <button class="text-xs text-gray-500 hover:text-red-600 font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-red-50 transition-all">
                                            <i class="fa-solid fa-eye-slash text-[10px]"></i>
                                            <span class="hidden xs:inline">Hide All</span>
                                        </button>
                                        <div class="h-5 w-px bg-gray-200 hidden sm:block"></div>
                                        <button class="text-xs text-gray-500 hover:text-brand-primary font-medium flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-gray-50 transition-all">
                                            <i class="fa-solid fa-file-export text-[10px]"></i>
                                            <span class="hidden xs:inline">Export</span>
                                        </button>
                                    </div> --}}
                                </div>

                                <!-- Column Headers -->
                                <div class="overflow-x-auto -mx-3 sm:mx-0 px-3 sm:px-0">
                                    <div class="bg-gradient-to-r from-brand-primary to-brand-secondary text-white px-3 sm:px-5 py-3 flex items-center gap-3 min-w-[880px] sticky top-0 z-10 shadow-sm">
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
                                    <div id="field-sections-container" class="bg-white border border-gray-200 border-t-0 rounded-b-xl overflow-hidden min-w-[880px] divide-y divide-gray-100">
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
                                            <div class="field-section" data-section-id="{{ $section->id }}" data-section-name="{{ Str::lower($section->name) }}">
                                                {{-- Section Header --}}
                                                <div class="section-header bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} border-b {{ $color['border'] }} px-3 sm:px-5 py-3.5 flex items-center justify-between {{ $color['hover_from'] }} {{ $color['hover_to'] }} transition-all group" onclick="toggleSection(this, event)">
                                                    <div class="flex items-center gap-3">
                                                        <span class="section-drag-handle" draggable="true" title="Drag section" aria-label="Drag section">
                                                            <i class="fa-solid fa-grip-vertical text-xs"></i>
                                                        </span>
                                                        <i class="fa-solid {{ $isFirst ? 'fa-chevron-down' : 'fa-chevron-right' }} text-xs text-brand-secondary section-chevron"></i>
                                                        <div class="w-7 h-7 bg-white/70 rounded-lg flex items-center justify-center shadow-sm">
                                                            <i class="fa-solid {{ $icon }} text-brand-cta text-xs"></i>
                                                        </div>
                                                        <span class="font-bold text-brand-primary text-sm">{{ $section->name }}</span>
                                                        <span class="section-field-count {{ $color['badge_bg'] }} {{ $color['badge_text'] }} px-2 py-0.5 rounded-md text-[10px] font-bold">{{ $fieldCount }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-4">
                                                        {{-- Mini progress bar --}}
                                                        @if ($fieldCount > 0)
                                                            <div class="hidden sm:flex items-center gap-2">
                                                                <div class="section-progress w-20">
                                                                    <div class="section-progress-fill {{ $color['progress'] }}" style="width: {{ $mandatoryPct }}%"></div>
                                                                </div>
                                                                <span class="section-progress-label text-[10px] text-gray-500 font-medium tabular-nums">{{ $mandatoryCount }}/{{ $fieldCount }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="section-summary text-[11px] text-gray-500 font-medium">
                                                            @if ($fieldCount > 0)
                                                                <span class="section-mandatory-count text-emerald-600 font-semibold">{{ $mandatoryCount }}</span> req
                                                                <span class="text-gray-300 mx-0.5">&middot;</span>
                                                                <span class="section-optional-count text-amber-600 font-semibold">{{ $optionalCount }}</span> opt
                                                            @else
                                                                <span class="text-gray-400 italic">Empty</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Section Content --}}
                                                <div class="section-content {{ $isFirst ? '' : 'collapsed' }}">
                                                    <div class="section-dropzone" data-section-id="{{ $section->id }}">
                                                        @foreach ($section->kycFields as $field)
                                                            @php
                                                                $dtStyle = $dataTypeStyles[$field->data_type] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'fa-code'];
                                                            @endphp
                                                            <div class="field-row px-3 sm:px-5 py-3.5 flex items-center gap-3 border-b border-gray-100 odd:bg-white even:bg-gray-50/60 hover:bg-blue-50/40" draggable="true" data-field-id="{{ $field->id }}" data-section-id="{{ $section->id }}" data-field-label="{{ Str::lower($field->field_name) }}" data-field-name="{{ Str::lower($field->field_name) }} {{ Str::lower($field->internal_key) }}">
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
                                                                    <div class="field-internal-key font-mono text-[11px] text-gray-400 truncate">{{ $field->internal_key }}</div>
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
                                                        @endforeach
                                                    </div>
                                                    <div class="section-empty-state px-3 sm:px-5 py-10 text-center {{ $fieldCount > 0 ? 'hidden' : '' }}">
                                                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                                <i class="fa-solid fa-inbox text-gray-300 text-lg"></i>
                                                            </div>
                                                            <p class="text-sm text-gray-400 font-medium">No KYC fields in this section</p>
                                                            <p class="text-xs text-gray-300 mt-1">Add fields from the KYC Field Master</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Right Panel: Live Preview (Sticky) -->
                            {{-- <div class="w-full lg:w-[340px] flex-shrink-0 lg:sticky lg:top-20">
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
                                       
                                        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
                                            
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

                                                
                                                <div class="pt-3 border-t border-gray-100">
                                                    <div class="bg-gray-200 text-gray-400 text-center py-2 rounded-lg text-xs font-semibold">
                                                        Submit Application
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Bottom Footer -->
        {{-- <div class="fixed bottom-0 left-0 md:left-[260px] right-0 bg-white/95 backdrop-blur-sm border-t border-gray-200 shadow-lg px-4 md:px-8 py-3 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 z-40">
            <div class="flex items-center justify-center sm:justify-start gap-3">
                <button class="text-gray-500 hover:text-brand-primary font-medium text-sm transition-colors">Cancel</button>
                <span class="text-xs text-gray-300">|</span>
                <span class="text-xs text-gray-400" id="change-indicator">No unsaved changes</span>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <button class="border border-gray-300 text-gray-600 px-5 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors text-sm order-2 sm:order-1">
                    Save Draft
                </button>
                <button class="bg-gradient-to-r from-brand-cta to-orange-500 text-white px-6 py-2 rounded-lg font-semibold shadow-sm hover:shadow-md transition-all text-sm order-1 sm:order-2">
                    <i class="fa-solid fa-check mr-1.5"></i>
                    Save Mapping
                </button>
            </div>
        </div> --}}

        <script>
            const mappingSyncUrl = @json(route('admin.masters.acquirer-field-mapping.sync'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token());
            const dragState = {
                row: null,
                section: null,
                snapshot: '',
                isSaving: false,
            };
            const dropPlaceholder = document.createElement('div');
            dropPlaceholder.className = 'drop-placeholder';
            const sectionDropPlaceholder = document.createElement('div');
            sectionDropPlaceholder.className = 'section-drop-placeholder';

            function setSaveStatus(state, text) {
                const el = document.getElementById('mapping-save-status');
                if (!el) {
                    return;
                }

                const dot = el.querySelector('span');
                el.className = 'px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2 transition-all';

                if (state === 'saving') {
                    el.classList.add('bg-amber-50', 'border', 'border-amber-200', 'text-amber-700');
                    if (dot) dot.className = 'w-2 h-2 bg-amber-500 rounded-full animate-pulse';
                } else if (state === 'saved') {
                    el.classList.add('bg-green-50', 'border', 'border-green-200', 'text-green-700');
                    if (dot) dot.className = 'w-2 h-2 bg-green-500 rounded-full';
                } else if (state === 'error') {
                    el.classList.add('bg-red-50', 'border', 'border-red-200', 'text-red-700');
                    if (dot) dot.className = 'w-2 h-2 bg-red-500 rounded-full';
                } else {
                    el.classList.add('bg-slate-50', 'border', 'border-slate-200', 'text-slate-700');
                    if (dot) dot.className = 'w-2 h-2 bg-slate-400 rounded-full';
                }

                const label = el.querySelectorAll('span')[1];
                if (label) {
                    label.textContent = text;
                }
            }

            function captureLayoutSnapshot() {
                return JSON.stringify(getLayoutPayload());
            }

            function getLayoutPayload() {
                const items = [];
                const sections = [];

                document.querySelectorAll('#field-sections-container .field-section').forEach((section, index) => {
                    sections.push({
                        section_id: Number(section.dataset.sectionId),
                        sort_order: index,
                    });
                });

                document.querySelectorAll('.section-dropzone').forEach(dropzone => {
                    const sectionId = Number(dropzone.dataset.sectionId);
                    dropzone.querySelectorAll('.field-row').forEach((row, index) => {
                        items.push({
                            field_id: Number(row.dataset.fieldId),
                            kyc_section_id: sectionId,
                            sort_order: index,
                        });
                    });
                });

                return { items, sections };
            }

            function getDragAfterElement(container, clientY) {
                const draggableRows = [...container.querySelectorAll('.field-row:not(.is-dragging)')];

                return draggableRows.reduce((closest, child) => {
                    const box = child.getBoundingClientRect();
                    const offset = clientY - box.top - box.height / 2;

                    if (offset < 0 && offset > closest.offset) {
                        return { offset, element: child };
                    }

                    return closest;
                }, { offset: Number.NEGATIVE_INFINITY, element: null }).element;
            }

            function getSectionDragAfterElement(container, clientY) {
                const draggableSections = [...container.querySelectorAll('.field-section:not(.is-dragging-section)')];

                return draggableSections.reduce((closest, child) => {
                    const box = child.getBoundingClientRect();
                    const offset = clientY - box.top - box.height / 2;

                    if (offset < 0 && offset > closest.offset) {
                        return { offset, element: child };
                    }

                    return closest;
                }, { offset: Number.NEGATIVE_INFINITY, element: null }).element;
            }

            function updateSectionEmptyStates() {
                document.querySelectorAll('.field-section').forEach(section => {
                    const dropzone = section.querySelector('.section-dropzone');
                    const emptyState = section.querySelector('.section-empty-state');
                    const hasRows = dropzone && dropzone.querySelector('.field-row');

                    if (emptyState) {
                        emptyState.classList.toggle('hidden', Boolean(hasRows));
                    }
                });
            }

            function updateSectionCounts() {
                document.querySelectorAll('.field-section').forEach(section => {
                    const rows = [...section.querySelectorAll('.section-dropzone .field-row')];
                    const fieldCount = rows.length;
                    const mandatoryCount = rows.filter(row => row.querySelector('.requirement-toggle .active')).length;
                    const optionalCount = Math.max(fieldCount - mandatoryCount, 0);
                    const progress = fieldCount > 0 ? Math.round((mandatoryCount / fieldCount) * 100) : 0;
                    const fieldCountEl = section.querySelector('.section-field-count');
                    const summaryEl = section.querySelector('.section-summary');
                    const mandatoryEl = section.querySelector('.section-mandatory-count');
                    const optionalEl = section.querySelector('.section-optional-count');
                    const progressBar = section.querySelector('.section-progress-fill');
                    const progressLabel = section.querySelector('.section-progress-label');

                    if (fieldCountEl) {
                        fieldCountEl.textContent = fieldCount;
                    }

                    if (fieldCount === 0) {
                        if (summaryEl) {
                            summaryEl.innerHTML = '<span class="text-gray-400 italic">Empty</span>';
                        }
                    } else {
                        if (summaryEl && mandatoryEl && optionalEl) {
                            mandatoryEl.textContent = mandatoryCount;
                            optionalEl.textContent = optionalCount;
                        } else if (summaryEl) {
                            summaryEl.innerHTML = `<span class="section-mandatory-count text-emerald-600 font-semibold">${mandatoryCount}</span> req <span class="text-gray-300 mx-0.5">&middot;</span> <span class="section-optional-count text-amber-600 font-semibold">${optionalCount}</span> opt`;
                        }
                    }

                    if (progressBar) {
                        progressBar.style.width = `${progress}%`;
                    }

                    if (progressLabel) {
                        progressLabel.textContent = `${mandatoryCount}/${fieldCount}`;
                    }
                });
            }

            function clearDropState() {
                document.querySelectorAll('.field-section').forEach(section => section.classList.remove('drag-over'));
                document.querySelectorAll('.section-dropzone').forEach(dropzone => dropzone.classList.remove('drag-over'));
                if (dropPlaceholder.parentNode) {
                    dropPlaceholder.parentNode.removeChild(dropPlaceholder);
                }
                if (sectionDropPlaceholder.parentNode) {
                    sectionDropPlaceholder.parentNode.removeChild(sectionDropPlaceholder);
                }
            }

            function syncUpdatedFieldKeys(fields) {
                if (!Array.isArray(fields)) {
                    return;
                }

                fields.forEach(field => {
                    const row = document.querySelector(`.field-row[data-field-id="${field.field_id}"]`);
                    if (!row) {
                        return;
                    }

                    row.dataset.sectionId = String(field.kyc_section_id);
                    row.dataset.fieldName = `${row.dataset.fieldLabel || ''} ${String(field.internal_key || '').toLowerCase()}`.trim();

                    const internalKeyEl = row.querySelector('.field-internal-key');
                    if (internalKeyEl) {
                        internalKeyEl.textContent = field.internal_key;
                    }
                });
            }

            async function persistLayout() {
                if (dragState.isSaving) {
                    return;
                }

                const payload = getLayoutPayload();
                dragState.isSaving = true;
                setSaveStatus('saving', 'Saving field mapping...');

                try {
                    const response = await fetch(mappingSyncUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify(payload),
                    });

                    if (!response.ok) {
                        throw new Error('Failed to save mapping changes.');
                    }

                    const result = await response.json();
                    syncUpdatedFieldKeys(result.fields || []);

                    dragState.snapshot = JSON.stringify(payload.items);
                    setSaveStatus('saved', `Saved at ${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`);
                } catch (error) {
                    setSaveStatus('error', error.message || 'Unable to save mapping.');
                } finally {
                    dragState.isSaving = false;
                }
            }

            function handleDropzoneDragOver(event) {
                event.preventDefault();
                const dropzone = event.currentTarget;
                dropzone.classList.add('drag-over');
                dropzone.closest('.field-section')?.classList.add('drag-over');

                if (!dragState.row) {
                    return;
                }

                const afterElement = getDragAfterElement(dropzone, event.clientY);
                if (afterElement) {
                    dropzone.insertBefore(dropPlaceholder, afterElement);
                } else {
                    dropzone.appendChild(dropPlaceholder);
                }
            }

            function handleSectionHeaderDrop(event) {
                event.preventDefault();

                if (dragState.section) {
                    return;
                }

                const section = event.currentTarget.closest('.field-section');
                const dropzone = section?.querySelector('.section-dropzone');
                const content = section?.querySelector('.section-content');

                if (!dropzone || !dragState.row) {
                    return;
                }

                if (content) {
                    content.classList.remove('collapsed');
                    const chevron = section.querySelector('.section-chevron');
                    chevron?.classList.remove('fa-chevron-right');
                    chevron?.classList.add('fa-chevron-down');
                }

                dropzone.appendChild(dragState.row);
                dragState.row.dataset.sectionId = dropzone.dataset.sectionId;
                clearDropState();
                updateSectionEmptyStates();
                updateSectionCounts();

                const nextSnapshot = captureLayoutSnapshot();
                if (nextSnapshot !== dragState.snapshot) {
                    persistLayout();
                }
            }

            function initDragAndDrop() {
                dragState.snapshot = captureLayoutSnapshot();

                const sectionsContainer = document.getElementById('field-sections-container');

                document.querySelectorAll('.section-drag-handle').forEach(handle => {
                    handle.addEventListener('dragstart', event => {
                        const section = handle.closest('.field-section');
                        if (!section) {
                            event.preventDefault();
                            return;
                        }

                        dragState.section = section;
                        dragState.snapshot = captureLayoutSnapshot();
                        section.classList.add('is-dragging-section');
                        event.dataTransfer.effectAllowed = 'move';
                        event.dataTransfer.setData('text/plain', section.dataset.sectionId || '');
                    });

                    handle.addEventListener('dragend', () => {
                        const section = handle.closest('.field-section');
                        section?.classList.remove('is-dragging-section');
                        dragState.section = null;
                        clearDropState();
                    });
                });

                if (sectionsContainer) {
                    sectionsContainer.addEventListener('dragover', event => {
                        if (!dragState.section) {
                            return;
                        }

                        event.preventDefault();
                        const afterElement = getSectionDragAfterElement(sectionsContainer, event.clientY);

                        if (afterElement) {
                            sectionsContainer.insertBefore(sectionDropPlaceholder, afterElement);
                        } else {
                            sectionsContainer.appendChild(sectionDropPlaceholder);
                        }
                    });

                    sectionsContainer.addEventListener('drop', event => {
                        if (!dragState.section) {
                            return;
                        }

                        event.preventDefault();

                        if (sectionDropPlaceholder.parentNode === sectionsContainer) {
                            sectionsContainer.insertBefore(dragState.section, sectionDropPlaceholder);
                        } else {
                            sectionsContainer.appendChild(dragState.section);
                        }

                        dragState.section.classList.remove('is-dragging-section');
                        dragState.section = null;
                        clearDropState();

                        const nextSnapshot = captureLayoutSnapshot();
                        if (nextSnapshot !== dragState.snapshot) {
                            persistLayout();
                        }
                    });
                }

                document.querySelectorAll('.field-row').forEach(row => {
                    row.addEventListener('dragstart', event => {
                        dragState.row = row;
                        dragState.snapshot = captureLayoutSnapshot();
                        row.classList.add('is-dragging');
                        event.dataTransfer.effectAllowed = 'move';
                        event.dataTransfer.setData('text/plain', row.dataset.fieldId || '');
                    });

                    row.addEventListener('dragend', () => {
                        row.classList.remove('is-dragging');
                        dragState.row = null;
                        clearDropState();
                    });
                });

                document.querySelectorAll('.section-dropzone').forEach(dropzone => {
                    dropzone.addEventListener('dragover', handleDropzoneDragOver);
                    dropzone.addEventListener('dragleave', event => {
                        if (!dropzone.contains(event.relatedTarget)) {
                            dropzone.classList.remove('drag-over');
                            dropzone.closest('.field-section')?.classList.remove('drag-over');
                        }
                    });
                    dropzone.addEventListener('drop', event => {
                        event.preventDefault();

                        if (!dragState.row) {
                            return;
                        }

                        if (dropPlaceholder.parentNode === dropzone) {
                            dropzone.insertBefore(dragState.row, dropPlaceholder);
                        } else {
                            dropzone.appendChild(dragState.row);
                        }

                        dragState.row.dataset.sectionId = dropzone.dataset.sectionId;
                        clearDropState();
                        updateSectionEmptyStates();
                        updateSectionCounts();

                        const nextSnapshot = captureLayoutSnapshot();
                        if (nextSnapshot !== dragState.snapshot) {
                            persistLayout();
                        }
                    });
                });

                document.querySelectorAll('.section-header').forEach(header => {
                    header.addEventListener('dragover', event => {
                        event.preventDefault();
                        header.closest('.field-section')?.classList.add('drag-over');
                    });
                    header.addEventListener('dragleave', event => {
                        if (!header.contains(event.relatedTarget)) {
                            header.closest('.field-section')?.classList.remove('drag-over');
                        }
                    });
                    header.addEventListener('drop', handleSectionHeaderDrop);
                });
            }

            // Toggle individual section
            function toggleSection(header, event) {
                if (event?.target?.closest('.section-drag-handle')) {
                    return;
                }

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
                event?.preventDefault?.();
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
                updateSectionCounts();
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
                setSaveStatus('saving', 'Unsaved local changes');
            }

            // Mark unsaved on any checkbox change
            document.querySelectorAll('.visibility-checkbox input').forEach(cb => {
                cb.addEventListener('change', markUnsaved);
            });

            updateSectionEmptyStates();
            updateSectionCounts();
            initDragAndDrop();
        </script>

    </body>
@endsection
