<x-merchant.kyc>
    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl md:text-[28px] font-bold text-brand-dark mb-2">{{ $section->name }}</h1>
        <p class="text-sm sm:text-[15px] text-[#6A6A6A]">{{ $section->description }}</p>
    </div>

    <form id="kyc-form" method="POST" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">

        @if($fields->isNotEmpty())
            <section class="mb-10">
                {{-- <h2 class="text-xl font-semibold text-brand-dark mb-6">{{ $section->name }}</h2> --}}

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    @foreach($fields as $field)
                        @php
                            $colSpan = in_array($field->data_type, ['textarea', 'address', 'file']) ? 'col-span-2' : '';
                            $fieldVisibleAcquirers = collect($field->visible_acquirers ?? [])->map(fn ($value) => strtolower(trim((string) $value)))->filter();
                            $activeOnboardingAcquirers = collect($onboardingAcquirers ?? [])->map(fn ($value) => strtolower(trim((string) $value)))->filter();
                            $isVisibleForAcquirer = $fieldVisibleAcquirers->isEmpty()
                                || $fieldVisibleAcquirers->intersect($activeOnboardingAcquirers)->isNotEmpty();
                        @endphp
                        @if($isVisibleForAcquirer)
                            <div class="{{ $colSpan }}">
                                <x-kyc-field :field="$field" :value="$savedValues[$field->id] ?? null" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @else
            <section class="mb-10">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-3xl mb-3"></i>
                    <p class="text-yellow-800 font-medium">No fields configured for this section</p>
                    <p class="text-yellow-600 text-sm mt-1">Please contact the administrator to configure KYC fields.</p>
                </div>
            </section>
        @endif

        <footer
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ $prevSection ? route('merchant.kyc.section', ['kyc_link' => $kyc_link, 'section' => $prevSection->slug]) : route('merchant.kyc.start', ['kyc_link' => $kyc_link]) }}"
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
                        <span>{{ $nextSection ? 'Continue' : 'Review' }}</span>
                        <i class="fa-solid fa-arrow-right text-sm hidden sm:inline"></i>
                    </button>
                </div>
            </div>
        </footer>
    </form>

    @push('js')
        <script>
            const kycFieldLabels = @json(
                $fields->mapWithKeys(fn($field) => [(string) $field->id => (string) $field->field_name])
            );

            function resolveFriendlyFieldLabel(fieldPath) {
                const path = String(fieldPath || '');
                const dynamicMatch = path.match(/^dynamic_fields\.(\d+)\.value$/);
                if (dynamicMatch) {
                    return kycFieldLabels[dynamicMatch[1]] || 'This field';
                }

                const groupedMatch = path.match(/^(bo_fields|bm_fields|as_fields)\.(\d+)\.(\d+)\.value$/);
                if (groupedMatch) {
                    const groupType = groupedMatch[1];
                    const groupIndex = Number(groupedMatch[2]) + 1;
                    const fieldId = groupedMatch[3];
                    const fieldLabel = kycFieldLabels[fieldId] || 'This field';

                    const groupLabelMap = {
                        bo_fields: 'Beneficial Owner',
                        bm_fields: 'Board Member',
                        as_fields: 'Authorized Signatory',
                    };

                    return `${fieldLabel} (${groupLabelMap[groupType] || 'Group'} #${groupIndex})`;
                }

                return 'This field';
            }

            function formatValidationMessage(fieldPath, rawMessage) {
                const message = String(rawMessage || '').trim();
                const friendlyField = resolveFriendlyFieldLabel(fieldPath);

                if (!message) {
                    return `${friendlyField} is invalid.`;
                }

                if (/field is required\.?$/i.test(message) || /is required\.?$/i.test(message)) {
                    return `${friendlyField} is required.`;
                }

                if (/must be an array\.?$/i.test(message)) {
                    return `${friendlyField} has an invalid format.`;
                }

                if (/must have at least/i.test(message) || /at least/i.test(message)) {
                    return `${friendlyField} requires at least one selection.`;
                }

                return message;
            }

            function collectValidationMessages(errors) {
                if (!errors || typeof errors !== 'object') {
                    return [];
                }

                return Object.entries(errors)
                    .flatMap(([fieldPath, messages]) => {
                        const normalized = Array.isArray(messages) ? messages : [messages];
                        return normalized
                            .filter(Boolean)
                            .map((msg) => formatValidationMessage(fieldPath, msg));
                    })
                    .filter(Boolean);
            }

            async function submitSection(redirectAfterSave = false) {
                const form = document.getElementById('kyc-form');

                // Enforce native HTML required validation before continue/review.
                if (redirectAfterSave && !form.reportValidity()) {
                    return;
                }

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
                        const messages = collectValidationMessages(data.errors);
                        if (messages.length > 0) {
                            [...new Set(messages)].slice(0, 3).forEach((message) => showToast(message, 'error'));
                            if (messages.length > 3) {
                                showToast(`Please fix ${messages.length - 3} more field(s).`, 'error');
                            }
                        } else {
                            showToast(data.message || 'Unable to save section data.', 'error');
                        }
                        return;
                    }

                    if (redirectAfterSave) {
                        @if($nextSection)
                            window.location.href = '{{ route('merchant.kyc.section', ['kyc_link' => $kyc_link, 'section' => $nextSection->slug]) }}';
                        @else
                            window.location.href = '{{ route('merchant.kyc.review', ['kyc_link' => $kyc_link]) }}';
                        @endif
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitSection(false);
            }

            function saveAndContinue() {
                submitSection(true);
            }
        </script>
    @endpush
</x-merchant.kyc>
