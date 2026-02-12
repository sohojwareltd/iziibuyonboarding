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
        .requirement-toggle {
            display: flex;
            background-color: #F3F4F6;
            border-radius: 0.375rem;
            padding: 2px;
            gap: 0;
        }
        .requirement-toggle button {
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            background: transparent;
            color: #6B7280;
        }
        .requirement-toggle button.active {
            background: white;
            color: #10B981;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-weight: 600;
        }
        .requirement-toggle button.optional-active {
            background: white;
            color: #F59E0B;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-weight: 600;
        }
        .requirement-toggle button.hidden-active {
            background: white;
            color: #EF4444;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-weight: 600;
        }
        .field-row {
            transition: all 0.2s;
        }
        .field-row:hover {
            background-color: #F9FAFB;
        }
        .visibility-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .visibility-checkbox:hover {
            background-color: #F3F4F6;
        }
        .visibility-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 2px solid #D1D5DB;
            border-radius: 4px;
            cursor: pointer;
            flex-shrink: 0;
        }
        .visibility-checkbox input[type="checkbox"]:checked {
            border-color: #4055A8;
            background-color: #4055A8;
        }
        .visibility-checkbox span {
            font-size: 0.8125rem;
            color: #374151;
            font-weight: 500;
            white-space: nowrap;
        }
        .drag-handle {
            cursor: grab;
            transition: color 0.2s;
        }
        .drag-handle:hover {
            color: #4055A8;
        }
        .preview-tabs {
            display: flex;
            background-color: #E5E7EB;
            border-radius: 0.25rem;
            padding: 2px;
            gap: 0;
        }
        .preview-tabs button {
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.625rem;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            background: transparent;
            color: #6B7280;
        }
        .preview-tabs button.active {
            background: white;
            color: #2D3A74;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .section-header {
            cursor: pointer;
        }
        .section-content {
            display: block;
        }
        .section-content.collapsed {
            display: none;
        }
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral">

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Acquirer-Specific KYC Field Mapping', 'url' => route('admin.masters.acquirer-field-mapping')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">
             

                <!-- Page Content -->
                <div class="bg-brand-neutral p-6">
                    <div class="max-w-[1200px] mx-auto">
                        <!-- Page Title and Description -->
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-brand-cta text-white p-3 rounded-xl shadow-lg">
                                    <i class="fa-solid fa-sliders text-xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-bold text-brand-primary">Acquirer Field Mapping</h1>
                                    <p class="text-sm text-brand-text mt-1">Configure field requirements per acquirer and country</p>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration Controls -->
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6 mb-6 shadow-md">
                            <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                                <div class="w-full sm:w-72">
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2 flex items-center gap-2">
                                        <i class="fa-solid fa-building text-brand-cta"></i>
                                        Acquirer
                                    </label>
                                    <select class="form-input">
                                        <option value="">Select Acquirer...</option>
                                        @foreach ($acquirers as $acquirer)
                                            <option value="{{ $acquirer->id }}">{{ $acquirer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full sm:w-72">
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2 flex items-center gap-2">
                                        <i class="fa-solid fa-globe text-brand-secondary"></i>
                                        Country
                                    </label>
                                    <select class="form-input">
                                        <option value="">Select Country...</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="w-full sm:w-auto bg-brand-primary from-brand-primary to-brand-secondary text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 font-semibold">
                                    <i class="fa-solid fa-download"></i>
                                    <span>Load Mapping</span>
                                </button>
                                <div class="w-full sm:flex-1 flex items-center justify-end">
                                    <div class="bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Last updated: Feb 11, 2026</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content: Field Mapping and Preview -->
                        <div class="flex flex-col lg:flex-row gap-6">
                            <!-- Left Panel: Field Mapping Configuration -->
                            <div class="flex-1 bg-white border-2 border-gray-200 rounded-xl shadow-lg overflow-hidden">
                                <!-- Action Bar -->
                                <div class="bg-gradient-to-r from-gray-50 to-white border-b-2 border-gray-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex flex-wrap items-center gap-4">
                                        <button class="bg-white border-2 border-brand-primary text-brand-primary px-4 py-2 rounded-lg shadow-sm hover:bg-brand-primary hover:text-white transition-all font-semibold flex items-center gap-2">
                                            <i class="fa-solid fa-list-check"></i>
                                            Bulk Actions
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </button>
                                        <div class="h-6 w-px bg-gray-300"></div>
                                        <button class="text-sm text-gray-700 hover:text-green-600 font-medium flex items-center gap-2 hover:bg-green-50 px-3 py-2 rounded-lg transition-all">
                                            <i class="fa-solid fa-check-double"></i>
                                            All Mandatory
                                        </button>
                                        <button class="text-sm text-gray-700 hover:text-red-600 font-medium flex items-center gap-2 hover:bg-red-50 px-3 py-2 rounded-lg transition-all">
                                            <i class="fa-solid fa-eye-slash"></i>
                                            Hide All
                                        </button>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:shadow-md transition-all text-sm font-medium flex items-center gap-2">
                                            <i class="fa-solid fa-upload"></i>
                                            Import
                                        </button>
                                        <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:shadow-md transition-all text-sm font-medium flex items-center gap-2">
                                            <i class="fa-solid fa-download"></i>
                                            Export
                                        </button>
                                    </div>
                                </div>

                                <!-- Table Headers -->
                                <div class="overflow-x-auto">
                                <div class="bg-gradient-to-r from-brand-primary to-brand-secondary text-white px-6 py-4 flex items-center gap-4 min-w-[900px]">
                                    <div class="w-10 flex items-center justify-center">
                                        <i class="fa-solid fa-grip-vertical text-xs opacity-60"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-xs font-bold uppercase tracking-wide">Field Name</div>
                                    </div>
                                    <div class="w-52">
                                        <div class="text-xs font-bold uppercase tracking-wide">Requirement</div>
                                    </div>
                                    <div class="w-80">
                                        <div class="text-xs font-bold uppercase tracking-wide flex items-center gap-2">
                                            Visibility Roles
                                            <i class="fa-solid fa-circle-info text-xs opacity-70" title="Control where field appears"></i>
                                        </div>
                                    </div>
                                    <div class="w-24 text-center">
                                        <div class="text-xs font-bold uppercase tracking-wide">Actions</div>
                                    </div>
                                </div>

                                <!-- Field Sections -->
                                <div class="divide-y divide-gray-200 min-w-[900px]">
                                    @php
                                        $sectionColors = [
                                            ['from' => 'from-blue-50', 'to' => 'to-indigo-50', 'hover_from' => 'hover:from-blue-100', 'hover_to' => 'hover:to-indigo-100', 'border' => 'border-blue-200', 'badge_border' => 'border-blue-300'],
                                            ['from' => 'from-purple-50', 'to' => 'to-pink-50', 'hover_from' => 'hover:from-purple-100', 'hover_to' => 'hover:to-pink-100', 'border' => 'border-purple-200', 'badge_border' => 'border-purple-300'],
                                            ['from' => 'from-green-50', 'to' => 'to-teal-50', 'hover_from' => 'hover:from-green-100', 'hover_to' => 'hover:to-teal-100', 'border' => 'border-green-200', 'badge_border' => 'border-green-300'],
                                            ['from' => 'from-amber-50', 'to' => 'to-orange-50', 'hover_from' => 'hover:from-amber-100', 'hover_to' => 'hover:to-orange-100', 'border' => 'border-amber-200', 'badge_border' => 'border-amber-300'],
                                            ['from' => 'from-rose-50', 'to' => 'to-red-50', 'hover_from' => 'hover:from-rose-100', 'hover_to' => 'hover:to-red-100', 'border' => 'border-rose-200', 'badge_border' => 'border-rose-300'],
                                            ['from' => 'from-cyan-50', 'to' => 'to-sky-50', 'hover_from' => 'hover:from-cyan-100', 'hover_to' => 'hover:to-sky-100', 'border' => 'border-cyan-200', 'badge_border' => 'border-cyan-300'],
                                            ['from' => 'from-emerald-50', 'to' => 'to-lime-50', 'hover_from' => 'hover:from-emerald-100', 'hover_to' => 'hover:to-lime-100', 'border' => 'border-emerald-200', 'badge_border' => 'border-emerald-300'],
                                            ['from' => 'from-violet-50', 'to' => 'to-fuchsia-50', 'hover_from' => 'hover:from-violet-100', 'hover_to' => 'hover:to-fuchsia-100', 'border' => 'border-violet-200', 'badge_border' => 'border-violet-300'],
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
                                    @endphp

                                    @foreach ($kycSections as $sIndex => $section)
                                        @php
                                            $color = $sectionColors[$sIndex % count($sectionColors)];
                                            $icon = $sectionIcons[$section->slug] ?? 'fa-folder';
                                            $fieldCount = $section->kycFields->count();
                                            $mandatoryCount = $section->kycFields->where('is_required', true)->count();
                                            $optionalCount = $fieldCount - $mandatoryCount;
                                            $isFirst = $sIndex === 0;
                                        @endphp
                                        <div class="field-section">
                                            <div class="section-header bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} border-b-2 {{ $color['border'] }} px-6 py-4 flex items-center justify-between cursor-pointer {{ $color['hover_from'] }} {{ $color['hover_to'] }} transition-all" onclick="toggleSection(this)">
                                                <div class="flex items-center gap-3">
                                                    <i class="fa-solid {{ $isFirst ? 'fa-chevron-down' : 'fa-chevron-right' }} text-base text-brand-secondary section-chevron transition-transform"></i>
                                                    <i class="fa-solid {{ $icon }} text-brand-cta"></i>
                                                    <span class="font-bold text-brand-primary text-base">{{ $section->name }}</span>
                                                    <span class="bg-white border-2 {{ $color['badge_border'] }} text-brand-secondary px-3 py-1 rounded-full text-xs font-bold">{{ $fieldCount }} {{ Str::plural('field', $fieldCount) }}</span>
                                                </div>
                                                <div class="text-xs text-gray-600 font-medium">
                                                    @if ($fieldCount > 0)
                                                        {{ $mandatoryCount }} Mandatory &bull; {{ $optionalCount }} Optional
                                                    @else
                                                        No fields
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="section-content {{ $isFirst ? '' : 'collapsed' }}">
                                                @forelse ($section->kycFields as $field)
                                                    <div class="field-row px-6 py-5 flex items-center gap-4 border-b border-gray-200">
                                                        <div class="w-10 flex items-center justify-center">
                                                            <i class="fa-solid fa-grip-vertical text-gray-400 drag-handle"></i>
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <div class="font-semibold text-gray-900 text-base">{{ $field->field_name }}</div>
                                                                @if ($field->is_required)
                                                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-md text-xs font-bold flex items-center gap-1">
                                                                        <i class="fa-solid fa-asterisk" style="font-size: 8px;"></i>
                                                                        Required
                                                                    </span>
                                                                @else
                                                                    <span class="bg-amber-100 text-amber-700 px-2 py-0.5 rounded-md text-xs font-bold">Optional</span>
                                                                @endif
                                                            </div>
                                                            <div class="font-mono text-xs text-gray-500">{{ $field->internal_key }}</div>
                                                        </div>
                                                        <div class="w-60">
                                                            <div class="requirement-toggle" data-field-id="{{ $field->id }}">
                                                                <button class="{{ $field->is_required ? 'active' : '' }}" onclick="setRequirement(this, 'mandatory')">Mandatory</button>
                                                                <button class="{{ !$field->is_required ? 'optional-active' : '' }}" onclick="setRequirement(this, 'optional')">Optional</button>
                                                                <button onclick="setRequirement(this, 'hidden')">Hidden</button>
                                                            </div>
                                                        </div>
                                                        <div class="w-80">
                                                            <div class="flex items-center gap-4">
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
                                                        <div class="w-24 text-center">
                                                            <button class="bg-brand-primary text-white px-3 py-2 rounded-lg text-xs font-semibold hover:bg-brand-secondary transition-all shadow-sm flex items-center gap-2 mx-auto">
                                                                <i class="fa-solid fa-cog"></i>
                                                                Setup
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="px-6 py-8 text-center text-gray-400 text-sm">
                                                        <i class="fa-solid fa-inbox text-2xl mb-2"></i>
                                                        <p>No KYC fields in this section yet.</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                </div>
                            </div>

                            <!-- Right Panel: Live Preview -->
                            <div class="w-full lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <!-- Preview Header -->
                                <div class="bg-gray-50 border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                                    <div class="text-xs font-bold text-gray-500 uppercase">Live Preview</div>
                                    <div class="preview-tabs">
                                        <button class="active" onclick="switchPreview(this, 'merchant')">Merchant</button>
                                        <button onclick="switchPreview(this, 'admin')">Admin</button>
                                    </div>
                                </div>

                                <!-- Preview Content -->
                                <div class="p-6 bg-gray-50 min-h-[800px]">
                                    @foreach ($kycSections as $section)
                                        @if ($section->kycFields->where('visible_to_merchant', true)->count() > 0)
                                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mb-4">
                                                <h3 class="text-lg font-semibold text-brand-primary mb-4">{{ $section->name }}</h3>
                                                <div class="space-y-4">
                                                    @foreach ($section->kycFields->where('visible_to_merchant', true) as $field)
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                                {{ $field->field_name }}
                                                                @if ($field->is_required)
                                                                    <span class="text-brand-accent">*</span>
                                                                @else
                                                                    <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                                                                @endif
                                                            </label>
                                                            @switch($field->data_type)
                                                                @case('textarea')
                                                                    <textarea class="form-input resize-y" rows="2" placeholder="{{ $field->field_name }}" disabled></textarea>
                                                                    @break
                                                                @case('dropdown')
                                                                @case('multi-select')
                                                                @case('country')
                                                                @case('currency')
                                                                    <select class="form-input" disabled>
                                                                        <option>Select {{ $field->field_name }}...</option>
                                                                    </select>
                                                                    @break
                                                                @case('file')
                                                                @case('signature')
                                                                    <div class="form-input bg-gray-50 text-gray-400 text-sm flex items-center gap-2">
                                                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                                                        Upload {{ $field->field_name }}
                                                                    </div>
                                                                    @break
                                                                @case('checkbox')
                                                                    <label class="flex items-center gap-2">
                                                                        <input type="checkbox" class="w-4 h-4 border-gray-300 rounded" disabled>
                                                                        <span class="text-sm text-gray-600">{{ $field->field_name }}</span>
                                                                    </label>
                                                                    @break
                                                                @case('radio')
                                                                    <label class="flex items-center gap-2">
                                                                        <input type="radio" class="w-4 h-4 border-gray-300" disabled>
                                                                        <span class="text-sm text-gray-600">{{ $field->field_name }}</span>
                                                                    </label>
                                                                    @break
                                                                @default
                                                                    <input type="{{ $field->data_type }}" class="form-input" placeholder="{{ $field->field_name }}" disabled>
                                                            @endswitch
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Bottom Footer -->
        <div class="fixed bottom-0 left-0 md:left-[260px] right-0 bg-white border-t border-gray-200 shadow-lg px-4 md:px-8 py-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 z-40">
            <button class="text-brand-primary font-medium hover:text-brand-secondary text-center">Cancel</button>
            <div class="flex flex-col sm:flex-row gap-3">
                <button class="border-2 border-brand-accent text-brand-accent px-6 py-3 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                    Save Draft
                </button>
                <button class="bg-brand-accent text-white px-6 py-3 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                    Save Mapping
                </button>
            </div>
        </div>

        <script>
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
            }

            function switchPreview(button, view) {
                document.querySelectorAll('.preview-tabs button').forEach(btn => {
                    btn.classList.remove('active');
                });
                button.classList.add('active');
                // Update preview content based on view
            }
        </script>

    </body>
@endsection
