@php
    $groupedConfig = [
        'beneficial-owners'      => ['key' => 'bo_fields',  'label' => 'Beneficial Owner'],
        'board-members-gm'       => ['key' => 'bm_fields',  'label' => 'Board Member'],
        'authorized-signatories' => ['key' => 'as_fields',  'label' => 'Authorized Signatory'],
    ];
    $groupConfig = $groupedConfig[$section->slug] ?? null;
    $isGrouped   = (bool) ($section->allow_multiple ?? false);
    $fieldKey    = $groupConfig['key'] ?? (str_replace('-', '_', $section->slug) . '_fields');
    $addLabel    = $groupConfig['label'] ?? $section->name;
    $groupItems  = ($isGrouped && !empty($savedGroups)) ? $savedGroups : [0 => []];
@endphp

<x-merchant.kyc>
    <div id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl md:text-[28px] font-bold text-brand-dark mb-2">{{ $section->name }}</h1>
        <p class="text-sm sm:text-[15px] text-[#6A6A6A]">{{ $section->description }}</p>
    </div>

    <form id="kyc-form" method="POST"
        action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">

        @if ($fields->isNotEmpty())
            @if ($isGrouped)
                {{-- Grouped section: renders one card per group (Beneficial Owner, Board Member, etc.) --}}
                <div id="group-cards-wrapper">
                    @foreach ($groupItems as $gIdx => $gValues)
                        <div class="group-card bg-white border border-gray-200 rounded-xl p-6 mb-6 relative" data-group-index="{{ $gIdx }}">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="text-base font-semibold text-brand-dark group-card-heading">{{ $addLabel }} #{{ $gIdx + 1 }}</h3>
                                <button type="button" class="remove-group-card inline-flex items-center gap-1.5 text-sm text-red-500 hover:text-red-700 transition-colors {{ $loop->first ? 'hidden' : '' }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Remove</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                @foreach ($fields as $field)
                                    @php
                                        $colSpan = in_array($field->data_type, ['textarea', 'address', 'file']) ? 'col-span-2' : '';
                                        $nameOverride = $fieldKey . '[' . $gIdx . '][' . $field->id . '][value]';
                                    @endphp
                                    <div class="{{ $colSpan }}">
                                        <x-kyc-field :field="$field" :value="$gValues[$field->id] ?? null" :nameOverride="$nameOverride" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Hidden template used by JS to clone fresh cards --}}
                <template id="group-card-template">
                    <div class="group-card bg-white border border-gray-200 rounded-xl p-6 mb-6 relative" data-group-index="__IDX__">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-base font-semibold text-brand-dark group-card-heading">{{ $addLabel }} #__NUM__</h3>
                            <button type="button" class="remove-group-card inline-flex items-center gap-1.5 text-sm text-red-500 hover:text-red-700 transition-colors">
                                <i class="fa-solid fa-trash-can"></i>
                                <span>Remove</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            @foreach ($fields as $field)
                                @php
                                    $colSpan = in_array($field->data_type, ['textarea', 'address', 'file']) ? 'col-span-2' : '';
                                    $tplName = $fieldKey . '[__IDX__][' . $field->id . '][value]';
                                @endphp
                                <div class="{{ $colSpan }}">
                                    <x-kyc-field :field="$field" value="" :nameOverride="$tplName" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </template>

                <div class="text-center mb-8 mt-2">
                    <button type="button" id="add-group-btn"
                        class="inline-flex items-center gap-2 px-8 py-2.5 border border-brand-accent text-brand-accent bg-white hover:bg-blue-50 font-medium rounded-lg transition-colors duration-200">
                        <i class="fa-solid fa-plus text-sm"></i>
                        <span>Add Another {{ $addLabel }}</span>
                    </button>
                </div>
            @else
                {{-- Non-grouped section: flat grid of fields --}}
                <section class="mb-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        @foreach ($fields as $field)
                            @php
                                $colSpan = in_array($field->data_type, ['textarea', 'address', 'file']) ? 'col-span-2' : '';
                                $fieldVisibleAcquirers = collect($field->visible_acquirers ?? [])
                                    ->map(fn($value) => strtolower(trim((string) $value)))
                                    ->filter();
                                $activeOnboardingAcquirers = collect($onboardingAcquirers ?? [])
                                    ->map(fn($value) => strtolower(trim((string) $value)))
                                    ->filter();
                                $isVisibleForAcquirer =
                                    $fieldVisibleAcquirers->isEmpty() ||
                                    $fieldVisibleAcquirers->intersect($activeOnboardingAcquirers)->isNotEmpty();
                            @endphp
                            @if ($isVisibleForAcquirer)
                                <div class="{{ $colSpan }}">
                                    <x-kyc-field :field="$field" :value="$savedValues[$field->id] ?? null" />
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif
        @endif

        <footer
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ $prevSection ? ($prevSection->slug === 'company-information' ? route('merchant.kyc.company', ['kyc_link' => $kyc_link]) : route('merchant.kyc.section', ['kyc_link' => $kyc_link, 'section' => $prevSection->slug])) : route('merchant.kyc.start', ['kyc_link' => $kyc_link]) }}"
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
            const kycFieldLabels = @json($fields->mapWithKeys(fn($field) => [(string) $field->id => (string) $field->field_name]));

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

            function isElementVisible(element) {
                if (!element) {
                    return false;
                }

                const style = window.getComputedStyle(element);
                if (style.display === 'none' || style.visibility === 'hidden') {
                    return false;
                }

                return element.offsetParent !== null || style.position === 'fixed';
            }

            function getFieldWrapper(control) {
                return control.closest('.kyc-field') || control.closest('[data-file-upload]') || control;
            }

            function disableHiddenRequiredControls(form) {
                const controls = Array.from(form.querySelectorAll('input, select, textarea'));
                const disabledControls = [];

                controls.forEach((control) => {
                    if (!control.required || control.disabled) {
                        return;
                    }

                    // File inputs inside our custom upload zones are structurally hidden
                    // (class="hidden") — the wrapper label is visible but the input itself
                    // can never be focused, causing the "not focusable" browser error.
                    const isStructurallyHiddenFile =
                        control.type === 'file' && control.classList.contains('hidden');

                    const wrapper = getFieldWrapper(control);
                    if (!isStructurallyHiddenFile && isElementVisible(wrapper)) {
                        return;
                    }

                    disabledControls.push(control);
                    control.dataset.wasRequired = '1';
                    control.required = false;
                });

                return () => {
                    disabledControls.forEach((control) => {
                        if (control.dataset.wasRequired === '1') {
                            control.required = true;
                            delete control.dataset.wasRequired;
                        }
                    });
                };
            }

            function validateVisibleRequiredGroups(form) {
                const wrappers = Array.from(form.querySelectorAll('.kyc-field'));
                const errors = [];

                wrappers.forEach((wrapper) => {
                    if (!isElementVisible(wrapper)) {
                        return;
                    }

                    const label = wrapper.querySelector('label');
                    const hasRequiredMark = Boolean(label && label.querySelector('.text-red-500'));
                    if (!hasRequiredMark) {
                        return;
                    }

                    const checkboxes = Array.from(wrapper.querySelectorAll('input[type="checkbox"]'));
                    if (checkboxes.length > 0 && !checkboxes.some((item) => item.checked)) {
                        errors.push((label?.textContent || 'This field').replace('*', '').trim() + ' is required.');
                    }
                });

                return errors;
            }

            function validateVisibleFields(form) {
                const restoreRequiredState = disableHiddenRequiredControls(form);
                const isNativeValid = form.reportValidity();
                const groupErrors = validateVisibleRequiredGroups(form);
                restoreRequiredState();

                if (groupErrors.length > 0) {
                    [...new Set(groupErrors)].slice(0, 2).forEach((message) => showToast(message, 'error'));
                }

                return isNativeValid && groupErrors.length === 0;
            }

            async function submitSection(redirectAfterSave = false) {
                const form = document.getElementById('kyc-form');

                // Enforce native HTML required validation before continue/review.
                if (redirectAfterSave && !validateVisibleFields(form)) {
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
                        @if ($nextSection)
                            window.location.href =
                                '{{ route('merchant.kyc.section', ['kyc_link' => $kyc_link, 'section' => $nextSection->slug]) }}';
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

            // ── Grouped card logic (Beneficial Owners / Board Members / Authorized Signatories) ──

            function fixFileUploadIds(container) {
                container.querySelectorAll('label[for^="file-upload-"]').forEach(function (label) {
                    const oldId = label.getAttribute('for');
                    const newId = 'file-upload-' + Date.now().toString(36) + Math.random().toString(36).slice(2);
                    label.setAttribute('for', newId);
                    const input = container.querySelector('#' + CSS.escape(oldId));
                    if (input) { input.id = newId; }
                });
            }

            function updateCardRemoveButtons() {
                const wrapper = document.getElementById('group-cards-wrapper');
                if (!wrapper) { return; }
                const cards = wrapper.querySelectorAll('.group-card');
                cards.forEach(function (card, i) {
                    const btn = card.querySelector('.remove-group-card');
                    if (btn) { btn.classList.toggle('hidden', cards.length === 1); }
                    card.setAttribute('data-group-index', String(i));
                    const heading = card.querySelector('.group-card-heading');
                    if (heading) {
                        heading.textContent = heading.textContent.replace(/#\d+$/, '#' + (i + 1));
                    }
                });
            }

            function reIndexGroupNames() {
                const wrapper = document.getElementById('group-cards-wrapper');
                if (!wrapper) { return; }
                wrapper.querySelectorAll('.group-card').forEach(function (card, i) {
                    card.querySelectorAll('[name]').forEach(function (el) {
                        el.name = el.name.replace(/\[\d+\]/, '[' + i + ']');
                    });
                });
            }

            function cloneGroupCard() {
                const wrapper = document.getElementById('group-cards-wrapper');
                const tpl = document.getElementById('group-card-template');
                if (!wrapper || !tpl) { return; }

                const newIndex = wrapper.querySelectorAll('.group-card').length;
                const newNum   = newIndex + 1;

                let html = tpl.innerHTML;
                html = html.replaceAll('__IDX__', String(newIndex));
                html = html.replaceAll('__NUM__', String(newNum));

                const div = document.createElement('div');
                div.innerHTML = html;
                const card = div.firstElementChild;

                fixFileUploadIds(card);

                // Re-init select2 after appending
                wrapper.appendChild(card);

                if (window.jQuery) {
                    jQuery(card).find('select').each(function () {
                        if (jQuery(this).hasClass('js-select2-multi') || jQuery(this).hasClass('select2')) {
                            jQuery(this).select2({ width: '100%' });
                        }
                    });
                }

                updateCardRemoveButtons();
            }

            document.addEventListener('DOMContentLoaded', function () {
                const addBtn = document.getElementById('add-group-btn');
                if (addBtn) {
                    addBtn.addEventListener('click', cloneGroupCard);
                }

                const wrapper = document.getElementById('group-cards-wrapper');
                if (wrapper) {
                    wrapper.addEventListener('click', function (e) {
                        const btn = e.target.closest('.remove-group-card');
                        if (!btn) { return; }
                        const card = btn.closest('.group-card');
                        if (!card) { return; }
                        const cards = wrapper.querySelectorAll('.group-card');
                        if (cards.length <= 1) { return; }
                        card.remove();
                        reIndexGroupNames();
                        updateCardRemoveButtons();
                    });

                    updateCardRemoveButtons();
                }
            });
        </script>
    @endpush
</x-merchant.kyc>
