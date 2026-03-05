
<x-merchant.kyc>
    @push('css')
        <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F7F8FA;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .form-input {
            width: 100%;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            color: #2D3A74;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: #2D3A74;
            box-shadow: 0 0 0 1px #2D3A74;
        }

        .step-line {
            position: absolute;
            left: 15px;
            top: 30px;
            bottom: -10px;
            width: 2px;
            background-color: #E5E7EB;
            z-index: 0;
        }

        .last-step .step-line {
            display: none;
        }
    </style>
    @endpush


    <!-- Header Section -->
    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl font-semibold text-primary mb-2">{{ $section->name }}</h1>
        <p class="text-gray-500 text-sm">{{ $section->description }}</p>
    </div>

    <form id="cp-form" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}" method="POST">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">

        <!-- Contact Person Card -->
        <div id="contact-person-card" class="bg-white rounded-lg shadow-sm border border-gray-200/60 p-4 sm:p-6">

            @if($fields->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                @foreach($fields as $field)
                    @php
                        $colSpan = in_array($field->data_type, ['textarea', 'address', 'file']) ? 'col-span-2' : '';
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
                <p class="text-yellow-600 text-sm mt-1">Please contact the administrator to configure KYC fields.</p>
            </div>
            @endif

        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.boardMembers', ['kyc_link' => $kyc_link]) }}"
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

            async function submitContactPerson(redirectAfterSave = false) {
                const form = document.getElementById('cp-form');
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
                        showToast(data.message || 'Unable to save contact person information.', 'error');
                        return;
                    }

                    showToast('Contact person information saved.', 'success');

                    if (redirectAfterSave) {
                        window.location.href = '{{ route('merchant.kyc.purposeOfService', ['kyc_link' => $kyc_link]) }}';
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitContactPerson(false);
            }

            function saveAndContinue() {
                submitContactPerson(true);
            }

            document.addEventListener('click', function(e) {
                const zone = e.target.closest('.upload-zone');
                if (zone) {
                    const input = zone.querySelector('input[type="file"]');
                    if (input) input.click();
                }
            });
        </script>
    @endpush
</x-merchant.kyc>
