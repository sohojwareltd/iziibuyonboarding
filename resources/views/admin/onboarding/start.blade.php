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

        <header id="header" class="fixed top-0 left-[260px] right-0 h-16 bg-white border-b border-gray-200 flex items-center justify-end px-8 z-40">
            <div class="flex items-center gap-6">
                <!-- Notification Bell -->
                <button class="text-brand-text hover:text-brand-primary transition-colors relative">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Admin Profile -->
                <div class="flex items-center gap-3 cursor-pointer group">
                    <img src="https://storage.googleapis.com/uxpilot-auth.appspot.com/avatars/avatar-2.jpg" alt="Admin Avatar" class="w-8 h-8 rounded-full object-cover">
                    <i class="fa-solid fa-chevron-down text-xs text-brand-text group-hover:text-brand-primary transition-colors"></i>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="ml-[260px] pt-16 pb-24 min-h-screen bg-brand-neutral">
            <div class="p-8">

                <!-- Page Title -->
                <h1 id="page-title" class="text-[28px] font-bold text-brand-primary mb-6 text-center">Start New Onboarding</h1>

                <!-- Form Container -->
                <div id="form-container" class="max-w-[960px] mx-auto bg-white rounded-2xl p-8 shadow-sm">

                    <!-- Section A: Partner & Merchant Information -->
                    <section id="partner-merchant-section" class="mb-8">
                        <h2 class="text-[20px] font-semibold text-brand-primary mb-4">Partner & Merchant Information</h2>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Partner</label>
                                <select class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none">
                                    <option value="">Choose Partner</option>
                                    <option value="digitax">Digitax</option>
                                    <option value="2izii-direct">2iZii Direct</option>
                                    <option value="taxi-group">Taxi Group</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Merchant Legal Name</label>
                                <input type="text" class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none" placeholder="Enter registered name of the merchant">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                <select class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none">
                                    <option value="">Select Country</option>
                                    <option value="norway">Norway</option>
                                    <option value="sweden">Sweden</option>
                                    <option value="denmark">Denmark</option>
                                    <option value="finland">Finland</option>
                                    <option value="iceland">Iceland</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Merchant Email Address</label>
                                <input type="email" class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none" placeholder="merchant@example.com">
                            </div>

                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Merchant Phone Number (Optional)</label>
                                <input type="text" class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none" placeholder="+47 ...">
                            </div>
                        </div>
                    </section>

                    <!-- Section B: Product & Acquirer Configuration -->
                    <section id="product-acquirer-section" class="mb-8">
                        <h2 class="text-[20px] font-semibold text-brand-primary mb-4">Product & Acquirer Configuration</h2>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Solution</label>
                                <select class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none">
                                    <option value="">Choose Solution</option>
                                    <option value="ecommerce">E-commerce Gateway</option>
                                    <option value="pos">POS Integration</option>
                                    <option value="mobile">Mobile Payments</option>
                                    <option value="international">International Gateway</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Primary Acquirer</label>
                                <select class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none">
                                    <option value="">Auto-filled from Solution</option>
                                    <option value="elavon">Elavon</option>
                                    <option value="surfboard">Surfboard</option>
                                    <option value="adyen">Adyen</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Enabled Payment Methods</label>
                            <div class="flex flex-wrap gap-3">
                                <button class="pill-selected px-4 py-2 rounded-full border text-sm font-medium transition-colors">
                                    Card
                                </button>
                                <button class="pill-unselected px-4 py-2 rounded-full border text-sm font-medium transition-colors hover:border-brand-cta">
                                    Vipps
                                </button>
                                <button class="pill-unselected px-4 py-2 rounded-full border text-sm font-medium transition-colors hover:border-brand-cta">
                                    MobilePay
                                </button>
                                <button class="pill-unselected px-4 py-2 rounded-full border text-sm font-medium transition-colors hover:border-brand-cta">
                                    Bank Transfer
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Acquirers (Multi-select)</label>
                            <select class="w-full h-12 px-4 border border-brand-border rounded-lg focus:border-brand-secondary focus:outline-none">
                                <option value="">Select additional acquirers</option>
                                <option value="stripe">Stripe</option>
                                <option value="paypal">PayPal</option>
                                <option value="worldpay">WorldPay</option>
                            </select>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-brand-cta p-3 rounded">
                            <p class="text-xs text-gray-600">KYC requirements will expand based on selected acquirers.</p>
                        </div>
                    </section>

                    <!-- Section C: Onboarding Link Generation -->
                    <section id="link-generation-section">
                        <h2 class="text-[20px] font-semibold text-brand-primary mb-4">Onboarding Link Generation</h2>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview of Generated Link</label>
                            <input type="text" class="w-full h-12 px-4 border border-brand-border rounded-lg bg-gray-50" placeholder="https://onboarding.2izii.com/start/MOB-XXXXXX" disabled>
                        </div>

                        <div class="flex gap-4">
                            <button class="bg-brand-secondary hover:bg-brand-primary text-white font-medium px-6 py-3 rounded-lg w-[180px] h-11 transition-colors">
                                Generate Link
                            </button>
                            <button class="bg-white border border-brand-secondary text-brand-secondary hover:bg-brand-secondary hover:text-white font-medium px-6 py-3 rounded-lg w-[150px] h-11 transition-colors">
                                Copy Link
                            </button>
                            <button class="bg-brand-cta hover:bg-brand-ctaHover text-white font-medium px-6 py-3 rounded-lg w-[220px] h-11 flex items-center justify-center gap-2 transition-colors">
                                <i class="fa-solid fa-envelope text-sm"></i>
                                Send Email to Merchant
                            </button>
                        </div>
                    </section>
                </div>
            </div>
        </main>

        <!-- Fixed Bottom Action Bar -->
        <div id="bottom-action-bar" class="fixed bottom-0 left-[260px] right-0 bg-white border-t border-gray-200 px-8 py-4 flex justify-end gap-4 shadow-lg z-30">
            <button class="bg-white border border-brand-primary text-brand-primary hover:bg-brand-primary hover:text-white font-medium px-6 py-3 rounded-lg w-[130px] h-11 transition-colors">
                Cancel
            </button>
            <button class="bg-white border border-brand-cta text-brand-cta hover:bg-brand-cta hover:text-white font-medium px-6 py-3 rounded-lg w-[140px] h-11 transition-colors">
                Save Draft
            </button>
            <a href="{{ route('merchant.kyc.welcome') }}" class="bg-brand-primary hover:bg-brand-secondary text-white font-medium px-6 py-3 rounded-lg w-[220px] h-11 transition-colors text-center">
                Proceed to KYC Overview
            </a>
        </div>

        <script>
            // Payment method pill toggle functionality
            document.addEventListener('DOMContentLoaded', function() {
                const pills = document.querySelectorAll('.pill-unselected, .pill-selected');

                pills.forEach(pill => {
                    pill.addEventListener('click', function() {
                        if (this.classList.contains('pill-selected')) {
                            this.classList.remove('pill-selected');
                            this.classList.add('pill-unselected');
                        } else {
                            this.classList.remove('pill-unselected');
                            this.classList.add('pill-selected');
                        }
                    });
                });
            });
        </script>

    </body>
@endsection

