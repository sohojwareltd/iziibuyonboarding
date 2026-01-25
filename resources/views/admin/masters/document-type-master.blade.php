@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Types Master - 2iZii</title>
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
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem;
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

        .form-input-disabled {
            background-color: #EFEFEF;
        }

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
    </style>
@endsection

@section('body')

    <body class="bg-brand-neutral">

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Document Types Master', 'url' => route('admin.masters.document-type-master')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">

                <!-- Page Content -->
                <div class="bg-brand-neutral p-4 md:p-8">
                    <div class="max-w-[1200px] mx-auto">
                        <!-- Page Title and Add Button -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-brand-primary mb-1">Document Types Master</h1>
                                <p class="text-sm text-gray-500">Configure allowable document types for merchant onboarding
                                    and validation.</p>
                            </div>
                            <button onclick="openDrawer()"
                                class="self-start md:self-auto bg-brand-accent text-white px-6 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Document Type</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-4 md:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="relative w-full sm:w-[384px]">
                                <i
                                    class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Search document types..."
                                    class="form-input pl-10 bg-white border-gray-200">
                            </div>
                            <div class="flex items-center gap-3 self-end sm:self-auto">
                                <button
                                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-filter text-sm"></i>
                                    Filters
                                </button>
                                <div class="h-8 w-[1px] bg-gray-200"></div>
                                <button class="text-gray-600 hover:text-brand-primary p-2">
                                    <i class="fa-solid fa-download text-base"></i>
                                </button>
                                <button class="text-gray-600 hover:text-brand-primary p-2">
                                    <i class="fa-solid fa-upload text-base"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" style="min-width: 900px;">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            <div class="flex items-center gap-1">
                                                <span>Document Name</span>
                                                <i class="fa-solid fa-chevron-up text-[10px] text-gray-400"></i>
                                            </div>
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            Category</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            <div class="leading-tight">
                                                <div>Allowed</div>
                                                <div>Types</div>
                                            </div>
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            Sensitivity</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            Required For</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <!-- Row 1: Passport -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                                    <span class="text-brand-primary font-bold text-xs">ID</span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Passport</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-sm">Identity Document</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1 mb-1">
                                                <span
                                                    class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium">PDF</span>
                                                <span
                                                    class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium">JPG</span>
                                                <span
                                                    class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium">PNG</span>
                                            </div>
                                            <div class="text-[10px] text-gray-400">Max 10 MB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Sensitive</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <span
                                                    class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">Elavon</span>
                                                <span
                                                    class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">Surfboard</span>
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">+3 more</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Active</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button class="text-gray-400 hover:text-brand-primary p-2">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-red-500 p-2">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 2: Business Registration -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-purple-100 rounded flex items-center justify-center">
                                                    <span class="text-purple-700 font-bold text-xs">BR</span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900 leading-tight">
                                                        <div>Business</div>
                                                        <div>Registration</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-600 text-sm leading-tight">
                                                <div>Company</div>
                                                <div>Registration</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1 mb-1">
                                                <span
                                                    class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium">PDF</span>
                                            </div>
                                            <div class="text-[10px] text-gray-400">Max 15 MB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium">Normal</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">All
                                                Solutions</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Active</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button class="text-gray-400 hover:text-brand-primary p-2">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-red-500 p-2">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 3: Bank Statement -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-teal-100 rounded flex items-center justify-center">
                                                    <span class="text-teal-700 font-bold text-xs">BK</span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Bank Statement</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-sm">Bank Verification</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1 mb-1">
                                                <span
                                                    class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium">PDF</span>
                                                <span
                                                    class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium">JPG</span>
                                            </div>
                                            <div class="text-[10px] text-gray-400">Max 5 MB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium leading-tight">
                                                <div>Highly</div>
                                                <div>Sensitive</div>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <span
                                                    class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">UK</span>
                                                <span
                                                    class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">NO</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-red-100 text-red-600 px-2.5 py-1 rounded-full text-xs font-medium">Inactive</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button class="text-gray-400 hover:text-brand-primary p-2">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button class="text-gray-400 hover:text-red-500 p-2">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>

                            <!-- Pagination -->
                            <div class="bg-gray-50 border-t border-gray-200 px-4 md:px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <div class="text-sm text-gray-500 text-center sm:text-left">
                                    Showing <span class="font-medium text-gray-900">1</span> to <span
                                        class="font-medium text-gray-900">3</span> of <span
                                        class="font-medium text-gray-900">3</span> entries
                                </div>
                                <div class="flex flex-wrap items-center justify-center gap-2">
                                    <button
                                        class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50 flex items-center gap-1">
                                        <i class="fa-solid fa-chevron-left text-xs"></i>
                                    </button>
                                    <button class="bg-brand-primary text-white px-3 py-1.5 rounded text-sm">1</button>
                                    <button
                                        class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">2</button>
                                    <button
                                        class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">3</button>
                                    <button
                                        class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50 flex items-center gap-1">
                                        <i class="fa-solid fa-chevron-right text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit Document Type -->
        <div id="document-type-drawer"
            class="fixed top-0 right-0 w-full max-w-[520px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="mb-2">
                        <h2 class="text-xl font-semibold text-brand-primary">Add Document Type</h2>
                        <p class="text-sm text-gray-500 mt-1">Configure new document type for validation</p>
                    </div>
                    <button onclick="closeDrawer()"
                        class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="space-y-8">
                        <!-- Basic Information Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Basic Information
                                </h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Document Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" class="form-input" placeholder="e.g., Passport, Business License">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span
                                        class="text-red-500">*</span></label>
                                <select class="form-input form-input-disabled">
                                    <option value="">Select category...</option>
                                    <option value="identity">Identity Document</option>
                                    <option value="company">Company Registration</option>
                                    <option value="bank">Bank Verification</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description <span
                                        class="text-gray-400 text-xs font-normal">(Optional)</span></label>
                                <textarea class="form-input resize-y" rows="3" placeholder="Brief description of this document type..."></textarea>
                            </div>
                        </div>

                        <!-- File Format & Size Rules Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">File Format & Size
                                    Rules</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Allowed File Types <span
                                        class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-2">
                                    <label
                                        class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">PDF</span>
                                    </label>
                                    <label
                                        class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">PNG</span>
                                    </label>
                                    <label
                                        class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">JPG</span>
                                    </label>
                                    <label
                                        class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">JPEG</span>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Max File Size <span
                                            class="text-red-500">*</span></label>
                                    <select class="form-input form-input-disabled">
                                        <option value="10">10 MB</option>
                                        <option value="15">15 MB</option>
                                        <option value="5">5 MB</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Pages <span
                                            class="text-gray-400 text-xs font-normal">(Optional)</span></label>
                                    <input type="number" class="form-input" placeholder="0" value="0">
                                </div>
                            </div>
                        </div>

                        <!-- Visibility & Sensitivity Controls Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Visibility &
                                    Sensitivity Controls</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sensitivity Level <span
                                        class="text-red-500">*</span></label>
                                <select class="form-input form-input-disabled">
                                    <option value="normal">Normal</option>
                                    <option value="sensitive">Sensitive</option>
                                    <option value="highly-sensitive">Highly Sensitive</option>
                                </select>
                            </div>

                            <div class="space-y-2.5">
                                <label class="flex items-center gap-2.5 cursor-pointer">
                                    <input type="checkbox" checked
                                        class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                    <span class="text-sm text-gray-700">Visible to Merchant</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer">
                                    <input type="checkbox" checked
                                        class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600">
                                    <span class="text-sm text-gray-700">Visible to Admin</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer">
                                    <input type="checkbox" class="w-3.5 h-3.5 border-gray-400 rounded">
                                    <span class="text-sm text-gray-700">Mask Metadata When Viewed</span>
                                </label>
                            </div>
                        </div>

                        <!-- Required For (Dynamic Mapping) Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Required For
                                    (Dynamic Mapping)</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Acquirer <span
                                        class="text-gray-400 text-xs font-normal">(Multi-select)</span></label>
                                <select multiple class="form-input h-24">
                                    <option value="elavon">Elavon</option>
                                    <option value="surfboard">Surfboard</option>
                                    <option value="stripe">Stripe</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country <span
                                        class="text-gray-400 text-xs font-normal">(Multi-select)</span></label>
                                <select multiple class="form-input h-24">
                                    <option value="uk">United Kingdom</option>
                                    <option value="no">Norway</option>
                                    <option value="us">United States</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Solution <span
                                        class="text-gray-400 text-xs font-normal">(Multi-select)</span></label>
                                <select multiple class="form-input h-24">
                                    <option value="pos">POS</option>
                                    <option value="ecommerce">E-commerce</option>
                                    <option value="mobile">Mobile App</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">KYC Section</label>
                                <select class="form-input form-input-disabled">
                                    <option value="">Select section...</option>
                                    <option value="company">Company Information</option>
                                    <option value="beneficial">Beneficial Owners</option>
                                    <option value="board">Board Members</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status & Notes Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status & Notes</h3>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-gray-700">Status <span
                                            class="text-red-500">*</span></div>
                                    <div class="text-xs text-gray-500">Activate this document type</div>
                                </div>
                                <div class="toggle-switch" id="status-toggle" onclick="toggleStatus()"></div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Internal Notes <span
                                        class="text-gray-400 text-xs font-normal">(Optional)</span></label>
                                <textarea class="form-input resize-y" rows="2" placeholder="For compliance team usage only..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()"
                        class="text-brand-secondary font-medium hover:text-brand-primary flex items-center gap-2">
                        <i class="fa-solid fa-xmark text-sm"></i>
                        <span>Cancel</span>
                    </button>
                    <button
                        class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-check text-sm"></i>
                        <span>Save Document Type</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay" class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeDrawer()"></div>

        <script>
            function openDrawer() {
                document.getElementById('document-type-drawer').classList.remove('drawer-closed');
                document.getElementById('document-type-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function closeDrawer() {
                document.getElementById('document-type-drawer').classList.remove('drawer-open');
                document.getElementById('document-type-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
            }

            function toggleStatus() {
                const toggle = document.getElementById('status-toggle');
                toggle.classList.toggle('inactive');
            }
        </script>

    </body>
@endsection
