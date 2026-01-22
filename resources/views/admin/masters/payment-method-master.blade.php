@extends('layouts.admin')

@section('title', 'Payment Method Master - 2iZii')

@push('head')
    <style>
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
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .toggle-switch.inactive {
            background-color: #E5E7EB;
        }
        .toggle-switch.inactive::after {
            left: 2px;
        }
    </style>
@endpush

@section('body')

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Payment Method Master', 'url' => route('admin.masters.payment-method-master')],
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
                                <h1 class="text-2xl font-semibold text-brand-primary mb-1">Payment Method Master</h1>
                                <p class="text-sm text-gray-500">Manage all payment methods, cards, and wallets available on the platform.</p>
                            </div>
                            <button onclick="openDrawer()" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Payment Method</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div class="bg-white border border-gray-200 rounded-t-xl p-5 flex items-center justify-between">
                            <div class="relative w-[384px]">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Search payment methods..." class="form-input pl-10 bg-brand-neutral border-gray-200">
                            </div>
                            <button class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-filter text-sm"></i>
                                Filters
                            </button>
                        </div>

                        <!-- Table -->
                        <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Payment Method</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Country</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Acquirers</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Solutions</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-6 bg-gray-100 border border-gray-200 rounded flex items-center justify-center">
                                                    <i class="fa-brands fa-cc-visa text-blue-600 text-lg"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Visa</div>
                                                    <div class="text-xs text-gray-400">Visa Card Payments</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Card</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600 text-sm">UK</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">Elavon</span>
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">Surfboard</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">POS</span>
                                                <span class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">E-com</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Active</span>
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
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-6 bg-gray-100 border border-gray-200 rounded flex items-center justify-center">
                                                    <i class="fa-brands fa-cc-mastercard text-red-600 text-lg"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Mastercard</div>
                                                    <div class="text-xs text-gray-400">Mastercard Payments</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Card</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-400">—</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">Elavon</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">POS</span>
                                                <span class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">E-com</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Active</span>
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
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-6 bg-orange-50 border border-orange-200 rounded flex items-center justify-center">
                                                    <span class="text-orange-600 font-bold text-xs">Vipps</span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Vipps</div>
                                                    <div class="text-xs text-gray-400">Vipps Mobile Pay</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-purple-100 text-purple-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Wallet</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <img src="http://localhost:3845/assets/1a8da1778248920c5e036fc9b8e7651d8a32e25e.svg" alt="Flags" class="h-5">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">Surfboard</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-1 flex-wrap">
                                                <span class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">E-com</span>
                                                <span class="border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs">Mobile</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-red-100 text-red-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Inactive</span>
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
                            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-between">
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

        <!-- Right Drawer for Add/Edit Payment Method -->
        <div id="payment-method-drawer" class="fixed top-0 right-0 w-[520px] h-full bg-white shadow-2xl z-[60] drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <!-- Drawer Header -->
                <div class="border-b border-gray-200 px-6 py-5 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-brand-primary">Add Payment Method</h2>
                    <button onclick="closeDrawer()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="space-y-8">
                        <!-- Basic Information Section -->
                        <div class="space-y-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Basic Information</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method Name <span class="text-red-500">*</span></label>
                                <input type="text" class="form-input" placeholder="e.g. Visa">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Display Label <span class="text-red-500">*</span></label>
                                <input type="text" class="form-input" placeholder="e.g. Visa Card Payments">
                                <p class="text-xs text-gray-500 mt-1">Visible to merchants during onboarding</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                                <select class="form-input">
                                    <option value="card">Card</option>
                                    <option value="wallet">Wallet</option>
                                    <option value="bank">Bank Transfer</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea class="form-input resize-y" rows="3"></textarea>
                            </div>
                        </div>

                        <!-- Supported Country Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Country</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Countries</label>
                                <div class="border border-gray-200 rounded-lg p-2 flex flex-wrap gap-2 min-h-[42px]">
                                    <input type="text" placeholder="Add country..." class="flex-1 min-w-[120px] border-0 outline-none text-sm bg-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Supported Acquirers Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Acquirers</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="border border-gray-200 rounded-lg p-3">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded mt-0.5">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900 text-sm mb-2">Elavon</div>
                                            <div class="flex gap-4 ml-7">
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" class="w-3 h-3 border-gray-400 rounded">
                                                    <span class="text-xs text-gray-600">Online</span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" class="w-3 h-3 border-gray-400 rounded">
                                                    <span class="text-xs text-gray-600">POS</span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" class="w-3 h-3 border-gray-400 rounded">
                                                    <span class="text-xs text-gray-600">Recurring</span>
                                                </label>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="border border-gray-200 rounded-lg p-3">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 border-gray-400 rounded mt-0.5">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900 text-sm mb-2">Surfboard</div>
                                            <div class="flex gap-4 ml-7">
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" class="w-3 h-3 border-gray-400 rounded">
                                                    <span class="text-xs text-gray-600">Online</span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" class="w-3 h-3 border-gray-400 rounded">
                                                    <span class="text-xs text-gray-600">POS</span>
                                                </label>
                                                <label class="flex items-center gap-2 cursor-pointer">
                                                    <input type="checkbox" class="w-3 h-3 border-gray-400 rounded">
                                                    <span class="text-xs text-gray-600">Recurring</span>
                                                </label>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Supported Solutions Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Supported Solutions</h3>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <label class="border border-gray-200 rounded-lg p-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                    <span class="text-sm text-gray-900">POS</span>
                                </label>
                                <label class="border border-gray-200 rounded-lg p-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                    <span class="text-sm text-gray-900">E-commerce</span>
                                </label>
                                <label class="border border-gray-200 rounded-lg p-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                    <span class="text-sm text-gray-900">Marketplace</span>
                                </label>
                                <label class="border border-gray-200 rounded-lg p-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                    <span class="text-sm text-gray-900">Mobile App</span>
                                </label>
                                <label class="border border-gray-200 rounded-lg p-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
                                    <span class="text-sm text-gray-900">Recurring Billing</span>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Method Details Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Payment Method Details</h3>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Scheme</label>
                                <select class="form-input">
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">Mastercard</option>
                                    <option value="amex">Amex</option>
                                </select>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                                <span class="text-sm text-gray-700 font-medium">Supports 3DS</span>
                                <div class="toggle-switch inactive" onclick="toggle3DS()"></div>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                                <span class="text-sm text-gray-700 font-medium">Allows Tokenization</span>
                                <div class="toggle-switch inactive" onclick="toggleTokenization()"></div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Status</h3>
                            </div>
                            
                            <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-1">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Active Status</div>
                                        <div class="text-xs text-gray-500">Enable this payment method</div>
                                    </div>
                                    <div class="toggle-switch" id="status-toggle" onclick="toggleStatus()"></div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                                <textarea class="form-input resize-y" rows="2" placeholder="Add any notes or reason..."></textarea>
                            </div>
                        </div>

                        <!-- Compliance Tags Section -->
                        <div class="space-y-3 border-t border-gray-200 pt-4">
                            <div class="pb-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Compliance Tags</h3>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                                <span class="text-sm text-gray-700">Requires Additional Documents</span>
                                <div class="toggle-switch inactive" onclick="toggleCompliance('docs')"></div>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                                <span class="text-sm text-gray-700">Requires Acquirer Configuration</span>
                                <div class="toggle-switch inactive" onclick="toggleCompliance('acquirer')"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()" class="text-brand-secondary font-medium hover:text-brand-primary">Cancel</button>
                    <div class="flex gap-3">
                        <button class="border-2 border-brand-accent text-brand-accent px-5 py-2.5 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                            Save Draft
                        </button>
                        <button class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Payment Method
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
            document.getElementById('payment-method-drawer').classList.remove('drawer-closed');
            document.getElementById('payment-method-drawer').classList.add('drawer-open');
            document.getElementById('drawer-overlay').classList.remove('hidden');
        }

        function closeDrawer() {
            document.getElementById('payment-method-drawer').classList.remove('drawer-open');
            document.getElementById('payment-method-drawer').classList.add('drawer-closed');
            document.getElementById('drawer-overlay').classList.add('hidden');
        }

        function toggleStatus() {
            const toggle = document.getElementById('status-toggle');
            toggle.classList.toggle('inactive');
        }

        function toggle3DS() {
            event.target.classList.toggle('inactive');
        }

        function toggleTokenization() {
            event.target.classList.toggle('inactive');
        }

        function toggleCompliance(type) {
            event.target.classList.toggle('inactive');
        }
    </script>
@endpush
