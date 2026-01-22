<x-merchant.kyc>
    @push('css')
    
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #F7F8FA;
            }

            ::-webkit-scrollbar {
                width: 6px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            .step-item {
                display: flex;
                align-items: center;
                padding: 12px 24px;
                position: relative;
                font-size: 14px;
                color: #6B7280;
            }

            .step-item.completed {
                color: #2D3A74;
            }

            .step-item.active {
                background-color: #FFF8F0;
                color: #111827;
                font-weight: 600;
            }

            .step-item.active::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 4px;
                background-color: #FFA439;
            }

            .step-icon {
                width: 24px;
                text-align: center;
                margin-right: 12px;
                font-size: 16px;
            }

            .completed .step-icon {
                color: #28A745;
            }

            .active .step-icon {
                color: #FFA439;
                font-size: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 20px;
                width: 20px;
                border: 2px solid #FFA439;
                border-radius: 50%;
                background: #FFA439;
                color: white;
            }

            .pending .step-icon {
                color: #BFC4CC;
                font-size: 18px;
            }

            .form-checkbox {
                width: 18px;
                height: 18px;
                border-radius: 4px;
                border: 1px solid #D1D5DB;
                color: #2D3A74;
            }

            .form-input {
                width: 100%;
                border: 1px solid #D1D5DB;
                border-radius: 6px;
                padding: 10px 12px;
                font-size: 14px;
                transition: all 0.2s;
                outline: none;
            }

            .form-input:focus {
                border-color: #4055A8;
                box-shadow: 0 0 0 3px rgba(64, 85, 168, 0.1);
            }

            .form-label {
                display: block;
                font-size: 14px;
                font-weight: 500;
                color: #374151;
                margin-bottom: 6px;
            }

            .form-helper {
                font-size: 12px;
                color: #6B7280;
                margin-top: 4px;
            }

            .toggle-checkbox:checked {
                right: 0;
                border-color: #2D3A74;
            }

            .toggle-checkbox:checked+.toggle-label {
                background-color: #2D3A74;
            }
        </style>
    @endpush

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-[24px] font-semibold text-primary mb-2">Sales Channels</h1>
        <p class="text-gray-500">Select the types of sales channels your business uses to accept customer
            payments.</p>
    </div>
    <form id="sc-form">

        <!-- SALES CHANNELS CARD -->
        <div id="sales-channels-card" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">

            <!-- A. SALES CHANNEL SELECTION -->
            <div class="mb-10">
                <label class="block text-sm font-semibold text-primary mb-4">Sales Channel <span
                        class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <label
                        class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="channels" value="physical"
                            class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            onchange="toggleSection('physical-details', this.checked)">
                        <span class="ml-3 text-sm font-medium text-gray-700">Physical Store</span>
                    </label>

                    <label
                        class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="channels" value="online"
                            class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            onchange="toggleSection('online-details', this.checked)">
                        <span class="ml-3 text-sm font-medium text-gray-700">Online Store</span>
                    </label>

                    <label
                        class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="channels" value="mobile"
                            class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            onchange="toggleSection('mobile-details', this.checked)">
                        <span class="ml-3 text-sm font-medium text-gray-700">Mobile / App</span>
                    </label>

                    <label
                        class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="channels" value="invoices"
                            class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            onchange="toggleSection('invoice-details', this.checked)">
                        <span class="ml-3 text-sm font-medium text-gray-700">Invoices / Billing</span>
                    </label>

                    <label
                        class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="channels" value="recurring"
                            class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            onchange="toggleSection('recurring-details', this.checked)">
                        <span class="ml-3 text-sm font-medium text-gray-700">Recurring</span>
                    </label>

                    <label
                        class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="channels" value="marketplace"
                            class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            onchange="toggleSection('marketplace-details', this.checked)">
                        <span class="ml-3 text-sm font-medium text-gray-700">Marketplace</span>
                    </label>

                    <label
                        class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="checkbox" name="channels" value="other"
                            class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            onchange="toggleSection('other-details', this.checked)">
                        <span class="ml-3 text-sm font-medium text-gray-700">Other</span>
                    </label>
                </div>

                <!-- Other Specify -->
                <div id="other-details" class="hidden mt-4 pl-1">
                    <div class="max-w-md">
                        <label class="form-label">Specify Other Channel</label>
                        <input type="text" name="other_channel" class="form-input" placeholder="e.g. Telephone Sales">
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
                            <label class="form-label">Number of Physical Locations <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="physical_locations_count" id="physical-locations-count" class="form-input" placeholder="e.g. 5" min="1" onchange="updatePhysicalLocations(this.value)">
                        </div>
                    </div>

                    <div id="physical-locations-container">
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 mb-4 location-item" data-location="1">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="font-medium text-gray-700">Location #1</h4>
                                <button type="button" class="text-gray-400 hover:text-red-500" onclick="removeLocation(this)" style="display: none;"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <textarea name="physical_locations[0][address]" class="form-input h-24 resize-none" placeholder="Enter full address..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="text-accent font-medium hover:text-orange-600 text-sm flex items-center" onclick="addPhysicalLocation()">
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
                            <input type="url" name="website_url" class="form-input" placeholder="https://example.com" required>
                        </div>
                        <div>
                            <label class="form-label">Platform Used <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="online_platform" class="form-input appearance-none bg-white" required>
                                    <option value="" disabled selected>Select Platform</option>
                                    <option value="shopify">Shopify</option>
                                    <option value="woocommerce">WooCommerce</option>
                                    <option value="magento">Magento</option>
                                    <option value="custom">Custom</option>
                                    <option value="other">Other</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
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
                            <input type="text" name="app_name" class="form-input" placeholder="e.g. 2iZii Mobile">
                        </div>
                        <div>
                            <label class="form-label">App Platform</label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="app_platform" value="ios" class="text-accent focus:ring-accent">
                                    <span class="ml-2 text-sm text-gray-600">iOS</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="app_platform" value="android" class="text-accent focus:ring-accent">
                                    <span class="ml-2 text-sm text-gray-600">Android</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="app_platform" value="both" class="text-accent focus:ring-accent"
                                        checked>
                                    <span class="ml-2 text-sm text-gray-600">Both</span>
                                </label>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">App Store / Play Store URL</label>
                            <input type="url" name="app_store_url" class="form-input" placeholder="https://apps.apple.com/...">
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
                                <select name="billing_frequency" class="form-input appearance-none bg-white">
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Invoice System (Optional)</label>
                            <input type="text" name="invoice_system" class="form-input" placeholder="e.g. Xero, QuickBooks">
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
                                <select name="subscription_tool" class="form-input appearance-none bg-white">
                                    <option value="stripe">Stripe Billing</option>
                                    <option value="recurly">Recurly</option>
                                    <option value="chargebee">Chargebee</option>
                                    <option value="inhouse">In-house</option>
                                    <option value="other">Other</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
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
                                    <input type="radio" name="market_type" value="single" class="text-accent focus:ring-accent"
                                        checked>
                                    <span class="ml-2 text-sm text-gray-600">Single-vendor</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="market_type" value="multi" class="text-accent focus:ring-accent">
                                    <span class="ml-2 text-sm text-gray-600">Multi-vendor</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Escrow or Split Payments Used?</label>
                            <div class="flex items-center mt-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="escrow_split_payments" value="1" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                    </div>
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
                            <input type="number" name="sales_instore_percent" class="form-input pr-8" placeholder="0" min="0"
                                max="100" onchange="validatePercentages()" required>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">% of Sales from Online <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="sales_online_percent" class="form-input pr-8" placeholder="0" min="0"
                                max="100" onchange="validatePercentages()" required>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">% of Sales from Other Channels <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="sales_other_percent" class="form-input pr-8" placeholder="0" min="0"
                                max="100" onchange="validatePercentages()" required>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-brand-border px-12 py-4 z-30">
            <div class="max-w-[900px] mx-auto flex items-center justify-between">
                <a href="{{ route('merchant.kyc.purposeOfService') }}"
                    class="px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-4">
                    <button type="button" onclick="saveDraft()"
                        class="px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="fa-regular fa-floppy-disk text-sm"></i>
                        <span>Save as Draft</span>
                    </button>

                    <a href="{{ route('merchant.kyc.bankInformation') }}" id="continue-btn"
                        class="px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <span>Continue to Bank Information</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
        </footer>
    </form>

    @push('js')
        <script>
            let locationCounter = 1;

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

            function addPhysicalLocation() {
                locationCounter++;
                const container = document.getElementById('physical-locations-container');
                const newLocation = document.createElement('div');
                newLocation.className = 'bg-gray-50 rounded-lg p-5 border border-gray-200 mb-4 location-item';
                newLocation.setAttribute('data-location', locationCounter);
                newLocation.innerHTML = `
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-medium text-gray-700">Location #${locationCounter}</h4>
                        <button type="button" class="text-gray-400 hover:text-red-500" onclick="removeLocation(this)">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <textarea name="physical_locations[${locationCounter - 1}][address]" class="form-input h-24 resize-none" placeholder="Enter full address..." required></textarea>
                    </div>
                `;
                container.appendChild(newLocation);
                updateDeleteButtons();
            }

            function removeLocation(button) {
                const locationItem = button.closest('.location-item');
                locationItem.remove();
                reindexLocations();
                updateDeleteButtons();
            }

            function reindexLocations() {
                const locations = document.querySelectorAll('.location-item');
                locations.forEach((location, index) => {
                    const heading = location.querySelector('h4');
                    heading.textContent = `Location #${index + 1}`;
                    const textarea = location.querySelector('textarea');
                    textarea.name = `physical_locations[${index}][address]`;
                    location.setAttribute('data-location', index + 1);
                });
                locationCounter = locations.length;
            }

            function updateDeleteButtons() {
                const locations = document.querySelectorAll('.location-item');
                locations.forEach((location, index) => {
                    const deleteBtn = location.querySelector('button[onclick*="removeLocation"]');
                    if (deleteBtn) {
                        deleteBtn.style.display = locations.length > 1 ? 'block' : 'none';
                    }
                });
            }

            function updatePhysicalLocations(count) {
                const currentCount = document.querySelectorAll('.location-item').length;
                const targetCount = parseInt(count) || 1;

                if (targetCount > currentCount) {
                    for (let i = currentCount; i < targetCount; i++) {
                        addPhysicalLocation();
                    }
                } else if (targetCount < currentCount) {
                    const locations = document.querySelectorAll('.location-item');
                    for (let i = currentCount - 1; i >= targetCount; i--) {
                        locations[i].remove();
                    }
                    reindexLocations();
                }
                updateDeleteButtons();
            }

            function validatePercentages() {
                const instore = parseFloat(document.querySelector('input[name="sales_instore_percent"]').value) || 0;
                const online = parseFloat(document.querySelector('input[name="sales_online_percent"]').value) || 0;
                const other = parseFloat(document.querySelector('input[name="sales_other_percent"]').value) || 0;
                const total = instore + online + other;
                
                const inputs = document.querySelectorAll('input[name*="sales_"][name*="_percent"]');
                if (total !== 100 && total > 0) {
                    inputs.forEach(input => {
                        input.setCustomValidity(`Total must equal 100% (currently ${total}%)`);
                    });
                } else {
                    inputs.forEach(input => {
                        input.setCustomValidity('');
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('input[name="channels"]').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const anyChecked = Array.from(document.querySelectorAll('input[name="channels"]')).some(
                            cb => cb.checked);
                        const continueBtn = document.getElementById('continue-btn');
                        if (continueBtn) {
                            continueBtn.classList.toggle('opacity-50', !anyChecked);
                            continueBtn.classList.toggle('cursor-not-allowed', !anyChecked);
                            if (!anyChecked) {
                                continueBtn.style.pointerEvents = 'none';
                            } else {
                                continueBtn.style.pointerEvents = 'auto';
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</x-merchant.kyc>
