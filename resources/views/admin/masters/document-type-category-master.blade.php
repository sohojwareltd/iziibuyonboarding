@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Type Categories - {{ config('app.name') }}</title>
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
        };
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        ::-webkit-scrollbar-track { background: transparent; }
        .nav-item-active { background: rgba(255,255,255,0.15); border-left: 4px solid #FF7C00; padding-left: 20px; }
        .nav-item { padding-left: 24px; }
        .nav-item-sub { padding-left: 44px; }
        .nav-item-sub-active { background: rgba(255,255,255,0.15); border-left: 4px solid #FF7C00; padding-left: 40px; }
        .drawer-open  { transform: translateX(0); }
        .drawer-closed { transform: translateX(100%); }
        .form-input {
            width: 100%; border: 1px solid #D1D5DB; border-radius: 0.375rem;
            padding: 0.625rem 0.75rem; color: #2D3A74; outline: none;
            transition: all 0.2s; font-size: 0.875rem;
        }
        .form-input:focus { border-color: #2D3A74; box-shadow: 0 0 0 1px #2D3A74; }
        #toast-container {
            position: fixed; top: 1.25rem; right: 1rem; z-index: 100;
            display: flex; flex-direction: column; gap: 0.5rem; pointer-events: none;
        }
        .toast {
            display: flex; align-items: center; gap: 0.625rem;
            min-width: 260px; max-width: 420px; padding: 0.75rem 0.875rem;
            border-radius: 0.75rem; color: #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            animation: toast-in 0.25s ease-out; pointer-events: auto;
        }
        .toast-success { background: linear-gradient(135deg,#16A34A 0%,#22C55E 100%); }
        .toast-error   { background: linear-gradient(135deg,#DC2626 0%,#EF4444 100%); }
        .toast-icon { width:32px;height:32px;border-radius:9999px;background:rgba(255,255,255,0.2);display:inline-flex;align-items:center;justify-content:center;flex-shrink:0; }
        .toast-title   { font-size:0.8125rem;font-weight:600;line-height:1.2; }
        .toast-message { font-size:0.75rem;opacity:0.9; }
        @keyframes toast-in { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }
    </style>
@endsection

@section('body')
<body class="bg-brand-neutral">

    <x-admin.sidebar active="masters" />

    <x-admin.topbar :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => '#'],
        ['label' => 'Masters', 'url' => route('admin.masters.solution-master')],
        ['label' => 'Document Type Categories', 'url' => route('admin.masters.document-type-categories.index')],
    ]" />

    <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
        <div class="p-4 md:p-8">
            <div class="bg-brand-neutral p-4 md:p-8">
                <div class="max-w-[1200px] mx-auto">

                    @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification("{{ session('success') }}", 'success');
                            });
                        </script>
                    @endif
                    @if(session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showNotification("{{ session('error') }}", 'error');
                            });
                        </script>
                    @endif

                    <!-- Page Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                        <div>
                            <h1 class="text-2xl font-semibold text-brand-primary mb-1">Document Type Categories</h1>
                            <p class="text-sm text-gray-500">Manage categories used to classify document types in KYC.</p>
                        </div>
                        <button onclick="openDrawer()"
                            class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2 self-start md:self-auto">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span class="font-medium">Add Category</span>
                        </button>
                    </div>

                    <!-- Search -->
                    <form method="GET" action="{{ route('admin.masters.document-type-categories.index') }}"
                        class="bg-white border border-gray-200 rounded-t-xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="relative w-full sm:w-[384px]">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="search" id="search-input"
                                placeholder="Search categories..."
                                value="{{ $search ?? '' }}"
                                class="form-input pl-10 bg-white border-gray-200 w-full"
                                oninput="clearSearchIfEmpty(this)">
                            @if(!empty($search))
                                <a href="{{ route('admin.masters.document-type-categories.index') }}"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </a>
                            @endif
                        </div>
                        <button type="submit"
                            class="bg-brand-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-secondary transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-search text-sm"></i> Search
                        </button>
                    </form>

                    <!-- Table -->
                    <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse ($categories as $category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    {{ $category->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $category->slug }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 max-w-[220px] truncate">{{ $category->description ?? '—' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($category->is_active)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <button
                                                    onclick="editCategory({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ $category->slug }}', '{{ addslashes($category->description ?? '') }}', {{ $category->is_active ? 'true' : 'false' }})"
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
                                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                                No categories found.
                                                <a href="javascript:openDrawer()" class="text-brand-accent hover:underline">Create one</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($categories->hasPages())
                            <div class="bg-white border-t border-gray-200 px-4 sm:px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium text-gray-900">{{ ($categories->currentPage() - 1) * $categories->perPage() + 1 }}</span>
                                    to <span class="font-medium text-gray-900">{{ min($categories->currentPage() * $categories->perPage(), $categories->total()) }}</span>
                                    of <span class="font-medium text-gray-900">{{ $categories->total() }}</span> results
                                </div>
                                <div>{{ $categories->links('pagination::tailwind') }}</div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Right Drawer -->
    <div id="category-drawer"
        class="fixed top-0 right-0 w-full max-w-[540px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
        <form id="category-form" action="{{ route('admin.masters.document-type-categories.store') }}" method="POST" class="h-full flex flex-col">
            @csrf
            <div class="flex flex-col h-full">
                <!-- Header -->
                <div class="border-b border-gray-200 px-6 py-5 relative">
                    <h2 id="drawer-title" class="text-xl font-semibold text-brand-primary">Add New Category</h2>
                    <p id="drawer-subtitle" class="text-xs text-gray-500 mt-1">Create a new document type category.</p>
                    <button type="button" onclick="closeDrawer()"
                        class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="category-name" name="name" class="form-input" placeholder="e.g. Identity Documents">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="category-slug" name="slug" class="form-input" placeholder="e.g. identity-documents" readonly>
                        <p class="text-xs text-gray-500 mt-1">Auto-generated from name. Click to edit manually.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="category-description" name="description" rows="3"
                            class="form-input resize-none" placeholder="Optional description..."></textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="category-is-active" name="is_active" value="1"
                            class="w-4 h-4 text-brand-primary rounded border-gray-300 focus:ring-brand-primary" checked>
                        <label for="category-is-active" class="text-sm font-medium text-gray-700">Active</label>
                    </div>
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button type="button" onclick="closeDrawer()"
                        class="text-brand-primary font-medium hover:text-brand-secondary">Cancel</button>
                    <button type="submit"
                        class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                        Save Category
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Drawer overlay -->
    <div id="drawer-overlay"
        class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-40 hidden"
        onclick="closeDrawer()"></div>

    <!-- Delete Modal -->
    <div id="delete-modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" onclick="closeDeleteModal()"></div>
    <div id="delete-modal" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl shadow-2xl z-50 hidden max-w-sm w-full mx-4">
        <div class="p-6">
            <div class="flex justify-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-trash text-red-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Delete Category</h3>
            <p class="text-gray-600 text-center text-sm mb-6">
                Are you sure you want to delete this category? This action cannot be undone.
            </p>
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

    <script>
        const STORE_URL  = "{{ route('admin.masters.document-type-categories.store') }}";
        const UPDATE_URL = "{{ route('admin.masters.document-type-categories.update', ':id') }}";
        const DELETE_URL = "{{ route('admin.masters.document-type-categories.destroy', ':id') }}";

        function showNotification(message, type) {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                document.body.appendChild(container);
            }
            const n = document.createElement('div');
            const ok = type === 'success';
            n.className = `toast ${ok ? 'toast-success' : 'toast-error'}`;
            n.innerHTML = `
                <div class="toast-icon"><i class="fa-solid ${ok ? 'fa-check' : 'fa-xmark'} text-sm"></i></div>
                <div>
                    <div class="toast-title">${ok ? 'Success' : 'Error'}</div>
                    <div class="toast-message">${message}</div>
                </div>`;
            container.appendChild(n);
            setTimeout(() => n.remove(), ok ? 3200 : 4500);
        }

        function generateSlug(text) {
            return text.toLowerCase().trim().replace(/\s+/g, '-').replace(/[^\w-]/g, '');
        }

        function clearSearchIfEmpty(input) {
            if (!input.value.trim()) input.closest('form').submit();
        }

        function openDrawer() {
            document.getElementById('category-drawer').classList.replace('drawer-closed', 'drawer-open');
            document.getElementById('drawer-overlay').classList.remove('hidden');
            setupSlugGeneration();
        }

        function closeDrawer() {
            document.getElementById('category-drawer').classList.replace('drawer-open', 'drawer-closed');
            document.getElementById('drawer-overlay').classList.add('hidden');
            resetDrawer();
        }

        function resetDrawer() {
            const form = document.getElementById('category-form');
            form.action = STORE_URL;
            const method = form.querySelector('input[name="_method"]');
            if (method) method.remove();
            document.getElementById('drawer-title').textContent = 'Add New Category';
            document.getElementById('drawer-subtitle').textContent = 'Create a new document type category.';
            document.getElementById('category-name').value = '';
            document.getElementById('category-slug').value = '';
            document.getElementById('category-slug').removeAttribute('data-edited');
            document.getElementById('category-slug').readOnly = true;
            document.getElementById('category-description').value = '';
            document.getElementById('category-is-active').checked = true;
        }

        function editCategory(id, name, slug, description, isActive) {
            const form = document.getElementById('category-form');
            form.action = UPDATE_URL.replace(':id', id);

            const existing = form.querySelector('input[name="_method"]');
            if (existing) existing.remove();
            const mi = document.createElement('input');
            mi.type = 'hidden'; mi.name = '_method'; mi.value = 'PUT';
            form.prepend(mi);

            document.getElementById('drawer-title').textContent = 'Edit Category';
            document.getElementById('drawer-subtitle').textContent = 'Update existing document type category.';
            document.getElementById('category-name').value = name;
            document.getElementById('category-slug').value = slug || generateSlug(name);
            document.getElementById('category-slug').removeAttribute('data-edited');
            document.getElementById('category-slug').readOnly = true;
            document.getElementById('category-description').value = description;
            document.getElementById('category-is-active').checked = isActive;

            openDrawer();
        }

        function deleteCategory(id) {
            document.getElementById('delete-modal').classList.remove('hidden');
            document.getElementById('delete-modal-overlay').classList.remove('hidden');
            document.getElementById('delete-confirm-btn').onclick = () => confirmDelete(id);
        }

        function confirmDelete(id) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = DELETE_URL.replace(':id', id);
            form.innerHTML = `<input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">`;
            document.body.appendChild(form);
            form.submit();
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            document.getElementById('delete-modal-overlay').classList.add('hidden');
        }

        function setupSlugGeneration() {
            const nameInput = document.getElementById('category-name');
            const slugInput = document.getElementById('category-slug');
            if (!nameInput || !slugInput) return;

            // Re-attach listener cleanly
            const fresh = nameInput.cloneNode(true);
            nameInput.parentNode.replaceChild(fresh, nameInput);

            document.getElementById('category-name').addEventListener('input', function () {
                if (!slugInput.hasAttribute('data-edited')) {
                    slugInput.value = generateSlug(this.value);
                }
            });

            slugInput.addEventListener('click', function () {
                if (!this.hasAttribute('data-edited')) {
                    this.removeAttribute('readonly');
                    this.setAttribute('data-edited', 'true');
                    this.focus();
                }
            });

            slugInput.addEventListener('input', function () {
                if (!this.value.trim()) {
                    this.removeAttribute('data-edited');
                    this.setAttribute('readonly', 'readonly');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            setupSlugGeneration();

            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') this.closest('form').submit();
                });
            }
        });
    </script>
</body>
@endsection
