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
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">

                <!-- Page Title -->
                <h1 id="page-title" class="text-[28px] font-bold text-brand-primary mb-6">Merchant Onboarding</h1>

                <!-- Summary Cards Section -->
                <section id="summary-cards" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
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
                <section id="cta-panel" class="bg-white rounded-2xl p-6 md:p-8 shadow-lg mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="flex-1">
                            <h2 class="text-[22px] font-semibold text-brand-primary mb-2">Start a New Merchant Onboarding</h2>
                            <p class="text-sm text-[#595959] mb-5">Create an onboarding request and send it to the merchant to begin the KYC process.</p>
                            <a href="{{ route('admin.onboarding.start') }}" class="bg-brand-cta hover:bg-brand-ctaHover text-white font-medium px-6 py-3 rounded-lg w-full sm:w-[260px] h-12 flex items-center justify-center gap-2 transition-colors">
                                <i class="fa-solid fa-plus text-sm"></i>
                                Start New Onboarding
                            </a>
                        </div>
                        <div class="md:ml-8 flex md:block justify-center">
                            <i class="fa-solid fa-user-plus text-5xl md:text-6xl text-brand-primary/10"></i>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($onboardings as $onboarding)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $onboarding->legal_business_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->partner->title ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->solution->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->acquirer_names }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'draft' => 'bg-gray-100 text-gray-800',
                                                'sent' => 'bg-blue-100 text-blue-800',
                                                'in-review' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'active' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'suspended' => 'bg-orange-100 text-orange-800',
                                            ];
                                            $statusClass = $statusColors[$onboarding->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">{{ ucfirst(str_replace('-', ' ', $onboarding->status)) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->updated_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                        <a href="{{ route('admin.onboarding.track', $onboarding) }}" class="text-brand-secondary hover:text-brand-primary font-medium">View</a>
                                        <a href="{{ route('admin.onboarding.edit', $onboarding) }}" class="text-brand-primary hover:text-brand-secondary font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.onboarding.destroy', $onboarding) }}" class="inline-block" onsubmit="return confirm('Sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        No onboarding requests found. <a href="{{ route('admin.onboarding.create') }}" class="text-brand-primary font-medium">Create one</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $onboardings->links() }}
                    </div>
                </section>
            </div>
        </main>

    </body>
@endsection

