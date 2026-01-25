@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start New Onboarding</title>
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
                            border: '#D1D5DB'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest'};
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        ::-webkit-scrollbar { display: none;}
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
        .pill-selected {
            background: #FF7C00;
            color: white;
            border-color: #FF7C00;
        }
        .pill-unselected {
            background: white;
            color: #6B7280;
            border-color: #D1D5DB;
        }
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral">

        <x-admin.sidebar active="merchant-onboarding" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Merchant Onboarding', 'url' => route('admin.onboarding.index')],
            ['label' => 'Start New Onboarding', 'url' => route('admin.onboarding.start')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 pb-20 min-h-screen bg-brand-neutral">
            <div class="mx-auto px-4 sm:px-6 lg:px-20 py-8">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-brand-primary mb-1">Start New Onboarding</h1>
                    <p class="text-sm text-gray-500">Configure onboarding by selecting solution, partner, acquirers, payment methods, pricing, and merchant details.</p>
                </div>

                <!-- Form Container -->
                <div id="form-container" class="space-y-6">

                    <!-- Section 1: Core Configuration -->
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-sm font-bold text-brand-primary uppercase tracking-wide">1. Core Configuration</h2>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">Required Step</span>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                <!-- Solution Field -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Solution <span class="text-red-500">*</span>
                                        </label>
                                        <select class="w-full h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                            <option>POS Terminal Integration</option>
                                            <option>E-commerce Gateway</option>
                                            <option>Mobile Payments</option>
                                        </select>
                                    </div>
                                    <!-- Solution Info Card -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-md p-4 space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-brand-primary uppercase">Selected: POS Terminal</span>
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">Active</span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 text-xs">
                                            <div>
                                                <div class="text-gray-500 mb-1">Complexity</div>
                                                <div class="font-medium text-gray-900">Medium (HW Required)</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Default Price</div>
                                                <div class="font-medium text-gray-900">Standard Retail v2</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Supported</div>
                                                <div class="flex gap-1">
                                                    <span class="text-xs">🇬🇧</span>
                                                    <span class="text-xs">🇩🇪</span>
                                                    <span class="text-xs">🇳🇴</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Partner Field -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Partner <span class="text-red-500">*</span>
                                        </label>
                                        <select class="w-full h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                            <option>OnePOS Systems Ltd.</option>
                                            <option>Digitax</option>
                                            <option>2iZii Direct</option>
                                        </select>
                                    </div>
                                    <!-- Partner Info Card -->
                                    <div class="bg-gray-50 border border-gray-200 rounded-md p-4 space-y-4">
                                        <div class="grid grid-cols-2 gap-4 text-xs">
                                            <div>
                                                <div class="text-gray-500 mb-1">Partner Type</div>
                                                <div class="font-medium text-gray-900">Channel Partner</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Commission Plan</div>
                                                <div class="font-medium text-gray-900">Kickback Tier 1 (0.2%)</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Status</div>
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">Active</span>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Referral ID</div>
                                                <div class="font-mono font-medium text-gray-900">PART-8821</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 2: Merchant Details -->
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                            <h2 class="text-sm font-bold text-brand-primary uppercase tracking-wide">2. Merchant Details</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Legal Business Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary" placeholder="e.g. Acme Trading Ltd">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Trading Name</label>
                                    <input type="text" class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary" placeholder="e.g. Acme Coffee">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number / Org No</label>
                                    <input type="text" class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary" placeholder="e.g. 12345678">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Website</label>
                                    <div class="flex">
                                        <div class="bg-gray-50 border border-r-0 border-gray-300 rounded-l-md px-3 flex items-center text-sm text-gray-600">https://</div>
                                        <input type="text" class="flex-1 h-[39px] px-4 border border-gray-300 rounded-r-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary" placeholder="www.example.com">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Merchant Contact Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                        <input type="email" class="w-full h-[39px] pl-10 pr-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary" placeholder="contact@merchant.com">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Merchant Phone Number</label>
                                    <input type="tel" class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary" placeholder="+44 7700 900000">
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 3: Operations & Acquirers -->
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                            <h2 class="text-sm font-bold text-brand-primary uppercase tracking-wide">3. Operations & Acquirers</h2>
                        </div>
                        <div class="p-6 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Country of Operation <span class="text-red-500">*</span>
                                    </label>
                                    <select class="w-full h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                        <option>🇬🇧 United Kingdom</option>
                                        <option>🇳🇴 Norway</option>
                                        <option>🇸🇪 Sweden</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Filtered based on selected solution.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Methods</label>
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" data-payment-method="visa" class="bg-brand-primary text-white px-3 py-1.5 rounded-full text-sm font-medium border-2 border-brand-primary flex items-center gap-1.5">
                                            <i class="fa-brands fa-cc-visa text-sm"></i>
                                            Visa
                                        </button>
                                        <button type="button" data-payment-method="mastercard" class="bg-brand-primary text-white px-3 py-1.5 rounded-full text-sm font-medium border-2 border-brand-primary flex items-center gap-1.5">
                                            <i class="fa-brands fa-cc-mastercard text-sm"></i>
                                            Mastercard
                                        </button>
                                        <button type="button" data-payment-method="apple-pay" class="bg-white text-gray-700 px-3 py-1.5 rounded-full text-sm font-medium border border-gray-300 flex items-center gap-1.5">
                                            <i class="fa-brands fa-cc-apple-pay text-sm"></i>
                                            Apple Pay
                                        </button>
                                        <button type="button" data-payment-method="google-pay" class="bg-white text-gray-700 px-3 py-1.5 rounded-full text-sm font-medium border border-gray-300 flex items-center gap-1.5">
                                            <i class="fa-brands fa-google-pay text-sm"></i>
                                            Google Pay
                                        </button>
                                        <button type="button" data-payment-method="vipps" class="bg-gray-100 text-gray-400 px-3 py-1.5 rounded-full text-sm font-medium">
                                            Vipps
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Select Acquirer(s) <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Elavon Card -->
                                    <div data-acquirer-card="elavon" class="bg-blue-50 border-2 border-brand-secondary rounded-lg p-4 flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h3 class="font-bold text-sm text-gray-900">Elavon (Email Submission)</h3>
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">Primary</span>
                                            </div>
                                            <p class="text-sm text-gray-600">SLA: 24-48 hours. Requires full KYB doc set.</p>
                                        </div>
                                        <div class="ml-3">
                                            <input type="checkbox" data-acquirer="elavon" checked class="w-5 h-5 rounded text-brand-secondary focus:ring-brand-secondary">
                                        </div>
                                    </div>
                                    <!-- Surfboard Card -->
                                    <div data-acquirer-card="surfboard" class="bg-white border border-gray-200 rounded-lg p-4 flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h3 class="font-medium text-sm text-gray-900">Surfboard (API)</h3>
                                                <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded">Instant</span>
                                            </div>
                                            <p class="text-sm text-gray-600">SLA: Instant. Hybrid flow required.</p>
                                        </div>
                                        <div class="ml-3">
                                            <input type="checkbox" data-acquirer="surfboard" class="w-5 h-5 rounded border-gray-300 text-brand-secondary focus:ring-brand-secondary">
                                        </div>
                                    </div>
                                </div>
                                <!-- Elavon Requirements -->
                                <div data-elavon-requirements class="bg-gray-50 border border-gray-200 rounded-md p-4 mt-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <i class="fa-solid fa-info-circle text-brand-secondary"></i>
                                        <h4 class="font-semibold text-sm text-gray-700">Elavon Requirements</h4>
                                    </div>
                                    <ul class="text-xs text-gray-600 space-y-1.5 ml-6 list-disc">
                                        <li>Company Info, UBOs (>25%), Board Members</li>
                                        <li>Bank Account Verification Letter (dated < 3 months)</li>
                                        <li>Passport Copies for all UBOs</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 4: Pricing & Fees -->
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                            <div>
                                <h2 class="text-sm font-bold text-brand-primary uppercase tracking-wide mb-1">4. Pricing & Fees</h2>
                                <p class="text-xs text-gray-500">Assign pricing or customize fees for this onboarding.</p>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Select Price List <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full max-w-md h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                    <option>Default Solution Price List (Standard)</option>
                                    <option>Custom Price List</option>
                                </select>
                            </div>
                            <!-- Pricing Table -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm min-w-[640px]">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Payment Method</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Transaction</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">% Fee (MDR)</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Fixed Fee</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Min Fee</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Max Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-3 flex items-center gap-2">
                                                    <i class="fa-brands fa-cc-visa text-sm"></i>
                                                    <span class="font-medium">Visa Debit</span>
                                                </td>
                                                <td class="px-3 py-3 text-gray-600">Card Present</td>
                                                <td class="px-3 py-3 font-mono">0.75%</td>
                                                <td class="px-3 py-3 font-mono">£0.05</td>
                                                <td class="px-3 py-3 font-mono">£0.10</td>
                                                <td class="px-3 py-3 font-mono">-</td>
                                            </tr>
                                            <tr class="bg-white">
                                                <td class="px-6 py-3 flex items-center gap-2">
                                                    <i class="fa-brands fa-cc-mastercard text-sm"></i>
                                                    <span class="font-medium">Mastercard</span>
                                                </td>
                                                <td class="px-3 py-3 text-gray-600">Card Present</td>
                                                <td class="px-3 py-3 font-mono">0.80%</td>
                                                <td class="px-3 py-3 font-mono">£0.05</td>
                                                <td class="px-3 py-3 font-mono">£0.10</td>
                                                <td class="px-3 py-3 font-mono">-</td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-3 flex items-center gap-2">
                                                    <i class="fa-brands fa-cc-apple-pay text-sm"></i>
                                                    <span class="font-medium">Apple Pay</span>
                                                </td>
                                                <td class="px-3 py-3 text-gray-600">Contactless</td>
                                                <td class="px-3 py-3 font-mono">1.20%</td>
                                                <td class="px-3 py-3 font-mono">£0.10</td>
                                                <td class="px-3 py-3 font-mono">£0.15</td>
                                                <td class="px-3 py-3 font-mono">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button class="flex items-center gap-2 text-brand-secondary text-sm font-medium">
                                <i class="fa-solid fa-pen text-xs"></i>
                                Customize Pricing for this Merchant
                            </button>
                        </div>
                    </section>

                    <!-- Section 5: Internal Tags & Notes -->
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                            <h2 class="text-sm font-bold text-brand-primary uppercase tracking-wide">5. Internal Tags & Notes</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Internal Tags</label>
                                <div class="flex flex-wrap gap-2">
                                    <span data-tag class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-2">
                                        High-Risk
                                        <button type="button" data-tag-remove class="hover:text-purple-900"><i class="fa-solid fa-xmark text-xs"></i></button>
                                    </span>
                                    <span data-tag class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-2">
                                        Fast-Track
                                        <button type="button" data-tag-remove class="hover:text-green-900"><i class="fa-solid fa-xmark text-xs"></i></button>
                                    </span>
                                    <button type="button" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-2">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        Add Tag
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Internal Notes</label>
                                <textarea rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary resize-none" placeholder="Add internal notes visible only to 2iZii team..."></textarea>
                            </div>
                        </div>
                    </section>

                    <!-- Section 6: System Information -->
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                            <h2 class="text-sm font-bold text-brand-primary uppercase tracking-wide">6. System Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Request ID</div>
                                    <div class="font-mono text-sm text-gray-900">MOB-DRAFT</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Status</div>
                                    <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded">Draft</span>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Created On</div>
                                    <div class="font-medium text-sm text-gray-900">-</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Created By</div>
                                    <div class="font-medium text-sm text-gray-900">Admin User</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Section 7: KYC Link Preview -->
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                            <h2 class="text-sm font-bold text-brand-primary uppercase tracking-wide">7. KYC Link Preview</h2>
                        </div>
                        <div class="p-6 space-y-2">
                            <div class="bg-gray-100 rounded-md p-4 flex items-center justify-between">
                                <div class="flex items-center gap-3 flex-1">
                                    <i class="fa-solid fa-link text-gray-400"></i>
                                    <span class="font-mono text-sm text-gray-600">https://2izii.com/kyc/xxxxxxxxxxxxxxxx</span>
                                </div>
                                <button class="bg-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm font-medium flex items-center gap-2 hover:bg-gray-300">
                                    <i class="fa-regular fa-copy text-xs"></i>
                                    Copy Link
                                </button>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fa-solid fa-info-circle"></i>
                                <span>Link will be activated after you save and send the onboarding request.</span>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>

        <!-- Fixed Bottom Action Bar -->
        <footer class="fixed bottom-0 left-0 md:left-[260px] right-0 bg-white border-t border-gray-200 px-4 md:px-20 py-4 flex justify-between items-center z-30">
            <div class="max-w-[1024px] w-full mx-auto flex flex-col sm:flex-row justify-between items-center gap-3">
                <button class="text-gray-600 hover:text-gray-900 text-sm font-medium w-full sm:w-auto text-center">
                    Cancel
                </button>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                    <button class="border-2 border-brand-cta text-brand-cta hover:bg-brand-cta hover:text-white font-medium px-6 py-3 rounded-md text-sm transition-colors w-full sm:w-auto">
                        Save as Draft
                    </button>
                    <button class="bg-brand-cta hover:bg-orange-500 text-white font-medium px-5 py-3 rounded-md text-sm shadow-sm transition-colors w-full sm:w-auto">
                        Save & Send KYC Link
                    </button>
                </div>
            </div>
        </footer>

        <script>
            // Payment method toggle functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Payment method buttons
                const paymentButtons = document.querySelectorAll('[data-payment-method]');
                paymentButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (this.classList.contains('bg-brand-primary')) {
                            this.classList.remove('bg-brand-primary', 'text-white', 'border-brand-primary');
                            this.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                        } else {
                            this.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                            this.classList.add('bg-brand-primary', 'text-white', 'border-brand-primary');
                        }
                    });
                });

                // Acquirer checkbox toggle
                const acquirerCheckboxes = document.querySelectorAll('[data-acquirer]');
                const elavonRequirements = document.querySelector('[data-elavon-requirements]');
                
                acquirerCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const card = this.closest('[data-acquirer-card]');
                        if (this.checked) {
                            card.classList.remove('bg-white', 'border-gray-200');
                            card.classList.add('bg-blue-50', 'border-2', 'border-brand-secondary');
                        } else {
                            card.classList.remove('bg-blue-50', 'border-2', 'border-brand-secondary');
                            card.classList.add('bg-white', 'border-gray-200');
                        }
                        
                        // Show/hide Elavon requirements
                        if (elavonRequirements) {
                            const elavonCheckbox = document.querySelector('[data-acquirer="elavon"]');
                            if (elavonCheckbox && elavonCheckbox.checked) {
                                elavonRequirements.classList.remove('hidden');
                            } else {
                                elavonRequirements.classList.add('hidden');
                            }
                        }
                    });
                });
                
                // Initial check for Elavon requirements visibility
                if (elavonRequirements) {
                    const elavonCheckbox = document.querySelector('[data-acquirer="elavon"]');
                    if (elavonCheckbox && !elavonCheckbox.checked) {
                        elavonRequirements.classList.add('hidden');
                    }
                }

                // Tag removal
                document.querySelectorAll('[data-tag-remove]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.closest('[data-tag]').remove();
                    });
                });
            });
        </script>

    </body>
@endsection

