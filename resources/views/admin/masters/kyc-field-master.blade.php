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
        <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral">
            <div class="p-8">
            

                <!-- Page Content -->
                <div class="bg-brand-neutral p-8">
                    <div class="max-w-[1200px] mx-auto">
                        <!-- Page Title and Add Button -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h1 class="text-2xl font-semibold text-brand-primary mb-1">KYC Field Master</h1>
                                <p class="text-sm text-gray-500">Manage and configure KYC data fields for merchant onboarding.</p>
                            </div>
                            <button onclick="openDrawer()" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add KYC Field</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-6 flex items-center justify-between">
                            <div class="relative w-[384px]">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Search KYC fields..." class="form-input pl-10 bg-white border-gray-200">
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-filter text-sm"></i>
                                    Filters
                                </button>
                                <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-download text-sm"></i>
                                    Export
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-100">
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
                                    <!-- Row 1: Company Registration Number -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary leading-tight">
                                                <div>Company</div>
                                                <div>Registration Number</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-xs text-gray-600">company_reg_no</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-900 px-2.5 py-1 rounded-full text-xs font-medium">Text</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-700 text-sm leading-tight">
                                                <div>Company</div>
                                                <div>Info</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-1">
                                                <i class="fa-solid fa-triangle-exclamation text-yellow-600 text-xs"></i>
                                                <span class="text-yellow-600 text-xs font-medium">Sensitive</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-0">
                                                <span class="bg-blue-100 border-2 border-white text-blue-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium">M</span>
                                                <span class="bg-purple-100 border-2 border-white text-purple-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium -ml-1">A</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Active</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <button class="text-gray-400 hover:text-brand-primary">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-red-500">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-gray-600">
                                                    <i class="fa-solid fa-eye text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 2: Date of Incorporation -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary leading-tight">
                                                <div>Date of</div>
                                                <div>Incorporation</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-xs text-gray-600">incorporation_date</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-900 px-2.5 py-1 rounded-full text-xs font-medium">Date</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-700 text-sm leading-tight">
                                                <div>Company</div>
                                                <div>Info</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-xs font-medium">Normal</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-0">
                                                <span class="bg-blue-100 border-2 border-white text-blue-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium">M</span>
                                                <span class="bg-purple-100 border-2 border-white text-purple-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium -ml-1">A</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Active</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <button class="text-gray-400 hover:text-brand-primary">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-red-500">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-gray-600">
                                                    <i class="fa-solid fa-eye text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 3: Beneficial Owner ID -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Beneficial Owner ID</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-xs text-gray-600">bo_passport_id</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-900 px-2.5 py-1 rounded-full text-xs font-medium leading-tight">
                                                <div>File</div>
                                                <div>Upload</div>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-700 text-sm leading-tight">
                                                <div>Beneficial</div>
                                                <div>Owners</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-1">
                                                <i class="fa-solid fa-lock text-red-600 text-xs"></i>
                                                <span class="text-red-600 text-xs font-medium leading-tight">
                                                    <div>Highly</div>
                                                    <div>Sensitive</div>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-0">
                                                <span class="bg-blue-100 border-2 border-white text-blue-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium">M</span>
                                                <span class="bg-purple-100 border-2 border-white text-purple-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium -ml-1">A</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Active</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <button class="text-gray-400 hover:text-brand-primary">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-red-500">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-gray-600">
                                                    <i class="fa-solid fa-eye text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 4: Business Type -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Business Type</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-mono text-xs text-gray-600">business_type_id</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-900 px-2.5 py-1 rounded-full text-xs font-medium">Dropdown</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-700 text-sm leading-tight">
                                                <div>Company</div>
                                                <div>Info</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-xs font-medium">Normal</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-0">
                                                <span class="bg-blue-100 border-2 border-white text-blue-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium">M</span>
                                                <span class="bg-purple-100 border-2 border-white text-purple-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-medium -ml-1">A</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-white px-2.5 py-1 rounded-full text-xs font-medium">Inactive</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <button class="text-gray-400 hover:text-brand-primary">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-red-500">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-gray-600">
                                                    <i class="fa-solid fa-eye text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium text-gray-900">1-4</span> of <span class="font-medium text-gray-900">42</span> results
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm opacity-50 cursor-not-allowed">Previous</button>
                                    <button class="bg-brand-primary text-white px-3 py-1.5 rounded text-sm">1</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">2</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">3</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit KYC Field -->
        <div id="kyc-field-drawer" class="fixed top-0 right-0 w-[580px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="mb-2">
                        <h2 class="text-xl font-semibold text-brand-primary">Add New KYC Field</h2>
                        <p class="text-xs text-gray-500 mt-1">Configure field properties, validation, and visibility.</p>
                    </div>
                    <button onclick="closeDrawer()" class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="space-y-8">
                        <!-- Section 1: Basic Information -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 pb-2">
                                <div class="section-number">1</div>
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Basic Information</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Field Name <span class="text-red-500">*</span></label>
                                <input type="text" class="form-input" placeholder="e.g. Beneficial Owner Name">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Internal Key</label>
                                <div class="flex">
                                    <span class="form-input-prefix">kyc_</span>
                                    <input type="text" class="form-input form-input-with-prefix" placeholder="beneficial_owner_name" value="beneficial_owner_name">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">KYC Section <span class="text-red-500">*</span></label>
                                <select class="form-input">
                                    <option value="beneficial">Beneficial Owners</option>
                                    <option value="company">Company Information</option>
                                    <option value="board">Board Members</option>
                                    <option value="contact">Contact Person</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea class="form-input resize-y" rows="3" placeholder="Optional description for internal reference..."></textarea>
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
                                <select class="form-input">
                                    <option value="text">Text</option>
                                    <option value="date">Date</option>
                                    <option value="number">Number</option>
                                    <option value="email">Email</option>
                                    <option value="tel">Phone</option>
                                    <option value="file">File Upload</option>
                                    <option value="dropdown">Dropdown</option>
                                    <option value="textarea">Textarea</option>
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
                                <select class="form-input">
                                    <option value="normal">Normal</option>
                                    <option value="sensitive">Sensitive</option>
                                    <option value="highly-sensitive">Highly Sensitive</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Visibility Controls</label>
                                <div class="space-y-2.5">
                                    <label class="flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" checked class="w-4 h-4 border-gray-400 rounded text-blue-600">
                                        <span class="text-sm text-gray-700">Visible to Merchant</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 cursor-pointer">
                                        <input type="checkbox" checked class="w-4 h-4 border-gray-400 rounded text-blue-600">
                                        <span class="text-sm text-gray-700">Visible to Admin</span>
                                    </label>
                                    <label class="flex items-center gap-2.5 cursor-pointer opacity-50">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Visible to Partner</span>
                                        <i class="fa-solid fa-circle-question text-gray-400 text-xs"></i>
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
                                <input type="number" class="form-input" placeholder="100" value="100">
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium text-gray-700">Status</label>
                                <div class="toggle-switch active" id="status-toggle" onclick="toggleStatus()"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()" class="text-brand-primary font-medium hover:text-brand-secondary">Cancel</button>
                    <div class="flex gap-3">
                        <button class="border-2 border-brand-accent text-brand-accent px-5 py-2.5 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                            Save Draft
                        </button>
                        <button class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Field
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeDrawer()"></div>

        <script>
            function openDrawer() {
                document.getElementById('kyc-field-drawer').classList.remove('drawer-closed');
                document.getElementById('kyc-field-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function closeDrawer() {
                document.getElementById('kyc-field-drawer').classList.remove('drawer-open');
                document.getElementById('kyc-field-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
            }

            function toggleRequired() {
                const toggle = document.getElementById('required-toggle');
                toggle.classList.toggle('active');
            }

            function toggleStatus() {
                const toggle = document.getElementById('status-toggle');
                toggle.classList.toggle('active');
            }
        </script>

    </body>
@endsection
