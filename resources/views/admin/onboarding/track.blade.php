@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Onboarding Details - 2iZii</title>
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
                        },
                        primary: '#2D3A74',
                        accent: '#4055A8',
                        cta: '#FF7C00',
                        bgLight: '#F7F8FA',
                        success: '#27AE60',
                        danger: '#E74C3C',
                        matrixBg: '#F3F6FF',
                        matrixBorder: '#D8E2FF'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        ::-webkit-scrollbar-track { background: transparent; }
        .nav-item-active {
            background: rgba(255,255,255,0.15);
            border-left: 4px solid #FF7C00;
            padding-left: 20px;
        }
        .nav-item {
            padding-left: 24px;
        }
        .tab-btn.active { border-bottom: 2px solid #4055A8; color: #2D3A74; font-weight: 600; }
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral">

        <x-admin.sidebar active="merchant-onboarding" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Merchant Onboarding', 'url' => route('admin.onboarding.index')],
            ['label' => 'Onboarding Details', 'url' => route('admin.onboarding.track', $onboarding)],
        ]" />

        @php
            $statusColors = [
                'draft' => ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-700', 'icon' => 'fa-file-pen'],
                'sent' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'icon' => 'fa-paper-plane'],
                'in-review' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-700', 'icon' => 'fa-clock'],
                'approved' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
                'rejected' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-700', 'icon' => 'fa-times-circle'],
                'active' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'icon' => 'fa-circle-check'],
                'suspended' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-700', 'icon' => 'fa-ban'],
            ];
            $currentStatus = $statusColors[$onboarding->status] ?? $statusColors['draft'];
        @endphp

        <!-- MAIN CONTENT WRAPPER -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral flex flex-col">
            <!-- SCROLLABLE CONTENT AREA -->
            <div class="flex-1 overflow-y-auto bg-brand-neutral p-4 md:p-8">
                <div class="max-w-[1280px] mx-auto space-y-6">
                    <!-- Page Header Section -->
                    <div class="space-y-3">
                        <h1 class="text-2xl font-bold text-brand-primary">Onboarding Details — {{ $onboarding->legal_business_name }}</h1>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="bg-gray-100 border border-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">ID: {{ $onboarding->request_id }}</span>

                            @if($country)
                                <span class="bg-blue-50 border border-blue-200 text-brand-secondary px-3 py-1 rounded-full text-xs font-medium">{{ $country->code }} {{ $country->name }}</span>
                            @else
                                <span class="bg-blue-50 border border-blue-200 text-brand-secondary px-3 py-1 rounded-full text-xs font-medium">{{ $onboarding->country_of_operation }}</span>
                            @endif

                            @if($onboarding->solution)
                                <span class="bg-purple-50 border border-purple-200 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">{{ $onboarding->solution->name }}</span>
                            @endif

                            @if($paymentMethodNames->isNotEmpty())
                                <span class="bg-indigo-50 border border-indigo-200 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium">{{ $paymentMethodNames->join(', ') }}</span>
                            @endif

                            <span class="{{ $currentStatus['bg'] }} border {{ $currentStatus['border'] }} {{ $currentStatus['text'] }} px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1.5">
                                <i class="fa-solid {{ $currentStatus['icon'] }} text-xs"></i>
                                {{ ucfirst(str_replace('-', ' ', $onboarding->status)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Solution Matrix -->
                    <section class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-base font-semibold text-brand-primary">Payment Solution Matrix</h2>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fa-solid fa-lock"></i>
                                <span>Read-only view</span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm min-w-[720px]">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Acquirer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Mode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Reference ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Last Update</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($acquirerRecords as $acquirer)
                                        @php
                                            $initials = strtoupper(substr($acquirer->name, 0, 2));
                                            $modeLabel = ucfirst($acquirer->mode ?? 'N/A');
                                            $modeColors = [
                                                'email' => 'bg-blue-50 text-blue-800',
                                                'api' => 'bg-purple-50 text-purple-800',
                                            ];
                                            $modeClass = $modeColors[strtolower($acquirer->mode ?? '')] ?? 'bg-gray-50 text-gray-800';
                                            $colorSets = ['bg-gray-100 text-gray-600', 'bg-indigo-100 text-indigo-600', 'bg-blue-100 text-blue-600', 'bg-green-100 text-green-600'];
                                            $colorSet = $colorSets[$loop->index % count($colorSets)];
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-8 h-8 {{ explode(' ', $colorSet)[0] }} rounded flex items-center justify-center text-xs font-bold {{ explode(' ', $colorSet)[1] }}">{{ $initials }}</div>
                                                    <span class="font-medium text-gray-900">{{ $acquirer->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="{{ $modeClass }} px-2 py-1 rounded-full text-xs font-semibold">{{ $modeLabel }}</span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <span class="{{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5 w-fit">
                                                    <i class="fa-solid {{ $currentStatus['icon'] }} text-xs"></i>
                                                    {{ ucfirst(str_replace('-', ' ', $onboarding->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 text-gray-600">{{ $onboarding->request_id }}</td>
                                            <td class="px-6 py-5 text-gray-600">{{ $onboarding->updated_at->format('M d, H:i') }}</td>
                                            <td class="px-6 py-5 text-right">
                                                <a href="#" class="text-brand-secondary text-sm font-medium hover:underline">View Logs</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No acquirers assigned to this onboarding.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Export KYC Data -->
                    <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-base font-semibold text-brand-primary mb-1">Export KYC Data</h3>
                                <p class="text-sm text-gray-500">Download the full onboarding package or specific components.</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <button class="bg-brand-cta text-white px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 hover:bg-orange-500 transition-colors">
                                    <i class="fa-solid fa-download text-xs"></i>
                                    Full Package (ZIP)
                                </button>
                                <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                    Summary PDF
                                </button>
                                <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-code text-xs"></i>
                                    JSON Payload
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Main Content Area with Tabs -->
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Left Column: Tabbed Content -->
                        <div class="flex-1 min-w-0">
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                <!-- Tab Navigation -->
                                <div class="border-b border-gray-200 overflow-x-auto">
                                    <div class="flex min-w-max">
                                        <button onclick="switchTab('company')" id="tab-company" class="tab-btn active px-4 py-4 text-sm font-semibold text-brand-primary border-b-2 border-brand-secondary">Company Info</button>
                                        <button onclick="switchTab('owners')" id="tab-owners" class="tab-btn px-4 py-4 text-sm font-normal text-gray-500 hover:text-brand-primary">Beneficial Owners</button>
                                        <button onclick="switchTab('docs')" id="tab-docs" class="tab-btn px-4 py-4 text-sm font-normal text-gray-500 hover:text-brand-primary">Documents</button>
                                        <button onclick="switchTab('bank')" id="tab-bank" class="tab-btn px-4 py-4 text-sm font-normal text-gray-500 hover:text-brand-primary">Bank Info</button>
                                        <button onclick="switchTab('activity')" id="tab-activity" class="tab-btn px-4 py-4 text-sm font-normal text-gray-500 hover:text-brand-primary">Activity Log</button>
                                    </div>
                                </div>

                                <!-- Tab Content: Company Info -->
                                <div id="content-company" class="tab-content block bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
                                        <h3 class="text-lg font-semibold text-gray-800">General Information</h3>
                                        <a href="{{ route('admin.onboarding.edit', $onboarding) }}" class="text-accent hover:text-primary text-sm font-medium border border-accent rounded-lg px-4 py-2 transition-colors">
                                            <i class="fa-solid fa-pen mr-2"></i> Edit Section
                                        </a>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Legal Name</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->legal_business_name }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Trade Name</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->trading_name ?? '—' }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Registration Number</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->registration_number ?? '—' }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Country of Operation</label>
                                            <div class="text-gray-900 font-medium">{{ $country->name ?? $onboarding->country_of_operation }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Solution</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->solution->name ?? '—' }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Partner</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->partner->title ?? '—' }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Website URL</label>
                                            @if($onboarding->business_website)
                                                <a href="{{ $onboarding->business_website }}" target="_blank" class="text-accent hover:underline font-medium">{{ $onboarding->business_website }}</a>
                                            @else
                                                <div class="text-gray-900 font-medium">—</div>
                                            @endif
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Contact Email</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->merchant_contact_email }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Phone Number</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->merchant_phone_number ?? '—' }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Payment Methods</label>
                                            <div class="text-gray-900 font-medium">{{ $paymentMethodNames->isNotEmpty() ? $paymentMethodNames->join(', ') : ($onboarding->payment_method_names ?: '—') }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Acquirer(s)</label>
                                            <div class="text-gray-900 font-medium">{{ $acquirerRecords->pluck('name')->join(', ') ?: ($onboarding->acquirer_names ?: '—') }}</div>
                                        </div>
                                        @if($onboarding->priceList)
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Price List</label>
                                            <div class="text-gray-900 font-medium">{{ $onboarding->priceList->name }}</div>
                                        </div>
                                        @endif
                                        <div class="col-span-2">
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">KYC Link</label>
                                            @if($onboarding->kyc_link)
                                                <div class="bg-gray-100 rounded-md p-4 flex items-center justify-between gap-4">
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        <i class="fa-solid fa-link text-gray-400 shrink-0"></i>
                                                        <a href="{{ route('merchant.kyc.start', $onboarding->kyc_link) }}" target="_blank" class="font-mono text-sm text-accent hover:underline truncate" id="kyc-link-text">{{ route('merchant.kyc.start', $onboarding->kyc_link) }}</a>
                                                    </div>
                                                    <button type="button" class="copy-kyc-link-btn bg-brand-primary text-white px-3 py-1.5 rounded text-sm font-medium flex items-center gap-2 hover:bg-brand-secondary transition-colors shrink-0" data-kyc-link="{{ route('merchant.kyc.start', $onboarding->kyc_link) }}">
                                                        <i class="fa-regular fa-copy text-xs"></i>
                                                        Copy Link
                                                    </button>
                                                </div>
                                            @else
                                                <div class="bg-gray-100 rounded-md p-4 flex items-center justify-between gap-4">
                                                    <div class="flex items-center gap-3 flex-1">
                                                        <i class="fa-solid fa-link text-gray-300"></i>
                                                        <span class="font-mono text-sm text-gray-400 italic">Link will be generated after sending</span>
                                                    </div>
                                                    <button type="button" disabled class="bg-gray-200 text-gray-400 px-3 py-1.5 rounded text-sm font-medium flex items-center gap-2 cursor-not-allowed shrink-0">
                                                        <i class="fa-regular fa-copy text-xs"></i>
                                                        Copy Link
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Content: Documents -->
                                <div id="content-docs" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
                                        <h3 class="text-lg font-semibold text-gray-800">Uploaded Documents</h3>
                                        <button class="bg-primary text-white text-sm font-medium rounded-lg px-4 py-2 hover:bg-opacity-90 transition-colors">
                                            <i class="fa-solid fa-upload mr-2"></i> Upload New
                                        </button>
                                    </div>
                                    
                                    <p class="text-gray-500 text-sm">Documents will appear here once uploaded by the merchant through the KYC form.</p>
                                </div>

                                <!-- Tab Content: Beneficial Owners -->
                                <div id="content-owners" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Beneficial Owners</h3>
                                    <p class="text-gray-500 text-sm">Beneficial owner information will be available once the merchant completes the KYC form.</p>
                                </div>

                                <!-- Tab Content: Bank Info -->
                                <div id="content-bank" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Bank Information</h3>
                                    <p class="text-gray-500 text-sm">Bank information will be available once the merchant completes the KYC form.</p>
                                </div>

                                <!-- Tab Content: Activity Log -->
                                <div id="content-activity" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Activity Timeline</h3>
                                    <div class="space-y-4">
                                        @if($onboarding->kyc_completed_at)
                                            <div class="flex gap-4">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium text-gray-800">KYC Completed</div>
                                                    <div class="text-xs text-gray-500">{{ $onboarding->kyc_completed_at->format('M d, Y - h:i A') }}</div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($onboarding->approved_at)
                                            <div class="flex gap-4">
                                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium text-gray-800">Onboarding Approved</div>
                                                    <div class="text-xs text-gray-500">{{ $onboarding->approved_at->format('M d, Y - h:i A') }}
                                                        @if($onboarding->approver) by {{ $onboarding->approver->name }} @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($onboarding->sent_at)
                                            <div class="flex gap-4">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium text-gray-800">KYC Link Sent to Merchant</div>
                                                    <div class="text-xs text-gray-500">{{ $onboarding->sent_at->format('M d, Y - h:i A') }}</div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex gap-4">
                                            <div class="w-2 h-2 bg-accent rounded-full mt-2"></div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-800">Onboarding Created</div>
                                                <div class="text-xs text-gray-500">{{ $onboarding->created_at->format('M d, Y - h:i A') }}
                                                    @if($onboarding->creator) by {{ $onboarding->creator->name }} @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Sidebar -->
                        <aside class="w-full lg:w-80 space-y-6">
                            <!-- Onboarding Summary -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                                <h3 class="text-sm font-semibold text-brand-primary mb-4">Onboarding Summary</h3>
                                
                                <!-- KYC Completion -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs text-gray-500">KYC Completion</span>
                                        <span class="text-xs font-medium text-brand-secondary">{{ $kycPercent }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-brand-secondary h-2 rounded-full" style="width: {{ $kycPercent }}%"></div>
                                    </div>
                                </div>

                                <!-- Internal Notes -->
                                @if($onboarding->internal_notes)
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Internal Notes</label>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded px-3 py-2.5 text-xs text-yellow-800">
                                        <i class="fa-solid fa-exclamation-circle mr-1.5"></i>
                                        {{ $onboarding->internal_notes }}
                                    </div>
                                </div>
                                @endif

                                @if($onboarding->rejection_reason)
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Rejection Reason</label>
                                    <div class="bg-red-50 border border-red-200 rounded px-3 py-2.5 text-xs text-red-800">
                                        <i class="fa-solid fa-times-circle mr-1.5"></i>
                                        {{ $onboarding->rejection_reason }}
                                    </div>
                                </div>
                                @endif

                                <!-- Merchant Contact -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Merchant Contact</label>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 bg-brand-secondary text-white rounded-full flex items-center justify-center text-xs font-bold">
                                            {{ strtoupper(substr($onboarding->legal_business_name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-brand-primary">{{ $onboarding->legal_business_name }}</span>
                                    </div>
                                    <div class="pl-8 space-y-1">
                                        <p class="text-xs text-gray-500">{{ $onboarding->merchant_contact_email }}</p>
                                        @if($onboarding->merchant_phone_number)
                                            <p class="text-xs text-gray-500">{{ $onboarding->merchant_phone_number }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Internal Tags -->
                                @if(!empty($onboarding->internal_tags))
                                <div class="border-t border-gray-100 pt-4">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Internal Tags</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($onboarding->internal_tags as $tag)
                                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-medium">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Revision Count -->
                                @if($onboarding->revision_count > 0)
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">Revisions</span>
                                        <span class="text-xs font-medium text-brand-secondary">{{ $onboarding->revision_count }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Recent Activity -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                                <h3 class="text-sm font-semibold text-brand-primary mb-4">Recent Activity</h3>
                                <div class="border-l-2 border-gray-100 pl-4 space-y-6">
                                    @if($onboarding->kyc_completed_at)
                                    <div class="relative">
                                        <div class="absolute -left-[21px] w-3 h-3 bg-green-500 rounded-full border-4 border-white"></div>
                                        <div class="text-xs text-gray-500 mb-1">{{ $onboarding->kyc_completed_at->format('M d, H:i') }}</div>
                                        <div class="text-sm font-medium text-brand-primary">KYC form completed</div>
                                    </div>
                                    @endif

                                    @if($onboarding->approved_at)
                                    <div class="relative">
                                        <div class="absolute -left-[21px] w-3 h-3 bg-green-500 rounded-full border-4 border-white"></div>
                                        <div class="text-xs text-gray-500 mb-1">{{ $onboarding->approved_at->format('M d, H:i') }}</div>
                                        <div class="text-sm font-medium text-brand-primary">Onboarding approved</div>
                                    </div>
                                    @endif

                                    @if($onboarding->sent_at)
                                    <div class="relative">
                                        <div class="absolute -left-[21px] w-3 h-3 bg-blue-500 rounded-full border-4 border-white"></div>
                                        <div class="text-xs text-gray-500 mb-1">{{ $onboarding->sent_at->format('M d, H:i') }}</div>
                                        <div class="text-sm font-medium text-brand-primary">KYC link sent to merchant</div>
                                    </div>
                                    @endif

                                    <div class="relative">
                                        <div class="absolute -left-[21px] w-3 h-3 bg-brand-secondary rounded-full border-4 border-white"></div>
                                        <div class="text-xs text-gray-500 mb-1">{{ $onboarding->created_at->format('M d, H:i') }}</div>
                                        <div class="text-sm font-medium text-brand-primary">Onboarding created</div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <button onclick="switchTab('activity')" class="text-brand-secondary text-xs font-medium">View full activity log →</button>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>

        </main>

        <script>
            // Copy KYC Link with feedback
            document.addEventListener('DOMContentLoaded', function() {
                const copyBtn = document.querySelector('.copy-kyc-link-btn');
                if (copyBtn) {
                    copyBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const link = this.getAttribute('data-kyc-link');
                        const btn = this;

                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(link).then(function() {
                                showCopySuccess(btn);
                            }).catch(function() {
                                copyViaTextarea(link, btn);
                            });
                        } else {
                            copyViaTextarea(link, btn);
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
                        showCopySuccess(btn);
                    } catch (err) {
                        alert('Failed to copy link');
                    }
                    document.body.removeChild(textarea);
                }

                function showCopySuccess(btn) {
                    const originalHTML = btn.innerHTML;
                    const originalClass = btn.className;
                    btn.innerHTML = '<i class="fa-solid fa-check text-xs"></i> Copied!';
                    btn.className = 'copy-kyc-link-btn bg-green-600 text-white px-3 py-1.5 rounded text-sm font-medium flex items-center gap-2 shrink-0';
                    setTimeout(() => {
                        btn.innerHTML = originalHTML;
                        btn.className = originalClass;
                    }, 2000);
                }
            });

            function switchTab(tabName) {
                const tabs = document.querySelectorAll('.tab-btn');
                const contents = document.querySelectorAll('.tab-content');

                tabs.forEach(tab => {
                    tab.classList.remove('active', 'font-semibold', 'text-brand-primary', 'border-brand-secondary');
                    tab.classList.add('font-normal', 'text-gray-500');
                    tab.style.borderBottom = 'none';
                });
                contents.forEach(content => content.classList.add('hidden'));
                contents.forEach(content => content.classList.remove('block'));

                const activeTab = document.getElementById('tab-' + tabName);
                const activeContent = document.getElementById('content-' + tabName);
                
                if (activeTab) {
                    activeTab.classList.add('active', 'font-semibold', 'text-brand-primary');
                    activeTab.classList.remove('font-normal', 'text-gray-500');
                    activeTab.style.borderBottom = '2px solid #4055A8';
                }
                
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                    activeContent.classList.add('block');
                }
            }
        </script>

    </body>
@endsection

