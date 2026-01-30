@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Types Master - 2iZii</title>
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
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        .drawer-open { transform: translateX(0); }
        .drawer-closed { transform: translateX(100%); }
        select { -webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; }
        .form-input { width: 100%; border: 1px solid #E5E7EB; border-radius: 0.5rem; padding: 0.625rem 0.75rem; color: #2D3A74; outline: none; transition: all 0.2s; font-size: 0.875rem; }
        .form-input:focus { border-color: #2D3A74; box-shadow: 0 0 0 1px #2D3A74; }
        .form-input-disabled { background-color: #EFEFEF; }
        .toggle-switch { position: relative; width: 44px; height: 24px; background-color: #28A745; border-radius: 9999px; cursor: pointer; transition: background-color 0.2s; }
        .toggle-switch::after { content: ''; position: absolute; width: 20px; height: 20px; background-color: white; border-radius: 50%; top: 2px; left: 20px; transition: left 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .toggle-switch.inactive { background-color: #E5E7EB; }
        .toggle-switch.inactive::after { left: 2px; }
        
        /* Multi-select Styles */
        .multi-select-wrapper { position: relative; width: 100%; }
        .multi-select-input { display: flex; align-items: center; justify-content: space-between; width: 100%; min-height: 44px; border: 1px solid #E5E7EB; border-radius: 0.5rem; padding: 0.5rem 0.75rem; background-color: white; cursor: pointer; transition: all 0.2s; font-size: 0.875rem; flex-wrap: wrap; gap: 0.375rem; }
        .multi-select-input:hover { border-color: #2D3A74; }
        .multi-select-input:focus-within { border-color: #2D3A74; box-shadow: 0 0 0 1px #2D3A74; }
        .multi-select-tags { display: flex; flex-wrap: wrap; gap: 0.375rem; flex: 1; align-items: center; }
        .multi-select-tag { display: inline-flex; align-items: center; gap: 0.375rem; background-color: #2D3A74; color: white; padding: 0.375rem 0.625rem; border-radius: 0.375rem; font-size: 0.8125rem; font-weight: 500; }
        .multi-select-tag-remove { cursor: pointer; font-weight: bold; line-height: 1; opacity: 0.8; transition: opacity 0.2s; }
        .multi-select-tag-remove:hover { opacity: 1; }
        .multi-select-dropdown { position: absolute; top: 100%; left: 0; right: 0; margin-top: 0.375rem; background-color: white; border: 1px solid #E5E7EB; border-radius: 0.5rem; z-index: 50; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .multi-select-dropdown.hidden { display: none; }
        .multi-select-search { width: 100%; border: none; border-bottom: 1px solid #E5E7EB; padding: 0.625rem 0.75rem; font-size: 0.875rem; outline: none; }
        .multi-select-search:focus { background-color: #F9FAFB; }
        .multi-select-options { max-height: 240px; overflow-y: auto; }
        .multi-select-option { display: flex; align-items: center; gap: 0.625rem; padding: 0.625rem 0.75rem; cursor: pointer; transition: background-color 0.15s; font-size: 0.875rem; color: #374151; border: none; width: 100%; text-align: left; }
        .multi-select-option:hover { background-color: #F3F4F6; }
        .multi-select-option input[type="checkbox"] { cursor: pointer; width: 16px; height: 16px; border: 1px solid #D1D5DB; border-radius: 0.25rem; accent-color: #2D3A74; }
        .multi-select-option input[type="checkbox"]:checked { background-color: #2D3A74; border-color: #2D3A74; }
        .multi-select-checkbox { flex-shrink: 0; }
        .multi-select-option span { flex: 1; }
        .multi-select-placeholder { color: #9CA3AF; font-size: 0.875rem; }
        
        /* Hide native scrollbar styling for webkit browsers */
        .multi-select-options::-webkit-scrollbar { width: 4px; }
        .multi-select-options::-webkit-scrollbar-track { background: transparent; }
        .multi-select-options::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 2px; }
        .multi-select-options::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    </style>
@endsection

@section('body')
    <body class="bg-brand-neutral">
        <x-admin.sidebar active="masters" />
        <x-admin.topbar :breadcrumbs="[['label' => 'Dashboard', 'url' => '#'], ['label' => 'Document Types Master', 'url' => route('admin.masters.document-type-master')]]" />

        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">
                <div class="bg-brand-neutral p-4 md:p-8">
                    <div class="max-w-[1200px] mx-auto">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-brand-primary mb-1">Document Types Master</h1>
                                <p class="text-sm text-gray-500">Configure allowable document types for merchant onboarding and validation.</p>
                            </div>
                            <button onclick="openDrawer()" class="self-start md:self-auto bg-brand-accent text-white px-6 py-2.5 rounded-lg shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-plus text-sm"></i>
                                <span class="font-medium">Add Document Type</span>
                            </button>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-t-xl p-4 md:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="relative w-full sm:w-[384px]">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="Search document types..." class="form-input pl-10 bg-white border-gray-200">
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Document Name</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Category</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Allowed Types</th>
                                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Sensitivity</th>
                                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Status</th>
                                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @forelse($documentTypes as $docType)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4"><div class="font-medium text-gray-900">{{ $docType->document_name }}</div></td>
                                            <td class="px-6 py-4"><span class="text-gray-600 text-sm capitalize">{{ str_replace('_', ' ', $docType->category) }}</span></td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-wrap gap-1 mb-1">
                                                    @foreach($docType->allowed_file_types as $type)
                                                    <span class="bg-gray-100 border border-gray-200 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium">{{ strtoupper($type) }}</span>
                                                    @endforeach
                                                </div>
                                                <div class="text-[10px] text-gray-400">Max {{ $docType->max_file_size }} MB</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($docType->sensitivity_level === 'highly-sensitive')
                                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">Highly Sensitive</span>
                                                @elseif($docType->sensitivity_level === 'sensitive')
                                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Sensitive</span>
                                                @else
                                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium">Normal</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($docType->status === 'active')
                                                    <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-medium">Active</span>
                                                @elseif($docType->status === 'draft')
                                                    <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full text-xs font-medium">Draft</span>
                                                @else
                                                    <span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full text-xs font-medium">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <button onclick="editDocumentType({{ $docType->id }})" class="text-gray-400 hover:text-brand-primary p-2"><i class="fa-solid fa-pen text-sm"></i></button>
                                                    <button onclick="deleteDocumentType({{ $docType->id }}, '{{ $docType->document_name }}')" class="text-gray-400 hover:text-red-500 p-2"><i class="fa-solid fa-trash text-sm"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No document types found. Click "Add Document Type" to create one.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
                                {{ $documentTypes->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div id="document-type-drawer" class="fixed top-0 right-0 w-full max-w-[520px] h-full bg-white shadow-2xl z-50 drawer-closed transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex flex-col h-full">
                <div class="border-b border-gray-200 px-6 py-5">
                    <div class="mb-2">
                        <h2 id="drawer-title" class="text-xl font-semibold text-brand-primary">Add Document Type</h2>
                        <p class="text-sm text-gray-500 mt-1">Configure new document type for validation</p>
                    </div>
                    <button onclick="closeDrawer()" class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <form id="document-type-form" class="space-y-8" data-mode="create" data-id="">
                        <div class="space-y-4">
                            <div class="pb-2"><h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Basic Information</h3></div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Document Name <span class="text-red-500">*</span></label>
                                <input type="text" id="document-name" name="document_name" class="form-input" placeholder="e.g., Passport, Business License" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                                <select id="category" name="category" class="form-input" required>
                                    <option value="">Select category...</option>
                                    <option value="identity">Identity Document</option>
                                    <option value="company">Company Registration</option>
                                    <option value="bank">Bank Verification</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 text-xs font-normal">(Optional)</span></label>
                                <textarea id="description" name="description" class="form-input resize-y" rows="3" placeholder="Brief description of this document type..."></textarea>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2"><h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">File Format & Size Rules</h3></div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Allowed File Types <span class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" name="allowed_file_types" value="pdf" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">PDF</span>
                                    </label>
                                    <label class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" name="allowed_file_types" value="png" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">PNG</span>
                                    </label>
                                    <label class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" name="allowed_file_types" value="jpg" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">JPG</span>
                                    </label>
                                    <label class="border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                        <input type="checkbox" name="allowed_file_types" value="jpeg" class="w-3.5 h-3.5 border-gray-400 rounded">
                                        <span class="text-sm text-gray-900">JPEG</span>
                                    </label>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Max File Size <span class="text-red-500">*</span></label>
                                    <select id="max-file-size" name="max_file_size" class="form-input" required>
                                        <option value="5">5 MB</option>
                                        <option value="10" selected>10 MB</option>
                                        <option value="15">15 MB</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Pages <span class="text-gray-400 text-xs font-normal">(Optional)</span></label>
                                    <input type="number" id="min-pages" name="min_pages" class="form-input" placeholder="0" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2"><h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Visibility & Sensitivity Controls</h3></div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sensitivity Level <span class="text-red-500">*</span></label>
                                <select id="sensitivity-level" name="sensitivity_level" class="form-input" required>
                                    <option value="normal">Normal</option>
                                    <option value="sensitive">Sensitive</option>
                                    <option value="highly-sensitive">Highly Sensitive</option>
                                </select>
                            </div>
                            <div class="space-y-2.5">
                                <label class="flex items-center gap-2.5 cursor-pointer">
                                    <input type="checkbox" id="visible-merchant" name="visible_to_merchant" value="1" class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600" checked>
                                    <span class="text-sm text-gray-700">Visible to Merchant</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer">
                                    <input type="checkbox" id="visible-admin" name="visible_to_admin" value="1" class="w-3.5 h-3.5 border-gray-400 rounded text-blue-600" checked>
                                    <span class="text-sm text-gray-700">Visible to Admin</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer">
                                    <input type="checkbox" id="mask-metadata" name="mask_metadata" value="1" class="w-3.5 h-3.5 border-gray-400 rounded">
                                    <span class="text-sm text-gray-700">Mask Metadata When Viewed</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2"><h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Required For (Dynamic Mapping)</h3></div>
                            
                            <!-- Acquirer Multi-select -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Acquirer <span class="text-gray-400 text-xs font-normal">(Multi-select)</span></label>
                                <div class="multi-select-wrapper" data-field="acquirers">
                                    <div class="multi-select-input" onclick="toggleDropdown(this)">
                                        <div class="multi-select-tags" id="acquirers-tags"></div>
                                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                    <div class="multi-select-dropdown hidden" id="acquirers-dropdown">
                                        <input type="text" class="multi-select-search" placeholder="Search acquirers..." onkeyup="filterOptions(this)">
                                        <div class="multi-select-options">
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_acquirers" value="elavon" class="multi-select-checkbox" onchange="updateTags('acquirers')">
                                                <span>Elavon</span>
                                            </label>
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_acquirers" value="surfboard" class="multi-select-checkbox" onchange="updateTags('acquirers')">
                                                <span>Surfboard</span>
                                            </label>
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_acquirers" value="stripe" class="multi-select-checkbox" onchange="updateTags('acquirers')">
                                                <span>Stripe</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Country Multi-select -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Country <span class="text-gray-400 text-xs font-normal">(Multi-select)</span></label>
                                <div class="multi-select-wrapper" data-field="countries">
                                    <div class="multi-select-input" onclick="toggleDropdown(this)">
                                        <div class="multi-select-tags" id="countries-tags"></div>
                                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                    <div class="multi-select-dropdown hidden" id="countries-dropdown">
                                        <input type="text" class="multi-select-search" placeholder="Search countries..." onkeyup="filterOptions(this)">
                                        <div class="multi-select-options">
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_countries" value="uk" class="multi-select-checkbox" onchange="updateTags('countries')">
                                                <span>United Kingdom</span>
                                            </label>
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_countries" value="no" class="multi-select-checkbox" onchange="updateTags('countries')">
                                                <span>Norway</span>
                                            </label>
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_countries" value="us" class="multi-select-checkbox" onchange="updateTags('countries')">
                                                <span>United States</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Solution Multi-select -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Solution <span class="text-gray-400 text-xs font-normal">(Multi-select)</span></label>
                                <div class="multi-select-wrapper" data-field="solutions">
                                    <div class="multi-select-input" onclick="toggleDropdown(this)">
                                        <div class="multi-select-tags" id="solutions-tags"></div>
                                        <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                    <div class="multi-select-dropdown hidden" id="solutions-dropdown">
                                        <input type="text" class="multi-select-search" placeholder="Search solutions..." onkeyup="filterOptions(this)">
                                        <div class="multi-select-options">
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_solutions" value="pos" class="multi-select-checkbox" onchange="updateTags('solutions')">
                                                <span>POS</span>
                                            </label>
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_solutions" value="ecommerce" class="multi-select-checkbox" onchange="updateTags('solutions')">
                                                <span>E-commerce</span>
                                            </label>
                                            <label class="multi-select-option">
                                                <input type="checkbox" name="required_solutions" value="mobile" class="multi-select-checkbox" onchange="updateTags('solutions')">
                                                <span>Mobile App</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">KYC Section</label>
                                <select id="kyc-section" name="kyc_section" class="form-input">
                                    <option value="">Select section...</option>
                                    <option value="company">Company Information</option>
                                    <option value="beneficial">Beneficial Owners</option>
                                    <option value="board">Board Members</option>
                                    <option value="contact">Contact Person</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-gray-200 pt-4">
                            <div class="pb-2"><h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status & Notes</h3></div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></div>
                                    <div class="text-xs text-gray-500">Activate this document type</div>
                                </div>
                                <div class="toggle-switch" id="status-toggle" onclick="toggleStatus()"></div>
                                <input type="hidden" id="status" name="status" value="active">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Internal Notes <span class="text-gray-400 text-xs font-normal">(Optional)</span></label>
                                <textarea id="internal-notes" name="internal_notes" class="form-input resize-y" rows="2" placeholder="For compliance team usage only..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between bg-white">
                    <button onclick="closeDrawer()" class="text-brand-secondary font-medium hover:text-brand-primary flex items-center gap-2"><i class="fa-solid fa-xmark text-sm"></i><span>Cancel</span></button>
                    <button id="save-btn" class="bg-brand-accent text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:bg-orange-500 transition-colors flex items-center gap-2"><i class="fa-solid fa-check text-sm"></i><span>Save Document Type</span></button>
                </div>
            </div>
        </div>

        <div id="drawer-overlay" class="fixed top-0 left-0 md:left-[260px] right-0 bottom-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeDrawer()"></div>

        <!-- Delete Modal -->
        <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[70] hidden flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-scale-in">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                        <i class="fa-solid fa-trash-can text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-primary text-center mb-2">Delete Document Type</h3>
                    <p class="text-gray-600 text-center mb-6">Are you sure you want to delete <span id="delete-doc-name" class="font-semibold text-brand-primary"></span>? This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">Cancel</button>
                        <button id="confirm-delete-btn" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors shadow-sm"><i class="fa-solid fa-trash-can mr-2"></i>Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentDeleteId = null;

            function openDrawer() {
                resetForm();
                document.getElementById('document-type-form').dataset.mode = 'create';
                document.getElementById('drawer-title').textContent = 'Add Document Type';
                document.getElementById('document-type-drawer').classList.remove('drawer-closed');
                document.getElementById('document-type-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function openDrawerForEdit() {
                document.getElementById('document-type-drawer').classList.remove('drawer-closed');
                document.getElementById('document-type-drawer').classList.add('drawer-open');
                document.getElementById('drawer-overlay').classList.remove('hidden');
            }

            function closeDrawer() {
                document.getElementById('document-type-drawer').classList.remove('drawer-open');
                document.getElementById('document-type-drawer').classList.add('drawer-closed');
                document.getElementById('drawer-overlay').classList.add('hidden');
            }

            function resetForm() {
                document.getElementById('document-type-form').reset();
                document.getElementById('document-type-form').dataset.id = '';
                document.getElementById('document-type-form').dataset.mode = 'create';
                document.getElementById('status-toggle').classList.remove('inactive');
                document.getElementById('status').value = 'active';
                document.getElementById('max-file-size').value = '10';
            }

            function toggleStatus() {
                const toggle = document.getElementById('status-toggle');
                toggle.classList.toggle('inactive');
                document.getElementById('status').value = toggle.classList.contains('inactive') ? 'draft' : 'active';
            }

            function editDocumentType(id) {
                fetch(`/admin/masters/document-types/${id}`, {
                    headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('document-type-form').reset();
                    document.getElementById('document-type-form').dataset.mode = 'edit';
                    document.getElementById('document-type-form').dataset.id = data.id;
                    
                    // Basic Information
                    document.getElementById('document-name').value = data.document_name;
                    document.getElementById('category').value = data.category;
                    document.getElementById('description').value = data.description || '';

                    // File Format & Size Rules
                    document.getElementById('max-file-size').value = data.max_file_size;
                    document.getElementById('min-pages').value = data.min_pages || '0';
                    
                    // Sensitivity & Visibility
                    document.getElementById('sensitivity-level').value = data.sensitivity_level;
                    document.getElementById('visible-merchant').checked = data.visible_to_merchant;
                    document.getElementById('visible-admin').checked = data.visible_to_admin;
                    document.getElementById('mask-metadata').checked = data.mask_metadata;

                    // File Types
                    document.querySelectorAll('input[name="allowed_file_types"]').forEach(chk => {
                        chk.checked = data.allowed_file_types.includes(chk.value);
                    });

                    // Required For Mappings
                    document.querySelectorAll('input[name="required_acquirers"]').forEach(chk => {
                        chk.checked = (data.required_acquirers || []).includes(chk.value);
                    });
                    document.querySelectorAll('input[name="required_countries"]').forEach(chk => {
                        chk.checked = (data.required_countries || []).includes(chk.value);
                    });
                    document.querySelectorAll('input[name="required_solutions"]').forEach(chk => {
                        chk.checked = (data.required_solutions || []).includes(chk.value);
                    });

                    // KYC Section
                    document.getElementById('kyc-section').value = data.kyc_section || '';

                    // Status & Notes
                    if (data.status === 'draft') {
                        document.getElementById('status-toggle').classList.add('inactive');
                    } else {
                        document.getElementById('status-toggle').classList.remove('inactive');
                    }
                    document.getElementById('status').value = data.status;
                    document.getElementById('internal-notes').value = data.internal_notes || '';

                    // Update multi-select tags display
                    updateTags('acquirers');
                    updateTags('countries');
                    updateTags('solutions');

                    // Update drawer title
                    document.getElementById('drawer-title').textContent = 'Edit Document Type';

                    // Open drawer without resetting form
                    openDrawerForEdit();
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading document type', 'error');
                });
            }

            function deleteDocumentType(id, name) {
                currentDeleteId = id;
                document.getElementById('delete-doc-name').textContent = name;
                document.getElementById('delete-modal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('delete-modal').classList.add('hidden');
                currentDeleteId = null;
            }

            document.getElementById('confirm-delete-btn').addEventListener('click', function() {
                if (!currentDeleteId) return;
                fetch(`/admin/masters/document-types/${currentDeleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error deleting document type', 'error');
                    closeDeleteModal();
                });
            });

            document.getElementById('save-btn').addEventListener('click', function() {
                document.getElementById('document-type-form').dispatchEvent(new Event('submit'));
            });

            document.getElementById('document-type-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const mode = this.dataset.mode;
                const id = this.dataset.id;
                const url = mode === 'edit' ? `/admin/masters/document-types/${id}` : '/admin/masters/document-types';
                const method = mode === 'edit' ? 'PUT' : 'POST';

                const formData = new FormData(this);
                formData.append('_method', method);

                // Collect multi-select values from checkboxes
                const acquirers = Array.from(document.querySelectorAll('input[name="required_acquirers"]:checked')).map(chk => chk.value);
                const countries = Array.from(document.querySelectorAll('input[name="required_countries"]:checked')).map(chk => chk.value);
                const solutions = Array.from(document.querySelectorAll('input[name="required_solutions"]:checked')).map(chk => chk.value);
                const fileTypes = Array.from(document.querySelectorAll('input[name="allowed_file_types"]:checked')).map(chk => chk.value);

                // Rebuild FormData with proper values
                const cleanData = new FormData();
                cleanData.append('_method', method);
                cleanData.append('document_name', document.getElementById('document-name').value);
                cleanData.append('category', document.getElementById('category').value);
                cleanData.append('description', document.getElementById('description').value);
                cleanData.append('max_file_size', document.getElementById('max-file-size').value);
                cleanData.append('min_pages', document.getElementById('min-pages').value);
                cleanData.append('sensitivity_level', document.getElementById('sensitivity-level').value);
                cleanData.append('visible_to_merchant', document.getElementById('visible-merchant').checked ? '1' : '0');
                cleanData.append('visible_to_admin', document.getElementById('visible-admin').checked ? '1' : '0');
                cleanData.append('mask_metadata', document.getElementById('mask-metadata').checked ? '1' : '0');
                cleanData.append('kyc_section', document.getElementById('kyc-section').value);
                cleanData.append('status', document.getElementById('status').value);
                cleanData.append('internal_notes', document.getElementById('internal-notes').value);
                
                fileTypes.forEach(type => cleanData.append('allowed_file_types[]', type));
                acquirers.forEach(acq => cleanData.append('required_acquirers[]', acq));
                countries.forEach(country => cleanData.append('required_countries[]', country));
                solutions.forEach(sol => cleanData.append('required_solutions[]', sol));

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: cleanData
                })
                .then(response => {
                    if (!response.ok && response.status !== 422) {
                        return response.text().then(text => { throw new Error(`HTTP error! status: ${response.status}`); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showNotification(`${field}: ${data.errors[field][0]}`, 'error');
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification(error.message || 'Error saving document type', 'error');
                });
            });

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 max-w-sm px-6 py-4 rounded-lg shadow-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                notification.textContent = message;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), type === 'success' ? 3000 : 5000);
            }

            /* Multi-select Functions */
            function toggleDropdown(inputElement) {
                const wrapper = inputElement.closest('.multi-select-wrapper');
                const field = wrapper.dataset.field;
                const dropdown = document.getElementById(`${field}-dropdown`);
                
                // Close other dropdowns
                document.querySelectorAll('.multi-select-dropdown').forEach(d => {
                    if (d !== dropdown) d.classList.add('hidden');
                });
                
                dropdown.classList.toggle('hidden');
            }

            function filterOptions(searchInput) {
                const dropdown = searchInput.closest('.multi-select-dropdown');
                const options = dropdown.querySelectorAll('.multi-select-option');
                const searchTerm = searchInput.value.toLowerCase();
                
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            }

            function updateTags(field) {
                const tagsContainer = document.getElementById(`${field}-tags`);
                const fieldMap = {
                    'acquirers': 'required_acquirers',
                    'countries': 'required_countries',
                    'solutions': 'required_solutions'
                };
                const fieldName = fieldMap[field];
                const checked = document.querySelectorAll(`input[name="${fieldName}"]:checked`);
                
                tagsContainer.innerHTML = '';
                const labelMap = {
                    'elavon': 'Elavon',
                    'surfboard': 'Surfboard',
                    'stripe': 'Stripe',
                    'uk': 'UK',
                    'no': 'Norway',
                    'us': 'USA',
                    'pos': 'POS',
                    'ecommerce': 'E-commerce',
                    'mobile': 'Mobile'
                };
                
                checked.forEach(checkbox => {
                    const label = labelMap[checkbox.value] || checkbox.value;
                    const tag = document.createElement('span');
                    tag.className = 'multi-select-tag';
                    tag.innerHTML = `
                        ${label}
                        <span class="multi-select-tag-remove" onclick="removeTag('${field}', '${checkbox.value}')">×</span>
                    `;
                    tagsContainer.appendChild(tag);
                });
                
                if (checked.length === 0) {
                    tagsContainer.innerHTML = '<span class="multi-select-placeholder">Select options...</span>';
                }
            }

            function removeTag(field, value) {
                const fieldMap = {
                    'acquirers': 'required_acquirers',
                    'countries': 'required_countries',
                    'solutions': 'required_solutions'
                };
                const fieldName = fieldMap[field];
                const checkbox = document.querySelector(`input[name="${fieldName}"][value="${value}"]`);
                if (checkbox) {
                    checkbox.checked = false;
                    updateTags(field);
                }
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.multi-select-wrapper')) {
                    document.querySelectorAll('.multi-select-dropdown').forEach(d => d.classList.add('hidden'));
                }
            });

            if (!document.querySelector('meta[name="csrf-token"]')) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }
        </script>
    </body>
@endsection
