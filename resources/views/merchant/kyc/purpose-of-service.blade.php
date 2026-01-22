<x-merchant.kyc>
    @push('css')
        <style>
            ::-webkit-scrollbar {
                display: none;
            }

            .toggle-checkbox:checked {
                right: 0;
                border-color: #2D3A74;
            }

            .toggle-checkbox:checked+.toggle-label {
                background-color: #2D3A74;
            }

            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
            }
        </style>
    @endpush


    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-[24px] font-semibold text-primary mb-2">Purpose of Service</h1>
        <p class="text-gray-600 text-sm max-w-2xl">
            Describe how you intend to use 2iZii’s payment services and provide details required by acquirers
            and regulatory bodies.
        </p>
    </header>

    <form id="ps-form" class="space-y-8" action="#" method="POST">

        <!-- 3. PURPOSE OF SERVICE CARD -->
        <section id="purpose-card" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 mb-24">

            <!-- A. SERVICE DESCRIPTION -->
            <div id="section-description">
                <x-input.textarea id="service-desc" label="Purpose of Payment Service" required rows="4" 
                    placeholder="Describe how your business plans to use the payment services..."
                    class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" />
            </div>

            <!-- B. PAYMENT SERVICE DETAILS -->
            <div id="section-payment-details" class="mt-2">
                <h3 class="text-sm font-semibold text-primary mb-4 uppercase tracking-wider opacity-80">Payment
                    Service Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Expected Monthly Transaction Volume -->
                    <div>
                        <div class="relative">
                            <x-input.select id="monthly-volume" label="Expected Monthly Transaction Volume" required placeholder="Select volume range"
                                class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white">
                                <option value="under-50k">Under 50,000 NOK</option>
                                <option value="50k-250k">50,000–250,000 NOK</option>
                                <option value="250k-1m">250,000–1,000,000 NOK</option>
                                <option value="above-1m">Above 1,000,000 NOK</option>
                            </x-input.select>
                        </div>
                    </div>

                    <!-- Expected Monthly Transaction Count -->
                    <div>
                        <x-input.number id="monthly-count" label="Expected Monthly Transaction Count" required 
                            placeholder="e.g., 120 transactions per month"
                            class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none" />
                    </div>

                    <!-- Average Transaction Size -->
                    <div>
                        <div class="relative">
                            <label for="avg-size" class="block text-sm font-medium text-gray-700 mb-1">
                                Average Transaction Size <span class="text-red-500">*</span>
                            </label>
                           
                            <x-input.number id="avg-size" required placeholder="e.g., 400"
                                class="w-full rounded-md border border-gray-300 pl-14 pr-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none" />
                        </div>
                    </div>

                    <!-- Maximum Transaction Size -->
                    <div>
                        <div class="relative">
                            <label for="max-size" class="block text-sm font-medium text-gray-700 mb-1">
                                Maximum Transaction Size <span class="text-red-500">*</span>
                            </label>
                            
                            <x-input.number id="max-size" required placeholder="e.g., 5000"
                                class="w-full rounded-md border border-gray-300 pl-14 pr-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- C. BUSINESS MODEL DETAILS -->
            <div id="section-business-model" class="mt-4">
                <h3 class="text-sm font-semibold text-primary mb-4 uppercase tracking-wider opacity-80">Business
                    Model Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

                    <!-- Business Model Type -->
                    <div>
                        <x-input.select id="business-model" label="Business Model Type" required placeholder="Select business model"
                            class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white">
                            <option value="retail">Retail</option>
                            <option value="fnb">Food & Beverage</option>
                            <option value="ecommerce">E-commerce</option>
                            <option value="services">Services</option>
                            <option value="subscription">Subscription</option>
                            <option value="marketplace">Marketplace</option>
                            <option value="other">Other</option>
                        </x-input.select>
                    </div>

                    <!-- Conditional 'Other' Input -->
                    <div id="other-specify-container" class="hidden">
                        <x-input.text id="other-model" label="Specify Other Model" required placeholder="Please specify"
                            class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none" />
                    </div>

                    <div class="hidden md:block"></div>

                    <!-- Toggles Container -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                        <!-- Recurring Billing Toggle -->
                        <div class="flex items-center justify-between border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div>
                                <span class="block text-sm font-medium text-gray-900">Recurring billing?</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Does your business provide
                                    subscription services?</span>
                            </div>
                            <div
                                class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="recurring" id="recurring"
                                    class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 transition-all duration-300" />
                                <label for="recurring"
                                    class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>

                        <!-- Store Card Info Toggle -->
                        <div
                            class="flex items-center justify-between border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div>
                                <span class="block text-sm font-medium text-gray-900">Store card
                                    information?</span>
                                <span class="block text-xs text-gray-500 mt-0.5">Required for compliance
                                    verification.</span>
                            </div>
                            <div
                                class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="store-card" id="store-card"
                                    class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 transition-all duration-300" />
                                <label for="store-card"
                                    class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- D. ADDITIONAL INFORMATION -->
            <div id="section-additional" class="mt-4">
                <div class="mb-2">
                    <span class="text-sm font-medium text-gray-700">Additional Notes</span>
                    <span class="text-gray-400 font-normal text-sm"> (optional)</span>
                </div>
                <x-input.textarea id="additional-notes" rows="3" placeholder="Any other details relevant to your application..."
                    class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors" />
            </div>
        </section>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.contactPerson') }}"
                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                    <button onclick="saveDraft()"
                        class="flex-1 sm:flex-none px-3 sm:px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="fa-regular fa-floppy-disk text-sm hidden sm:inline"></i>
                        <span>Draft</span>
                    </button>

                    <a href="{{ route('merchant.kyc.salesChannels') }}"
                        class="flex-1 sm:flex-none px-4 sm:px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-base">
                        <span>Continue</span>
                        <i class="fa-solid fa-arrow-right text-sm hidden sm:inline"></i>
                    </a>
                </div>
            </div>
        </footer>
    </form>
</x-merchant.kyc>
