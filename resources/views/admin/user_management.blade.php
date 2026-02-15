@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - 2iZii</title>
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
                        mono: ['Liberation Mono', 'monospace'],
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

        /* Toast notifications */
        #toast-container {
            position: fixed;
            top: 1.25rem;
            right: 1rem;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            pointer-events: none;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            min-width: 260px;
            max-width: 420px;
            padding: 0.75rem 0.875rem;
            border-radius: 0.75rem;
            color: #FFFFFF;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            animation: toast-in 0.25s ease-out;
            pointer-events: auto;
        }

        .toast-success {
            background: linear-gradient(135deg, #16A34A 0%, #22C55E 100%);
        }

        .toast-error {
            background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
        }

        .toast-icon {
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-title {
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .toast-message {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        @keyframes toast-in {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('body')

    <body class="bg-brand-neutral">
        <x-admin.sidebar active="users" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'User Management', 'url' => route('admin.users.index')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-brand-primary mb-1">User Management</h1>
                    <p class="text-sm text-gray-500">Manage system users, roles, and permissions</p>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div
                        class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                @endif

                <!-- Filters and Search -->
                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by name, email, or phone..."
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="w-full md:w-48">
                            <select name="role_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                <option value="">All Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-48">
                            <input type="text" name="country" value="{{ request('country') }}" placeholder="Country"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-brand-primary text-white px-6 py-2 rounded-lg hover:bg-brand-secondary transition-colors">
                                <i class="fa-solid fa-search mr-2"></i>Search
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                                class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-redo"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <!-- Table Header with Actions -->
                    <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                        <div class="text-sm font-semibold text-gray-700">
                            Total Users: <span class="text-brand-primary">{{ $users->total() }}</span>
                        </div>
                        <button onclick="openUserOffcanvas()"
                            class="bg-brand-accent text-white px-4 py-2 rounded-lg hover:bg-orange-500 transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i>
                            <span>Add New User</span>
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        User</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Contact</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Location</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-brand-primary text-white flex items-center justify-center font-semibold">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $user->name }} {{ $user->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $user->role->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i class="fa-solid fa-phone text-gray-400 mr-2"></i>
                                                {{ $user->phone ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div>
                                                {{ $user->city ?? '' }}{{ $user->city && $user->country ? ', ' : '' }}{{ $user->country ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="text-brand-primary hover:text-brand-secondary" title="View">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <button onclick="editUser({{ $user->id }})"
                                                    class="text-blue-600 hover:text-blue-800" title="Edit">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                        title="Delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fa-solid fa-users text-4xl mb-4 text-gray-300"></i>
                                            <p class="text-lg">No users found</p>
                                            <p class="text-sm mt-2">Try adjusting your search or filters</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="bg-white px-6 py-4 border-t border-gray-200">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>

        <!-- Offcanvas for Create/Edit User -->
        <div id="userOffcanvas" class="fixed inset-0 z-50 hidden">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeUserOffcanvas()"></div>

            <!-- Offcanvas Panel -->
            <div class="absolute right-0 top-0 h-full w-full md:w-[600px] bg-white shadow-xl transform transition-transform duration-300 translate-x-full"
                id="offcanvasPanel">
                <div class="h-full flex flex-col">
                    <!-- Header -->
                    <div class="bg-brand-primary text-white px-6 py-4 flex items-center justify-between">
                        <h2 class="text-xl font-semibold" id="offcanvasTitle">Add New User</h2>
                        <button onclick="closeUserOffcanvas()" class="text-white hover:text-gray-200">
                            <i class="fa-solid fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Form Content -->
                    <div class="flex-1 overflow-y-auto p-6">
                        <form id="userForm" onsubmit="submitUserForm(event)">
                            <input type="hidden" id="userId" name="user_id">
                            <input type="hidden" id="formMethod" name="_method" value="POST">

                            <!-- Personal Information -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-brand-primary mb-4">Personal Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                            First Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" id="name" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                        <span class="text-red-500 text-sm error-message" id="error-name"></span>
                                    </div>

                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Last Name
                                        </label>
                                        <input type="text" name="last_name" id="last_name"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                        <span class="text-red-500 text-sm error-message" id="error-last_name"></span>
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email" id="email" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                        <span class="text-red-500 text-sm error-message" id="error-email"></span>
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="text" name="phone" id="phone"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                        <span class="text-red-500 text-sm error-message" id="error-phone"></span>
                                    </div>

                                    <div>
                                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Role <span class="text-red-500">*</span>
                                        </label>
                                        <select name="role_id" id="role_id" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-red-500 text-sm error-message" id="error-role_id"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="mb-6 hidden" id="passwordSection">
                                <h3 class="text-lg font-semibold text-brand-primary mb-2">Password</h3>
                                <p class="text-sm text-gray-500 mb-4 hidden" id="passwordHint">Leave blank to keep current
                                    password</p>

                                <div class="space-y-4">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500" id="passwordRequired">*</span>
                                        </label>
                                        <input type="password" name="password" id="password"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                        <span class="text-red-500 text-sm error-message" id="error-password"></span>
                                    </div>

                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm Password <span class="text-red-500" id="passwordConfRequired">*</span>
                                        </label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-brand-primary mb-4">Address Information</h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                            Street Address
                                        </label>
                                        <input type="text" name="address" id="address"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                        <span class="text-red-500 text-sm error-message" id="error-address"></span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                                City
                                            </label>
                                            <input type="text" name="city" id="city"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                            <span class="text-red-500 text-sm error-message" id="error-city"></span>
                                        </div>

                                        <div>
                                            <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                                                State/Province
                                            </label>
                                            <input type="text" name="state" id="state"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                            <span class="text-red-500 text-sm error-message" id="error-state"></span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                                Postal Code
                                            </label>
                                            <input type="text" name="postal_code" id="postal_code"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                            <span class="text-red-500 text-sm error-message"
                                                id="error-postal_code"></span>
                                        </div>

                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                                Country
                                            </label>
                                            <input type="text" name="country" id="country"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary">
                                            <span class="text-red-500 text-sm error-message" id="error-country"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-gray-50">
                        <button type="button" onclick="closeUserOffcanvas()"
                            class="text-brand-primary font-medium hover:text-brand-secondary">
                            Cancel
                        </button>
                        <button type="submit" form="userForm"
                            class="bg-brand-accent text-white px-6 py-2 rounded-lg font-medium hover:bg-orange-500 transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-save"></i>
                            <span id="submitButtonText">Create User</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showNotification(message, type) {
                let container = document.getElementById('toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'toast-container';
                    document.body.appendChild(container);
                }

                const notification = document.createElement('div');
                const isSuccess = type === 'success';
                notification.className = `toast ${isSuccess ? 'toast-success' : 'toast-error'}`;
                notification.innerHTML = `
                    <div class="toast-icon">
                        <i class="fa-solid ${isSuccess ? 'fa-check' : 'fa-xmark'} text-sm"></i>
                    </div>
                    <div>
                        <div class="toast-title">${isSuccess ? 'Success' : 'Error'}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                `;
                container.appendChild(notification);
                setTimeout(() => notification.remove(), isSuccess ? 3200 : 4500);
            }

            function openUserOffcanvas(userId = null) {
                const offcanvas = document.getElementById('userOffcanvas');
                const panel = document.getElementById('offcanvasPanel');
                const form = document.getElementById('userForm');
                const title = document.getElementById('offcanvasTitle');
                const submitBtn = document.getElementById('submitButtonText');
                const passwordHint = document.getElementById('passwordHint');
                const passwordSection = document.getElementById('passwordSection');
                const passwordRequired = document.getElementById('passwordRequired');
                const passwordConfRequired = document.getElementById('passwordConfRequired');
                const password = document.getElementById('password');

                // Reset form
                form.reset();
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

                if (userId) {
                    // Edit mode - hide password section
                    title.textContent = 'Edit User';
                    submitBtn.textContent = 'Update User';
                    passwordSection.classList.add('hidden');
                    password.removeAttribute('required');
                    document.getElementById('password_confirmation').removeAttribute('required');
                    document.getElementById('formMethod').value = 'PUT';
                } else {
                    // Create mode - show password section
                    title.textContent = 'Add New User';
                    submitBtn.textContent = 'Create User';
                    passwordSection.classList.remove('hidden');
                    passwordHint.classList.add('hidden');
                    passwordRequired.classList.remove('hidden');
                    passwordConfRequired.classList.remove('hidden');
                    password.setAttribute('required', 'required');
                    document.getElementById('password_confirmation').setAttribute('required', 'required');
                    document.getElementById('formMethod').value = 'POST';
                    document.getElementById('userId').value = '';
                }

                offcanvas.classList.remove('hidden');
                setTimeout(() => {
                    panel.classList.remove('translate-x-full');
                }, 10);
            }

            function closeUserOffcanvas() {
                const offcanvas = document.getElementById('userOffcanvas');
                const panel = document.getElementById('offcanvasPanel');

                panel.classList.add('translate-x-full');
                setTimeout(() => {
                    offcanvas.classList.add('hidden');
                }, 300);
            }

            function editUser(userId) {
                openUserOffcanvas(userId);

                // Fetch user data
                fetch(`/admin/users/${userId}/edit`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('userId').value = data.user.id;
                        document.getElementById('name').value = data.user.name || '';
                        document.getElementById('last_name').value = data.user.last_name || '';
                        document.getElementById('email').value = data.user.email || '';
                        document.getElementById('phone').value = data.user.phone || '';
                        document.getElementById('role_id').value = data.user.role_id || '';
                        document.getElementById('address').value = data.user.address || '';
                        document.getElementById('city').value = data.user.city || '';
                        document.getElementById('state').value = data.user.state || '';
                        document.getElementById('postal_code').value = data.user.postal_code || '';
                        document.getElementById('country').value = data.user.country || '';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to load user data');
                    });
            }

            function submitUserForm(event) {
                event.preventDefault();

                const form = document.getElementById('userForm');
                const formData = new FormData(form);
                const userId = document.getElementById('userId').value;
                const method = document.getElementById('formMethod').value;

                let url = userId ? `/admin/users/${userId}` : '/admin/users';

                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                document.querySelectorAll('input, select').forEach(el => el.classList.remove('border-red-500'));

                // Add CSRF token
                formData.append('_token', '{{ csrf_token() }}');
                if (method === 'PUT') {
                    formData.append('_method', 'PUT');
                }

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw {
                                    errors: data.errors || {},
                                    message: data.message
                                };
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            closeUserOffcanvas();
                            showNotification(data.message || 'User saved successfully', 'success');
                            setTimeout(() => location.reload(), 1200);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (error.errors) {
                            // Display validation errors
                            Object.keys(error.errors).forEach(key => {
                                const errorElement = document.getElementById(`error-${key}`);
                                const inputElement = document.getElementById(key);
                                if (errorElement) {
                                    errorElement.textContent = error.errors[key][0];
                                }
                                if (inputElement) {
                                    inputElement.classList.add('border-red-500');
                                }
                            });
                        } else {
                            showNotification(error.message || 'An error occurred. Please try again.', 'error');
                        }
                    });
            }

        document.addEventListener('DOMContentLoaded', function() {
            const flashSuccess = @json(session('success'));
            const flashError = @json(session('error'));

            if (flashSuccess) {
                showNotification(flashSuccess, 'success');
            }
            if (flashError) {
                showNotification(flashError, 'error');
            }
        });
        </script>
    </body>
@endsection
