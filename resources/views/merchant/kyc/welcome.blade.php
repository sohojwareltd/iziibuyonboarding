@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Onboarding | 2iZii</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#2D3A74',
                            accent: '#4055A8',
                            orange: '#FF7C00',
                            orangeHover: '#E56D00',
                            bg: '#F7F8FA',
                            border: '#E5E7EB',
                            textSubtle: '#595959',
                            textMuted: '#9A9A9A'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        ::-webkit-scrollbar { display: none; }
        body { font-family: 'Inter', sans-serif; }
        .brand-gradient {
            background: linear-gradient(135deg, #2D3A74 0%, #4055A8 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }
    </style>
@endsection

@section('body')
    <body class="h-screen overflow-hidden bg-white flex flex-row antialiased">

        <!-- LEFT BRAND PANEL (40%) -->
        <section id="brand-panel" class="w-2/5 h-full brand-gradient relative flex flex-col justify-between shrink-0 hidden lg:flex text-white">
            <!-- Logo Area -->
            <div class="p-10">
                <!-- Simulated 2iZii Logo White -->
                <div class="flex items-center gap-2">
                     <div class="text-2xl font-bold tracking-tight text-white">2iZii</div>
                     <div class="h-2 w-2 rounded-full bg-[#FF7C00] mt-1"></div>
                </div>
            </div>

            <!-- Center Illustration Area -->
            <div class="flex-1 flex flex-col items-center justify-center px-12 text-center relative z-10">
                <div class="mb-8 opacity-20">
                    <!-- Abstract Fintech Illustration via FontAwesome Icons layered -->
                    <div class="relative w-64 h-64 flex items-center justify-center">
                        <i class="fa-solid fa-shield-halved text-9xl absolute text-white opacity-30"></i>
                        <i class="fa-solid fa-check text-5xl absolute text-white top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                        <i class="fa-solid fa-fingerprint text-6xl absolute text-white top-10 right-10 opacity-50"></i>
                        <i class="fa-solid fa-credit-card text-6xl absolute text-white bottom-10 left-10 opacity-50"></i>
                    </div>
                </div>

                <h2 class="text-[26px] font-semibold leading-tight text-white/90 mb-2">
                    Secure, Fast & Compliant Merchant Onboarding.
                </h2>
                <p class="text-white/60 text-sm mt-4 max-w-md mx-auto">
                    Streamlined verification process to get your business ready for payments in minutes.
                </p>
            </div>

            <!-- Background Decoration -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
                <div class="absolute top-[20%] -left-[10%] w-96 h-96 bg-white opacity-[0.03] rounded-full blur-3xl"></div>
                <div class="absolute bottom-[10%] -right-[10%] w-80 h-80 bg-[#FF7C00] opacity-[0.05] rounded-full blur-3xl"></div>
            </div>

            <!-- Footer -->
            <div class="p-6 text-xs text-white/60">
                © 2025 2iZii. All rights reserved.
            </div>
        </section>

        <!-- RIGHT KYC CONTENT PANEL (60%) -->
        <main id="kyc-content-panel" class="w-full lg:w-3/5 h-full bg-white overflow-y-auto flex flex-col items-center justify-center relative">

            <!-- Main Content Container -->
            <div class="w-full max-w-[600px] px-8 py-12 flex flex-col h-full justify-center">

                <!-- HEADER CONTENT -->
                <div id="header-content" class="text-center mb-8">
                    <h1 class="text-[28px] font-bold text-brand-dark mb-2.5">
                        Welcome to Your Merchant Onboarding
                    </h1>
                    <p class="text-base text-brand-textSubtle">
                        Let’s get your business verified for payments.
                    </p>
                </div>

                <!-- MERCHANT & ONBOARDING SUMMARY PANEL -->
                <div id="summary-card" class="bg-[#F7F8FA] rounded-xl border border-brand-border p-6 mb-7 shadow-sm">

                    <!-- Grid for Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-4 mb-6">
                        <!-- Merchant Name -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-[#555] mb-1">Merchant:</label>
                            <div class="text-lg font-semibold text-brand-dark flex items-center gap-2">
                                <i class="fa-solid fa-store text-brand-accent text-sm"></i>
                                Global Retail Solutions Ltd.
                            </div>
                        </div>

                        <!-- Solution -->
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1 uppercase tracking-wide">Solution Selected</label>
                            <div class="text-sm font-medium text-gray-800">OnePOS Integrated</div>
                        </div>

                        <!-- Partner -->
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1 uppercase tracking-wide">Referred By</label>
                            <div class="text-sm font-medium text-gray-800">Digitax Systems</div>
                        </div>

                        <!-- Acquirers -->
                        <div class="col-span-2 pt-2 border-t border-gray-200">
                            <label class="block text-xs font-medium text-[#555] mb-2 uppercase tracking-wide">Your Payment Providers</label>
                            <div class="flex flex-wrap gap-2">
                                <!-- Elavon Badge -->
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-brand-dark border border-gray-300">
                                    <i class="fa-solid fa-building-columns mr-1.5"></i> Elavon
                                </span>
                                <!-- Surfboard Badge -->
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#EEF3FF] text-brand-accent border border-blue-100">
                                    <i class="fa-solid fa-water mr-1.5"></i> Surfboard
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Strip -->
                    <div class="bg-[#FFF6E8] border-l-4 border-brand-orange p-3 rounded-r-md flex items-start gap-3">
                        <i class="fa-solid fa-circle-info text-[#8A6C1A] mt-0.5 text-xs"></i>
                        <p class="text-xs text-[#8A6C1A] leading-relaxed">
                            This information was pre-configured by your 2iZii representative.
                        </p>
                    </div>
                </div>

                <!-- LINK VALIDATION STATE (Hidden by default, toggleable via JS for demo) -->
                <div id="error-state" class="hidden bg-white rounded-xl border border-red-100 p-8 text-center shadow-sm mb-8">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-circle-exclamation text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Link Expired or Invalid</h3>
                    <p class="text-gray-600 mb-6">Your onboarding link has expired or is no longer valid. Please contact your 2iZii representative for a new invitation.</p>
                    <button class="inline-flex items-center justify-center px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200">
                        Contact Support
                    </button>
                </div>

                <!-- START KYC CTA -->
                <div id="action-area" class="space-y-4">
                    <a href="{{ route('merchant.kyc.company') }}" class="group w-full h-[50px] bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold text-base rounded-lg shadow-md transition-all duration-200 flex items-center justify-center gap-2 transform active:scale-[0.99]">
                        <span>Start Your KYC Application</span>
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <!-- Information Note -->
                    <div class="text-center space-y-1">
                        <p class="text-[13px] text-[#6A6A6A]">
                            <i class="fa-regular fa-clock mr-1 text-gray-400"></i> This process will take approximately 5–10 minutes to complete.
                        </p>
                        <p class="text-[13px] text-[#6A6A6A]">
                            You can save progress at any time and return later.
                        </p>
                    </div>
                </div>

                <!-- FOOTER (RIGHT PANEL) -->
                <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                    <p class="text-xs text-brand-textMuted flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-lock text-[10px]"></i>
                        Your information is securely encrypted and handled per EU AML requirements.
                    </p>
                </div>

            </div>
        </main>

        <script>
            // Optional: Logic to show error state based on URL param (simulation)
            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('error') === 'true') {
                document.getElementById('summary-card').style.display = 'none';
                document.getElementById('header-content').style.display = 'none';
                document.getElementById('action-area').style.display = 'none';
                document.getElementById('error-state').classList.remove('hidden');
            }
        </script>
    </body>
@endsection

