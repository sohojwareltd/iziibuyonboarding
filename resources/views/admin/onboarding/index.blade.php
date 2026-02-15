@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                            border: '#D1D5DB'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest'};
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        ::-webkit-scrollbar { display: none;}
        .nav-item-active {
            background: rgba(255,255,255,0.15);
            border-left: 4px solid #FF7C00;
            padding-left: 20px;
        }
        .nav-item {
            padding-left: 24px;
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

        .toast-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%);
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

        <x-admin.sidebar active="merchant-onboarding" />

        <x-admin.topbar :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => '#'],
            ['label' => 'Merchant Onboarding', 'url' => route('admin.onboarding.index')],
        ]" />

        <!-- MAIN CONTENT AREA -->
        <main id="main-content" class="md:ml-[260px] ml-0 pt-16 min-h-screen bg-brand-neutral">
            <div class="p-4 md:p-8">

                <!-- Page Title -->
                <h1 id="page-title" class="text-[28px] font-bold text-brand-primary mb-6">Merchant Onboarding</h1>

                <!-- Summary Cards Section -->
                <section id="summary-cards" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">New Requests Today</p>
                                <p class="text-[26px] font-bold text-brand-primary">12</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">In Progress</p>
                                <p class="text-[26px] font-bold text-brand-primary">34</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">Submitted to Acquirers</p>
                                <p class="text-[26px] font-bold text-brand-primary">18</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm text-brand-text mb-1">Approved Merchants</p>
                                <p class="text-[26px] font-bold text-brand-primary">102</p>
                            </div>
                            <i class="fa-solid fa-arrow-trend-up text-green-500 text-sm"></i>
                        </div>
                    </div>
                </section>

                <!-- Primary CTA Panel -->
                <section id="cta-panel" class="bg-white rounded-2xl p-6 md:p-8 shadow-lg mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div class="flex-1">
                            <h2 class="text-[22px] font-semibold text-brand-primary mb-2">Start a New Merchant Onboarding</h2>
                            <p class="text-sm text-[#595959] mb-5">Create an onboarding request and send it to the merchant to begin the KYC process.</p>
                            <a href="{{ route('admin.onboarding.start') }}" class="bg-brand-cta hover:bg-brand-ctaHover text-white font-medium px-6 py-3 rounded-lg w-full sm:w-[260px] h-12 flex items-center justify-center gap-2 transition-colors">
                                <i class="fa-solid fa-plus text-sm"></i>
                                Start New Onboarding
                            </a>
                        </div>
                        <div class="md:ml-8 flex md:block justify-center">
                            <i class="fa-solid fa-user-plus text-5xl md:text-6xl text-brand-primary/10"></i>
                        </div>
                    </div>
                </section>

                <!-- Recent Onboardings Table -->
                <section id="recent-onboardings" class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-brand-primary">Recent Onboarding Requests</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Merchant Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solution</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acquirer(s)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KYC Link</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($onboardings as $onboarding)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $onboarding->legal_business_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->partner->title ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->solution->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->acquirer_names }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($onboarding->kyc_link)
                                            <button type="button" class="copy-kyc-btn text-brand-cta hover:text-brand-ctaHover font-medium" data-kyc-link="{{ route('merchant.kyc.start', $onboarding->kyc_link) }}" title="Copy KYC Link">
                                                <i class="fa-solid fa-copy"></i> Copy
                                            </button>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'draft' => 'bg-gray-100 text-gray-800',
                                                'sent' => 'bg-blue-100 text-blue-800',
                                                'in-review' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'active' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'suspended' => 'bg-orange-100 text-orange-800',
                                            ];
                                            $statusClass = $statusColors[$onboarding->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">{{ ucfirst(str_replace('-', ' ', $onboarding->status)) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $onboarding->updated_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                        <a href="{{ route('admin.onboarding.track', $onboarding) }}" class="text-brand-secondary hover:text-brand-primary font-medium">View</a>
                                        <a href="{{ route('admin.onboarding.edit', $onboarding) }}" class="text-brand-primary hover:text-brand-secondary font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.onboarding.destroy', $onboarding) }}" class="inline-block delete-onboarding-form" data-merchant-name="{{ $onboarding->legal_business_name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="openDeleteModal(this)" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        No onboarding requests found. <a href="{{ route('admin.onboarding.create') }}" class="text-brand-primary font-medium">Create one</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $onboardings->links() }}
                    </div>
                </section>
            </div>
        </main>

        <script>
            // Copy KYC Link functionality
            document.addEventListener('DOMContentLoaded', function() {
                const params = new URLSearchParams(window.location.search);
                const successMessage = params.get('success');
                const errorMessage = params.get('error');
                const warningMessage = params.get('warning');
                if (successMessage) {
                    showNotification(successMessage, 'success');
                    params.delete('success');
                }
                if (errorMessage) {
                    showNotification(errorMessage, 'error');
                    params.delete('error');
                }
                if (warningMessage) {
                    showNotification(warningMessage, 'warning');
                    params.delete('warning');
                }
                if (successMessage || errorMessage || warningMessage) {
                    const newUrl = `${window.location.pathname}${params.toString() ? `?${params.toString()}` : ''}`;
                    window.history.replaceState({}, '', newUrl);
                }

                const copyButtons = document.querySelectorAll('.copy-kyc-btn');
                
                copyButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const link = this.getAttribute('data-kyc-link');
                        const icon = this.querySelector('i');
                        
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(link).then(function() {
                                showCopySuccess(icon);
                            }).catch(function() {
                                copyViaTextarea(link, icon);
                            });
                        } else {
                            copyViaTextarea(link, icon);
                        }
                    });
                });

                function copyViaTextarea(text, icon) {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        document.execCommand('copy');
                        showCopySuccess(icon);
                    } catch (err) {
                        alert('Failed to copy link');
                    }
                    document.body.removeChild(textarea);
                }

                function showCopySuccess(icon) {
                    const originalClass = icon.className;
                    icon.className = 'fa-solid fa-check';
                    icon.parentElement.classList.add('text-green-600');
                    icon.parentElement.classList.remove('text-brand-cta', 'hover:text-brand-ctaHover');

                    showNotification('KYC link copied', 'success');
                    
                    setTimeout(() => {
                        icon.className = originalClass;
                        icon.parentElement.classList.remove('text-green-600');
                        icon.parentElement.classList.add('text-brand-cta', 'hover:text-brand-ctaHover');
                    }, 2000);
                }
            });

            function showNotification(message, type) {
                let container = document.getElementById('toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'toast-container';
                    document.body.appendChild(container);
                }

                const notification = document.createElement('div');
                const isSuccess = type === 'success';
                const isWarning = type === 'warning';
                const typeClass = isSuccess ? 'toast-success' : isWarning ? 'toast-warning' : 'toast-error';
                const icon = isSuccess ? 'fa-check' : isWarning ? 'fa-exclamation-triangle' : 'fa-xmark';
                const title = isSuccess ? 'Success' : isWarning ? 'Warning' : 'Error';
                
                notification.className = `toast ${typeClass}`;
                notification.innerHTML = `
                    <div class="toast-icon">
                        <i class="fa-solid ${icon} text-sm"></i>
                    </div>
                    <div>
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                `;
                container.appendChild(notification);
                setTimeout(() => notification.remove(), isSuccess ? 3200 : 4500);
            }

            let deleteTargetForm = null;

            function openDeleteModal(trigger) {
                const form = trigger.closest('form');
                if (!form) return;
                deleteTargetForm = form;

                const name = form.getAttribute('data-merchant-name') || 'this onboarding request';
                const nameEl = document.getElementById('delete-merchant-name');
                if (nameEl) {
                    nameEl.textContent = name;
                }

                document.getElementById('delete-modal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('delete-modal').classList.add('hidden');
                deleteTargetForm = null;
            }

            function confirmDelete() {
                if (deleteTargetForm) {
                    deleteTargetForm.submit();
                }
            }
        </script>

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="fixed inset-0 bg-black/40 z-[70] hidden flex items-center justify-center p-4" onclick="closeDeleteModal()">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full" onclick="event.stopPropagation()">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-trash-can text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Delete Onboarding</h3>
                            <p class="text-sm text-gray-500">Are you sure you want to delete <span id="delete-merchant-name" class="font-medium text-gray-700"></span>?</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mb-6">This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-gray-600 font-medium hover:bg-gray-50 transition-colors">Cancel</button>
                        <button type="button" onclick="confirmDelete()" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">Delete</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
@endsection

