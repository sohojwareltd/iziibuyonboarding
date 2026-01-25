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
            ['label' => 'Onboarding Details', 'url' => route('admin.onboarding.track')],
        ]" />

        <!-- MAIN CONTENT WRAPPER -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral flex flex-col">
            <!-- SCROLLABLE CONTENT AREA -->
            <div class="flex-1 overflow-y-auto bg-brand-neutral p-4 md:p-8">
                <div class="max-w-[1280px] mx-auto space-y-6">
                    <!-- Page Header Section -->
                    <div class="space-y-3">
                        <h1 class="text-2xl font-bold text-brand-primary">Onboarding Details — Nordic Retail Group AS</h1>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="bg-gray-100 border border-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">ID: MOB-839201</span>
                            <span class="bg-blue-50 border border-blue-200 text-brand-secondary px-3 py-1 rounded-full text-xs font-medium">🇳🇴 Norway</span>
                            <span class="bg-purple-50 border border-purple-200 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">POS, E-commerce</span>
                            <span class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-clock text-xs"></i>
                                Awaiting Acquirer Review
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
                                    <tr>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center text-xs font-bold text-gray-600">EL</div>
                                                <span class="font-medium text-gray-900">Elavon</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="bg-blue-50 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">Email</span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5 w-fit">
                                                <i class="fa-solid fa-exclamation-circle text-xs"></i>
                                                More Info Required
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-gray-600">MID-9928371</td>
                                        <td class="px-6 py-5 text-gray-600">Oct 24, 14:30</td>
                                        <td class="px-6 py-5 text-right">
                                            <a href="#" class="text-brand-secondary text-sm font-medium hover:underline">View Logs</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-8 h-8 bg-indigo-100 rounded flex items-center justify-center text-xs font-bold text-indigo-600">SB</div>
                                                <span class="font-medium text-gray-900">Surfboard</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="bg-purple-50 text-purple-800 px-2 py-1 rounded-full text-xs font-semibold">API</span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5 w-fit">
                                                <i class="fa-solid fa-check-circle text-xs"></i>
                                                Approved
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-gray-600">APP-772819</td>
                                        <td class="px-6 py-5 text-gray-600">Oct 23, 09:15</td>
                                        <td class="px-6 py-5 text-right">
                                            <a href="#" class="text-brand-secondary text-sm font-medium hover:underline">View Logs</a>
                                        </td>
                                    </tr>
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
                                        <button class="text-accent hover:text-primary text-sm font-medium border border-accent rounded-lg px-4 py-2 transition-colors">
                                            <i class="fa-solid fa-pen mr-2"></i> Edit Section
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Legal Name</label>
                                            <div class="text-gray-900 font-medium">TechNova Solutions L.L.C</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Trade Name</label>
                                            <div class="text-gray-900 font-medium">TechNova</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Registration Number</label>
                                            <div class="text-gray-900 font-medium">CN-3829102</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Date of Incorporation</label>
                                            <div class="text-gray-900 font-medium">15 Jan 2020</div>
                                        </div>
                                        <div class="col-span-2">
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Registered Address</label>
                                            <div class="text-gray-900 font-medium">Office 204, Building 5, Dubai Internet City, Dubai, UAE</div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Website URL</label>
                                            <a href="#" class="text-accent hover:underline font-medium">https://technova.ae</a>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase mb-1">Tax Registration (TRN)</label>
                                            <div class="text-gray-900 font-medium">100293847561234</div>
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
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <!-- Doc Card 1 -->
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow group">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="w-10 h-10 bg-red-50 text-red-500 rounded flex items-center justify-center text-xl">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </div>
                                                <button class="text-gray-400 hover:text-accent"><i class="fa-solid fa-download"></i></button>
                                            </div>
                                            <div class="text-sm font-medium text-gray-800 truncate mb-1">Trade_License.pdf</div>
                                            <div class="text-xs text-gray-500">Uploaded: Oct 24, 2023</div>
                                        </div>
                                        <!-- Doc Card 2 -->
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow group">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded flex items-center justify-center text-xl">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </div>
                                                <button class="text-gray-400 hover:text-accent"><i class="fa-solid fa-download"></i></button>
                                            </div>
                                            <div class="text-sm font-medium text-gray-800 truncate mb-1">Bank_Statement.pdf</div>
                                            <div class="text-xs text-gray-500">Uploaded: Oct 23, 2023</div>
                                        </div>
                                        <!-- Doc Card 3 -->
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow group">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="w-10 h-10 bg-green-50 text-green-500 rounded flex items-center justify-center text-xl">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </div>
                                                <button class="text-gray-400 hover:text-accent"><i class="fa-solid fa-download"></i></button>
                                            </div>
                                            <div class="text-sm font-medium text-gray-800 truncate mb-1">Passport_Copy.pdf</div>
                                            <div class="text-xs text-gray-500">Uploaded: Oct 22, 2023</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Content: Beneficial Owners -->
                                <div id="content-owners" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Beneficial Owners</h3>
                                    <div class="space-y-4">
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="font-medium text-gray-800 mb-2">Ahmed Al Mansouri</div>
                                            <div class="text-sm text-gray-600">Ownership: 60% • Nationality: UAE</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Content: Bank Info -->
                                <div id="content-bank" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Bank Information</h3>
                                    <p class="text-gray-500">Bank information content will be displayed here.</p>
                                </div>

                                <!-- Tab Content: Activity Log -->
                                <div id="content-activity" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Activity Timeline</h3>
                                    <div class="space-y-4">
                                        <div class="flex gap-4">
                                            <div class="w-2 h-2 bg-accent rounded-full mt-2"></div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-800">KYC Submitted</div>
                                                <div class="text-xs text-gray-500">Oct 24, 2023 - 2:30 PM</div>
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
                                        <span class="text-xs font-medium text-brand-secondary">85%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2">
                                        <div class="bg-brand-secondary h-2 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>

                                <!-- Acquirer Notes -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Acquirer Notes</label>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded px-3 py-2.5 text-xs text-yellow-800">
                                        <i class="fa-solid fa-exclamation-circle mr-1.5"></i>
                                        Missing bank statement for last 3<br>
                                        months. Please request update.
                                    </div>
                                </div>

                                <!-- Merchant Contact -->
                                <div class="mb-4">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Merchant Contact</label>
                                    <div class="flex items-center gap-2 mb-2">
                                        <img src="https://storage.googleapis.com/uxpilot-auth.appspot.com/avatars/avatar-3.jpg" class="w-6 h-6 rounded-full">
                                        <span class="text-sm font-medium text-brand-primary">Jan Johansen</span>
                                    </div>
                                    <div class="pl-8 space-y-1">
                                        <p class="text-xs text-gray-500">jan.johansen@nordicretail.no</p>
                                        <p class="text-xs text-gray-500">+47 99 88 77 66</p>
                                    </div>
                                </div>

                                <!-- Internal Tags -->
                                <div class="border-t border-gray-100 pt-4">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Internal Tags</label>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-medium">High Volume</span>
                                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-medium">Retail</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                                <h3 class="text-sm font-semibold text-brand-primary mb-4">Recent Activity</h3>
                                <div class="border-l-2 border-gray-100 pl-4 space-y-6">
                                    <div class="relative">
                                        <div class="absolute -left-[21px] w-3 h-3 bg-yellow-400 rounded-full border-4 border-white"></div>
                                        <div class="text-xs text-gray-500 mb-1">Today, 10:30 AM</div>
                                        <div class="text-sm font-medium text-brand-primary">Elavon requested more info</div>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute -left-[21px] w-3 h-3 bg-green-500 rounded-full border-4 border-white"></div>
                                        <div class="text-xs text-gray-500 mb-1">Yesterday, 14:15 PM</div>
                                        <div class="text-sm font-medium text-brand-primary">Surfboard approved API app</div>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute -left-[21px] w-3 h-3 bg-brand-secondary rounded-full border-4 border-white"></div>
                                        <div class="text-xs text-gray-500 mb-1">Oct 22, 16:45 PM</div>
                                        <div class="text-sm font-medium text-brand-primary">KYC submitted to acquirers</div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <a href="#" class="text-brand-secondary text-xs font-medium">View full activity log →</a>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>

        </main>

        <script>
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

