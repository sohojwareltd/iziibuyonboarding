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
            color: #FFA439;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .requirement-toggle button.hidden-active {
            background: white;
            color: #DC2626;
            border: 1px solid #FECACA;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
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
        <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral">
            <div class="p-8">
             

                <!-- Page Content -->
                <div class="bg-brand-neutral p-6">
                    <div class="max-w-[1200px] mx-auto">
                        <!-- Page Title and Description -->
                        <div class="mb-6">
                            <h1 class="text-2xl font-semibold text-brand-primary mb-1">Acquirer-Specific KYC Field Mapping</h1>
                            <p class="text-sm text-gray-500">Configure mandatory, optional, and hidden KYC fields per acquirer and per country. Supports drag-and-drop ordering and visibility control.</p>
                        </div>

                        <!-- Configuration Controls -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 flex items-end gap-4">
                            <div class="w-64">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Acquirer</label>
                                <select class="form-input">
                                    <option value="">Select Acquirer...</option>
                                    <option value="elavon">Elavon</option>
                                    <option value="surfboard">Surfboard</option>
                                    <option value="stripe">Stripe</option>
                                </select>
                            </div>
                            <div class="w-64">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Country</label>
                                <select class="form-input">
                                    <option value="">Select Country...</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="nl">Netherlands</option>
                                    <option value="no">Norway</option>
                                </select>
                            </div>
                            <button class="bg-brand-primary text-white px-4 py-2.5 rounded-lg shadow-sm hover:bg-brand-secondary transition-colors flex items-center gap-2 h-[38px]">
                                <i class="fa-solid fa-rotate text-sm"></i>
                                <span class="font-medium text-sm">Load Mapping</span>
                            </button>
                            <div class="flex-1 text-right text-xs text-gray-400">
                                <div>Last updated: Oct 24, 14:30 • v1.2.4</div>
                            </div>
                        </div>

                        <!-- Main Content: Field Mapping and Preview -->
                        <div class="flex gap-6">
                            <!-- Left Panel: Field Mapping Configuration -->
                            <div class="flex-1 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <!-- Action Bar -->
                                <div class="bg-gray-50 border-b border-gray-200 px-6 py-3 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <button class="text-sm font-medium text-brand-primary flex items-center gap-1">
                                            Bulk Actions
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </button>
                                        <div class="h-4 w-px bg-gray-300"></div>
                                        <button class="text-sm text-gray-600 hover:text-brand-primary flex items-center gap-1">
                                            <i class="fa-solid fa-check-double text-xs"></i>
                                            Make All Mandatory
                                        </button>
                                        <button class="text-sm text-gray-600 hover:text-brand-primary flex items-center gap-1">
                                            <i class="fa-solid fa-eye-slash text-xs"></i>
                                            Hide All
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button class="text-sm text-gray-600 hover:text-brand-primary flex items-center gap-1">
                                            <i class="fa-solid fa-upload text-xs"></i>
                                            Import JSON
                                        </button>
                                        <button class="text-sm text-gray-600 hover:text-brand-primary flex items-center gap-1">
                                            <i class="fa-solid fa-download text-xs"></i>
                                            Export JSON
                                        </button>
                                    </div>
                                </div>

                                <!-- Table Headers -->
                                <div class="bg-gray-50 border-b border-gray-200 px-6 py-3 flex items-center gap-4">
                                    <div class="w-10"></div>
                                    <div class="flex-1">
                                        <div class="text-xs font-bold text-gray-500 uppercase">Field Name</div>
                                    </div>
                                    <div class="w-40">
                                        <div class="text-xs font-bold text-gray-500 uppercase">Requirement</div>
                                    </div>
                                    <div class="w-48">
                                        <div class="text-xs font-bold text-gray-500 uppercase">Visibility</div>
                                    </div>
                                    <div class="w-20 text-right">
                                        <div class="text-xs font-bold text-gray-500 uppercase">Validation</div>
                                    </div>
                                </div>

                                <!-- Field Sections -->
                                <div class="divide-y divide-gray-100">
                                    <!-- Company Information Section -->
                                    <div class="field-section">
                                        <div class="section-header bg-gray-50 border-b border-gray-200 px-6 py-2.5 flex items-center justify-between cursor-pointer" onclick="toggleSection(this)">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-chevron-down text-xs text-gray-400 section-chevron"></i>
                                                <span class="font-medium text-brand-primary">Company Information</span>
                                                <span class="bg-white border border-gray-200 text-gray-400 px-2 py-0.5 rounded-full text-xs">5 fields</span>
                                            </div>
                                        </div>
                                        <div class="section-content">
                                            <!-- Legal Name -->
                                            <div class="px-6 py-3 flex items-center gap-4 border-b border-gray-100 hover:bg-gray-50">
                                                <div class="w-10 flex items-center justify-center">
                                                    <i class="fa-solid fa-grip-vertical text-gray-400 cursor-move"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">Legal Name</div>
                                                    <div class="font-mono text-xs text-gray-400">company_legal_name</div>
                                                </div>
                                                <div class="w-40">
                                                    <div class="requirement-toggle">
                                                        <button class="active" onclick="setRequirement(this, 'mandatory')">Mandatory</button>
                                                        <button onclick="setRequirement(this, 'optional')">Optional</button>
                                                        <button onclick="setRequirement(this, 'hidden')">Hidden</button>
                                                    </div>
                                                </div>
                                                <div class="w-48">
                                                    <div class="flex items-center gap-3">
                                                        <label class="flex items-center gap-2 cursor-pointer opacity-70">
                                                            <input type="checkbox" checked class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                                            <span class="text-xs text-gray-600">Merch</span>
                                                        </label>
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" checked class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                                            <span class="text-xs text-gray-600">Admin</span>
                                                        </label>
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                                            <span class="text-xs text-gray-400">Partner</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="w-20 text-right">
                                                    <button class="text-brand-primary text-xs font-medium flex items-center gap-1">
                                                        <i class="fa-solid fa-gear text-xs"></i>
                                                        Config
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Trading Name -->
                                            <div class="px-6 py-3 flex items-center gap-4 border-b border-gray-100 hover:bg-gray-50">
                                                <div class="w-10 flex items-center justify-center">
                                                    <i class="fa-solid fa-grip-vertical text-gray-400 cursor-move"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">Trading Name</div>
                                                    <div class="font-mono text-xs text-gray-400">company_trading_name</div>
                                                </div>
                                                <div class="w-40">
                                                    <div class="requirement-toggle">
                                                        <button onclick="setRequirement(this, 'mandatory')">Mandatory</button>
                                                        <button class="active" onclick="setRequirement(this, 'optional')">Optional</button>
                                                        <button onclick="setRequirement(this, 'hidden')">Hidden</button>
                                                    </div>
                                                </div>
                                                <div class="w-48">
                                                    <div class="flex items-center gap-3">
                                                        <label class="flex items-center gap-2 cursor-pointer opacity-70">
                                                            <input type="checkbox" checked class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                                            <span class="text-xs text-gray-600">Merch</span>
                                                        </label>
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" checked class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                                            <span class="text-xs text-gray-600">Admin</span>
                                                        </label>
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                                            <span class="text-xs text-gray-400">Partner</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="w-20 text-right">
                                                    <button class="text-brand-primary text-xs font-medium flex items-center gap-1">
                                                        <i class="fa-solid fa-gear text-xs"></i>
                                                        Config
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Tax ID (Hidden) -->
                                            <div class="px-6 py-3 flex items-center gap-4 border-b border-gray-100 hover:bg-gray-50 opacity-60">
                                                <div class="w-10 flex items-center justify-center">
                                                    <i class="fa-solid fa-grip-vertical text-gray-400 cursor-move"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-medium text-gray-900">Tax ID</span>
                                                        <span class="bg-red-100 border border-red-200 text-red-600 px-2 py-0.5 rounded text-xs font-medium">Hidden</span>
                                                    </div>
                                                    <div class="font-mono text-xs text-gray-400">company_tax_id</div>
                                                </div>
                                                <div class="w-40">
                                                    <div class="requirement-toggle">
                                                        <button onclick="setRequirement(this, 'mandatory')">Mandatory</button>
                                                        <button onclick="setRequirement(this, 'optional')">Optional</button>
                                                        <button class="hidden-active" onclick="setRequirement(this, 'hidden')">Hidden</button>
                                                    </div>
                                                </div>
                                                <div class="w-48">
                                                    <div class="flex items-center gap-3">
                                                        <label class="flex items-center gap-2 cursor-pointer opacity-70">
                                                            <input type="checkbox" checked class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                                            <span class="text-xs text-gray-600">Merch</span>
                                                        </label>
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" checked class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                                            <span class="text-xs text-gray-600">Admin</span>
                                                        </label>
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                                            <span class="text-xs text-gray-400">Partner</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="w-20 text-right">
                                                    <button class="text-brand-primary text-xs font-medium flex items-center gap-1">
                                                        <i class="fa-solid fa-gear text-xs"></i>
                                                        Config
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Beneficial Owners Section -->
                                    <div class="field-section">
                                        <div class="section-header bg-gray-50 border-b border-gray-200 px-6 py-2.5 flex items-center justify-between cursor-pointer" onclick="toggleSection(this)">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-chevron-right text-xs text-gray-400 section-chevron"></i>
                                                <span class="font-medium text-brand-primary">Beneficial Owners</span>
                                                <span class="bg-white border border-gray-200 text-gray-400 px-2 py-0.5 rounded-full text-xs">3 fields</span>
                                            </div>
                                        </div>
                                        <div class="section-content collapsed">
                                            <!-- Fields would go here -->
                                        </div>
                                    </div>

                                    <!-- Bank Information Section -->
                                    <div class="field-section">
                                        <div class="section-header bg-gray-50 border-b border-gray-200 px-6 py-2.5 flex items-center justify-between cursor-pointer" onclick="toggleSection(this)">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-chevron-right text-xs text-gray-400 section-chevron"></i>
                                                <span class="font-medium text-brand-primary">Bank Information</span>
                                                <span class="bg-white border border-gray-200 text-gray-400 px-2 py-0.5 rounded-full text-xs">4 fields</span>
                                            </div>
                                        </div>
                                        <div class="section-content collapsed">
                                            <!-- Fields would go here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Panel: Live Preview -->
                            <div class="w-80 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
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
                                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                        <h3 class="text-lg font-semibold text-brand-primary mb-4">Company Information</h3>
                                        <div class="space-y-4">
                                            <!-- Legal Name -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Legal Name <span class="text-brand-accent">*</span></label>
                                                <input type="text" class="form-input" placeholder="e.g. Acme Corp Ltd.">
                                            </div>
                                            <!-- Trading Name -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Trading Name <span class="text-gray-400 text-xs font-normal">(Optional)</span></label>
                                                <input type="text" class="form-input" placeholder="e.g. Acme Stores">
                                            </div>
                                            <!-- Registration Number -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number <span class="text-brand-accent">*</span></label>
                                                <input type="text" class="form-input" placeholder="e.g. 12345678">
                                            </div>
                                            <!-- Tax ID is hidden, so not shown in merchant preview -->
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
        <div class="fixed bottom-0 left-[260px] right-0 bg-white border-t border-gray-200 shadow-lg px-8 py-4 flex items-center justify-between z-40">
            <button class="text-brand-primary font-medium hover:text-brand-secondary">Cancel</button>
            <div class="flex gap-3">
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
                    btn.classList.remove('active', 'hidden-active');
                });
                
                if (type === 'hidden') {
                    button.classList.add('hidden-active');
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
