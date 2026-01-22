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
        .tab-btn.active { border-bottom: 3px solid #FF7C00; color: #2D3A74; font-weight: 600; }
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral">

        <x-admin.sidebar active="merchant-onboarding" />

        <x-admin.topbar />

        <!-- MAIN CONTENT WRAPPER -->
        <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral flex flex-col">
            <!-- SCROLLABLE CONTENT AREA -->
            <div class="flex-1 overflow-hidden flex bg-bgLight relative">

                <!-- LEFT COLUMN: MAIN DETAILS (70%) -->
                <div class="flex-1 overflow-y-auto p-8 pb-24">

                    <!-- 3A. ONBOARDING SUMMARY BLOCK -->
                    <section id="summary-block" class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-primary mb-1">TechNova Solutions Ltd.</h1>
                                <div class="flex items-center gap-3 text-sm text-gray-500">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-medium">ID: MOB-48217</span>
                                    <span>•</span>
                                    <span><i class="fa-solid fa-earth-americas mr-1"></i> United Arab Emirates</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-accent border border-blue-100">
                                    <span class="w-2 h-2 rounded-full bg-accent mr-2 animate-pulse"></span>
                                    Under Review
                                </span>
                                <div class="text-xs text-gray-400">Created: Oct 24, 2023</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-6 border-t border-gray-100 pt-6">
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Solution</div>
                                <div class="font-medium text-gray-800">E-Com Gateway</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Partner</div>
                                <div class="font-medium text-gray-800">Global Payments Inc.</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Created By</div>
                                <div class="flex items-center gap-2">
                                    <img src="https://storage.googleapis.com/uxpilot-auth.appspot.com/avatars/avatar-2.jpg" class="w-5 h-5 rounded-full">
                                    <span class="text-sm text-gray-800">John Broker</span>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Risk Level</div>
                                <div class="font-medium text-orange-600"><i class="fa-solid fa-shield-halved mr-1"></i> Medium</div>
                            </div>
                        </div>
                    </section>

                    <!-- 3B. ACQUIRER STATUS OVERVIEW -->
                    <section id="acquirer-status" class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-[22px] font-bold text-primary">ACQUIRER STATUS OVERVIEW</h2>
                            <div class="bg-[#E6F4FF] text-accent px-3 py-1.5 rounded-full text-xs font-medium flex items-center border border-[#D8E2FF]">
                                <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 animate-pulse"></span>
                                Live Status
                            </div>
                        </div>

                        <div class="bg-matrixBg border border-matrixBorder rounded-xl p-5 shadow-sm overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-xs font-semibold text-gray-500 uppercase border-b border-gray-200">
                                        <th class="pb-3 pl-2">Acquirer</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3">MID</th>
                                        <th class="pb-3 w-1/4">Comments</th>
                                        <th class="pb-3">Last Updated</th>
                                        <th class="pb-3 text-right pr-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <!-- Row 1 -->
                                    <tr class="border-b border-gray-200/60 last:border-0 group hover:bg-white/50 transition-colors">
                                        <td class="py-4 pl-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center border border-gray-100 text-xs font-bold text-indigo-600">
                                                    N
                                                </div>
                                                <span class="font-medium text-gray-800">Network Intl</span>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                Approved
                                            </span>
                                        </td>
                                        <td class="py-4 font-mono text-gray-600">982374102</td>
                                        <td class="py-4 text-gray-500 text-xs">Approved with standard limit.</td>
                                        <td class="py-4 text-gray-500 text-xs">Today, 10:30 AM</td>
                                        <td class="py-4 text-right pr-2">
                                            <button class="text-accent hover:text-primary text-xs font-medium border border-accent/30 hover:border-primary rounded px-3 py-1.5 transition-colors bg-white">
                                                View MID
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 2 -->
                                    <tr class="border-b border-gray-200/60 last:border-0 group hover:bg-white/50 transition-colors">
                                        <td class="py-4 pl-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center border border-gray-100 text-xs font-bold text-blue-600">
                                                    M
                                                </div>
                                                <span class="font-medium text-gray-800">Mashreq Bank</span>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                Need Info
                                            </span>
                                        </td>
                                        <td class="py-4 text-gray-400">—</td>
                                        <td class="py-4 text-gray-500 text-xs">Trade license expired. Please update.</td>
                                        <td class="py-4 text-gray-500 text-xs">Yesterday, 4:15 PM</td>
                                        <td class="py-4 text-right pr-2">
                                            <button class="bg-cta text-white hover:bg-orange-600 text-xs font-medium rounded px-3 py-1.5 transition-colors shadow-sm">
                                                Request Info
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 3 -->
                                    <tr class="group hover:bg-white/50 transition-colors">
                                        <td class="py-4 pl-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center border border-gray-100 text-xs font-bold text-red-600">
                                                    A
                                                </div>
                                                <span class="font-medium text-gray-800">ADCB</span>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                Pending
                                            </span>
                                        </td>
                                        <td class="py-4 text-gray-400">—</td>
                                        <td class="py-4 text-gray-500 text-xs italic">Ready for submission</td>
                                        <td class="py-4 text-gray-500 text-xs">—</td>
                                        <td class="py-4 text-right pr-2">
                                            <button class="text-accent hover:text-primary text-xs font-medium border border-accent/30 hover:border-primary rounded px-3 py-1.5 transition-colors bg-white">
                                                Submit
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- 4. SEPARATOR -->
                    <div class="border-t border-gray-300 my-8"></div>

                    <!-- 5. KYC DETAILS SECTIONS -->
                    <section id="kyc-details">
                        <h2 class="text-xl font-bold text-primary mb-4">KYC DETAILS</h2>

                        <!-- Tab Navigation -->
                        <div class="flex border-b border-gray-200 mb-6 overflow-x-auto">
                            <button onclick="switchTab('company')" id="tab-company" class="tab-btn active px-4 py-3 text-sm font-medium text-gray-500 hover:text-primary whitespace-nowrap transition-colors">Company Information</button>
                            <button onclick="switchTab('owners')" id="tab-owners" class="tab-btn px-4 py-3 text-sm font-medium text-gray-500 hover:text-primary whitespace-nowrap transition-colors">Beneficial Owners</button>
                            <button onclick="switchTab('docs')" id="tab-docs" class="tab-btn px-4 py-3 text-sm font-medium text-gray-500 hover:text-primary whitespace-nowrap transition-colors">Documents</button>
                            <button onclick="switchTab('activity')" id="tab-activity" class="tab-btn px-4 py-3 text-sm font-medium text-gray-500 hover:text-primary whitespace-nowrap transition-colors">Activity Log</button>
                        </div>

                        <!-- TAB CONTENT: COMPANY INFO -->
                        <div id="content-company" class="tab-content block bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">General Information</h3>
                                <button class="text-accent hover:text-primary text-sm font-medium border border-accent rounded-lg px-4 py-2 transition-colors">
                                    <i class="fa-solid fa-pen mr-2"></i> Edit Section
                                </button>
                            </div>

                            <div class="grid grid-cols-2 gap-x-12 gap-y-8">
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

                        <!-- TAB CONTENT: DOCUMENTS (Hidden by default) -->
                        <div id="content-docs" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-semibold text-gray-800">Uploaded Documents</h3>
                                <button class="bg-primary text-white text-sm font-medium rounded-lg px-4 py-2 hover:bg-opacity-90 transition-colors">
                                    <i class="fa-solid fa-upload mr-2"></i> Upload New
                                </button>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
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

                        <!-- TAB CONTENT: OWNERS (Hidden by default) -->
                        <div id="content-owners" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6">Beneficial Owners</h3>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="font-medium text-gray-800 mb-2">Ahmed Al Mansouri</div>
                                    <div class="text-sm text-gray-600">Ownership: 60% • Nationality: UAE</div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB CONTENT: ACTIVITY LOG (Hidden by default) -->
                        <div id="content-activity" class="tab-content hidden bg-white rounded-xl shadow-sm border border-gray-200 p-8">
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
                    </section>

                </div>

                <!-- RIGHT COLUMN: COMMUNICATION PANEL (30%) -->
                <aside id="communication-panel" class="w-[360px] bg-white border-l border-gray-200 flex flex-col h-full overflow-hidden flex-shrink-0">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-primary">Communications</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto p-6 space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <img src="https://storage.googleapis.com/uxpilot-auth.appspot.com/avatars/avatar-3.jpg" class="w-8 h-8 rounded-full">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-800">Admin User</div>
                                    <div class="text-xs text-gray-500 mb-2">Today, 10:45 AM</div>
                                    <div class="text-sm text-gray-700">Please upload updated trade license.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t border-gray-200">
                        <textarea class="w-full border border-gray-300 rounded-lg p-3 text-sm resize-none" rows="3" placeholder="Type message..."></textarea>
                        <button class="w-full bg-cta text-white rounded-lg py-2 mt-2 text-sm font-medium hover:bg-orange-600">Send</button>
                    </div>
                </aside>

            </div>

            <!-- 7. BOTTOM FIXED ACTION BAR -->
            <footer id="action-bar" class="fixed bottom-0 right-0 w-[calc(100%-260px)] h-20 bg-white border-t border-gray-200 flex items-center justify-end px-12 gap-4 z-10">
                <button class="px-6 py-2.5 border border-accent text-accent rounded-lg font-medium hover:bg-accent/5 transition-colors">
                    Request More Information
                </button>
                <button class="px-6 py-2.5 border border-primary text-primary rounded-lg font-medium hover:bg-primary/5 transition-colors">
                    Resend KYC Link
                </button>
                <button class="px-6 py-2.5 bg-success text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                    Approve Onboarding
                </button>
                <button class="px-6 py-2.5 bg-danger text-white rounded-lg font-medium hover:bg-red-600 transition-colors">
                    Reject Onboarding
                </button>
            </footer>

        </main>

        <script>
            function switchTab(tabName) {
                const tabs = document.querySelectorAll('.tab-btn');
                const contents = document.querySelectorAll('.tab-content');

                tabs.forEach(tab => tab.classList.remove('active'));
                contents.forEach(content => content.classList.add('hidden'));

                document.getElementById('tab-' + tabName).classList.add('active');
                document.getElementById('content-' + tabName).classList.remove('hidden');
                document.getElementById('content-' + tabName).classList.add('block');
            }
        </script>

    </body>
@endsection

