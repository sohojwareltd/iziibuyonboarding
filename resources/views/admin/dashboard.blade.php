@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - 2iZii</title>
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
                            border: '#D1D5DB',
                            accent: '#FFA439',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
        window.FontAwesomeConfig = {
            autoReplaceSvg: 'nest'
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background:
                radial-gradient(circle at top right, rgba(255, 124, 0, 0.08), transparent 24%),
                linear-gradient(180deg, #F8FAFC 0%, #F7F8FA 100%);
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 9999px;
        }

        .dashboard-shell {
            animation: fade-up 0.35s ease-out;
        }

        .hero-panel {
            background:
                linear-gradient(135deg, rgba(45, 58, 116, 0.98) 0%, rgba(64, 85, 168, 0.94) 62%, rgba(255, 124, 0, 0.92) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-panel::before,
        .hero-panel::after {
            content: '';
            position: absolute;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.08);
        }

        .hero-panel::before {
            width: 220px;
            height: 220px;
            top: -110px;
            right: -60px;
        }

        .hero-panel::after {
            width: 160px;
            height: 160px;
            bottom: -70px;
            right: 180px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
        }

        .surface-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
        }

        .status-slate { background: #F1F5F9; color: #334155; }
        .status-blue { background: #DBEAFE; color: #1D4ED8; }
        .status-amber { background: #FEF3C7; color: #B45309; }
        .status-emerald { background: #DCFCE7; color: #15803D; }
        .status-indigo { background: #E0E7FF; color: #4338CA; }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral text-slate-900">
        <x-admin.sidebar active="dashboard" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ]" />

        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen">
            <div class="p-4 md:p-8 dashboard-shell">
                <div class="max-w-[1400px] mx-auto space-y-6">
                    <section class="hero-panel rounded-[28px] p-6 md:p-8 text-white">
                        <div class="relative z-10 flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">
                            <div class="max-w-3xl">
                                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-white/80 mb-4">
                                    <i class="fa-solid fa-chart-pie text-[11px]"></i>
                                    Admin Control Center
                                </div>
                                <h1 class="text-3xl md:text-4xl font-semibold tracking-tight mb-3">Keep onboarding, KYC rules, and system health in one place.</h1>
                                <p class="text-sm md:text-base text-white/80 max-w-2xl">This dashboard surfaces the current onboarding pipeline, recent admin activity, and master-data coverage so the operations team can act quickly.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 md:min-w-[360px]">
                                <div class="glass-card rounded-2xl p-4">
                                    <p class="text-xs uppercase tracking-[0.18em] text-white/60 mb-1">Total Onboardings</p>
                                    <p class="text-3xl font-semibold">{{ number_format($totalOnboardings) }}</p>
                                </div>
                                <div class="glass-card rounded-2xl p-4">
                                    <p class="text-xs uppercase tracking-[0.18em] text-white/60 mb-1">Completed KYC</p>
                                    <p class="text-3xl font-semibold">{{ number_format($completedKyc) }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                        <div class="surface-card rounded-3xl p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">New Requests Today</p>
                                    <p class="text-3xl font-semibold text-brand-primary">{{ number_format($newToday) }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-2xl bg-orange-50 text-brand-cta flex items-center justify-center">
                                    <i class="fa-solid fa-bolt"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-4">Fresh entries created since midnight.</p>
                        </div>

                        <div class="surface-card rounded-3xl p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">In Progress</p>
                                    <p class="text-3xl font-semibold text-brand-primary">{{ number_format($inProgress) }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i class="fa-solid fa-spinner"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-4">Sent or under admin review.</p>
                        </div>

                        <div class="surface-card rounded-3xl p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Approved / Active</p>
                                    <p class="text-3xl font-semibold text-brand-primary">{{ number_format($approved) }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-4">Merchants moved beyond review.</p>
                        </div>

                        <div class="surface-card rounded-3xl p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Admin Users</p>
                                    <p class="text-3xl font-semibold text-brand-primary">{{ number_format(collect($systemOverview)->firstWhere('label', 'Admin Users')['value'] ?? 0) }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center">
                                    <i class="fa-solid fa-user-shield"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-4">Back-office accounts with admin access.</p>
                        </div>
                    </section>

                    <section class="grid grid-cols-1 xl:grid-cols-[1.3fr_0.7fr] gap-6">
                        <div class="surface-card rounded-3xl p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">
                                <div>
                                    <h2 class="text-xl font-semibold text-brand-primary">Quick actions</h2>
                                    <p class="text-sm text-slate-500">Most common admin actions, one click away.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                                <a href="{{ route('admin.onboarding.start') }}" class="rounded-2xl border border-orange-100 bg-orange-50/70 p-4 hover:bg-orange-50 transition-colors">
                                    <div class="w-10 h-10 rounded-2xl bg-white text-brand-cta flex items-center justify-center mb-3 shadow-sm">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                    <h3 class="font-semibold text-brand-primary mb-1">New Onboarding</h3>
                                    <p class="text-sm text-slate-500">Start and send a new merchant request.</p>
                                </a>

                                <a href="{{ route('admin.onboarding.index') }}" class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4 hover:bg-blue-50 transition-colors">
                                    <div class="w-10 h-10 rounded-2xl bg-white text-blue-600 flex items-center justify-center mb-3 shadow-sm">
                                        <i class="fa-solid fa-list-check"></i>
                                    </div>
                                    <h3 class="font-semibold text-brand-primary mb-1">Review Requests</h3>
                                    <p class="text-sm text-slate-500">Track drafts, sent links, and reviews.</p>
                                </a>

                                <a href="{{ route('admin.masters.kyc-field-master') }}" class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 hover:bg-emerald-50 transition-colors">
                                    <div class="w-10 h-10 rounded-2xl bg-white text-emerald-600 flex items-center justify-center mb-3 shadow-sm">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <h3 class="font-semibold text-brand-primary mb-1">KYC Fields</h3>
                                    <p class="text-sm text-slate-500">Adjust field rules and visibility.</p>
                                </a>

                                <a href="{{ route('admin.settings.index') }}" class="rounded-2xl border border-slate-200 bg-slate-50/80 p-4 hover:bg-slate-50 transition-colors">
                                    <div class="w-10 h-10 rounded-2xl bg-white text-slate-600 flex items-center justify-center mb-3 shadow-sm">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                    <h3 class="font-semibold text-brand-primary mb-1">Settings</h3>
                                    <p class="text-sm text-slate-500">Review system-level configuration.</p>
                                </a>
                            </div>
                        </div>

                        <div class="surface-card rounded-3xl p-6">
                            <div class="flex items-center justify-between mb-5">
                                <div>
                                    <h2 class="text-xl font-semibold text-brand-primary">Pipeline status</h2>
                                    <p class="text-sm text-slate-500">Live onboarding distribution.</p>
                                </div>
                                <div class="w-10 h-10 rounded-2xl bg-brand-primary/5 text-brand-primary flex items-center justify-center">
                                    <i class="fa-solid fa-signal"></i>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @foreach ($statusBreakdown as $status)
                                    <div class="flex items-center justify-between rounded-2xl px-4 py-3 {{ 'status-' . $status['tone'] }}">
                                        <span class="text-sm font-medium">{{ $status['label'] }}</span>
                                        <span class="text-lg font-semibold">{{ number_format($status['value']) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <section class="grid grid-cols-1 xl:grid-cols-[1.1fr_0.9fr] gap-6">
                        <div class="surface-card rounded-3xl overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="text-xl font-semibold text-brand-primary">Recent onboarding requests</h2>
                                    <p class="text-sm text-slate-500">Latest merchants entering the pipeline.</p>
                                </div>
                                <a href="{{ route('admin.onboarding.index') }}" class="text-sm font-semibold text-brand-secondary hover:text-brand-primary">View all</a>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-[0.12em]">
                                        <tr>
                                            <th class="px-6 py-4 text-left">Merchant</th>
                                            <th class="px-6 py-4 text-left">Partner</th>
                                            <th class="px-6 py-4 text-left">Solution</th>
                                            <th class="px-6 py-4 text-left">Status</th>
                                            <th class="px-6 py-4 text-left">Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 bg-white">
                                        @forelse ($recentOnboardings as $onboarding)
                                            <tr class="hover:bg-slate-50/80 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="font-medium text-slate-900">{{ $onboarding->legal_business_name }}</div>
                                                    <div class="text-xs text-slate-400">{{ $onboarding->merchant_contact_email }}</div>
                                                </td>
                                                <td class="px-6 py-4 text-slate-600">{{ $onboarding->partner->title ?? 'Direct' }}</td>
                                                <td class="px-6 py-4 text-slate-600">{{ $onboarding->solution->name ?? '—' }}</td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $statusTone = match ($onboarding->status) {
                                                            'sent' => 'status-blue',
                                                            'in-review' => 'status-amber',
                                                            'approved' => 'status-emerald',
                                                            'active' => 'status-indigo',
                                                            default => 'status-slate',
                                                        };
                                                    @endphp
                                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusTone }}">{{ ucfirst(str_replace('-', ' ', $onboarding->status)) }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-slate-500">{{ $onboarding->updated_at?->diffForHumans() ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">No onboarding records available yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="surface-card rounded-3xl p-6">
                                <div class="flex items-center justify-between mb-5">
                                    <div>
                                        <h2 class="text-xl font-semibold text-brand-primary">System overview</h2>
                                        <p class="text-sm text-slate-500">Coverage across master data and access.</p>
                                    </div>
                                    <div class="w-10 h-10 rounded-2xl bg-orange-50 text-brand-cta flex items-center justify-center">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    @foreach ($systemOverview as $item)
                                        <div class="flex items-start justify-between gap-4 rounded-2xl border border-slate-100 px-4 py-3">
                                            <div>
                                                <p class="text-sm font-medium text-slate-900">{{ $item['label'] }}</p>
                                                <p class="text-xs text-slate-500 mt-1">{{ $item['description'] }}</p>
                                            </div>
                                            <span class="text-2xl font-semibold text-brand-primary">{{ number_format($item['value']) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="surface-card rounded-3xl p-6">
                                <div class="flex items-center justify-between mb-5">
                                    <div>
                                        <h2 class="text-xl font-semibold text-brand-primary">Recent admin activity</h2>
                                        <p class="text-sm text-slate-500">Latest requests recorded in audit logs.</p>
                                    </div>
                                    <a href="{{ route('admin.audit-logs.index') }}" class="text-sm font-semibold text-brand-secondary hover:text-brand-primary">Logs</a>
                                </div>

                                <div class="space-y-3">
                                    @forelse ($recentAuditLogs as $log)
                                        <div class="rounded-2xl border border-slate-100 px-4 py-3">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <p class="text-sm font-medium text-slate-900">{{ $log->user_name ?? 'System' }}</p>
                                                    <p class="text-xs text-slate-500 mt-1">{{ $log->method }} {{ $log->route_name ?? $log->url }}</p>
                                                </div>
                                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $log->status_code }}</span>
                                            </div>
                                            <p class="text-xs text-slate-400 mt-3">{{ $log->created_at?->diffForHumans() ?? '—' }}</p>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-8 text-center text-sm text-slate-500">Audit activity will appear here once requests are recorded.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </body>
@endsection