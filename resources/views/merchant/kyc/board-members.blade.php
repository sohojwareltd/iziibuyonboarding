<x-merchant.kyc>
    <!-- Header Section -->
    <header id="page-header" class="mb-8">
        <h1 class="text-xl sm:text-2xl font-semibold text-brand-dark mb-2">{{ $section->name }}</h1>
        <p class="text-gray-600 text-sm">{{ $section->description }}</p>
    </header>

    <!-- Alert Banner -->
    <div id="alert-banner"
        class="bg-[#FFF4E5] border-l-4 border-brand-alert p-4 mb-8 rounded-r-md flex items-start shadow-sm">
        <div class="text-brand-alert mt-0.5 mr-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="text-sm text-gray-700 leading-relaxed">
            <span class="font-semibold">Requirement:</span> Please ensure that you list all active board members as
            they appear in your official company registration documents. At least one entry is required.
        </div>
    </div>

    @php
        $memberGroups = !empty($savedGroups) ? $savedGroups : [0 => []];
    @endphp

    <form id="bm-form" method="POST" action="{{ route('merchant.kyc.section.fields.save', ['kyc_link' => $kyc_link, 'section' => $section->slug]) }}">
        @csrf
        <input type="hidden" name="onboarding_id" value="{{ $onboarding_id }}">
        <div id="board-members-container" class="space-y-6">

            @foreach ($memberGroups as $groupIndex => $groupValues)
            <div class="board-member-card bg-white border border-[#E0E0E0] rounded-xl p-4 sm:p-6 mb-6"
                data-bm-index="{{ $loop->iteration }}">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-brand-dark">Board Member #{{ $loop->iteration }}</h3>
                    <button type="button"
                        class="remove-bo-btn text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200 {{ count($memberGroups) > 1 ? '' : 'hidden' }}">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </div>

                <!-- Card Body -->
                <div class="p-4 sm:p-6">

                    @if ($fields->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 sm:gap-x-6 gap-y-4 sm:gap-y-5">
                            @foreach ($fields as $field)
                                @php
                                    $colSpan = in_array($field->data_type, ['textarea', 'address', 'file'])
                                        ? 'col-span-2'
                                        : '';
                                @endphp
                                <div class="{{ $colSpan }}">
                                    <input type="hidden" name="bm_fields[{{ $groupIndex }}][{{ $field->id }}][field_id]" value="{{ $field->id }}">
                                    <input type="hidden" name="bm_fields[{{ $groupIndex }}][{{ $field->id }}][key]" value="{{ $field->internal_key }}">
                                    <x-kyc-field :field="$field" :value="$groupValues[$field->id] ?? null" :nameOverride="'bm_fields[' . $groupIndex . '][' . $field->id . '][value]'" />
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                            <i class="fa-solid fa-exclamation-triangle text-yellow-600 text-3xl mb-3"></i>
                            <p class="text-yellow-800 font-medium">No fields configured for this section</p>
                            <p class="text-yellow-600 text-sm mt-1">Please contact the administrator to configure KYC
                                fields.</p>
                        </div>
                    @endif

                </div>
            </div>
            @endforeach

        </div>

        <div class="text-center mb-8 mt-4">
            <button type="button" id="add-bo-btn"
                class="inline-flex items-center gap-2 px-8 py-2.5 border border-brand-accent text-brand-accent bg-white hover:bg-blue-50 font-medium rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Add Another Board Member</span>
            </button>
        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.beneficialOwners', ['kyc_link' => $kyc_link]) }}"
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

    <div id="toast-container" class="fixed top-6 right-6 z-50"></div>

    <div id="confirmation-modal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="modal bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <i class="fa-solid fa-triangle-exclamation text-4xl text-yellow-500 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Remove Board Member</h3>
                <p class="text-sm text-gray-600 mb-6">Are you sure you want to remove this board member? This
                    action cannot be undone.</p>
                <div class="flex gap-3 justify-center">
                    <button onclick="cancelRemove()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium">
                        Cancel
                    </button>
                    <button onclick="confirmRemove()"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script>
            let bmCount = document.querySelectorAll('.board-member-card').length || 1;
            let bmToRemove = null;

            window.addEventListener('load', function() {
                setupUploadZones();
                updateRemoveButtons();
                setupOwnershipValidation();
            });

            function setupUploadZones() {
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.upload-zone')) {
                        const zone = e.target.closest('.upload-zone');
                        const input = zone.querySelector('input[type="file"]');
                        input.click();
                    }
                });

                document.addEventListener('change', function(e) {
                    if (e.target.type === 'file' && e.target.files.length > 0) {
                        const zone = e.target.closest('.upload-zone');
                        const fileName = e.target.files[0].name;
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
            }

            function setupOwnershipValidation() {
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('ownership-percentage')) {
                        validateOwnershipTotal();
                    }
                });
            }

            function validateOwnershipTotal() {
                const percentageInputs = document.querySelectorAll('.ownership-percentage');
                let total = 0;

                percentageInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });

                percentageInputs.forEach(input => {
                    if (total > 100) {
                        input.classList.add('error-field');
                    } else {
                        input.classList.remove('error-field');
                    }
                });
            }

            document.getElementById('add-bo-btn').addEventListener('click', function() {
                bmCount++;
                const container = document.getElementById('board-members-container');
                const newBMCard = createBOCard(bmCount);
                container.appendChild(newBMCard);
                updateRemoveButtons();
                setupUploadZones();
                newBMCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });

            function createBOCard(index) {
                // Clone the first board member card
                const firstCard = document.querySelector('.board-member-card');
                const newCard = firstCard.cloneNode(true);

                // Update the card index and title
                newCard.setAttribute('data-bm-index', index);
                newCard.querySelector('h3').textContent = `Board Member #${index}`;

                // Show the remove button
                newCard.querySelector('.remove-bo-btn').classList.remove('hidden');

                // Clear all input values
                newCard.querySelectorAll('input').forEach(input => {
                    if (input.type === 'hidden') {
                        return;
                    }

                    if (input.type === 'file') {
                        input.value = '';
                    } else if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });

                // Reset all select elements to first option
                newCard.querySelectorAll('select').forEach(select => {
                    select.selectedIndex = 0;
                });

                // Clear all textarea values
                newCard.querySelectorAll('textarea').forEach(textarea => {
                    textarea.value = '';
                });

                // Reset any file upload zones
                newCard.querySelectorAll('.upload-zone').forEach(zone => {
                    if (zone.classList.contains('bg-green-50')) {
                        zone.classList.remove('bg-green-50', 'border-green-300');
                        const label = zone.closest('div').querySelector('label')?.textContent || 'Upload Document';
                        zone.innerHTML = `
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span class="text-brand-blue font-medium">browse</span></p>
                            <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                            <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                        `;
                    }
                });

                // Update field names to include array index for better form handling
                newCard.querySelectorAll('[name]').forEach(field => {
                    const fieldName = field.getAttribute('name');
                    // Update name to include index (e.g., field_name[0] becomes field_name[1])
                    const updatedName = fieldName.replace(/\[\d+\]/, `[${index - 1}]`) || `${fieldName}[${index - 1}]`;
                    field.setAttribute('name', updatedName);
                });

                return newCard;
            }

            function updateRemoveButtons() {
                const cards = document.querySelectorAll('.board-member-card');
                const removeButtons = document.querySelectorAll('.remove-bo-btn');

                removeButtons.forEach((btn) => {
                    if (cards.length > 1) {
                        btn.classList.remove('hidden');
                        btn.onclick = function() {
                            bmToRemove = btn.closest('.board-member-card');
                            document.getElementById('confirmation-modal').classList.remove('hidden');
                        };
                    } else {
                        btn.classList.add('hidden');
                    }
                });
            }

            function confirmRemove() {
                if (bmToRemove) {
                    bmToRemove.remove();
                    bmToRemove = null;
                    document.getElementById('confirmation-modal').classList.add('hidden');
                    updateRemoveButtons();
                    renumberBMCards();
                }
            }

            function cancelRemove() {
                bmToRemove = null;
                document.getElementById('confirmation-modal').classList.add('hidden');
            }

            function renumberBMCards() {
                const cards = document.querySelectorAll('.board-member-card');
                cards.forEach((card, index) => {
                    card.querySelector('h3').textContent = `Board Member #${index + 1}`;
                    card.setAttribute('data-bm-index', index + 1);

                    card.querySelectorAll('[name]').forEach(field => {
                        const name = field.getAttribute('name');
                        if (!name) {
                            return;
                        }
                        field.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                    });
                });

                bmCount = cards.length;
            }

            function removeFile(btn) {
                const zone = btn.closest('.upload-zone');
                zone.innerHTML = `
                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span class="text-brand-blue font-medium">browse</span></p>
                    <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                    <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                `;
                zone.classList.remove('bg-green-50', 'border-green-300');
            }

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

                document.getElementById('toast-container').appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            async function submitBoardMembers(redirectAfterSave = false) {
                const form = document.getElementById('bm-form');
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
                        showToast(data.message || 'Unable to save board members information.', 'error');
                        return;
                    }

                    showToast('Board members information saved.', 'success');

                    if (redirectAfterSave) {
                        window.location.href = '{{ route('merchant.kyc.contactPerson', ['kyc_link' => $kyc_link]) }}';
                    }
                } catch (error) {
                    showToast('Something went wrong while saving.', 'error');
                }
            }

            function saveDraft() {
                submitBoardMembers(false);
            }

            function saveAndContinue() {
                submitBoardMembers(true);
            }
        </script>
    @endpush
</x-merchant.kyc>
