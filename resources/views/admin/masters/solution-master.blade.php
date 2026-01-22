@extends('layouts.admin')

@section('title', 'Solution Master - 2iZii')

@section('body')

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Solution Master', 'url' => route('admin.masters.solution-master')],
        ]"   />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral">
            <div class="p-8">
            
                <!-- Page Content -->
                <div class="bg-brand-neutral p-8">
                    <div class="max-w-[1280px] mx-auto">
                        <!-- Page Title and Add Button -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h1 class="text-2xl font-semibold text-brand-primary mb-1">Solution Master</h1>
                                <p class="text-sm text-gray-500">Manage and configure merchant solutions, acquirers, and payment methods.</p>
                            </div>
                            <button onclick="openDrawer()" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Solution</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-4 flex items-center justify-between">
                            <div class="relative w-[384px]">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Search solutions..." class="form-input pl-10 bg-brand-neutral border-gray-200">
                            </div>
                            <div class="flex gap-3">
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
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Solution Name</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Country</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acquirers</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Elavon Card Present POS - NL</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated 2h ago</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-medium">POS</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">NL</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">Elavon</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                                Active
                                            </span>
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
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">E-com Global</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated 1d ago</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-purple-100 text-purple-700 px-2.5 py-0.5 rounded-full text-xs font-medium">E-commerce</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">—</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">Stripe, Adyen</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                                Active
                                            </span>
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
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Legacy Mobile App</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated 2mo ago</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-orange-100 text-orange-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Mobile App</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <img src="http://localhost:3845/assets/4a568b93e5ff17914d2d7bb4fc6a6c090ef0311f.svg" alt="Flags" class="h-6">
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">Worldpay</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-red-100 text-red-700 px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                                Inactive
                                            </span>
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
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Marketplace Connect</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated 5d ago</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-teal-100 text-teal-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Marketplace</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">—</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">Stripe Connect</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                                Active
                                            </span>
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

                            <!-- Pagination -->
                            <div class="bg-white border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium text-gray-900">1</span> to <span class="font-medium text-gray-900">10</span> of <span class="font-medium text-gray-900">42</span> results
                                </div>
                                <div class="flex items-center gap-2">
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm opacity-50 cursor-not-allowed">Previous</button>
                                    <button class="bg-brand-primary text-white px-3 py-1.5 rounded text-sm">1</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">2</button>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">3</button>
                                    <span class="text-gray-400 px-2">...</span>
                                    <button class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit Solution -->
        <div id="solution-drawer" class="fixed top-0 right-0 w-[480px] h-full bg-white shadow-2xl z-[60] drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-brand-primary">Add New Solution</h2>
                    <button onclick="closeDrawer()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="space-y-8">
                        <!-- Solution Information Section -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Solution Information</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Solution Name <span class="text-red-500">*</span></label>
                                <input type="text" class="form-input" placeholder="e.g. Retail POS Standard">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                                <select class="form-input">
                                    <option value="">Select category</option>
                                    <option value="pos">POS</option>
                                    <option value="ecommerce">E-commerce</option>
                                    <option value="mobile">Mobile App</option>
                                    <option value="marketplace">Marketplace</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea class="form-input resize-y" rows="3" placeholder="Brief description of the solution..."></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                                <div class="border border-gray-200 rounded-lg p-2 flex flex-wrap gap-2 min-h-[42px]">
                                    <span class="bg-brand-neutral text-gray-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                                        Retail
                                        <button class="text-gray-500 hover:text-gray-700">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </span>
                                    <span class="bg-brand-neutral text-gray-700 px-2 py-1 rounded text-xs flex items-center gap-1">
                                        Payment
                                        <button class="text-gray-500 hover:text-gray-700">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </span>
                                    <input type="text" placeholder="Add tag..." class="flex-1 min-w-[80px] border-0 outline-none text-xs bg-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Select Country Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Country <span class="text-red-500">*</span></label>
                            <select class="form-input">
                                <option value="">Select country...</option>
                                <option value="nl">Netherlands</option>
                                <option value="uk">United Kingdom</option>
                                <option value="no">Norway</option>
                            </select>
                        </div>

                        <!-- Supported Acquirers Section -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Supported Acquirers</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Acquirers <span class="text-red-500">*</span></label>
                                <div class="border border-gray-200 rounded-lg p-3 max-h-48 overflow-y-auto space-y-2">
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Elavon</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Surfboard</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Stripe</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">AIB Merchant Services</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Supported Payment Methods Section -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Supported Payment Methods</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Cards</label>
                                    <div class="flex gap-2 flex-wrap">
                                        <label class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Visa</span>
                                        </label>
                                        <label class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Mastercard</span>
                                        </label>
                                        <label class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Amex</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alternative Methods</label>
                                    <div class="flex gap-2 flex-wrap">
                                        <label class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Vipps</span>
                                        </label>
                                        <label class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">MobilePay</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Solution Requirements Section -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Solution Requirements <span class="text-gray-400 font-normal normal-case">(Optional)</span></h3>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </button>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Required Documents</label>
                                    <div class="bg-white border border-gray-200 rounded-lg h-24"></div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Default Pricing Plan</label>
                                    <select class="form-input">
                                        <option value="">Select pricing plan</option>
                                        <option value="standard">Standard</option>
                                        <option value="premium">Premium</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()" class="text-gray-600 font-medium hover:text-gray-800">Cancel</button>
                    <div class="flex gap-3">
                        <button class="border-2 border-brand-accent text-brand-accent px-5 py-3 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                            Save Draft
                        </button>
                        <button class="bg-brand-accent text-white px-5 py-3 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Solution
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay" class="fixed top-0 left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-[55] hidden" onclick="closeDrawer()"></div>
@endsection

@push('scripts')
    <script>
        function openDrawer() {
            document.getElementById('solution-drawer').classList.remove('drawer-closed');
            document.getElementById('solution-drawer').classList.add('drawer-open');
            document.getElementById('drawer-overlay').classList.remove('hidden');
        }

        function closeDrawer() {
            document.getElementById('solution-drawer').classList.remove('drawer-open');
            document.getElementById('solution-drawer').classList.add('drawer-closed');
            document.getElementById('drawer-overlay').classList.add('hidden');
        }
    </script>
@endpush
