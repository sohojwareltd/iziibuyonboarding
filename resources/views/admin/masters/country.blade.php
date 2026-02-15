@extends('layouts.admin')

@section('title', 'Country Master - 2iZii')

@push('head')
    <style>
        /* Drawer animations */
        #country-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            max-width: 480px;
            height: 100vh;
            background: white;
            z-index: 50;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        #country-drawer.drawer-open {
            transform: translateX(0) !important;
        }

        #country-drawer.drawer-closed {
            transform: translateX(100%) !important;
            pointer-events: none;
        }

        /* Overlay styles */
        #drawer-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            transition: opacity 0.3s ease-in-out;
            opacity: 1;
        }

        #drawer-overlay.hidden {
            display: none !important;
            opacity: 0;
            pointer-events: none;
        }

        /* Form input styles */
        .form-input {
            width: 100%;
            border: 1px solid #E5E7EB;
            border-radius: 0.5rem;
            padding: 0.625rem 0.75rem;
            color: #2D3A74;
            outline: none;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .form-input:focus {
            border-color: #2D3A74;
            box-shadow: 0 0 0 1px #2D3A74;
        }

        /* Active filters badges */
        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #FF9900 0%, #FF7200 100%);
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.813rem;
            font-weight: 500;
        }

        .filter-badge button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            margin-left: 0.25rem;
            display: flex;
            align-items: center;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .filter-badge button:hover {
            opacity: 1;
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
            min-width: 280px;
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
@endpush

@section('body')

    <x-admin.sidebar active="masters" />

    <x-admin.topbar :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => '#'],
        ['label' => 'Country Master', 'url' => route('admin.masters.countrys.index')],
    ]" />

    <!-- MAIN CONTENT AREA -->
    <main id="main-content" class="ml-[260px] pt-16 min-h-screen bg-brand-neutral">
        <div class="p-8">

            <!-- Page Content -->
            <div class="bg-brand-neutral p-8">
                <div class="max-w-[1280px] mx-auto">
                    <!-- Page Title and Add Button -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-semibold text-brand-primary mb-1">Country Master</h1>
                            <p class="text-sm text-gray-500">Manage all countries available on the platform.</p>
                        </div>

                        
                        <button onclick="openAddCountry()"
                            class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span class="font-medium">Add Country</span>
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="bg-white border border-gray-200 rounded-t-xl p-4">
                        <form method="GET" action="{{ route('admin.masters.countrys.index') }}" class="space-y-4">
                            <!-- Search Bar -->
                            <div class="flex items-center justify-between gap-4">
                                <div class="relative flex-1 max-w-[384px]">
                                    {{-- <i
                                        class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i> --}}
                                    <input type="text" name="search" placeholder="Search countries by name or code..."
                                        value="{{ request('search') }}"
                                        class="form-input pl-10 bg-white border-gray-200 focus:bg-white">
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="bg-brand-accent text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-500 transition-colors flex items-center gap-2">
                                        <i class="fa-solid fa-search text-sm"></i>
                                        Search
                                    </button>
                                    <a href="{{ route('admin.masters.country.export', request()->query()) }}"
                                        class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                        <i class="fa-solid fa-download text-sm"></i>
                                        Export
                                    </a>
                                </div>
                            </div>

                            <!-- Active Filters Display -->
                            @if (request()->has('search') && request('search'))
                                <div class="active-filters">
                                    <div class="filter-badge">
                                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                        <span>{{ request('search') }}</span>
                                        <button type="button" onclick="clearSearchFilter()">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Country Name</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Country Code</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Created At</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($countries as $country)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <span class="text-gray-500 text-sm">{{ $country->id }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 bg-brand-primary rounded-full flex items-center justify-center">
                                                    <i class="fa-solid fa-globe text-white text-xs"></i>
                                                </div>
                                                <span class="font-medium text-gray-900">{{ $country->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                {{ $country->code }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="text-gray-500 text-sm">{{ $country->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button onclick="editCountry({{ $country->id }})"
                                                    class="text-gray-400 hover:text-brand-primary p-2">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button
                                                    onclick="deleteCountry({{ $country->id }}, '{{ $country->name }}')"
                                                    class="text-gray-400 hover:text-red-500 p-2">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fa-solid fa-globe text-4xl text-gray-300 mb-3"></i>
                                            <p class="text-sm">No countries found. Add one to get started.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        @if ($countries->hasPages())
                            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                                <div class="text-xs text-gray-500">
                                    Showing <span
                                        class="font-medium text-gray-900">{{ ($countries->currentPage() - 1) * $countries->perPage() + 1 }}</span>
                                    to <span
                                        class="font-medium text-gray-900">{{ min($countries->currentPage() * $countries->perPage(), $countries->total()) }}</span>
                                    of <span class="font-medium text-gray-900">{{ $countries->total() }}</span> results
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    {{ $countries->links('pagination::tailwind') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Right Drawer for Add/Edit Country -->
    <div id="country-drawer" class="drawer-closed overflow-y-auto">
        <div class="flex flex-col h-full">
            <!-- Drawer Header -->
            <div class="border-b border-gray-200 px-6 py-5 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-brand-primary" id="drawer-title">Add Country</h2>
                <button onclick="closeDrawer()"
                    class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Drawer Content -->
            <form id="country-form" class="flex-1 overflow-y-auto p-6 flex flex-col">
                <input type="hidden" id="country_id" name="country_id">

                <div class="space-y-6 flex-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" class="form-input"
                            placeholder="e.g. United States" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Country Code <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="code" name="code" class="form-input uppercase"
                            placeholder="e.g. US" maxlength="3" required>
                        <p class="text-xs text-gray-500 mt-1">ISO 3166-1 alpha-2 or alpha-3 code (2-3 characters)</p>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="pt-6 mt-6 border-t border-gray-200 flex gap-3">
                    <button type="button" onclick="closeDrawer()"
                        class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-brand-accent text-white rounded-lg font-medium hover:bg-orange-500 transition-colors">
                        <span id="submit-text">Save Country</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Overlay -->
    <div id="drawer-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"
        onclick="closeDrawer()"></div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal"
        class="fixed inset-0 bg-black/30 z-[70] hidden flex items-center justify-center p-4 transition-opacity duration-200"
        onclick="closeDeleteModal()">

        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-scale-in" onclick="event.stopPropagation()">

            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Delete Country</h3>
                        <p class="text-sm text-gray-500">
                            Are you sure you want to delete
                            <span id="delete-country-name" class="font-medium text-gray-700"></span>?
                        </p>
                    </div>
                </div>

                <p class="text-sm text-gray-500 mb-6">
                    This action cannot be undone. This country will be permanently removed from the system.
                </p>

                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-gray-600 font-medium hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>

                    <button type="button" onclick="confirmDelete()"
                        class="flex-1 px-4 py-2.5 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors">
                        Delete
                    </button>
                </div>
            </div>

        </div>
    </div>


@endsection

@push('head')
    <style>
        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-scale-in {
            animation: scale-in 0.2s ease-out;
        }

        .drawer-open {
            transform: translateX(0);
        }

        .drawer-closed {
            transform: translateX(100%);
        }
    </style>
@endpush

@push('scripts')
    <script>
        let deleteCountryId = null;

        function clearSearchFilter() {
            window.location.href = '{{ route('admin.masters.countrys.index') }}';
        }

        // ✅ Add এর জন্য আলাদা ফাংশন
        function openAddCountry() {
            resetForm();
            openDrawer(false); // drawer খুলো, কিন্তু আবার resetForm() call করবে না
            document.getElementById('drawer-title').textContent = 'Add Country';
            document.getElementById('submit-text').textContent = 'Save Country';
        }

        // ✅ Drawer open: reset parameter সহ
        function openDrawer(reset = true) {
            const overlay = document.getElementById('drawer-overlay');
            overlay.classList.remove('hidden');

            setTimeout(() => {
                const drawer = document.getElementById('country-drawer');
                drawer.classList.remove('drawer-closed');
                drawer.classList.add('drawer-open');
            }, 10);

            if (reset) resetForm();
        }

        function closeDrawer() {
            const drawer = document.getElementById('country-drawer');
            drawer.classList.remove('drawer-open');
            drawer.classList.add('drawer-closed');

            setTimeout(() => {
                document.getElementById('drawer-overlay').classList.add('hidden');
            }, 300);
        }

        function resetForm() {
            document.getElementById('country-form').reset();
            document.getElementById('country_id').value = '';
            document.getElementById('drawer-title').textContent = 'Add Country';
            document.getElementById('submit-text').textContent = 'Save Country';
        }

        function editCountry(id) {
            fetch(`{{ url('admin/masters/countrys') }}/${id}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // ✅ reset না করে drawer খুলুন
                        openDrawer(false);

                        // ✅ তারপর data বসান
                        populateForm(data.data);

                        document.getElementById('drawer-title').textContent = 'Edit Country';
                        document.getElementById('submit-text').textContent = 'Update Country';
                    } else {
                        showNotification(data.message || 'Country not found', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to load country data', 'error');
                });
        }

        function populateForm(country) {
            document.getElementById('country_id').value = country.id;
            document.getElementById('name').value = country.name;
            document.getElementById('code').value = country.code;
        }

        function deleteCountry(id, name) {
            deleteCountryId = id;

            const drawerOverlay = document.getElementById('drawer-overlay');
            if (drawerOverlay) drawerOverlay.classList.add('hidden');

            document.getElementById('delete-country-name').textContent = name;
            document.getElementById('delete-modal').classList.remove('hidden');
        }


        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            deleteCountryId = null;
        }

        function confirmDelete() {
            if (!deleteCountryId) return;

            fetch(`{{ url('admin/masters/countrys') }}/${deleteCountryId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Country deleted successfully', 'success');
                        closeDeleteModal();
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showNotification(data.message || 'Failed to delete country', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to delete country', 'error');
                });
        }

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
            setTimeout(() => notification.remove(), 3200);
        }

        // Form submission
        document.getElementById('country-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const countryId = document.getElementById('country_id').value;
            const isEdit = countryId !== '';
            const url = isEdit ?
                `{{ url('admin/masters/countrys') }}/${countryId}` :
                '{{ route('admin.masters.countrys.store') }}';
            const method = isEdit ? 'PUT' : 'POST';

            const formData = {
                name: document.getElementById('name').value,
                code: document.getElementById('code').value.toUpperCase()
            };

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(isEdit ? 'Country updated successfully' :
                            'Country created successfully', 'success');
                        closeDrawer();
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        if (data.errors) {
                            const errorMessages = Object.values(data.errors).flat().join('\n');
                            showNotification(errorMessages, 'error');
                        } else {
                            showNotification(data.message || 'An error occurred', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to save country', 'error');
                });
        });

        // Add CSRF token to meta if not present
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }
    </script>
@endpush
