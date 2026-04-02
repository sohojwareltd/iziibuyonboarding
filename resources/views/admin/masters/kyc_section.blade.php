@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Section Master - 2iZii</title>
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

        .drawer-open {
            transform: translateX(0);
        }

        .drawer-closed {
            transform: translateX(100%);
        }

        .form-input {
            width: 100%;
            border: 1px solid #D1D5DB;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: #2D3A74;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: #2D3A74;
            box-shadow: 0 0 0 1px #2D3A74;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 280px;
            max-width: 400px;
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .toast-success {
            background: linear-gradient(135deg, #16A34A 0%, #22C55E 100%);
        }

        .toast-error {
            background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
        }

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
            color: #fff;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .filter-badge button {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 0;
            margin-left: 0.125rem;
        }

        #toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 60;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
    </style>
@endsection

@section('body')

    <body class="bg-brand-neutral">
        <x-admin.sidebar active="masters" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'KYC Section Master', 'url' => route('admin.masters.kyc-section-master')],
        ]" />

        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">
                <div class="max-w-[1200px] mx-auto">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-brand-primary mb-1">KYC Section Master</h1>
                            <p class="text-sm text-gray-500">Manage KYC section names, ordering, and status.</p>
                        </div>
                        <button onclick="openDrawer()"
                            class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2 self-start md:self-auto">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span class="font-medium">Add KYC Section</span>
                        </button>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
                        <form method="GET" action="{{ route('admin.masters.kyc-section-master') }}" class="space-y-4">
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="relative flex-1">
                                    <i
                                        class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search by name, slug, description" class="form-input pl-10">
                                </div>
                                <select name="status" class="form-input md:max-w-[220px]">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                <div class="flex gap-2">
                                    <button type="submit"
                                        class="bg-brand-accent text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-orange-500 transition-colors">
                                        Apply
                                    </button>
                                    <button type="button" onclick="clearAllFilters()"
                                        class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                                        Clear
                                    </button>
                                </div>
                            </div>

                            @if (request('search') || request('status'))
                                <div class="active-filters">
                                    @if (request('search'))
                                        <div class="filter-badge">
                                            <span>{{ request('search') }}</span>
                                            <button type="button" onclick="clearSearchFilter()"><i
                                                    class="fa-solid fa-xmark text-xs"></i></button>
                                        </div>
                                    @endif
                                    @if (request('status'))
                                        <div class="filter-badge">
                                            <span>Status: {{ ucfirst(request('status')) }}</span>
                                            <button type="button" onclick="clearStatusFilter()"><i
                                                    class="fa-solid fa-xmark text-xs"></i></button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 min-w-[760px]">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Slug</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Sort Order</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Description</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($kycSections as $section)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-brand-primary">{{ $section->name }}</div>
                                                <div class="text-xs text-gray-400">Updated {{ $section->updated_at->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $section->slug }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $section->sort_order }}</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="{{ $section->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                    {{ ucfirst($section->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 max-w-[280px] truncate">
                                                {{ $section->description ?: '—' }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-4">
                                                    <button onclick="editSection({{ $section->id }})"
                                                        class="text-brand-secondary text-xs font-medium hover:underline"><i
                                                            class="fa-solid fa-pen text-sm"></i></button>
                                                    <button onclick="deleteSection({{ $section->id }}, @js($section->name))"
                                                        class="text-red-500 text-xs font-medium hover:underline"><i
                                                            class="fa-solid fa-trash text-sm"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 text-sm">
                                                No KYC sections found. Create one to get started.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div
                            class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="text-xs text-gray-500">
                                Showing
                                <span class="font-medium text-gray-900">{{ $kycSections->firstItem() ?? 0 }}</span>
                                to
                                <span class="font-medium text-gray-900">{{ $kycSections->lastItem() ?? 0 }}</span>
                                of
                                <span class="font-medium text-gray-900">{{ $kycSections->total() }}</span>
                                results
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                {{ $kycSections->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div id="section-drawer"
            class="fixed top-0 right-0 w-full max-w-[520px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-brand-primary" id="drawer-title">Add KYC Section</h2>
                    <button onclick="closeDrawer()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form id="section-form" class="flex-1 overflow-y-auto p-6 flex flex-col">
                    <div class="space-y-5 flex-1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="form-input" placeholder="e.g. Company Information"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slug (Optional)</label>
                            <input type="text" name="slug" id="slug" class="form-input" placeholder="auto-generated-if-empty">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="sort_order" id="sort_order" class="form-input" min="0"
                                    value="100" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span
                                        class="text-red-500">*</span></label>
                                <select name="status" id="status" class="form-input" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Allow Multiple Entries</label>
                            <label class="inline-flex items-center cursor-pointer gap-3">
                                <div class="relative">
                                    <input type="checkbox" name="allow_multiple" id="allow_multiple" value="1" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-brand-primary/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                                </div>
                                <span class="text-sm text-gray-600" id="allow_multiple_label">Disabled</span>
                            </label>
                            <p class="text-xs text-gray-400 mt-1">When enabled, merchants can add multiple entries for this section (shows &ldquo;Add Another&rdquo; button).</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-input resize-y"
                                placeholder="Short section description"></textarea>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between bg-white mt-8">
                        <button type="button" onclick="closeDrawer()"
                            class="text-brand-primary font-medium hover:text-brand-primary/80">Cancel</button>
                        <button type="submit" id="save-btn"
                            class="bg-brand-accent text-white px-5 py-3 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save KYC Section
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="drawer-overlay" class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black/50 z-40 hidden"
            onclick="closeDrawer()"></div>

        <div id="delete-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                        <i class="fa-solid fa-trash-can text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-primary text-center mb-2">Delete KYC Section</h3>
                    <p class="text-gray-600 text-center mb-6">
                        Are you sure you want to delete <span id="delete-section-name"
                            class="font-semibold text-brand-primary"></span>?
                    </p>
                    <div class="flex gap-3">
                        <button onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">Cancel</button>
                        <button onclick="confirmDelete()"
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors shadow-sm">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="toast-container"></div>

        <script>
            const baseUrl = @json(url('admin/masters/kyc-sections'));
            let deleteSectionId = null;

            function openDrawer() {
                resetForm();
                document.getElementById('drawer-title').textContent = 'Add KYC Section';
                document.getElementById('save-btn').textContent = 'Save KYC Section';
                const form = document.getElementById('section-form');
                form.dataset.mode = 'create';
                delete form.dataset.id;
                document.getElementById('section-drawer').classList.remove('drawer-closed');
                document.getElementById('section-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function closeDrawer() {
                document.getElementById('section-drawer').classList.remove('drawer-open');
                document.getElementById('section-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
                resetForm();
            }

            function resetForm() {
                const form = document.getElementById('section-form');
                form.reset();
                document.getElementById('sort_order').value = 100;
                document.getElementById('status').value = 'active';
                document.getElementById('allow_multiple').checked = false;
                document.getElementById('allow_multiple_label').textContent = 'Disabled';
            }

            function editSection(id) {
                fetch(`${baseUrl}/${id}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (!result.success) {
                            showNotification('Unable to load KYC section', 'error');
                            return;
                        }

                        const section = result.data;
                        document.getElementById('name').value = section.name || '';
                        document.getElementById('slug').value = section.slug || '';
                        document.getElementById('description').value = section.description || '';
                        document.getElementById('sort_order').value = section.sort_order ?? 100;
                        document.getElementById('status').value = section.status || 'active';
                        document.getElementById('allow_multiple').checked = Boolean(section.allow_multiple);
                        document.getElementById('allow_multiple_label').textContent = section.allow_multiple ? 'Enabled' : 'Disabled';

                        const form = document.getElementById('section-form');
                        form.dataset.mode = 'edit';
                        form.dataset.id = id;

                        document.getElementById('drawer-title').textContent = 'Edit KYC Section';
                        document.getElementById('save-btn').textContent = 'Update KYC Section';

                        document.getElementById('section-drawer').classList.remove('drawer-closed');
                        document.getElementById('section-drawer').classList.add('drawer-open');
                        document.getElementById('drawer-overlay').classList.remove('hidden');
                    })
                    .catch(() => {
                        showNotification('Unable to load KYC section', 'error');
                    });
            }

            document.getElementById('section-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');

                const isEdit = this.dataset.mode === 'edit' && this.dataset.id;
                let url = baseUrl;

                if (isEdit) {
                    url = `${baseUrl}/${this.dataset.id}`;
                    formData.append('_method', 'PUT');
                }

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message || 'Saved successfully', 'success');
                            setTimeout(() => window.location.reload(), 900);
                            return;
                        }

                        if (data.errors) {
                            const message = Object.values(data.errors).flat().join(' | ');
                            showNotification(message || 'Validation failed', 'error');
                            return;
                        }

                        showNotification(data.message || 'Unable to save KYC section', 'error');
                    })
                    .catch(() => {
                        showNotification('Unable to save KYC section', 'error');
                    });
            });

            function deleteSection(id, name) {
                deleteSectionId = id;
                document.getElementById('delete-section-name').textContent = name || 'this section';
                document.getElementById('delete-modal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('delete-modal').classList.add('hidden');
                deleteSectionId = null;
            }

            function confirmDelete() {
                if (!deleteSectionId) return;

                fetch(`${baseUrl}/${deleteSectionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                                '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            closeDeleteModal();
                            showNotification(data.message || 'Deleted successfully', 'success');
                            setTimeout(() => window.location.reload(), 900);
                            return;
                        }

                        closeDeleteModal();
                        showNotification(data.message || 'Unable to delete KYC section', 'error');
                    })
                    .catch(() => {
                        closeDeleteModal();
                        showNotification('Unable to delete KYC section', 'error');
                    });
            }

            function showNotification(message, type) {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = `toast ${type === 'success' ? 'toast-success' : 'toast-error'}`;
                toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check' : 'fa-xmark'}"></i><span>${message}</span>`;
                container.appendChild(toast);
                setTimeout(() => toast.remove(), 3500);
            }

            function clearAllFilters() {
                window.location.href = '{{ route('admin.masters.kyc-section-master') }}';
            }

            function clearSearchFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('search');
                window.location.href = `?${params.toString()}`;
            }

            function clearStatusFilter() {
                const params = new URLSearchParams(window.location.search);
                params.delete('status');
                window.location.href = `?${params.toString()}`;
            }

            document.getElementById('allow_multiple').addEventListener('change', function () {
                document.getElementById('allow_multiple_label').textContent = this.checked ? 'Enabled' : 'Disabled';
            });

            if (!document.querySelector('meta[name="csrf-token"]')) {
                const meta = document.createElement('meta');
                meta.setAttribute('name', 'csrf-token');
                meta.setAttribute('content', '{{ csrf_token() }}');
                document.head.appendChild(meta);
            }
        </script>
    </body>
@endsection
