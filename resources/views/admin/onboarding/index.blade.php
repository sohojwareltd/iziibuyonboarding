@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral">

        <x-admin.sidebar active="merchant-onboarding" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Merchant Onboarding', 'url' => route('admin.onboarding.index')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral">
            <div class="p-8">

                <!-- Page Title -->
                <h1 id="page-title" class="text-[28px] font-bold text-brand-primary mb-6">Merchant Onboarding</h1>

                <!-- Summary Cards Section -->
                <section id="summary-cards" class="grid grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">New Requests Today</p>
                                <p class="text-[26px] font-bold text-brand-primary">12</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">In Progress</p>
                                <p class="text-[26px] font-bold text-brand-primary">34</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">Submitted to Acquirers</p>
                                <p class="text-[26px] font-bold text-brand-primary">18</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">Approved Merchants</p>
                                <p class="text-[26px] font-bold text-brand-primary">102</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>
                </section>

                <!-- Primary CTA Panel -->
                <section id="cta-panel" class="bg-white rounded-2xl p-8 shadow-lg mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h2 class="text-[22px] font-semibold text-brand-primary mb-2">Start a New Merchant Onboarding</h2>
                            <p class="text-sm text-[#595959] mb-5">Create an onboarding request and send it to the merchant to begin the KYC process.</p>
                            <a href="{{ route('admin.onboarding.start') }}" class="bg-brand-cta hover:bg-brand-ctaHover text-white font-medium px-6 py-3 rounded-lg w-[260px] h-12 flex items-center justify-center gap-2 transition-colors">
                                <i class="fa-solid fa-plus text-sm"></i>
                                Start New Onboarding
                            </a>
                        </div>
                        <div class="ml-8">
                            <i class="fa-solid fa-user-plus text-6xl text-brand-primary/10"></i>
                        </div>
                    </div>
                </section>

                <!-- Recent Onboardings Table -->
                <section id="recent-onboardings" class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-brand-primary">Recent Onboarding Requests</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Merchant Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solution</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acquirer(s)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TechFlow Solutions</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">FinancePartner</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">E-commerce Gateway</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Stripe, PayPal</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Submitted</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 hours ago</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Digital Commerce Ltd</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">PaymentHub</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mobile Payments</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Square</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Started</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4 hours ago</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Retail Express Inc</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">MerchantGateway</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">POS Integration</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Adyen</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 day ago</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Global Trade Co</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">FinancePartner</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">International Gateway</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">WorldPay, Stripe</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending More Info</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 days ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>

    </body>
@endsection

