@extends('layouts.admin')

@section('title', 'Solution Master - 2iZii')

@section('body')

    <x-admin.sidebar active="masters" />

    <x-admin.topbar :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => '#'],
        ['label' => 'Solution Master', 'url' => route('admin.masters.solution-master')],
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
                            <h1 class="text-2xl font-semibold text-brand-primary mb-1">Solution Master</h1>
                            <p class="text-sm text-gray-500">Manage and configure merchant solutions, acquirers, and payment
                                methods.</p>
                        </div>
                        <button onclick="openDrawer()"
                            class="bg-brand-accent text-white px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span class="font-medium">Add Solution</span>
                        </button>
                    </div>

                    <!-- Search and Filters -->
                    <div class="bg-white border border-gray-200 rounded-t-xl p-4 flex items-center justify-between">
                        <div class="relative w-[384px]">
                            <i
                                class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="Search solutions..."
                                class="form-input pl-10 bg-brand-neutral border-gray-200">
                        </div>
                        <div class="flex gap-3">
                            <button
                                class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-filter text-sm"></i>
                                Filters
                            </button>
                            <button
                                class="bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-download text-sm"></i>
                                Export
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Solution Name</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Category</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Country</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Acquirers</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($solutions as $solution)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-brand-primary">{{ $solution->name }}</div>
                                            <div class="text-xs text-gray-400 mt-0.5">Updated
                                                {{ $solution->updated_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-blue-100 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-medium">{{ $solution->category->name }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">{{ $solution->country ?? '—' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-gray-600">
                                                {{ !empty($solution->acquirers) ? implode(', ', $solution->acquirers) : '—' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-xs font-medium flex items-center gap-1.5 w-fit {{ $solution->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full {{ $solution->status === 'published' ? 'bg-green-600' : 'bg-yellow-600' }}"></span>
                                                {{ ucfirst($solution->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    data-id="{{ $solution->id }}"
                                                    data-name="{{ $solution->name }}"
                                                    data-category-id="{{ $solution->category_id }}"
                                                    data-country="{{ $solution->country }}"
                                                    data-status="{{ $solution->status }}"
                                                    data-description="{{ $solution->description }}"
                                                    data-tags='@json($solution->tags ?? [])'
                                                    data-acquirers='@json($solution->acquirers ?? [])'
                                                    data-payment-methods='@json($solution->payment_methods ?? [])'
                                                    data-alternative-methods='@json($solution->alternative_methods ?? [])'
                                                    data-requirements="{{ $solution->requirements }}"
                                                    data-pricing-plan="{{ $solution->pricing_plan }}"
                                                    onclick="editSolution(this)"
                                                    class="text-gray-400 hover:text-brand-primary p-2">
                                                    <i class="fa-solid fa-pen text-sm"></i>
                                                </button>
                                                <button onclick="deleteSolution({{ $solution->id }})"
                                                    class="text-gray-400 hover:text-red-500 p-2">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-3"></i>
                                                <p class="text-gray-500 font-medium">No solutions found</p>
                                                <p class="text-sm text-gray-400">Create your first solution to get started
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="bg-white border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Showing <span class="font-medium text-gray-900">1</span> to <span
                                    class="font-medium text-gray-900">10</span> of <span
                                    class="font-medium text-gray-900">42</span> results
                            </div>
                            <div class="flex items-center gap-2">
                                <button
                                    class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm opacity-50 cursor-not-allowed">Previous</button>
                                <button class="bg-brand-primary text-white px-3 py-1.5 rounded text-sm">1</button>
                                <button
                                    class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">2</button>
                                <button
                                    class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">3</button>
                                <span class="text-gray-400 px-2">...</span>
                                <button
                                    class="border border-gray-200 text-gray-600 px-3 py-1.5 rounded text-sm hover:bg-gray-50">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Right Drawer for Add/Edit Solution -->
    <div id="solution-drawer"
        class="fixed top-0 right-0 w-[480px] h-full bg-white shadow-2xl z-[60] drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
        <div class="flex flex-col h-full">
            <!-- Drawer Header -->
            <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 bg-white">
                <h2 class="text-lg font-semibold text-brand-primary">Add New Solution</h2>
                <button onclick="closeDrawer()"
                    class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Drawer Content -->
            <form id="solution-form" method="POST" action="{{ route('admin.masters.solutions.store') }}" class="flex-1 overflow-y-auto flex flex-col">
                @csrf
                <div id="form-method"></div>
                <input type="hidden" name="status" id="solution-status" value="published">

                <div class="flex-1 overflow-y-auto p-6">
                    <div class="space-y-8">
                        <!-- Solution Information Section -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Solution Information</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Solution Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="solution-name" name="name" class="form-input"
                                    placeholder="e.g. Retail POS Standard" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span
                                        class="text-red-500">*</span></label>
                                <select id="category-select" name="category_id" class="form-input" required>
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="solution-description" name="description" class="form-input resize-y" rows="3"
                                    placeholder="Brief description of the solution..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                                <div class="border border-gray-200 rounded-lg p-2 flex flex-wrap gap-2 min-h-[42px]">
                                    <div id="tags-container" class="flex flex-wrap gap-2"></div>
                                    <input type="text" id="tags-input" placeholder="Add tag and press Enter"
                                        class="flex-1 min-w-[120px] border-0 outline-none text-xs bg-transparent">
                                </div>
                                <div id="tags-hidden" class="hidden"></div>
                                <p class="text-xs text-gray-400 mt-1">Press Enter or comma to add multiple tags.</p>
                            </div>
                        </div>

                        <!-- Select Country Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Country</label>
                            <select id="solution-country" name="country" class="form-input">
                                <option value="">Select country...</option>
                                <option value="nl">Netherlands</option>
                                <option value="uk">United Kingdom</option>
                                <option value="no">Norway</option>
                            </select>
                        </div>

                        <!-- Supported Acquirers Section -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Supported Acquirers
                                </h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Acquirers</label>
                                <div class="border border-gray-200 rounded-lg p-3 max-h-48 overflow-y-auto space-y-2">
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="acquirers[]" value="elavon" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Elavon</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="acquirers[]" value="surfboard" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Surfboard</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="acquirers[]" value="stripe" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">Stripe</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="acquirers[]" value="aib" class="w-4 h-4 border-gray-400 rounded">
                                        <span class="text-sm text-gray-700">AIB Merchant Services</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Supported Payment Methods Section -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Supported Payment
                                    Methods</h3>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Cards</label>
                                    <div class="flex gap-2 flex-wrap">
                                        <label
                                            class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" name="payment_methods[]" value="visa" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Visa</span>
                                        </label>
                                        <label
                                            class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" name="payment_methods[]" value="mastercard" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Mastercard</span>
                                        </label>
                                        <label
                                            class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" name="payment_methods[]" value="amex" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Amex</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alternative
                                        Methods</label>
                                    <div class="flex gap-2 flex-wrap">
                                        <label
                                            class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" name="alternative_methods[]" value="vipps" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">Vipps</span>
                                        </label>
                                        <label
                                            class="border-2 border-gray-200 rounded-lg px-3.5 py-2.5 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" name="alternative_methods[]" value="mobilepay" class="w-4 h-4 border-gray-400 rounded">
                                            <span class="text-sm text-gray-900">MobilePay</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Solution Requirements Section -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Solution Requirements
                                    <span class="text-gray-400 font-normal normal-case">(Optional)</span></h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </button>
                            </div>

                            <div class="border-t border-gray-200 pt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Required Documents</label>
                                    <textarea name="requirements" id="solution-requirements" class="form-input resize-y" rows="4"
                                        placeholder="List requirements or notes..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Default Pricing
                                        Plan</label>
                                    <select name="pricing_plan" id="solution-pricing-plan" class="form-input">
                                        <option value="">Select pricing plan</option>
                                        <option value="standard">Standard</option>
                                        <option value="premium">Premium</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white sticky bottom-0">
                    <button type="button" onclick="closeDrawer()" class="text-gray-600 font-medium hover:text-gray-800">Cancel</button>
                    <div class="flex gap-3">
                        <button type="button" onclick="setStatusAndSubmit('draft')"
                            class="border-2 border-brand-accent text-brand-accent px-5 py-3 rounded-lg font-medium hover:bg-orange-50 transition-colors">
                            Save Draft
                        </button>
                        <button type="button" onclick="setStatusAndSubmit('published')"
                            class="bg-brand-accent text-white px-5 py-3 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors">
                            Save Solution
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-[70]">
        <div class="bg-white rounded-lg shadow-xl max-w-sm mx-4">
            <div class="p-6 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mb-4">
                    <i class="fa-solid fa-trash text-red-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Solution</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this solution? This action cannot
                    be undone.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <form id="delete-form" method="POST" action="" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="drawer-overlay" class="fixed top-0 left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-[55] hidden" onclick="closeDrawer()"></div>
@endsection

    @push('scripts')
        <script>
            let currentEditId = null;
            let solutionTags = [];

            function renderTags() {
                const container = document.getElementById('tags-container');
                const hidden = document.getElementById('tags-hidden');
                if (!container || !hidden) return;

                container.innerHTML = '';
                hidden.innerHTML = '';

                solutionTags.forEach((tag) => {
                    const pill = document.createElement('span');
                    pill.className = 'bg-brand-neutral text-gray-700 px-2 py-1 rounded text-xs flex items-center gap-1';
                    pill.innerHTML = `${tag}<button type="button" class="text-gray-500 hover:text-gray-700" onclick="removeTag('${tag.replace(/'/g, "\\'")}')"><i class="fa-solid fa-xmark text-xs"></i></button>`;
                    container.appendChild(pill);

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'tags[]';
                    input.value = tag;
                    hidden.appendChild(input);
                });
            }

            function addTag(tag) {
                const clean = tag.trim().toLowerCase();
                if (!clean || solutionTags.includes(clean)) return;
                solutionTags.push(clean);
                renderTags();
            }

            function removeTag(tag) {
                solutionTags = solutionTags.filter((t) => t !== tag);
                renderTags();
            }

            function openDrawer(resetForm = true) {
                document.getElementById('solution-drawer').classList.remove('drawer-closed');
                document.getElementById('solution-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');

                if (resetForm) {
                    currentEditId = null;
                    document.querySelector('#solution-drawer h2').textContent = 'Add New Solution';
                    document.getElementById('solution-form').reset();
                    document.getElementById('solution-form').action = '{{ route('admin.masters.solutions.store') }}';
                    document.getElementById('form-method').innerHTML = '';
                    document.getElementById('solution-status').value = 'published';
                    solutionTags = [];
                    renderTags();
                }
            }

            function closeDrawer() {
                document.getElementById('solution-drawer').classList.remove('drawer-open');
                document.getElementById('solution-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
            }

            function editSolution(button) {
                const data = button.dataset;
                currentEditId = data.id;
                openDrawer(false);
                document.querySelector('#solution-drawer h2').textContent = 'Edit Solution';
                document.getElementById('solution-form').action = `/admin/masters/solutions/${data.id}`;
                document.getElementById('form-method').innerHTML = '@method("PUT")';

                document.getElementById('solution-name').value = data.name || '';
                document.getElementById('category-select').value = data.categoryId || '';
                document.getElementById('solution-country').value = data.country || '';
                document.getElementById('solution-status').value = data.status || 'draft';
                document.getElementById('solution-description').value = data.description || '';
                document.getElementById('solution-requirements').value = data.requirements || '';
                document.getElementById('solution-pricing-plan').value = data.pricingPlan || '';

                solutionTags = [];
                try {
                    solutionTags = JSON.parse(data.tags || '[]') || [];
                } catch (error) {
                    solutionTags = [];
                }
                renderTags();

                const acquirers = new Set(JSON.parse(data.acquirers || '[]'));
                document.querySelectorAll('input[name="acquirers[]"]').forEach((input) => {
                    input.checked = acquirers.has(input.value);
                });

                const paymentMethods = new Set(JSON.parse(data.paymentMethods || '[]'));
                document.querySelectorAll('input[name="payment_methods[]"]').forEach((input) => {
                    input.checked = paymentMethods.has(input.value);
                });

                const alternativeMethods = new Set(JSON.parse(data.alternativeMethods || '[]'));
                document.querySelectorAll('input[name="alternative_methods[]"]').forEach((input) => {
                    input.checked = alternativeMethods.has(input.value);
                });
            }

            function submitSolution() {
                const form = document.getElementById('solution-form');
                const name = document.getElementById('solution-name').value.trim();
                const categoryId = document.getElementById('category-select').value;

                if (!name) {
                    alert('Solution name is required');
                    return;
                }

                if (!categoryId) {
                    alert('Please select a category');
                    return;
                }

                form.submit();
            }

            function setStatusAndSubmit(status) {
                document.getElementById('solution-status').value = status;
                submitSolution();
            }

            function deleteSolution(id) {
                document.getElementById('delete-form').action = `/admin/masters/solutions/${id}`;
                document.getElementById('delete-modal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('delete-modal').classList.add('hidden');
            }

            document.addEventListener('DOMContentLoaded', () => {
                const input = document.getElementById('tags-input');
                if (!input) return;

                input.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ',') {
                        event.preventDefault();
                        addTag(input.value.replace(/,/g, ''));
                        input.value = '';
                    }
                });

                input.addEventListener('blur', () => {
                    if (input.value.trim()) {
                        addTag(input.value);
                        input.value = '';
                    }
                });
            });
        </script>
    @endpush
