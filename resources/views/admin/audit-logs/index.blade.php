@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - 2iZii</title>
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
                            dark: '#2D3A74',
                            accent: '#FFA439',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        ::-webkit-scrollbar-track { background: transparent; }
    </style>
@endsection

@section('body')
<body class="bg-brand-neutral">
    <x-admin.sidebar active="audit-logs" />

    <x-admin.topbar :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => '#'],
        ['label' => 'Audit Logs', 'url' => route('admin.audit-logs.index')],
    ]" />

    <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
        <div class="p-4 md:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-brand-primary mb-1">Audit Logs</h1>
                <p class="text-sm text-gray-500">Track all authenticated user activities.</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search user, route, url, IP"
                        class="md:col-span-2 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">

                    <select name="user_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">
                        <option value="">All Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ (string) request('user_id') === (string) $user->id ? 'selected' : '' }}>
                                {{ trim(($user->name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->email }}
                            </option>
                        @endforeach
                    </select>

                    <select name="method" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">
                        <option value="">All Methods</option>
                        @foreach (['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $httpMethod)
                            <option value="{{ $httpMethod }}" {{ request('method') === $httpMethod ? 'selected' : '' }}>{{ $httpMethod }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">

                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">

                    <div class="md:col-span-6 flex items-center gap-2">
                        <button type="submit" class="bg-brand-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-brand-secondary transition-colors">
                            <i class="fa-solid fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.audit-logs.index') }}" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px]">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Time</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Method</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Route</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">URL</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">IP</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($auditLogs as $log)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $log->created_at?->format('M d, Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <div class="font-medium text-brand-primary">{{ $log->user_name ?: 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->user_email ?: 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 rounded text-xs font-semibold {{ in_array($log->method, ['POST','PUT','PATCH','DELETE']) ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $log->method }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $log->route_name ?: '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 max-w-[420px] truncate" title="{{ $log->url }}">{{ $log->url }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $log->ip_address ?: '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">{{ $log->status_code ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">No audit activity found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $auditLogs->links() }}
                </div>
            </div>
        </div>
    </main>
</body>
@endsection
