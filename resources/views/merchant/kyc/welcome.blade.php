@extends('layouts.merchant')

@section('title', 'Welcome to Your Merchant Onboarding - 2iZii')

@push('head')
    <style>
        .brand-gradient {
            background: linear-gradient(114.228deg, #2D3A74 0%, #4055A8 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(2px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .decorative-circle {
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 9999px;
        }
        .decorative-circle-small {
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
        }
    </style>
@endpush

@section('body')
    <div class="min-h-screen bg-white flex flex-col lg:flex-row">
        <!-- LEFT BRAND PANEL -->
        <section class="w-full lg:w-[648px] min-h-[400px] brand-gradient relative flex flex-col justify-between p-6 md:p-12 text-white overflow-hidden">
            <!-- Decorative Background Circles -->
            <div class="absolute inset-0 opacity-10 overflow-hidden pointer-events-none">
                <div class="absolute -left-16 -top-36 w-[500px] h-[500px] decorative-circle"></div>
                <div class="absolute -bottom-36 -right-16 w-[600px] h-[600px] decorative-circle"></div>
                <div class="absolute left-[130px] top-[576px] w-[200px] h-[200px] decorative-circle-small"></div>
            </div>

            <!-- Logo Area -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="glass-effect rounded-lg p-1 flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-file-lines text-white text-lg"></i>
                </div>
                <div class="text-2xl font-bold tracking-tight text-white">2iZii</div>
            </div>

            <!-- Center Content -->
            <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-5 md:px-8 text-center max-w-[512px] mx-auto">
                <!-- Illustration -->
                <div class="mb-10 opacity-90">
                    <div class="w-48 h-48 md:w-64 md:h-64 mx-auto relative">
                        <img src="http://localhost:3845/assets/a4f4263e1386eea4fc73bc146ef6b55e49d89168.png" 
                             alt="Secure Verification" 
                             class="w-full h-full object-contain">
                    </div>
                </div>

                <!-- Main Heading -->
                <div class="space-y-4 mb-4">
                    <h1 class="text-2xl md:text-3xl lg:text-[36px] font-bold leading-tight text-white">
                        Secure, Fast & Compliant<br>
                        Merchant Verification.
                    </h1>
                    <p class="text-base md:text-lg text-white/80 font-light leading-relaxed max-w-md mx-auto">
                        Complete a short digital verification to activate your payment services.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 text-sm text-white/40">
                © 2025 2iZii. All rights reserved.
            </div>
        </section>

        <!-- RIGHT CONTENT PANEL -->
        <main class="w-full lg:w-[792px] min-h-screen bg-white flex items-center justify-center p-6 md:p-12 lg:p-16">
            <div class="w-full max-w-[480px] space-y-8">
                <!-- Header -->
                <div class="text-center space-y-2">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#2d3a74] leading-tight">
                        Welcome to Your Merchant<br>
                        Onboarding
                    </h2>
                    <p class="text-base md:text-lg text-[#6a6a6a]">
                        Let's get your business verified for accepting payments.
                    </p>
                </div>

                <!-- Info Cards -->
                <div class="bg-white border border-[#f3f4f6] rounded-xl shadow-sm overflow-hidden">
                    <!-- Merchant Card -->
                    <div class="border-b border-[#f3f4f6] p-5">
                        <div class="flex items-center gap-4">
                            <div class="bg-[#eff6ff] rounded-full w-10 h-10 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-store text-[#4055a8] text-base"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-medium text-[#9a9a9a] uppercase tracking-wider mb-1">
                                    Merchant
                                </div>
                                <div class="text-base font-semibold text-[#2d3a74] truncate">
                                    {{ $onboarding?->legal_business_name ?? 'Global Retail Solutions Ltd.' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Solution Selected Card -->
                    <div class="border-b border-[#f3f4f6] p-5">
                        <div class="flex items-center gap-4">
                            <div class="bg-[#eef2ff] rounded-full w-10 h-10 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-mobile-screen-button text-[#6366f1] text-base"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-medium text-[#9a9a9a] uppercase tracking-wider mb-1">
                                    Solution Selected
                                </div>
                                <div class="text-base font-semibold text-[#2d3a74]">
                                    {{ $onboarding?->solution?->name ?? 'OnePOS Integrated' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Partners -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-[#9a9a9a]">
                        Your Payment Partners
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @if($onboarding && $onboarding->acquirers)
                            @foreach($onboarding->acquirers as $acquirer)
                                <div class="bg-[#f3f4f6] border border-[#e5e7eb] rounded-full px-4 py-2 flex items-center gap-2">
                                    <i class="fa-solid fa-building text-[#374151] text-sm"></i>
                                    <span class="text-sm font-medium text-[#374151]">{{ $acquirer }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-[#f3f4f6] border border-[#e5e7eb] rounded-full px-4 py-2 flex items-center gap-2">
                                <i class="fa-solid fa-building text-[#374151] text-sm"></i>
                                <span class="text-sm font-medium text-[#374151]">Elavon</span>
                            </div>
                            <div class="bg-[#f3f4f6] border border-[#e5e7eb] rounded-full px-4 py-2 flex items-center gap-2">
                                <i class="fa-solid fa-water text-[#374151] text-sm"></i>
                                <span class="text-sm font-medium text-[#374151]">Surfboard</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Spacer -->
                <div class="h-14"></div>

                <!-- CTA Button / Login Form Container -->
                <div id="cta-container" class="space-y-4">
                    <!-- Initial CTA Button -->
                    <button type="button" 
                            onclick="handleStartKYC()"
                            class="w-full bg-[#FF7C00] hover:bg-[#E56D00] text-white font-semibold text-base py-3 px-8 rounded-lg shadow-md transition-all duration-200 flex items-center justify-center gap-2 group">
                        <span>Start Your KYC Application</span>
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>

                <!-- Hidden Login Form (shown when user not authenticated) -->
                <div id="login-form-container" class="hidden space-y-4">
                    <div class="bg-white border border-[#FF7C00] rounded-xl p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-[#2d3a74] mb-1">Sign In Required</h3>
                        <p class="text-sm text-[#6a6a6a] mb-6">Please sign in with your merchant account to continue.</p>
                        
                        <form id="merchant-login-form" method="POST" action="{{ route('merchant.kyc.login') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="kyc_link" value="{{ $kyc_link ?? $onboarding?->kyc_link }}">
                            
                            <!-- Email Input -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-[#374151] mb-2">
                                    Email Address
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required 
                                       placeholder="your@email.com"
                                       class="w-full px-4 py-2 border border-[#e5e7eb] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF7C00] focus:border-transparent text-[#2d3a74]">
                            </div>

                            <!-- Password Input -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-[#374151] mb-2">
                                    Password
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       placeholder="••••••••"
                                       class="w-full px-4 py-2 border border-[#e5e7eb] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF7C00] focus:border-transparent text-[#2d3a74]">
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="remember" 
                                       name="remember" 
                                       class="w-4 h-4 bg-white border border-[#e5e7eb] rounded focus:ring-2 focus:ring-[#FF7C00]">
                                <label for="remember" class="ml-2 text-sm text-[#6a6a6a]">
                                    Remember me
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-[#FF7C00] hover:bg-[#E56D00] text-white font-semibold text-base py-3 px-8 rounded-lg shadow-md transition-all duration-200">
                                Sign In & Continue
                            </button>
                        </form>

                        <!-- Forgot Password Link -->
                        <div class="text-center mt-4">
                            <a href="#" class="text-sm text-[#FF7C00] hover:text-[#E56D00] font-medium">
                                Forgot your password?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
        <script>
            // Check authentication status and handle start KYC flow
            async function handleStartKYC() {
                try {
                    // Attempt to fetch user data via an authenticated endpoint
                    const response = await fetch('{{ route("merchant.kyc.check-auth") }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include'
                    });

                    const data = await response.json();

                    if (response.ok && data.authenticated && data.is_merchant) {
                        // User is authenticated as merchant, redirect to company page
                        window.location.href = '{{ route("merchant.kyc.company", ["kyc_link" => $kyc_link ?? $onboarding?->kyc_link]) }}';
                    } else {
                        // User is not authenticated or not a merchant, show login form
                        toggleLoginForm(true);
                    }
                } catch (error) {
                    console.error('Auth check failed:', error);
                    // On error, show login form to be safe
                    toggleLoginForm(true);
                }
            }

            // Show/hide login form
            function toggleLoginForm(show = true) {
                const ctaContainer = document.getElementById('cta-container');
                const loginContainer = document.getElementById('login-form-container');
                
                if (show) {
                    ctaContainer.classList.add('hidden');
                    loginContainer.classList.remove('hidden');
                    // Focus on email input for better UX
                    document.getElementById('email').focus();
                } else {
                    ctaContainer.classList.remove('hidden');
                    loginContainer.classList.add('hidden');
                }
            }

            // Handle merchant login form submission
            document.getElementById('merchant-login-form')?.addEventListener('submit', async function(e) {
                e.preventDefault();

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const kyc_link = document.querySelector('input[name="kyc_link"]').value;
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Signing in...';

                try {
                    const response = await fetch('{{ route("merchant.kyc.login") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include',
                        body: JSON.stringify({
                            email: email,
                            password: password,
                            kyc_link: kyc_link
                        })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        // Login successful, redirect to company page
                        window.location.href = '{{ route("merchant.kyc.company", ["kyc_link" => $kyc_link ?? $onboarding?->kyc_link]) }}';
                    } else {
                        // Login failed, show error message
                        const errorMsg = data.message || 'Invalid email or password. Please try again.';
                        showError(errorMsg);
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                } catch (error) {
                    console.error('Login error:', error);
                    showError('An error occurred. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });

            // Show error message
            function showError(message) {
                // Remove existing error if present
                const existing = document.getElementById('login-error-msg');
                if (existing) existing.remove();

                const errorDiv = document.createElement('div');
                errorDiv.id = 'login-error-msg';
                errorDiv.className = 'bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm';
                errorDiv.textContent = message;

                const formContainer = document.getElementById('login-form-container');
                formContainer.insertBefore(errorDiv, formContainer.querySelector('.bg-white'));
            }

            // Initialize: Check auth status on page load
            window.addEventListener('load', function() {
                // Check auth status immediately
                fetch('{{ route("merchant.kyc.check-auth") }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'include'
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.authenticated || !data.is_merchant) {
                        // Not authenticated as merchant, show login form
                        toggleLoginForm(true);
                    }
                })
                .catch(error => {
                    console.error('Initial auth check failed:', error);
                    // Show login form on error
                    toggleLoginForm(true);
                });
            });
        </script>
    @endpush
@endsection
