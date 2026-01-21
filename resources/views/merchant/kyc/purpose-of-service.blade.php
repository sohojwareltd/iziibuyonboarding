@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purpose of Service - 2iZii KYC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2D3A74',
                        accent: '#4055A8',
                        cta: '#FFA439',
                        success: '#28A745',
                        bg: '#F7F8FA',
                        input: '#D1D5DB',
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        ::-webkit-scrollbar { display: none; }
        .toggle-checkbox:checked {
            right: 0;
            border-color: #2D3A74;
        }
        .toggle-checkbox:checked + .toggle-label {
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
@endsection

@section('body')
<body class="text-primary h-screen flex overflow-hidden">

    <!-- 1. LEFT-SIDE KYC STEPPER -->
    <x-merchant.kyc-stepper :active="5" />

    <!-- 2. MAIN CONTENT AREA -->
    <main id="main-content" class="flex-1 overflow-y-auto bg-bg relative">
        <div class="max-w-5xl mx-auto p-10 pb-32 w-full">
            
            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-[24px] font-semibold text-primary mb-2">Purpose of Service</h1>
                <p class="text-gray-600 text-sm max-w-2xl">
                    Describe how you intend to use 2iZii’s payment services and provide details required by acquirers and regulatory bodies.
                </p>
            </header>

            <!-- 3. PURPOSE OF SERVICE CARD -->
            <section id="purpose-card" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 mb-24">
                
                <form id="purpose-form" class="space-y-8">
                    
                    <!-- A. SERVICE DESCRIPTION -->
                    <div id="section-description">
                        <label for="service-desc" class="block text-sm font-semibold text-gray-700 mb-2">
                            Purpose of Payment Service <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="service-desc" 
                            rows="4" 
                            class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors"
                            placeholder="Describe how your business plans to use the payment services..."></textarea>
                    </div>

                    <hr class="border-gray-100">

                    <!-- B. PAYMENT SERVICE DETAILS -->
                    <div id="section-payment-details">
                        <h3 class="text-sm font-semibold text-primary mb-4 uppercase tracking-wider opacity-80">Payment Service Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Expected Monthly Transaction Volume -->
                            <div>
                                <label for="monthly-volume" class="block text-sm font-medium text-gray-700 mb-1">
                                    Expected Monthly Transaction Volume <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="monthly-volume" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white">
                                        <option value="" disabled selected>Select volume range</option>
                                        <option value="under-50k">Under 50,000 NOK</option>
                                        <option value="50k-250k">50,000–250,000 NOK</option>
                                        <option value="250k-1m">250,000–1,000,000 NOK</option>
                                        <option value="above-1m">Above 1,000,000 NOK</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Expected Monthly Transaction Count -->
                            <div>
                                <label for="monthly-count" class="block text-sm font-medium text-gray-700 mb-1">
                                    Expected Monthly Transaction Count <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="monthly-count" 
                                    class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none"
                                    placeholder="e.g., 120 transactions per month">
                            </div>

                            <!-- Average Transaction Size -->
                            <div>
                                <label for="avg-size" class="block text-sm font-medium text-gray-700 mb-1">
                                    Average Transaction Size <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-gray-500 text-sm">NOK</span>
                                    <input 
                                        type="number" 
                                        id="avg-size" 
                                        class="w-full rounded-md border border-gray-300 pl-14 pr-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none"
                                        placeholder="e.g., 400">
                                </div>
                            </div>

                            <!-- Maximum Transaction Size -->
                            <div>
                                <label for="max-size" class="block text-sm font-medium text-gray-700 mb-1">
                                    Maximum Transaction Size <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-gray-500 text-sm">NOK</span>
                                    <input 
                                        type="number" 
                                        id="max-size" 
                                        class="w-full rounded-md border border-gray-300 pl-14 pr-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none"
                                        placeholder="e.g., 5000">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- C. BUSINESS MODEL DETAILS -->
                    <div id="section-business-model">
                        <h3 class="text-sm font-semibold text-primary mb-4 uppercase tracking-wider opacity-80">Business Model Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                            
                            <!-- Business Model Type -->
                            <div>
                                <label for="business-model" class="block text-sm font-medium text-gray-700 mb-1">
                                    Business Model Type <span class="text-red-500">*</span>
                                </label>
                                <select id="business-model" class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white">
                                    <option value="" disabled selected>Select business model</option>
                                    <option value="retail">Retail</option>
                                    <option value="fnb">Food & Beverage</option>
                                    <option value="ecommerce">E-commerce</option>
                                    <option value="services">Services</option>
                                    <option value="subscription">Subscription</option>
                                    <option value="marketplace">Marketplace</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Conditional 'Other' Input -->
                            <div id="other-specify-container" class="hidden">
                                <label for="other-model" class="block text-sm font-medium text-gray-700 mb-1">
                                    Specify Other Model <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="other-model" 
                                    class="w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none"
                                    placeholder="Please specify">
                            </div>

                            <div class="hidden md:block"></div>

                            <!-- Toggles Container -->
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                                <!-- Recurring Billing Toggle -->
                                <div class="flex items-center justify-between border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-900">Recurring billing?</span>
                                        <span class="block text-xs text-gray-500 mt-0.5">Does your business provide subscription services?</span>
                                    </div>
                                    <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="recurring" id="recurring" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 transition-all duration-300"/>
                                        <label for="recurring" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-300"></label>
                                    </div>
                                </div>

                                <!-- Store Card Info Toggle -->
                                <div class="flex items-center justify-between border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-900">Store card information?</span>
                                        <span class="block text-xs text-gray-500 mt-0.5">Required for compliance verification.</span>
                                    </div>
                                    <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="store-card" id="store-card" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 transition-all duration-300"/>
                                        <label for="store-card" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-300"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- D. ADDITIONAL INFORMATION -->
                    <div id="section-additional">
                        <label for="additional-notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Notes <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <textarea 
                            id="additional-notes" 
                            rows="3" 
                            class="w-full rounded-md border border-gray-300 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors"
                            placeholder="Any other details relevant to your application..."></textarea>
                    </div>

                </form>
            </section>

        </div>

        <!-- 5. FOOTER BUTTON ROW -->
        <footer id="footer" class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-gray-200 px-10 py-4 z-30">
            <div class="max-w-5xl mx-auto flex items-center justify-between">
                <!-- Back Link -->
                <a href="{{ route('merchant.kyc.contactPerson') }}" class="group flex items-center text-primary text-sm font-medium hover:underline">
                    <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                    Back
                </a>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4">
                    <button type="button" class="px-6 py-2.5 rounded-md border border-cta text-cta text-sm font-semibold bg-white hover:bg-orange-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cta">
                        Save Draft
                    </button>
                    
                    <a href="{{ route('merchant.kyc.salesChannels') }}" class="px-6 py-2.5 rounded-md bg-cta text-white text-sm font-semibold hover:bg-orange-400 shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cta flex items-center">
                        Continue to Sales Channel
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </footer>

    </main>

    <!-- Script to handle dynamic 'Other' field -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const businessModelSelect = document.getElementById('business-model');
            const otherContainer = document.getElementById('other-specify-container');

            businessModelSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherContainer.classList.remove('hidden');
                } else {
                    otherContainer.classList.add('hidden');
                }
            });
        });
    </script>
</body>
@endsection
