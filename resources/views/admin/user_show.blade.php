@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User - 2iZii</title>
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
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        .nav-item-active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #FF7C00;
            padding-left: 20px;
        }

        .nav-item {
            padding-left: 24px;
        }

        .nav-item-sub {
            padding-left: 44px;
        }

        .nav-item-sub-active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #FF7C00;
            padding-left: 40px;
        }

        .drawer-open {
            transform: translateX(0);
        }

        .drawer-closed {
            transform: translateX(100%);
        }
    </style>
@endsection

@section('body')

    <body class="bg-brand-neutral">
        <x-admin.sidebar active="users" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'User Management', 'url' => route('admin.users.index')],
            ['label' => 'View User', 'url' => ''],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">
                <!-- Page Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-brand-primary mb-1">User Details</h1>
                        <p class="text-sm text-gray-500">View complete user information</p>
                    </div>
                    {{-- <div class="flex gap-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="bg-brand-primary text-white px-4 py-2 rounded-lg hover:bg-brand-secondary transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-edit"></i>
                            <span>Edit User</span>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-trash"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div> --}}
                </div>

                <!-- User Profile Card -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-brand-primary to-brand-secondary">
                        <div class="flex items-center">
                            <div
                                class="h-20 w-20 rounded-full bg-white text-brand-primary flex items-center justify-center font-bold text-2xl shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                            </div>
                            <div class="ml-6 text-white">
                                <h2 class="text-2xl font-bold">{{ $user->name }} {{ $user->last_name }}</h2>
                                <p class="text-blue-100 mt-1">{{ $user->email }}</p>
                                <div class="mt-2">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                                        <i class="fa-solid fa-user-tag mr-2"></i>
                                        {{ $user->role->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-brand-primary mb-4 flex items-center">
                            <i class="fa-solid fa-user mr-2"></i>
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">First Name</label>
                                <p class="text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Last Name</label>
                                <p class="text-gray-900">{{ $user->last_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Email</label>
                                <p class="text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Phone</label>
                                <p class="text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Role</label>
                                <p class="text-gray-900">{{ $user->role->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Member Since</label>
                                <p class="text-gray-900">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-brand-primary mb-4 flex items-center">
                            <i class="fa-solid fa-map-marker-alt mr-2"></i>
                            Address Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Street
                                    Address</label>
                                <p class="text-gray-900">{{ $user->address ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">City</label>
                                <p class="text-gray-900">{{ $user->city ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase mb-1">State/Province</label>
                                <p class="text-gray-900">{{ $user->state ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Postal Code</label>
                                <p class="text-gray-900">{{ $user->postal_code ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Country</label>
                                <p class="text-gray-900">{{ $user->country ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline (Optional - can be implemented later) -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-brand-primary mb-4 flex items-center">
                            <i class="fa-solid fa-clock mr-2"></i>
                            Account Timeline
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                        <i class="fa-solid fa-user-plus text-xs"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Account Created</p>
                                    <p class="text-sm text-gray-500">{{ $user->created_at->format('F d, Y \a\t g:i A') }}
                                    </p>
                                </div>
                            </div>
                            @if ($user->updated_at != $user->created_at)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                            <i class="fa-solid fa-edit text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $user->updated_at->format('F d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center text-brand-primary hover:text-brand-secondary font-medium">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Back to User List
                    </a>
                </div>
            </div>
        </main>
    </body>
@endsection
