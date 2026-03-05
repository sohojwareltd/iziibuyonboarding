<x-merchant.kyc>
    @push('css')
        <style>
            ::-webkit-scrollbar {
                display: none;
            }

            .toggle-checkbox:checked {
                right: 0;
                border-color: #2D3A74;
            }

            .toggle-checkbox:checked+.toggle-label {
                background-color: #2D3A74;
            }

            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
            }
        </style>
    @endpush


    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-[24px] font-semibold text-primary mb-2">{{ $section->name }}</h1>
        <p class="text-gray-600 text-sm max-w-2xl">
            {{ $section->description }}
        </p>
    </header>

    <form id="ps-form" class="space-y-8" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}" method="POST">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">

        <!-- 3. PURPOSE OF SERVICE CARD -->
        <section id="purpose-card" class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 mb-24">

            @if ($fields->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($fields as $field)
                        @php
                            $colSpan = in_array($field->data_type, ['textarea', 'address', 'file'])
                                ? 'md:col-span-2'
                                : '';
                        @endphp
                        <div class="{{ $colSpan }}">
                            <x-kyc-field :field="$field" :value="$savedValues[$field->id] ?? null" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-3xl mb-3"></i>
                    <p class="text-yellow-800 font-medium">No fields configured for this section</p>
                    <p class="text-yellow-600 text-sm mt-1">Please contact the administrator to configure KYC fields.
                    </p>
                </div>
            @endif

        </section>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.contactPerson', ['kyc_link' => $kyc_link]) }}"
                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                    <button type="button" onclick="saveDraft()"
                        class="flex-1 sm:flex-none px-3 sm:px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="fa-regular fa-floppy-disk text-sm hidden sm:inline"></i>
                        <span>Draft</span>
                    </button>

                    <button type="button" onclick="saveAndContinue()"
                        class="flex-1 sm:flex-none px-4 sm:px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 text-xs sm:text-base">
                        <span>Continue</span>
                        <i class="fa-solid fa-arrow-right text-sm hidden sm:inline"></i>
                    </button>
                </div>
            </div>
        </footer>
    </form>

    @push('js')
        <script>
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className =
                    `toast bg-white border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'} rounded-lg shadow-lg p-4 mb-3`;
                toast.innerHTML = `
                    <div class="flex items-center gap-3">
                        <i class="fa-solid ${type === 'success' ? 'fa-check-circle text-green-500' : 'fa-exclamation-circle text-red-500'} text-xl"></i>
                        <p class="text-sm font-medium text-gray-900">${message}</p>
                    </div>
                `;

                let container = document.getElementById('toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'toast-container';
                    container.className = 'fixed top-6 right-6 z-50';
                    document.body.appendChild(container);
                }

                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            async function submitPurposeOfService(redirectAfterSave = false) {
                const form = document.getElementById('ps-form');
                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        showToast(data.message || 'Unable to save purpose of service information.', 'error');
                        return;
                    }

                    showToast('Purpose of service information saved.', 'success');

                    if (redirectAfterSave) {
                        window.location.href = '{{ route('merchant.kyc.salesChannels', ['kyc_link' => $kyc_link]) }}';
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitPurposeOfService(false);
            }

            function saveAndContinue() {
                submitPurposeOfService(true);
            }
        </script>
    @endpush
</x-merchant.kyc>
