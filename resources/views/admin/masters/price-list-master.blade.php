@extends('layouts.admin')

@section('title', 'Price List Master - 2iZii')

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
                        <div class="bg-white border border-gray-200 rounded-t-xl p-6 flex items-center justify-between">
                            <div class="relative w-[384px]">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Search price lists..." class="form-input pl-10 bg-white border-gray-200">
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
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">Standard EU Retail</div>
                                            <div class="text-xs text-gray-400 mt-0.5">EUR • Created by Admin</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#eff6ff] text-[#1d4ed8] px-2.5 py-0.5 rounded-full text-xs font-medium">Merchant Selling Price</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] text-[#475569] px-2 py-0.5 rounded text-xs font-medium flex items-center gap-1 w-fit">
                                                <i class="fa-solid fa-globe text-[10px]"></i>
                                                Global
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">
                                                <div>From: <span class="font-medium text-gray-900">Jan 01, 2024</span></div>
                                                <div class="text-xs text-gray-400 mt-0.5">To: Indefinite</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#f0fdf4] border border-[#dcfce7] text-[#28a745] px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit">
                                                <span class="w-1.5 h-1.5 bg-[#28a745] rounded-full"></span>
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
                                            <div class="font-medium text-brand-primary">Acquirer Cost - Chase US</div>
                                            <div class="text-xs text-gray-400 mt-0.5">USD • Created by System</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#faf5ff] text-[#7e22ce] px-2.5 py-0.5 rounded-full text-xs font-medium">Acquirer Cost</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="bg-[#f1f5f9] border border-[#e2e8f0] text-[#475569] px-2 py-0.5 rounded text-xs font-medium flex items-center gap-1 w-fit">
                                                    <i class="fa-solid fa-building text-[10px]"></i>
                                                    Chase
                                                </span>
                                                <span class="bg-[#f1f5f9] border border-[#e2e8f0] text-[#475569] px-2 py-0.5 rounded text-xs font-medium flex items-center gap-1 w-fit">
                                                    <i class="fa-solid fa-flag text-[10px]"></i>
                                                    US
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">
                                                <div>From: <span class="font-medium text-gray-900">Feb 01, 2024</span></div>
                                                <div class="text-xs text-gray-400 mt-0.5">To: Dec 31, 2024</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#fff7ed] border border-[#fed7aa] text-[#ea580c] px-2.5 py-0.5 rounded-full text-xs font-medium">Draft</span>
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
                                            <div class="font-medium text-brand-primary">Partner Kickback - TechReseller</div>
                                            <div class="text-xs text-gray-400 mt-0.5">GBP • Created by Admin</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#ecfdf5] text-[#047857] px-2.5 py-0.5 rounded-full text-xs font-medium">Partner Kickback</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] text-[#475569] px-2 py-0.5 rounded text-xs font-medium flex items-center gap-1 w-fit">
                                                <i class="fa-solid fa-handshake text-[10px]"></i>
                                                TechReseller
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">
                                                <div>From: <span class="font-medium text-gray-900">Mar 15, 2023</span></div>
                                                <div class="text-xs text-gray-400 mt-0.5">To: Indefinite</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-[#ececec] border border-[#d1d5db] text-[#64748b] px-2.5 py-0.5 rounded-full text-xs font-medium">Expired</span>
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
                            <div class="bg-white border-t border-gray-200 px-4 py-4 flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium text-gray-900">1</span> to <span class="font-medium text-gray-900">10</span> of <span class="font-medium text-gray-900">45</span> results
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

        <!-- Right Drawer for Add/Edit Price List -->
        <div id="price-list-drawer" class="fixed top-0 right-0 w-[600px] h-full bg-white shadow-2xl z-[60] drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-brand-primary">Add Price List</h2>
                    <button onclick="closeDrawer()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto bg-[#f7f8fa] p-6">
                    <div class="space-y-8">
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
                                    <input type="text" class="form-input" placeholder="e.g. Standard Merchant Pricing 2025">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1.5">
                                            Type <span class="text-red-500">*</span>
                                        </label>
                                        <select class="form-input">
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
                                        <select class="form-input">
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
                                <button onclick="addPriceLine()" class="text-[#4055a8] text-xs font-medium flex items-center gap-1 hover:text-[#2d3a74]">
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
                                                <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5">
                                                    <option>Visa Credit</option>
                                                    <option>Mastercard</option>
                                                    <option>Amex</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2">
                                                <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5">
                                                    <option>Card Present</option>
                                                    <option>Card Not Present</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" class="form-input text-sm py-1.5" placeholder="2.50" value="2.50">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" class="form-input text-sm py-1.5" placeholder="0.25" value="0.25">
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <button onclick="removePriceLine(this)" class="text-gray-400 hover:text-red-500">
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
                                    <input type="text" class="form-input bg-[#f7f8fa] border-gray-200" value="Dec 15, 2024" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()" class="text-[#4055a8] font-medium hover:text-[#2d3a74]">Cancel</button>
                    <div class="flex gap-3">
                        <button class="border-2 border-brand-accent text-brand-accent px-5 py-2.5 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                            Save Draft
                        </button>
                        <button class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Price List
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
            document.getElementById('price-list-drawer').classList.remove('drawer-closed');
            document.getElementById('price-list-drawer').classList.add('drawer-open');
            document.getElementById('drawer-overlay').classList.remove('hidden');
        }

        function closeDrawer() {
            document.getElementById('price-list-drawer').classList.remove('drawer-open');
            document.getElementById('price-list-drawer').classList.add('drawer-closed');
            document.getElementById('drawer-overlay').classList.add('hidden');
        }

        function setAssignmentLevel(button, level) {
            // Remove active class from all buttons
            document.querySelectorAll('.assignment-level-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            // Add active class to clicked button
            button.classList.add('active');
        }

        function addPriceLine() {
            const tbody = document.getElementById('price-lines-tbody');
            const newRow = document.createElement('tr');
            newRow.className = 'border-b border-[#ececec]';
            newRow.innerHTML = `
                <td class="px-3 py-2">
                    <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5">
                        <option>Visa Credit</option>
                        <option>Mastercard</option>
                        <option>Amex</option>
                    </select>
                </td>
                <td class="px-3 py-2">
                    <select class="form-input bg-[#efefef] border-gray-200 text-sm py-1.5">
                        <option>Card Present</option>
                        <option>Card Not Present</option>
                    </select>
                </td>
                <td class="px-3 py-2">
                    <input type="text" class="form-input text-sm py-1.5" placeholder="0.00">
                </td>
                <td class="px-3 py-2">
                    <input type="text" class="form-input text-sm py-1.5" placeholder="0.00">
                </td>
                <td class="px-3 py-2 text-center">
                    <button onclick="removePriceLine(this)" class="text-gray-400 hover:text-red-500">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
        }

        function removePriceLine(button) {
            button.closest('tr').remove();
        }
    </script>
@endpush
