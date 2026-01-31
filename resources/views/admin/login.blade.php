@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign-In | 2iZii</title>

    {{-- Tailwind via CDN to match Figma utility classes --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#2D3A74',
                            accent: '#4055A8',
                            orange: '#FF7C00',
                            bg: '#F7F8FA',
                            textSubtle: '#6A6A6A',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }

        .bg-gradient-brand {
            background: linear-gradient(135deg, #F0F4FF 0%, #FFFFFF 100%);
        }

        .shadow-soft-card {
            box-shadow: 0 10px 40px -10px rgba(45, 58, 116, 0.10);
        }
    </style>
@endsection

@section('body')
<body class="min-h-screen bg-brand-bg flex items-stretch">
    <div class="flex-1 flex">
        {{-- Left illustration / branding section --}}
        <section class="hidden lg:flex bg-gradient-brand w-[48%] max-w-[792px] flex-col justify-between p-20 relative overflow-hidden">
            {{-- subtle background shapes --}}
            <div class="pointer-events-none absolute inset-0 opacity-30">
                {{-- these can be replaced with SVG background assets if available --}}
                <div class="absolute -right-32 top-24 w-[420px] h-[420px] rounded-full bg-white"></div>
                <div class="absolute -left-40 bottom-10 w-[360px] h-[360px] rounded-full bg-[#EEF2FF]"></div>
            </div>

            {{-- Brand logo --}}
            <div class="relative z-10">
                <div class="inline-flex items-center gap-3">
                    {{-- Use your real logo image if available --}}
                    <div
                        class="h-10 w-10 rounded-lg bg-brand-dark flex items-center justify-center text-white font-semibold text-lg">
                        2i
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs uppercase tracking-[0.16em] text-brand-textSubtle">It’s almost</span>
                        <span class="text-xl font-semibold text-brand-dark">2iZii</span>
                    </div>
                </div>
            </div>

            {{-- Illustration and headline --}}
            <div class="relative z-10 flex-1 flex flex-col justify-center max-w-xl">
                {{-- Illustration placeholder --}}
                <div
                    class="mb-10 h-64 w-full rounded-2xl overflow-hidden bg-black/80 border border-white/20 shadow-lg">
                    {{-- Replace src with real dashboard image if you have one --}}
                    <img
                        src="https://images.pexels.com/photos/669610/pexels-photo-669610.jpeg?auto=compress&cs=tinysrgb&w=1200"
                        alt="Analytics dashboard"
                        class="h-full w-full object-cover opacity-90">
                </div>

                <div class="space-y-3">
                    <h1 class="text-4xl leading-tight font-semibold text-brand-dark">
                        Welcome to the<br>2iZii Admin Portal
                    </h1>
                    <p class="text-[15px] text-brand-textSubtle max-w-md">
                        Manage onboarding, merchants, acquirers and platform configuration securely.
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="relative z-10 text-[12px] text-brand-textSubtle">
                © 2025 2iZii — All rights reserved.
            </div>
        </section>

        {{-- Right login section --}}
        <section class="flex-1 min-w-[320px] bg-white flex flex-col items-center justify-center px-6 py-12">
            {{-- Card --}}
            <div
                class="bg-white border border-[#F3F4F6] rounded-xl shadow-soft-card w-full max-w-[420px] px-12 py-12 relative">
                {{-- Heading --}}
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-brand-dark mb-1">Admin Sign-In</h2>
                    <p class="text-sm text-brand-textSubtle">
                        Use your Microsoft account to access the 2iZii Admin Portal.
                    </p>
                </div>

                {{-- Microsoft button --}}
                <button
                    type="button"
                    class="w-full h-12 border border-[#D0D0D0] rounded-lg flex items-center justify-center gap-3 text-[15px] font-medium text-brand-dark hover:bg-gray-50 transition-colors">
                    <span class="inline-flex items-center justify-center w-5 h-5">
                        {{-- Microsoft icon placeholder --}}
                        <span class="grid grid-cols-2 grid-rows-2 gap-[1px] w-4 h-4">
                            <span class="bg-[#F25022]"></span>
                            <span class="bg-[#7FBA00]"></span>
                            <span class="bg-[#00A4EF]"></span>
                            <span class="bg-[#FFB900]"></span>
                        </span>
                    </span>
                    <span>Sign in with Microsoft</span>
                </button>

                {{-- Security info --}}
                <div class="mt-6 bg-[#F9FAFB] border border-[#F3F4F6] rounded-md px-4 py-4">
                    <div class="flex items-start gap-3 mb-2">
                        <span
                            class="mt-[2px] inline-flex items-center justify-center w-5 h-5 rounded-full bg-white border border-[#E5E7EB] text-xs text-brand-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-3.5 h-3.5">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.5a.75.75 0 00-1.5 0v4.19l-1.22-1.22a.75.75 0 10-1.06 1.06l2.5 2.5a.75.75 0 001.06 0l2.5-2.5a.75.75 0 10-1.06-1.06l-1.22 1.22V6.5z"
                                      clip-rule="evenodd" />
                            </svg>
                        </span>
                        <p class="text-xs text-brand-textSubtle">
                            Your organization requires secure sign-in. Multi-factor authentication (MFA) will be
                            completed using the Microsoft Authenticator App.
                        </p>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="mt-6 flex items-center">
                    <div class="flex-1 h-px bg-[#E5E7EB]"></div>
                </div>

                {{-- Local credentials link --}}
                <div class="mt-5 text-center">
                    <button type="button" id="local-login-toggle"
                            class="text-sm font-medium text-[#4055A8] underline underline-offset-2">
                        Use Local Admin Credentials (Internal Only)
                    </button>
                </div>

                <div id="local-login-panel" class="hidden mt-4 border border-[#E5E7EB] rounded-lg p-4 bg-[#FAFAFB]">
                    <div class="text-xs text-brand-textSubtle mb-3">
                        Local login is for internal testing only.
                    </div>
                    @if ($errors->any())
                        <div class="mb-3 text-xs text-red-600">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-brand-textSubtle mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com"
                                   class="w-full h-10 px-3 border border-[#D0D0D0] rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-accent">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-brand-textSubtle mb-1">Password</label>
                            <input type="password" name="password" placeholder="••••••••"
                                   class="w-full h-10 px-3 border border-[#D0D0D0] rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-brand-accent">
                        </div>
                        <button type="submit"
                                class="w-full h-10 bg-brand-dark text-white rounded-md text-sm font-medium hover:bg-brand-accent transition-colors">
                            Sign in (Admin)
                        </button>
                    </form>
                </div>
            </div>

            {{-- Support text --}}
            <div class="mt-6 text-center text-[12px] text-[#9A9A9A]">
                <span>Having trouble signing in? </span>
                <a href="mailto:support@2izii.com" class="underline text-brand-textSubtle">
                    Contact support@2izii.com
                </a>
            </div>
        </section>
    </div>
</body>
<script>
    const localToggle = document.getElementById('local-login-toggle');
    const localPanel = document.getElementById('local-login-panel');

    if (localToggle && localPanel) {
        localToggle.addEventListener('click', () => {
            localPanel.classList.toggle('hidden');
        });
    }
</script>
@endsection

