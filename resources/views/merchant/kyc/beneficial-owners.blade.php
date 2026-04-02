<x-merchant.kyc>
    @push('css')
        <style>
            ::-webkit-scrollbar {
                display: none;
            }

            body {
                font-family: 'Inter', sans-serif;
            }

            .step-active {
                background: rgba(45, 58, 116, 0.08);
                border-left: 4px solid #FF7C00;
            }

            .step-completed {
                border-left: 4px solid #27AE60;
            }

            .upload-zone {
                border: 2px dashed #D1D5DB;
                transition: all 0.2s;
            }

            .upload-zone:hover {
                border-color: #4055A8;
                background: rgba(64, 85, 168, 0.02);
            }

            input:focus,
            select:focus,
            textarea:focus {
                outline: none;
                border-color: #4055A8;
                box-shadow: 0 0 0 3px rgba(64, 85, 168, 0.1);
            }

            .error-field {
                border-color: #E74C3C;
            }

            .toast {
                animation: slideIn 0.3s ease-out;
            }

            @keyframes slideIn {
                from {
                    transform: translateY(-100%);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .modal {
                animation: fadeIn 0.2s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }
        </style>
    @endpush

    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-brand-dark mb-2">{{ $section->name }}</h1>
        <p class="text-[15px] text-[#6A6A6A]">{{ $section->description }}</p>
    </div>

    <div id="info-banner" class="bg-[#FFF6E8] border-l-4 border-brand-orange p-4 rounded-lg mb-8">
        <p class="text-[13px] font-medium text-[#8A6C1A]">
            <i class="fa-solid fa-info-circle mr-2"></i>
            According to EU AML regulations, you must declare all individuals with 25% or more ownership.
        </p>
    </div>

    @php
        $groupItems = !empty($savedGroups) ? $savedGroups : [0 => []];
    @endphp

    <form id="bo-form" method="POST" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}" novalidate>
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">

        <div id="group-cards-wrapper">
            @foreach ($groupItems as $gIdx => $gValues)
            <div class="group-card bg-white border border-gray-200 rounded-xl p-6 mb-6 relative"
                data-group-index="{{ $gIdx }}">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-semibold text-brand-dark group-card-heading">Beneficial Owner #{{ $gIdx + 1 }}</h3>
                </div>

                @if ($fields->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        @foreach ($fields as $field)
                            @php
                                $colSpan = in_array($field->data_type, ['textarea', 'address', 'file'])
                                    ? 'col-span-2'
                                    : '';
                                $nameOverride = 'bo_fields[' . $gIdx . '][' . $field->id . '][value]';
                            @endphp
                            <div class="{{ $colSpan }}">
                                <x-kyc-field :field="$field" :value="$gValues[$field->id] ?? null" :nameOverride="$nameOverride" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="col-span-2 text-sm text-gray-400 italic">No fields configured for this section.</div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

        <footer
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.company', ['kyc_link' => $kyc_link]) }}"
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
            function showToast(message, type) {
                type = type || 'success';
                let container = document.getElementById('toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'toast-container';
                    container.className = 'fixed top-6 right-6 z-50';
                    document.body.appendChild(container);
                }
                const toast = document.createElement('div');
                toast.className = 'toast bg-white border-l-4 ' + (type === 'success' ? 'border-green-500' : 'border-red-500') + ' rounded-lg shadow-lg p-4 mb-3';
                toast.innerHTML = '<div class="flex items-center gap-3"><i class="fa-solid ' + (type === 'success' ? 'fa-check-circle text-green-500' : 'fa-exclamation-circle text-red-500') + ' text-xl"></i><p class="text-sm font-medium text-gray-900">' + String(message) + '</p></div>';
                container.appendChild(toast);
                setTimeout(function () { toast.style.opacity = '0'; setTimeout(function () { toast.remove(); }, 300); }, 3000);
            }

            async function submitBeneficialOwners(redirectAfterSave) {
                redirectAfterSave = redirectAfterSave || false;
                const form = document.getElementById('bo-form');

                // Temporarily strip required from always-hidden file inputs so FormData
                // collection does not trigger the browser "not focusable" validation error.
                const fileInputs = Array.from(form.querySelectorAll('input[type="file"]'));
                fileInputs.forEach(function (inp) { inp.removeAttribute('required'); });

                const formData = new FormData(form);

                // Restore required attribute
                fileInputs.forEach(function (inp) { inp.setAttribute('required', ''); });

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
                        showToast(data.message || 'Unable to save beneficial owners information.', 'error');
                        return;
                    }

                    if (redirectAfterSave) {
                        window.location.href = '{{ route('merchant.kyc.boardMembers', ['kyc_link' => $kyc_link]) }}';
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitBeneficialOwners(false);
            }

            function saveAndContinue() {
                submitBeneficialOwners(true);
            }
        </script>
    @endpush
</x-merchant.kyc>
