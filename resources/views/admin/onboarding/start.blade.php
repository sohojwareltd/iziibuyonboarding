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

        @php
            $isEdit = isset($onboarding);
            $selectedPaymentMethods = old('payment_methods', $onboarding->payment_methods ?? []);
            $selectedAcquirers = old('acquirers', $onboarding->acquirers ?? []);
            $tagValues = old('internal_tags', $onboarding->internal_tags ?? ['High-Risk', 'Fast-Track']);
        @endphp

        <form id="onboarding-form" method="POST"
            action="{{ $isEdit ? route('admin.onboarding.update', $onboarding) : route('admin.onboarding.store') }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

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
                                        <select name="solution_id"
                                            class="w-full h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                            @foreach ($solutions as $solution)
                                                <option value="{{ $solution->id }}"
                                                    {{ old('solution_id', $onboarding->solution_id ?? '') == $solution->id ? 'selected' : '' }}>
                                                    {{ $solution->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Solution Info Card -->
                                    <div id="solution-info-card" class="bg-gray-50 border border-gray-200 rounded-md p-4 space-y-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-brand-primary uppercase" id="selected-solution-name">Select a solution</span>
                                            <span id="solution-status-badge" class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded-full">-</span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 text-xs">
                                            <div>
                                                <div class="text-gray-500 mb-1">Complexity</div>
                                                <div class="font-medium text-gray-900" id="solution-complexity">-</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Category</div>
                                                <div class="font-medium text-gray-900" id="solution-category">-</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Status</div>
                                                <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded" id="solution-status-detail">-</span>
                                            </div>
                                            <div>
                                                <div class="text-gray-500 mb-1">Mode</div>
                                                <div class="font-medium text-gray-900" id="solution-mode">-</div>
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
                                        <select name="partner_id"
                                            class="w-full h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                            <option value="">Select Partner</option>
                                            @foreach ($partners as $partner)
                                                <option value="{{ $partner->id }}"
                                                    {{ old('partner_id', $onboarding->partner_id ?? '') == $partner->id ? 'selected' : '' }}>
                                                    {{ $partner->title }}
                                                </option>
                                            @endforeach
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
                                    <input type="text" name="legal_business_name"
                                        value="{{ old('legal_business_name', $onboarding->legal_business_name ?? '') }}"
                                        class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                                        placeholder="e.g. Acme Trading Ltd">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Trading Name</label>
                                    <input type="text" name="trading_name"
                                        value="{{ old('trading_name', $onboarding->trading_name ?? '') }}"
                                        class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                                        placeholder="e.g. Acme Coffee">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number / Org No</label>
                                    <input type="text" name="registration_number"
                                        value="{{ old('registration_number', $onboarding->registration_number ?? '') }}"
                                        class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                                        placeholder="e.g. 12345678">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Business Website</label>
                                    <div class="flex">
                                        <div class="bg-gray-50 border border-r-0 border-gray-300 rounded-l-md px-3 flex items-center text-sm text-gray-600">https://</div>
                                        <input type="text" name="business_website"
                                            value="{{ old('business_website', $onboarding->business_website ?? '') }}"
                                            class="flex-1 h-[39px] px-4 border border-gray-300 rounded-r-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                                            placeholder="www.example.com">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Merchant Contact Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                        <input type="email" name="merchant_contact_email"
                                            value="{{ old('merchant_contact_email', $onboarding->merchant_contact_email ?? '') }}"
                                            class="w-full h-[39px] pl-10 pr-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                                            placeholder="contact@merchant.com">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Merchant Phone Number</label>
                                    <input type="tel" name="merchant_phone_number"
                                        value="{{ old('merchant_phone_number', $onboarding->merchant_phone_number ?? '') }}"
                                        class="w-full h-[39px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary"
                                        placeholder="+44 7700 900000">
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
                                    <select name="country_of_operation"
                                        class="w-full h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                        @php
                                            $countryOptions = $countries->isNotEmpty() ? $countries : collect(['gb', 'no', 'se']);
                                        @endphp
                                        @foreach ($countryOptions as $country)
                                            <option value="{{ strtolower($country) }}"
                                                {{ strtolower(old('country_of_operation', $onboarding->country_of_operation ?? '')) === strtolower($country) ? 'selected' : '' }}>
                                                {{ strtoupper($country) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Filtered based on selected solution.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Methods</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($paymentMethods as $method)
                                            @php
                                                $isSelected = in_array($method->name, $selectedPaymentMethods);
                                            @endphp
                                            <input type="checkbox" name="payment_methods[]" value="{{ $method->name }}"
                                                class="hidden" data-payment-method-input="{{ $method->name }}"
                                                {{ $isSelected ? 'checked' : '' }}>
                                            <button type="button" data-payment-method="{{ $method->name }}"
                                                class="{{ $isSelected ? 'bg-brand-primary text-white border-brand-primary' : 'bg-white text-gray-700 border-gray-300' }} px-3 py-1.5 rounded-full text-sm font-medium border flex items-center gap-1.5">
                                                <i class="fa-solid fa-credit-card text-sm"></i>
                                                {{ $method->display_label ?? $method->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Select Acquirer(s) <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($acquirers as $acquirer)
                                        @php
                                            $acquirerKey = \Illuminate\Support\Str::slug($acquirer->name);
                                            $isSelected = in_array($acquirer->name, $selectedAcquirers);
                                        @endphp
                                        <div data-acquirer-card="{{ $acquirerKey }}"
                                            class="{{ $isSelected ? 'bg-blue-50 border-2 border-brand-secondary' : 'bg-white border border-gray-200' }} rounded-lg p-4 flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-1">
                                                    <h3 class="font-medium text-sm text-gray-900">{{ $acquirer->name }}</h3>
                                                    <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded">
                                                        {{ strtoupper($acquirer->mode) }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600">{{ $acquirer->description ?? 'Acquirer configuration' }}</p>
                                            </div>
                                            <div class="ml-3">
                                                <input type="checkbox" name="acquirers[]" value="{{ $acquirer->name }}"
                                                    data-acquirer="{{ $acquirerKey }}"
                                                    {{ $isSelected ? 'checked' : '' }}
                                                    class="w-5 h-5 rounded border-gray-300 text-brand-secondary focus:ring-brand-secondary">
                                            </div>
                                        </div>
                                    @endforeach
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
                                <select id="price-list-select" name="price_list_id"
                                    class="w-full max-w-md h-[39px] px-4 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                    <option value="">Select Price List</option>
                                    @foreach ($priceLists as $priceList)
                                        <option value="{{ $priceList->id }}"
                                            {{ old('price_list_id', $onboarding->price_list_id ?? '') == $priceList->id ? 'selected' : '' }}>
                                            {{ $priceList->name }} ({{ $priceList->currency }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Pricing Table -->
                            <div id="pricing-table-container" class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm min-w-[640px]">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Payment Method</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Transaction Type</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">% Fee (MDR)</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Fixed Fee</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Min Fee</th>
                                                <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Max Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pricing-rows" class="bg-white divide-y divide-gray-200">
                                            <tr class="text-gray-500">
                                                <td colspan="6" class="px-6 py-8 text-center">Select a price list to view pricing</td>
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
                                <div class="flex flex-wrap gap-2" id="tags-container">
                                    @php
                                        $tagOptions = ['High-Risk', 'Fast-Track', 'VIP-Client', 'Testing'];
                                        $selectedTags = $tagValues ?? [];
                                    @endphp
                                    @foreach ($selectedTags as $tag)
                                        <span data-tag class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-2">
                                            {{ $tag }}
                                            <input type="hidden" name="internal_tags[]" value="{{ $tag }}">
                                            <button type="button" data-tag-remove class="hover:text-purple-900"><i class="fa-solid fa-xmark text-xs"></i></button>
                                        </span>
                                    @endforeach
                                    <button type="button" id="add-tag-btn" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-2">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        Add Tag
                                    </button>
                                </div>
                                <!-- Add Tag Modal -->
                                <div id="tag-modal" class="fixed inset-0 bg-black/40 backdrop-blur-[1px] hidden items-center justify-center z-50">
                                    <div class="bg-white w-full max-w-md rounded-xl shadow-xl border border-gray-200">
                                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="bg-brand-neutral text-brand-primary px-2 py-1 rounded-md text-xs font-semibold">Tag</span>
                                                <h3 class="text-sm font-semibold text-gray-900">Add Internal Tag</h3>
                                            </div>
                                            <button type="button" id="tag-modal-close" class="text-gray-400 hover:text-gray-600">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                        <div class="px-6 py-5 space-y-3">
                                            <label for="tag-name-input" class="text-xs font-medium text-gray-600">Tag name</label>
                                            <input id="tag-name-input" type="text" placeholder="e.g. High-Risk" class="w-full h-[40px] px-4 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary" />
                                            <p class="text-[11px] text-gray-400">Tags help categorize onboardings for internal review.</p>
                                        </div>
                                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-2">
                                            <button type="button" id="tag-modal-cancel" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">Cancel</button>
                                            <button type="button" id="tag-modal-save" class="px-4 py-2 text-sm font-medium text-white bg-brand-cta hover:bg-brand-ctaHover rounded-md">Add Tag</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Internal Notes</label>
                                <textarea name="internal_notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary resize-none" placeholder="Add internal notes visible only to 2iZii team...">{{ old('internal_notes', $onboarding->internal_notes ?? '') }}</textarea>
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
                                    <div class="font-mono text-sm text-gray-900">{{ $isEdit ? $onboarding->request_id : 'NEW' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Status</div>
                                    <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded">{{ $isEdit ? ucfirst($onboarding->status) : 'Draft' }}</span>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Created On</div>
                                    <div class="font-medium text-sm text-gray-900">{{ $isEdit ? $onboarding->created_at->format('Y-m-d H:i') : '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Created By</div>
                                    <div class="font-medium text-sm text-gray-900">{{ $isEdit && $onboarding->creator ? $onboarding->creator->name : 'Current User' }}</div>
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
                                    @if ($isEdit && $onboarding->kyc_link)
                                        <span class="font-mono text-sm text-gray-600" id="kyc-link-text">{{ url('/merchant/kyc/' . $onboarding->kyc_link) }}</span>
                                    @else
                                        <span class="font-mono text-sm text-gray-600 italic">Link will be generated after sending</span>
                                    @endif
                                </div>
                                @if ($isEdit && $onboarding->kyc_link)
                                    <button type="button" class="copy-kyc-link-btn bg-brand-primary text-white px-3 py-1.5 rounded text-sm font-medium flex items-center gap-2 hover:bg-brand-secondary transition-colors" data-kyc-link="{{ url('/merchant/kyc/' . $onboarding->kyc_link) }}">
                                        <i class="fa-regular fa-copy text-xs"></i>
                                        Copy Link
                                    </button>
                                @else
                                    <button type="button" disabled class="bg-gray-200 text-gray-400 px-3 py-1.5 rounded text-sm font-medium flex items-center gap-2 cursor-not-allowed">
                                        <i class="fa-regular fa-copy text-xs"></i>
                                        Copy Link
                                    </button>
                                @endif
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
                <a href="{{ route('admin.onboarding.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium w-full sm:w-auto text-center">
                    Cancel
                </a>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                    <button type="submit" name="action" value="draft"
                        class="border-2 border-brand-cta text-brand-cta hover:bg-brand-cta hover:text-white font-medium px-6 py-3 rounded-md text-sm transition-colors w-full sm:w-auto">
                        Save as Draft
                    </button>
                    <button type="submit" name="action" value="send"
                        class="bg-brand-cta hover:bg-orange-500 text-white font-medium px-5 py-3 rounded-md text-sm shadow-sm transition-colors w-full sm:w-auto">
                        Save & Send KYC Link
                    </button>
                </div>
            </div>
        </footer>

        </form>

        <script>
            // Price list data mapping with price lines
            const priceListsData = {
                @foreach ($priceLists as $priceList)
                    {{ $priceList->id }}: {
                        name: '{{ $priceList->name }}',
                        currency: '{{ $priceList->currency }}',
                        type: '{{ $priceList->type }}',
                        price_lines: @json($priceList->price_lines ?? [])
                    },
                @endforeach
            };

            // Solution data mapping
            const solutionsData = {
                @foreach ($solutions as $solution)
                    {{ $solution->id }}: {
                        name: '{{ $solution->name }}',
                        complexity: '{{ $solution->status ?? "Standard" }}',
                        category: '{{ $solution->category->name ?? "Uncategorized" }}',
                        status: '{{ $solution->status ?? "draft" }}',
                        mode: '{{ $solution->pricing_plan ?? "Standard" }}'
                    },
                @endforeach
            };

            document.addEventListener('DOMContentLoaded', function() {
                // Price list selection handler
                const priceListSelect = document.getElementById('price-list-select');
                if (priceListSelect) {
                    console.log('Price list select found, adding event listener');
                    priceListSelect.addEventListener('change', function() {
                        console.log('Price list changed to:', this.value);
                        updatePricingTable(this.value);
                    });
                    // Initialize with selected value on load
                    if (priceListSelect.value && priceListSelect.value !== '') {
                        console.log('Initializing with price list:', priceListSelect.value);
                        updatePricingTable(priceListSelect.value);
                    }
                } else {
                    console.error('Price list select element not found!');
                }

                function updatePricingTable(priceListId) {
                    console.log('updatePricingTable called with ID:', priceListId);
                    const pricingRows = document.getElementById('pricing-rows');
                    
                    if (!priceListId || priceListId === '') {
                        console.log('No price list selected, showing placeholder');
                        pricingRows.innerHTML = `
                            <tr class="text-gray-500">
                                <td colspan="6" class="px-6 py-8 text-center">Select a price list to view pricing</td>
                            </tr>
                        `;
                        return;
                    }
                    
                    const data = priceListsData[priceListId];
                    console.log('Price list data:', data);
                    
                    if (!data) {
                        console.error('No data found for price list ID:', priceListId);
                        pricingRows.innerHTML = `
                            <tr class="text-gray-500">
                                <td colspan="6" class="px-6 py-8 text-center">Price list data not found</td>
                            </tr>
                        `;
                        return;
                    }
                    
                    // Parse price_lines if it's a JSON string
                    let priceLines = data.price_lines;
                    if (typeof priceLines === 'string') {
                        try {
                            priceLines = JSON.parse(priceLines);
                        } catch (e) {
                            console.error('Failed to parse price_lines:', e);
                            pricingRows.innerHTML = `
                                <tr class="text-gray-500">
                                    <td colspan="6" class="px-6 py-8 text-center">Invalid price list data format</td>
                                </tr>
                            `;
                            return;
                        }
                    }
                    
                    // Convert to array if it's an object
                    if (!Array.isArray(priceLines)) {
                        priceLines = Object.values(priceLines || {});
                    }
                    
                    if (!priceLines || priceLines.length === 0) {
                        console.warn('No price lines found for price list:', priceListId);
                        pricingRows.innerHTML = `
                            <tr class="text-gray-500">
                                <td colspan="6" class="px-6 py-8 text-center">No pricing configured for this price list</td>
                            </tr>
                        `;
                        return;
                    }

                    console.log('Rendering', priceLines.length, 'price lines');
                    
                    const currency = data.currency || 'GBP';
                    const currencySymbol = currency === 'GBP' ? '£' : currency === 'EUR' ? '€' : currency === 'USD' ? '$' : currency;
                    
                    let rows = '';
                    priceLines.forEach((line, index) => {
                        const paymentMethod = line.payment_method || line.method || 'Unknown';
                        const displayName = line.display_name || line.name || paymentMethod;
                        const icon = getPaymentIcon(paymentMethod);
                        const percentage = line.percentage_fee || line.percent_fee || line.mdr_rate || line.rate || line.percent || '-';
                        const fixedFee = line.fixed_fee || line.transaction_fee ? `${currencySymbol}${(line.fixed_fee || line.transaction_fee)}` : '-';
                        const minFee = line.min_fee ? `${currencySymbol}${line.min_fee}` : '-';
                        const maxFee = line.max_fee ? `${currencySymbol}${line.max_fee}` : '-';
                        const transactionType = line.transaction_type || line.type || 'Card Present';
                        
                        rows += `
                            <tr class="${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'}">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        ${icon}
                                        <span class="font-medium">${displayName}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-3 text-gray-600">${transactionType}</td>
                                <td class="px-3 py-3 font-mono text-gray-900">${percentage}${typeof percentage === 'number' || (!isNaN(percentage) && percentage !== '-') ? '%' : ''}</td>
                                <td class="px-3 py-3 font-mono text-gray-900">${fixedFee}</td>
                                <td class="px-3 py-3 font-mono text-gray-900">${minFee}</td>
                                <td class="px-3 py-3 font-mono text-gray-900">${maxFee}</td>
                            </tr>
                        `;
                    });
                    
                    pricingRows.innerHTML = rows;
                    console.log('Pricing table updated successfully');
                }

                function getPaymentIcon(method) {
                    const icons = {
                        'visa': '<i class="fa-brands fa-cc-visa text-sm text-blue-600"></i>',
                        'mastercard': '<i class="fa-brands fa-cc-mastercard text-sm text-orange-600"></i>',
                        'amex': '<i class="fa-brands fa-cc-amex text-sm text-cyan-600"></i>',
                        'apple_pay': '<i class="fa-brands fa-cc-apple-pay text-sm text-gray-900"></i>',
                        'google_pay': '<i class="fa-brands fa-google text-sm text-blue-500"></i>',
                        'paypal': '<i class="fa-brands fa-paypal text-sm text-blue-700"></i>',
                        'bank_transfer': '<i class="fa-solid fa-building-columns text-sm text-gray-600"></i>',
                    };
                    
                    const key = method.toLowerCase().replace(/[\\s-]/g, '_');
                    return icons[key] || '<i class="fa-solid fa-credit-card text-sm text-gray-400"></i>';
                }

                // Solution selection handler
                const solutionSelect = document.querySelector('select[name="solution_id"]');
                if (solutionSelect) {
                    solutionSelect.addEventListener('change', function() {
                        updateSolutionInfo(this.value);
                    });
                    // Initialize with selected value on load
                    if (solutionSelect.value) {
                        updateSolutionInfo(solutionSelect.value);
                    }
                }

                function updateSolutionInfo(solutionId) {
                    const data = solutionsData[solutionId];
                    if (data) {
                        document.getElementById('selected-solution-name').textContent = 'Selected: ' + data.name;
                        document.getElementById('solution-complexity').textContent = data.complexity;
                        document.getElementById('solution-category').textContent = data.category;
                        document.getElementById('solution-mode').textContent = data.mode;
                        
                        const statusDetail = document.getElementById('solution-status-detail');
                        const statusBadge = document.getElementById('solution-status-badge');
                        const statusText = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                        statusDetail.textContent = statusText;
                        statusBadge.textContent = statusText;
                        
                        // Update badge color based on status
                        statusBadge.className = 'text-xs font-medium px-2 py-0.5 rounded-full';
                        if (data.status === 'active') {
                            statusBadge.classList.add('bg-green-100', 'text-green-800');
                        } else if (data.status === 'inactive') {
                            statusBadge.classList.add('bg-red-100', 'text-red-800');
                        } else {
                            statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
                        }
                    } else {
                        // Reset if no selection
                        document.getElementById('selected-solution-name').textContent = 'Select a solution';
                        document.getElementById('solution-complexity').textContent = '-';
                        document.getElementById('solution-category').textContent = '-';
                        document.getElementById('solution-mode').textContent = '-';
                        document.getElementById('solution-status-detail').textContent = '-';
                        document.getElementById('solution-status-badge').textContent = '-';
                        document.getElementById('solution-status-badge').className = 'bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded-full';
                    }
                }

                // Payment method buttons
                const paymentButtons = document.querySelectorAll('[data-payment-method]');
                paymentButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const methodName = this.getAttribute('data-payment-method');
                        const checkbox = document.querySelector(`[data-payment-method-input="${methodName}"]`);
                        
                        if (checkbox) {
                            checkbox.checked = !checkbox.checked;
                        }
                        
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

                // Tag management
                const addTagBtn = document.getElementById('add-tag-btn');
                const tagsContainer = document.getElementById('tags-container');
                const tagModal = document.getElementById('tag-modal');
                const tagModalClose = document.getElementById('tag-modal-close');
                const tagModalCancel = document.getElementById('tag-modal-cancel');
                const tagModalSave = document.getElementById('tag-modal-save');
                const tagNameInput = document.getElementById('tag-name-input');

                function openTagModal() {
                    if (!tagModal) return;
                    tagModal.classList.remove('hidden');
                    tagModal.classList.add('flex');
                    if (tagNameInput) {
                        tagNameInput.value = '';
                        tagNameInput.focus();
                    }
                }

                function closeTagModal() {
                    if (!tagModal) return;
                    tagModal.classList.add('hidden');
                    tagModal.classList.remove('flex');
                }

                function addTagFromInput() {
                    const tagName = tagNameInput ? tagNameInput.value.trim() : '';
                    if (!tagName) return;
                    const existingTags = Array.from(tagsContainer.querySelectorAll('input[name="internal_tags[]"]'))
                        .map(input => input.value.toLowerCase());
                    if (existingTags.includes(tagName.toLowerCase())) {
                        tagNameInput.focus();
                        return;
                    }
                    const tagSpan = document.createElement('span');
                    tagSpan.setAttribute('data-tag', '');
                    tagSpan.className = 'bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-2';
                    tagSpan.innerHTML = `
                        ${tagName}
                        <input type="hidden" name="internal_tags[]" value="${tagName}">
                        <button type="button" data-tag-remove class="hover:text-purple-900"><i class="fa-solid fa-xmark text-xs"></i></button>
                    `;
                    tagsContainer.insertBefore(tagSpan, addTagBtn);

                    // Add remove listener
                    tagSpan.querySelector('[data-tag-remove]').addEventListener('click', function(e) {
                        e.preventDefault();
                        tagSpan.remove();
                    });

                    closeTagModal();
                }
                
                if (addTagBtn) {
                    addTagBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        openTagModal();
                    });
                }

                if (tagModalClose) {
                    tagModalClose.addEventListener('click', function(e) {
                        e.preventDefault();
                        closeTagModal();
                    });
                }

                if (tagModalCancel) {
                    tagModalCancel.addEventListener('click', function(e) {
                        e.preventDefault();
                        closeTagModal();
                    });
                }

                if (tagModalSave) {
                    tagModalSave.addEventListener('click', function(e) {
                        e.preventDefault();
                        addTagFromInput();
                    });
                }

                if (tagNameInput) {
                    tagNameInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            addTagFromInput();
                        }
                    });
                }

                if (tagModal) {
                    tagModal.addEventListener('click', function(e) {
                        if (e.target === tagModal) {
                            closeTagModal();
                        }
                    });
                }

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && tagModal && !tagModal.classList.contains('hidden')) {
                        closeTagModal();
                    }
                });

                // Tag removal
                document.querySelectorAll('[data-tag-remove]').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        this.closest('[data-tag]').remove();
                    });
                });

                // Form submission handler
                const form = document.getElementById('onboarding-form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Validate required fields
                        const solutionId = document.querySelector('select[name="solution_id"]').value;
                        const legalName = document.querySelector('input[name="legal_business_name"]').value;
                        const email = document.querySelector('input[name="merchant_contact_email"]').value;
                        const country = document.querySelector('select[name="country_of_operation"]').value;
                        
                        if (!solutionId || !legalName || !email || !country) {
                            e.preventDefault();
                            alert('Please fill all required fields');
                            return false;
                        }
                    });
                }

                // Copy KYC Link with feedback
                const copyBtn = document.querySelector('.copy-kyc-link-btn');
                if (copyBtn) {
                    copyBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const link = this.getAttribute('data-kyc-link');
                        console.log('Copying link:', link);
                        
                        // Fallback method for non-HTTPS environments
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(link).then(() => {
                                showCopySuccess(this);
                            }).catch(err => {
                                console.error('Clipboard API failed:', err);
                                copyViaTextarea(link, this);
                            });
                        } else {
                            // Fallback for older browsers or non-HTTPS
                            copyViaTextarea(link, this);
                        }
                    });
                }

                function copyViaTextarea(text, btn) {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        document.execCommand('copy');
                        console.log('Copy via textarea successful');
                        showCopySuccess(btn);
                    } catch (err) {
                        console.error('Copy failed:', err);
                        alert('Failed to copy link');
                    }
                    document.body.removeChild(textarea);
                }

                function showCopySuccess(btn) {
                    const originalClass = btn.className;
                    
                    // Show success state
                    btn.innerHTML = '<i class="fa-solid fa-check text-xs"></i> Copied!';
                    btn.className = 'copy-kyc-link-btn bg-green-600 text-white px-3 py-1.5 rounded text-sm font-medium flex items-center gap-2';
                    
                    // Restore after 2 seconds
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fa-regular fa-copy text-xs"></i> Copy Link';
                        btn.className = originalClass;
                    }, 2000);
                }
            });

            // Copy to clipboard utility
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    alert('Link copied to clipboard!');
                }).catch(function(err) {
                    console.error('Failed to copy: ', err);
                });
            }

            // Old copyKycLink function for backwards compatibility
            function copyKycLink(link) {
                navigator.clipboard.writeText(link).then(function() {
                    alert('Link copied to clipboard!');
                }).catch(function(err) {
                    alert('Failed to copy link: ' + err);
                });
            }
        </script>

    </body>
@endsection

