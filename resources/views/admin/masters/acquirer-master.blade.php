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
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .toggle-switch.inactive {
            background-color: #CBD5E1;
        }
        .toggle-switch.inactive::after {
            left: 4px;
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
                                <p class="text-sm text-gray-500">Manage acquirer configurations, API endpoints, and solution mappings.</p>
                            </div>
                            <button onclick="openDrawer()" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2 self-start md:self-auto">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Acquirer</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="relative w-full sm:w-[320px]">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Search acquirers..." class="form-input pl-10 bg-brand-neutral border-gray-200 w-full">
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-filter text-sm"></i>
                                    Filter
                                </button>
                                <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-download text-sm"></i>
                                    Export
                                </button>
                            </div>
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
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1">
                                            Acquirer Name
                                            <i class="fa-solid fa-arrow-up-down text-[10px]"></i>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mode</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Supported Solutions</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact / API</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-7">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Elavon</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated 2h ago</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-purple-100 text-purple-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Email</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">Elavon Card (POS)</span>
                                                <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">E-com</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-sm">kyc-requests@elavon.com</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-4">
                                                <button class="text-brand-secondary text-xs font-medium hover:underline">Edit</button>
                                                <button class="text-gray-400 text-xs hover:text-gray-600">View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-7">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Surfboard</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated 1d ago</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-medium">API</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">POS</span>
                                                <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">Mobile</span>
                                                <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">+2</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-xs font-mono">https://api.surfboard.com/v2</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-4">
                                                <button class="text-brand-secondary text-xs font-medium hover:underline">Edit</button>
                                                <button class="text-gray-400 text-xs hover:text-gray-600">View</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-7">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Global Payments</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated 3d ago</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-purple-100 text-purple-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Email</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">All</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-sm">onboarding@globalpay.com</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-red-100 text-red-700 px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                                Inactive
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-4">
                                                <button class="text-brand-secondary text-xs font-medium hover:underline">Edit</button>
                                                <button class="text-gray-400 text-xs hover:text-gray-600">View</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="text-xs text-gray-500">
                                    Showing <span class="font-medium text-gray-900">1</span> to <span class="font-medium text-gray-900">10</span> of <span class="font-medium text-gray-900">24</span> results
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-xs opacity-50 cursor-not-allowed flex items-center gap-1">
                                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                                        Previous
                                    </button>
                                    <button class="bg-brand-primary text-white px-3 py-1.5 rounded text-xs">1</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-xs hover:bg-gray-50">2</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-xs hover:bg-gray-50">3</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-xs hover:bg-gray-50 flex items-center gap-1">
                                        Next
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit Acquirer -->
        <div id="acquirer-drawer" class="fixed top-0 right-0 w-full max-w-[520px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-brand-primary">Add Acquirer</h2>
                    <button onclick="closeDrawer()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="space-y-8">
                        <!-- Acquirer Information Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Acquirer Information</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Acquirer Name <span class="text-red-500">*</span></label>
                                <input type="text" class="form-input" placeholder="e.g. Elavon">
                            </div>
                            
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mode <span class="text-red-500">*</span></label>
                                    <select class="form-input">
                                        <option value="email">Email</option>
                                        <option value="api">API</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                                    <div class="flex items-center gap-3 h-[38px]">
                                        <div class="toggle-switch" id="status-toggle" onclick="toggleStatus()"></div>
                                        <span class="text-sm text-gray-700 font-medium" id="status-label">Active</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea class="form-input resize-y" rows="3" placeholder="Brief description of the acquirer"></textarea>
                            </div>
                        </div>

                        <!-- Supported Countries Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Countries</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Countries</label>
                                <div class="border border-gray-200 rounded-lg p-2 flex flex-wrap gap-2 min-h-[42px]">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                                        🇺🇸 United States
                                        <button class="text-blue-600 hover:text-blue-800">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </span>
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                                        🇬🇧 United Kingdom
                                        <button class="text-blue-600 hover:text-blue-800">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </span>
                                    <input type="text" placeholder="Add country..." class="flex-1 min-w-[100px] border-0 outline-none text-xs bg-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Supported Solutions Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Solutions</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Solutions</label>
                                <div class="bg-white border border-gray-200 rounded-lg h-32 p-3 overflow-y-auto">
                                    <!-- Multi-select dropdown would go here -->
                                    <p class="text-sm text-gray-400">Select solutions...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Email Configuration Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Email Configuration</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Recipient(s) <span class="text-red-500">*</span></label>
                                <input type="email" class="form-input" placeholder="kyc@acquirer.com">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Subject Template <span class="text-red-500">*</span></label>
                                <input type="text" class="form-input" placeholder="KYC Application - {merchant_name}">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Body Template <span class="text-red-500">*</span></label>
                                <textarea class="form-input resize-y" rows="4" placeholder="Dear Team, Please find attached..."></textarea>
                            </div>
                            
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Attachment Format</label>
                                    <select class="form-input bg-gray-100">
                                        <option value="pdf">PDF</option>
                                        <option value="zip">ZIP</option>
                                    </select>
                                </div>
                                <div class="flex-1 flex items-end">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Secure Email Required</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Compliance Configuration Section -->
                        <div class="space-y-3">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Compliance Configuration</h3>
                            </div>
                            
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                <span class="text-sm text-gray-700">Requires Beneficial Owner Data</span>
                            </label>
                            
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                <span class="text-sm text-gray-700">Requires Board Member Data</span>
                            </label>
                            
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 border-gray-400 rounded" checked>
                                <span class="text-sm text-gray-700">Requires Signatories</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()" class="text-brand-primary font-medium hover:text-brand-primary/80">Cancel</button>
                    <div class="flex gap-3">
                        <button class="border-2 border-brand-accent text-brand-accent px-5 py-3 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                            Save Draft
                        </button>
                        <button class="bg-brand-accent text-white px-5 py-3 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Acquirer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay" class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeDrawer()"></div>

        <script>
            function openDrawer() {
                document.getElementById('acquirer-drawer').classList.remove('drawer-closed');
                document.getElementById('acquirer-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function closeDrawer() {
                document.getElementById('acquirer-drawer').classList.remove('drawer-open');
                document.getElementById('acquirer-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
            }

            function toggleStatus() {
                const toggle = document.getElementById('status-toggle');
                const label = document.getElementById('status-label');
                
                if (toggle.classList.contains('inactive')) {
                    toggle.classList.remove('inactive');
                    label.textContent = 'Active';
                } else {
                    toggle.classList.add('inactive');
                    label.textContent = 'Inactive';
                }
            }
        </script>

    </body>
@endsection
