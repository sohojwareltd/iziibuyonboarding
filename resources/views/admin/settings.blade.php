@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - 2iZii</title>
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
        .nav-item-active { background: rgba(255, 255, 255, 0.15); border-left: 4px solid #FF7C00; padding-left: 20px; }
        .nav-item { padding-left: 24px; }
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
        .form-input:focus { border-color: #2D3A74; box-shadow: 0 0 0 1px #2D3A74; }
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
        .toast-success { background: linear-gradient(135deg, #16A34A 0%, #22C55E 100%); }
        .toast-error { background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%); }
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
        .toast-title { font-size: 0.8125rem; font-weight: 600; line-height: 1.2; }
        .toast-message { font-size: 0.75rem; opacity: 0.9; }
        @keyframes toast-in {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection

@section('body')
<body class="bg-brand-neutral">
    <x-admin.sidebar active="settings" />

    <x-admin.topbar :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => '#'],
        ['label' => 'Settings', 'url' => route('admin.settings.index')],
    ]" />

    <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
        <div class="p-4 md:p-8">
            <div class="max-w-[1200px] mx-auto">
                <h1 class="text-2xl font-semibold text-brand-primary mb-1">Settings</h1>
                <p class="text-sm text-gray-500 mb-6">Manage logo and application settings.</p>

                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                @endif

                <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Logo Upload Section -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-brand-primary mb-4">
                            <i class="fa-solid fa-image mr-2"></i>Logo
                        </h2>
                        <div class="flex flex-col sm:flex-row items-start gap-6">
                            <div class="flex-shrink-0">
                                @if ($logoUrl ?? null)
                                    <img id="logo-preview" src="{{ $logoUrl }}" alt="Logo" class="h-24 w-auto object-contain border border-gray-200 rounded-lg p-2 bg-gray-50">
                                @else
                                    <div id="logo-preview" class="h-24 w-32 border border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 text-gray-400">
                                        <span class="text-sm">No logo</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" name="logo" id="logo-input" accept="image/png,image/jpeg,image/jpg,image/svg+xml" class="form-input text-sm">
                                <p class="text-xs text-gray-500 mt-2">PNG, JPG, JPEG or SVG. Max 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Key-Value Settings Table -->
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-brand-primary">
                                <i class="fa-solid fa-database mr-2"></i>Settings
                            </h2>
                            <button type="button" onclick="addSettingRow()" class="bg-brand-accent text-white px-4 py-2 rounded-lg hover:bg-orange-500 transition-colors flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-plus"></i>
                                Add Setting
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[40%]">Key</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="settings-tbody" class="bg-white divide-y divide-gray-200">
                                    @forelse ($settings as $index => $setting)
                                        <tr class="setting-row">
                                            <td class="px-6 py-3">
                                                <input type="text" name="keys[]" value="{{ old('keys.'.$index, $setting->key) }}" class="form-input" placeholder="setting_key">
                                            </td>
                                            <td class="px-6 py-3">
                                                <input type="text" name="values[]" value="{{ old('values.'.$index, $setting->value) }}" class="form-input" placeholder="Value">
                                            </td>
                                            <td class="px-6 py-3 text-right">
                                                <a href="{{ route('admin.settings.destroy', $setting) }}" 
                                                   onclick="return confirm('Remove this setting?');"
                                                   class="text-red-600 hover:text-red-800"
                                                   data-method="delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="empty-row" class="setting-row">
                                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                                No settings. Click "Add Setting" to add one.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-brand-primary text-white px-6 py-2.5 rounded-lg hover:bg-brand-secondary transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-save"></i>
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <div id="toast-container"></div>

    <script>
        // Logo preview
        document.getElementById('logo-input')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('logo-preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    if (preview.tagName === 'IMG') {
                        preview.src = reader.result;
                    } else {
                        const img = document.createElement('img');
                        img.id = 'logo-preview';
                        img.src = reader.result;
                        img.alt = 'Logo';
                        img.className = 'h-24 w-auto object-contain border border-gray-200 rounded-lg p-2 bg-gray-50';
                        preview.parentNode.replaceChild(img, preview);
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Add setting row
        function addSettingRow() {
            const tbody = document.getElementById('settings-tbody');
            const emptyRow = document.getElementById('empty-row');
            if (emptyRow) {
                emptyRow.remove();
            }
            const tr = document.createElement('tr');
            tr.className = 'setting-row';
            tr.innerHTML = `
                <td class="px-6 py-3">
                    <input type="text" name="keys[]" class="form-input" placeholder="setting_key">
                </td>
                <td class="px-6 py-3">
                    <input type="text" name="values[]" class="form-input" placeholder="Value">
                </td>
                <td class="px-6 py-3 text-right">
                    <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 hover:text-red-800">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        // Handle delete links with method spoofing
        document.querySelectorAll('[data-method="delete"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('Remove this setting?')) {
                    e.preventDefault();
                    return;
                }
                e.preventDefault();
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = this.href;
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
</body>
@endsection
