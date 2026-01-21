@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Channels - 2iZii Admin Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.plot.ly/plotly-3.1.1.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2D3A74',
                        accent: '#FFA439',
                        success: '#28A745',
                        neutral: '#F7F8FA',
                        border: '#D1D5DB',
                        focus: '#4055A8',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F8FA; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .step-item { display: flex; align-items: center; padding: 12px 24px; position: relative; font-size: 14px; color: #6B7280; }
        .step-item.completed { color: #2D3A74; }
        .step-item.active { background-color: #FFF8F0; color: #111827; font-weight: 600; }
        .step-item.active::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background-color: #FFA439; }
        
        .step-icon { width: 24px; text-align: center; margin-right: 12px; font-size: 16px; }
        .completed .step-icon { color: #28A745; }
        .active .step-icon { color: #FFA439; font-size: 10px; display: flex; align-items: center; justify-content: center; height: 20px; width: 20px; border: 2px solid #FFA439; border-radius: 50%; background: #FFA439; color: white; }
        .pending .step-icon { color: #BFC4CC; font-size: 18px; }

        .form-checkbox { width: 18px; height: 18px; border-radius: 4px; border: 1px solid #D1D5DB; color: #2D3A74; }
        .form-input { width: 100%; border: 1px solid #D1D5DB; border-radius: 6px; padding: 10px 12px; font-size: 14px; transition: all 0.2s; outline: none; }
        .form-input:focus { border-color: #4055A8; box-shadow: 0 0 0 3px rgba(64, 85, 168, 0.1); }
        .form-label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-helper { font-size: 12px; color: #6B7280; margin-top: 4px; }
        
        .toggle-checkbox:checked { right: 0; border-color: #2D3A74; }
        .toggle-checkbox:checked + .toggle-label { background-color: #2D3A74; }
    </style>
@endsection

@section('body')
<body class="text-primary h-screen flex overflow-hidden">

    <x-merchant.kyc-stepper :active="6" />

    <!-- MAIN CONTENT AREA -->
    <main id="main-content" class="flex-1 overflow-y-auto bg-[#F7F8FA] relative">
        <!-- Scrollable Form Area -->
        <div class="max-w-4xl mx-auto p-8 pb-32">
                
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-[24px] font-semibold text-primary mb-2">Sales Channels</h1>
                    <p class="text-gray-500">Select the types of sales channels your business uses to accept customer payments.</p>
                </div>

                <!-- SALES CHANNELS CARD -->
                <div id="sales-channels-card" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    
                    <!-- A. SALES CHANNEL SELECTION -->
                    <div class="mb-10">
                        <label class="block text-sm font-semibold text-primary mb-4">Sales Channel <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" name="channels" value="physical" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent" onchange="toggleSection('physical-details', this.checked)">
                                <span class="ml-3 text-sm font-medium text-gray-700">Physical Store</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" name="channels" value="online" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent" onchange="toggleSection('online-details', this.checked)">
                                <span class="ml-3 text-sm font-medium text-gray-700">Online Store</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" name="channels" value="mobile" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent" onchange="toggleSection('mobile-details', this.checked)">
                                <span class="ml-3 text-sm font-medium text-gray-700">Mobile / App</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" name="channels" value="invoices" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent" onchange="toggleSection('invoice-details', this.checked)">
                                <span class="ml-3 text-sm font-medium text-gray-700">Invoices / Billing</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" name="channels" value="recurring" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent" onchange="toggleSection('recurring-details', this.checked)">
                                <span class="ml-3 text-sm font-medium text-gray-700">Recurring</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" name="channels" value="marketplace" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent" onchange="toggleSection('marketplace-details', this.checked)">
                                <span class="ml-3 text-sm font-medium text-gray-700">Marketplace</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="checkbox" name="channels" value="other" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent" onchange="toggleSection('other-details', this.checked)">
                                <span class="ml-3 text-sm font-medium text-gray-700">Other</span>
                            </label>
                        </div>
                        
                        <!-- Other Specify -->
                        <div id="other-details" class="hidden mt-4 pl-1">
                             <div class="max-w-md">
                                <label class="form-label">Specify Other Channel</label>
                                <input type="text" class="form-input" placeholder="e.g. Telephone Sales">
                             </div>
                        </div>
                    </div>

                    <!-- B. SALES CHANNEL DETAILS (Conditional) -->
                    <div id="conditional-fields-container" class="space-y-8 border-t border-gray-100 pt-8 mt-8 hidden">
                        
                        <!-- Physical Store Details -->
                        <div id="physical-details" class="hidden animate-fade-in">
                            <h3 class="text-lg font-semibold text-primary mb-4 flex items-center">
                                <i class="fa-solid fa-store mr-2 text-accent"></i> Physical Store Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="form-label">Number of Physical Locations <span class="text-red-500">*</span></label>
                                    <input type="number" class="form-input" placeholder="e.g. 5">
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 mb-4">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="font-medium text-gray-700">Location #1</h4>
                                    <button class="text-gray-400 hover:text-red-500"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <textarea class="form-input h-24 resize-none" placeholder="Enter full address..."></textarea>
                                </div>
                            </div>
                            
                            <button class="text-accent font-medium hover:text-orange-600 text-sm flex items-center">
                                <i class="fa-solid fa-plus mr-2"></i> Add another location
                            </button>
                        </div>

                        <!-- Online Store Details -->
                        <div id="online-details" class="hidden animate-fade-in">
                            <h3 class="text-lg font-semibold text-primary mb-4 flex items-center">
                                <i class="fa-solid fa-globe mr-2 text-accent"></i> Online Store Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Website URL <span class="text-red-500">*</span></label>
                                    <input type="url" class="form-input" placeholder="https://example.com">
                                </div>
                                <div>
                                    <label class="form-label">Platform Used <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select class="form-input appearance-none bg-white">
                                            <option value="" disabled selected>Select Platform</option>
                                            <option value="shopify">Shopify</option>
                                            <option value="woocommerce">WooCommerce</option>
                                            <option value="magento">Magento</option>
                                            <option value="custom">Custom</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile App Details -->
                        <div id="mobile-details" class="hidden animate-fade-in">
                            <h3 class="text-lg font-semibold text-primary mb-4 flex items-center">
                                <i class="fa-solid fa-mobile-screen mr-2 text-accent"></i> Mobile App Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">App Name</label>
                                    <input type="text" class="form-input" placeholder="e.g. 2iZii Mobile">
                                </div>
                                <div>
                                    <label class="form-label">App Platform</label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="app_platform" class="text-accent focus:ring-accent">
                                            <span class="ml-2 text-sm text-gray-600">iOS</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="app_platform" class="text-accent focus:ring-accent">
                                            <span class="ml-2 text-sm text-gray-600">Android</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="app_platform" class="text-accent focus:ring-accent" checked>
                                            <span class="ml-2 text-sm text-gray-600">Both</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">App Store / Play Store URL</label>
                                    <input type="url" class="form-input" placeholder="https://apps.apple.com/...">
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Details -->
                        <div id="invoice-details" class="hidden animate-fade-in">
                            <h3 class="text-lg font-semibold text-primary mb-4 flex items-center">
                                <i class="fa-solid fa-file-invoice-dollar mr-2 text-accent"></i> Invoice Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Billing Frequency</label>
                                    <div class="relative">
                                        <select class="form-input appearance-none bg-white">
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Quarterly</option>
                                            <option>Yearly</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Invoice System (Optional)</label>
                                    <input type="text" class="form-input" placeholder="e.g. Xero, QuickBooks">
                                </div>
                            </div>
                        </div>

                        <!-- Recurring Details -->
                        <div id="recurring-details" class="hidden animate-fade-in">
                            <h3 class="text-lg font-semibold text-primary mb-4 flex items-center">
                                <i class="fa-solid fa-rotate mr-2 text-accent"></i> Subscription Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Subscription Tool Used</label>
                                    <div class="relative">
                                        <select class="form-input appearance-none bg-white">
                                            <option>Stripe Billing</option>
                                            <option>Recurly</option>
                                            <option>Chargebee</option>
                                            <option>In-house</option>
                                            <option>Other</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Marketplace Details -->
                        <div id="marketplace-details" class="hidden animate-fade-in">
                            <h3 class="text-lg font-semibold text-primary mb-4 flex items-center">
                                <i class="fa-solid fa-shop mr-2 text-accent"></i> Marketplace Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Marketplace Type</label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="market_type" class="text-accent focus:ring-accent" checked>
                                            <span class="ml-2 text-sm text-gray-600">Single-vendor</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="market_type" class="text-accent focus:ring-accent">
                                            <span class="ml-2 text-sm text-gray-600">Multi-vendor</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label">Escrow or Split Payments Used?</label>
                                    <div class="flex items-center mt-2">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- C. AVERAGE CHANNEL BREAKDOWN -->
                    <div class="border-t border-gray-100 pt-8 mt-8">
                        <h3 class="text-lg font-semibold text-primary mb-4 flex items-center">
                            <i class="fa-solid fa-chart-pie mr-2 text-accent"></i> Average Channel Breakdown
                        </h3>
                        <p class="text-sm text-gray-500 mb-4 flex items-center">
                            <i class="fa-solid fa-circle-info text-accent mr-2"></i>
                            Percentages must total 100%
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="form-label">% of Sales from In-Store <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" class="form-input pr-8" placeholder="0" min="0" max="100">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">% of Sales from Online <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" class="form-input pr-8" placeholder="0" min="0" max="100">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">% of Sales from Other Channels <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" class="form-input pr-8" placeholder="0" min="0" max="100">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- FOOTER BUTTON ROW -->
        <footer id="footer" class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-gray-200 px-8 py-5 flex items-center justify-between z-30">
            <div class="max-w-4xl mx-auto flex items-center justify-between w-full">
                <a href="{{ route('merchant.kyc.purposeOfService') }}" class="text-primary font-medium hover:underline flex items-center text-sm">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back
                </a>
                <div class="flex items-center gap-4">
                    <button class="px-6 py-2.5 border-2 border-accent text-accent font-medium rounded-lg hover:bg-orange-50 transition-colors">
                        Save Draft
                    </button>
                    <a href="{{ route('merchant.kyc.bankInformation') }}" class="px-6 py-2.5 bg-accent text-white font-medium rounded-lg hover:bg-orange-500 transition-colors flex items-center">
                        Continue to Bank Information <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </footer>

    </main>

    <script>
        function toggleSection(sectionId, show) {
            const section = document.getElementById(sectionId);
            const container = document.getElementById('conditional-fields-container');
            
            if (show) {
                section.classList.remove('hidden');
                container.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
                
                const visibleSections = container.querySelectorAll('[id$="-details"]:not(.hidden)');
                if (visibleSections.length === 0) {
                    container.classList.add('hidden');
                }
            }
        }

        document.querySelectorAll('input[name="channels"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const anyChecked = Array.from(document.querySelectorAll('input[name="channels"]')).some(cb => cb.checked);
                const continueBtn = document.querySelector('#footer-actions a:last-child');
                continueBtn.classList.toggle('opacity-50', !anyChecked);
                continueBtn.classList.toggle('cursor-not-allowed', !anyChecked);
            });
        });
    </script>

</body>
@endsection
