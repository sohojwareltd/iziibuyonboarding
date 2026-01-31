@props([
    'kyc_link' => null,
])
@php
    $kyc_link = $kyc_link ?? request()->route('kyc_link');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        window.FontAwesomeConfig = {
            autoReplaceSvg: 'nest'
        };
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#2D3A74',
                            accent: '#4055A8',
                            orange: '#FF7C00',
                            orangeHover: '#E56D00',
                            bg: '#F7F8FA',
                            border: '#E5E7EB',
                            inputBorder: '#D1D5DB',
                            textSubtle: '#595959',
                            textMuted: '#9A9A9A',
                            error: '#E74C3C'
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

    @stack('css')
</head>

<body class="h-screen overflow-hidden bg-brand-bg flex antialiased flex-col md:flex-row">

    {{-- <!-- Mobile Menu Button -->
    <button id="mobile-menu-btn" class="md:hidden fixed top-4 left-4 z-50 bg-white p-2.5 rounded-lg shadow-lg border border-gray-200 hover:bg-gray-50 transition-colors">
        <i class="fa-solid fa-bars text-brand-dark text-lg"></i>
    </button>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity"></div> --}}

    <x-merchant.kyc-stepper :kycLink="$kyc_link" />

    <main id="main-content" class="flex-1 h-full overflow-y-auto pb-32 sm:pb-24 w-full">
        <div class="max-w-[900px] mx-auto bg-white p-4 sm:p-6 md:p-12 min-h-full">

            {{ $slot }}
        </div>


    </main>

    <div id="toast-container" class="fixed top-4 left-4 right-4 sm:left-auto sm:right-6 sm:top-6 z-50"></div>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const sidebar = document.getElementById('kyc-sidebar');

        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        });

        mobileOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            mobileOverlay.classList.add('hidden');
        });

        window.addEventListener('load', function() {
            const uploadZones = document.querySelectorAll('.upload-zone');
            uploadZones.forEach(zone => {
                const input = zone.querySelector('input[type="file"]');
                zone.addEventListener('click', () => input.click());

                input.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        const fileName = this.files[0].name;
                        zone.innerHTML = `
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i class="fa-solid fa-file-pdf text-2xl text-brand-orange"></i>
                                        <div class="text-left">
                                            <p class="text-sm font-medium text-gray-900">${fileName}</p>
                                            <p class="text-xs text-gray-500">Uploaded successfully</p>
                                        </div>
                                    </div>
                                    <button onclick="removeFile(this)" class="text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </div>
                            `;
                        zone.classList.add('bg-green-50', 'border-green-300');
                    }
                });
            });
        });

        function goBack() {
            window.history.back();
        }

        function saveDraft() {
            showToast('Your progress has been saved.', 'success');
        }

        function showToast(message, type) {
            const container = document.getElementById('toast-container');
            const bgColor = type === 'success' ? 'bg-green-50' : 'bg-red-50';
            const borderColor = type === 'success' ? 'border-green-500' : 'border-red-500';
            const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';

            const toast = document.createElement('div');
            toast.className =
                `toast ${bgColor} border-l-4 ${borderColor} p-4 rounded-lg shadow-lg mb-3 flex items-center gap-3`;
            toast.innerHTML = `
                    <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'} ${textColor}"></i>
                    <p class="text-sm font-medium ${textColor}">${message}</p>
                `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        function removeFile(btn) {
            const zone = btn.closest('.upload-zone');
            zone.classList.remove('bg-green-50', 'border-green-300');
            zone.innerHTML = `
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                    <p class="text-sm font-medium text-gray-700 mb-1">Upload Document</p>
                    <p class="text-xs text-gray-500">Upload PDF / JPG / PNG (Max 5MB)</p>
                    <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                `;
        }
    </script>

    @stack('js')
</body>

</html>
