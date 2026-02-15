@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Master - 2iZii</title>
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
        window.FontAwesomeConfig = {
            autoReplaceSvg: 'nest'
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
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

        .drawer-open {
            transform: translateX(0);
        }

        .drawer-closed {
            transform: translateX(100%);
        }

        .form-input {
            width: 100%;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
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

        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Categories Master', 'url' => route('admin.categories.index')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">
                <!-- Page Content -->
                <div class="bg-brand-neutral p-4 md:p-8">
                    <div class="max-w-[1200px] mx-auto">
                        <!-- Page Title and Add Button -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                            <div>
                                <h1 class="text-2xl font-semibold text-brand-primary mb-1">Categories Master</h1>
                                <p class="text-sm text-gray-500">Manage and configure solution categories for merchants.</p>
                            </div>
                            <button onclick="openDrawer()"
                                class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2 self-start md:self-auto">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Category</span>
                            </button>
                        </div>

                        <!-- Search and Filters -->
                        <div
                            class="bg-white border border-gray-200 rounded-t-xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="relative w-full sm:w-[384px]">
                                <i
                                    class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" id="search-input" placeholder="Search categories..."
                                    class="form-input pl-10 bg-white border-gray-200 w-full">
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <button
                                    class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-download text-sm"></i>
                                    Export
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                #</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Slug</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Created Date</th>
                                            <th
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @forelse ($categories as $index => $category)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $index + 1 }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        {{ $category->name }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                    {{ $category->slug }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $category->created_at->format('M d, Y') }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                    <button
                                                        onclick="editCategory({{ $category->id }}, '{{ $category->name }}')"
                                                        class="text-blue-600 hover:text-blue-900 font-medium">
                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                    </button>
                                                    <button onclick="deleteCategory({{ $category->id }})"
                                                        class="text-red-600 hover:text-red-900 font-medium">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                    No categories found. <a href="javascript:openDrawer()"
                                                        class="text-brand-accent hover:underline">Create one</a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div
                                class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium text-gray-900">{{ count($categories) }}</span>
                                    categories
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Drawer for Add/Edit Category -->
        <div id="category-drawer"
            class="fixed top-0 right-0 w-full max-w-[580px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <form id="category-form" action="{{ route('admin.categories.store') }}" method="post" class="h-full flex flex-col">
                @csrf
                <div class="flex flex-col h-full">
                    <!-- Drawer Header -->
                    <div class="border-b border-gray-200 px-6 py-5">
                        <div class="mb-2">
                            <h2 id="drawer-title" class="text-xl font-semibold text-brand-primary">Add New Category</h2>
                            <p class="text-xs text-gray-500 mt-1">Create a new solution category.</p>
                        </div>
                        <button type="button" onclick="closeDrawer()"
                            class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Drawer Content -->
                    <div class="flex-1 overflow-y-auto p-6">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="category-name" name="name" class="form-input" placeholder="e.g. E-commerce">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Slug <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="category-slug" name="slug" class="form-input" placeholder="e.g. e-commerce"
                                    readonly>
                                <p class="text-xs text-gray-500 mt-1">Auto-generated from name. Click to edit manually.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Drawer Footer -->
                    <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                        <button type="button" onclick="closeDrawer()"
                            class="text-brand-primary font-medium hover:text-brand-secondary">Cancel</button>
                        <div class="flex gap-3">
                            <button type="submit"
                                class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                                Save Category
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Overlay -->
        <div id="drawer-overlay"
            class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-40 hidden"
            onclick="closeDrawer()"></div>

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal-overlay" class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 z-50 hidden" onclick="closeDeleteModal()"></div>
        <div id="delete-modal" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-2xl z-50 hidden max-w-sm w-full mx-4">
            <div class="p-6">
                <!-- Icon -->
                <div class="flex justify-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-trash text-red-600 text-xl"></i>
                    </div>
                </div>

                <!-- Title -->
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Delete Category</h3>

                <!-- Message -->
                <p class="text-gray-600 text-center text-sm mb-6">
                    Are you sure you want to delete this category? This action cannot be undone.
                </p>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button id="delete-confirm-btn"
                        class="flex-1 bg-red-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>

    </body>
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

        // Helper function to generate slug
        function generateSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]/g, '');
        }

        function openDrawer() {
            document.getElementById('category-drawer').classList.remove('drawer-closed');
            document.getElementById('category-drawer').classList.add('drawer-open');
            document.getElementById('drawer-overlay').classList.remove('hidden');
            setupSlugGeneration();
        }

        function closeDrawer() {
            document.getElementById('category-drawer').classList.remove('drawer-open');
            document.getElementById('category-drawer').classList.add('drawer-closed');
            document.getElementById('drawer-overlay').classList.add('hidden');
            document.getElementById('category-form').action = "{{ route('admin.categories.store') }}";
            document.getElementById('category-form').method = 'POST';
            document.getElementById('drawer-title').textContent = 'Add New Category';
            document.getElementById('category-name').value = '';
            document.getElementById('category-slug').value = '';
            document.getElementById('category-slug').removeAttribute('data-edited');
            document.getElementById('category-slug').readOnly = true;
        }

        function editCategory(id, name) {
            // Set form to update route
            const form = document.getElementById('category-form');
            form.action = "{{ route('admin.categories.update', ':id') }}".replace(':id', id);
            form.method = 'POST';
            
            // Add PUT method override for Laravel
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            
            // Remove existing _method input if present
            const existing = form.querySelector('input[name="_method"]');
            if (existing) existing.remove();
            
            form.insertBefore(methodInput, form.firstChild.nextSibling);
            
            // Update drawer
            document.getElementById('drawer-title').textContent = 'Edit Category';
            document.getElementById('category-name').value = name;
            document.getElementById('category-slug').value = generateSlug(name);
            // Don't mark as edited - allow auto-generation to work when user changes the name
            document.getElementById('category-slug').removeAttribute('data-edited');
            document.getElementById('category-slug').readOnly = true;
            
            openDrawer();
        }

        function deleteCategory(id) {
            // Show custom delete confirmation modal
            document.getElementById('delete-modal').classList.remove('hidden');
            document.getElementById('delete-modal-overlay').classList.remove('hidden');
            document.getElementById('delete-confirm-btn').onclick = function() {
                confirmDelete(id);
            };
        }

        function confirmDelete(id) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('admin.categories.destroy', ':id') }}".replace(':id', id);
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = "{{ csrf_token() }}";
            
            form.appendChild(methodInput);
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            document.getElementById('delete-modal-overlay').classList.add('hidden');
        }

        // Auto-generate slug from name in real-time
        function setupSlugGeneration() {
            const nameInput = document.getElementById('category-name');
            const slugInput = document.getElementById('category-slug');

            if (!nameInput || !slugInput) return;

            // Remove any existing listeners by cloning
            const newNameInput = nameInput.cloneNode(true);
            nameInput.parentNode.replaceChild(newNameInput, nameInput);

            const finalNameInput = document.getElementById('category-name');

            finalNameInput.addEventListener('input', function() {
                if (!slugInput.hasAttribute('data-edited')) {
                    slugInput.value = generateSlug(this.value);
                }
            });

            // Allow manual editing by clicking on slug field
            slugInput.addEventListener('click', function() {
                if (!this.hasAttribute('data-edited')) {
                    this.removeAttribute('readonly');
                    this.setAttribute('data-edited', 'true');
                    this.focus();
                }
            });

            // Reset edited flag when slug is cleared
            slugInput.addEventListener('input', function() {
                if (!this.value.trim()) {
                    this.removeAttribute('data-edited');
                    this.setAttribute('readonly', 'readonly');
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            setupSlugGeneration();

            const flashSuccess = @json(session('success'));
            const flashError = @json(session('error'));
            if (flashSuccess) {
                showNotification(flashSuccess, 'success');
            }
            if (flashError) {
                showNotification(flashError, 'error');
            }

            const params = new URLSearchParams(window.location.search);
            const successMessage = params.get('success');
            const errorMessage = params.get('error');
            if (successMessage) {
                showNotification(successMessage, 'success');
                params.delete('success');
            }
            if (errorMessage) {
                showNotification(errorMessage, 'error');
                params.delete('error');
            }
            if (successMessage || errorMessage) {
                const newUrl = `${window.location.pathname}${params.toString() ? `?${params.toString()}` : ''}`;
                window.history.replaceState({}, '', newUrl);
            }
        });
    </script>
@endsection
