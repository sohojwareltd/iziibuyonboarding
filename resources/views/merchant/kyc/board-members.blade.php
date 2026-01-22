<x-merchant.kyc>
    <!-- Header Section -->
    <header id="page-header" class="mb-8">
        <h1 class="text-2xl font-semibold text-brand-dark mb-2">Board Members / General Manager</h1>
        <p class="text-gray-600 text-sm">Provide details of individuals responsible for running the company (Directors,
            Board Members, or General Manager).</p>
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

    <form id="bm-form">
        <div id="board-members-container" class="space-y-6">

            <div class="board-member-card bg-white border border-[#E0E0E0] rounded-xl p-6 mb-6" data-bm-index="1">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-brand-dark">Board Member #1</h3>
                    <button type="button"
                        class="remove-bo-btn text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200 hidden">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </div>

                <!-- Card Body -->
                <div class="p-6">

                    <!-- Section: Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Personal Information
                        </h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <x-input.text id="bm-first-name-1" label="First Name" required placeholder="Enter first name"
                                    class="h-11 px-3" />
                            </div>
                            <div>
                                <x-input.text id="bm-last-name-1" label="Last Name" required placeholder="Enter last name"
                                    class="h-11 px-3" />
                            </div>
                            <div>
                                <x-input.date id="bm-dob-1" label="Date of Birth" required class="h-11 px-3 text-gray-600" />
                            </div>
                            <div>
                                <x-input.select id="bm-nationality-1" label="Nationality" required placeholder="Select nationality" class="h-11 px-3">
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="CA">Canada</option>
                                </x-input.select>
                            </div>
                            <div>
                                <label for="bm-email-1" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address <span
                                    class="text-gray-400 text-xs font-normal">(optional)</span></label>
                                <x-input.email id="bm-email-1" placeholder="example@company.com" class="h-11 px-3" />
                            </div>
                            <div>
                                <label for="bm-phone-1" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number <span
                                    class="text-gray-400 text-xs font-normal">(optional)</span></label>
                                <x-input.tel id="bm-phone-1" placeholder="+1 (555) 000-0000" class="h-11 px-3" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Role Information -->
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Role Information</h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <x-input.text id="bm-position-1" label="Position in Company" required placeholder="e.g. Director"
                                    class="h-11 px-3" />
                            </div>
                            <div>
                                <x-input.date id="bm-role-start-1" label="Start Date in Role" required class="h-11 px-3 text-gray-600" />
                            </div>

                            <!-- Toggle -->
                            <div class="col-span-2 mt-2">
                                <div
                                    class="flex items-center justify-between bg-gray-50 p-4 rounded-md border border-gray-200">
                                    <div>
                                        <div class="text-sm font-medium text-brand-dark">Is this person the General
                                            Manager?</div>
                                        <div class="text-xs text-gray-500 mt-1">Enable this if the individual holds the
                                            GM position for the entity.</div>
                                    </div>
                                    <div
                                        class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="toggle" id="toggle-gm-1"
                                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300" />
                                        <label for="toggle-gm-1"
                                            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Identification Details -->
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Identification
                            Details
                        </h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <x-input.select id="bm-id-type-1" label="Identification Type" required placeholder="Select ID type" class="h-11 px-3">
                                    <option value="passport">Passport</option>
                                    <option value="national_id">National ID</option>
                                    <option value="drivers_license">Driver's License</option>
                                </x-input.select>
                            </div>
                            <div>
                                <x-input.text id="bm-id-number-1" label="Identification Number" required placeholder="Enter ID number"
                                    class="h-11 px-3" />
                            </div>
                            <div>
                                <x-input.date id="bm-id-expiry-1" label="ID Expiry Date" required class="h-11 px-3 text-gray-600" />
                            </div>
                            <div>
                                <x-input.select id="bm-issue-country-1" label="Country of Issue" required placeholder="Select country" class="h-11 px-3">
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                </x-input.select>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Residential Address -->
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Residential Address
                        </h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div class="col-span-2">
                                <x-input.text id="bm-address-line1-1" label="Address Line 1" required
                                    placeholder="Street address, P.O. box" class="h-11 px-3" />
                            </div>
                            <div class="col-span-2">
                                <label for="bm-address-line2-1" class="block text-sm font-medium text-gray-700 mb-1.5">Address Line 2 <span
                                    class="text-gray-400 text-xs font-normal">(optional)</span></label>
                                <x-input.text id="bm-address-line2-1" placeholder="Apartment, suite, unit, building, floor"
                                    class="h-11 px-3" />
                            </div>
                            <div>
                                <x-input.text id="bm-city-1" label="City" required placeholder="Enter city" class="h-11 px-3" />
                            </div>
                            <div>
                                <x-input.text id="bm-postal-1" label="Postal Code" required placeholder="Enter postal code"
                                    class="h-11 px-3" />
                            </div>
                            <div class="col-span-2">
                                <x-input.select id="bm-country-1" label="Country" required placeholder="Select country" class="h-11 px-3">
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="CA">Canada</option>
                                </x-input.select>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Document Uploads -->
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Document Uploads</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Identity <span
                                        class="text-red-500">*</span></label>
                                <div
                                    class="upload-zone border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brand-blue transition-colors cursor-pointer bg-gray-50">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span
                                            class="text-brand-blue font-medium">browse</span></p>
                                    <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                                    <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Address <span
                                        class="text-red-500">*</span></label>
                                <div
                                    class="upload-zone border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brand-blue transition-colors cursor-pointer bg-gray-50">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span
                                            class="text-brand-blue font-medium">browse</span></p>
                                    <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                                    <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="text-center mb-8 mt-4">
            <button type="button" id="add-bo-btn"
                class="inline-flex items-center gap-2 px-8 py-2.5 border border-brand-accent text-brand-accent bg-white hover:bg-blue-50 font-medium rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Add Another Board Member</span>
            </button>
        </div>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-brand-border px-12 py-4 z-30">
            <div class="max-w-[900px] mx-auto flex items-center justify-between">
                <a href="{{ route('merchant.kyc.beneficialOwners') }}"
                    class="px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-4">
                    <button onclick="saveDraft()"
                        class="px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="fa-regular fa-floppy-disk text-sm"></i>
                        <span>Save as Draft</span>
                    </button>

                    <a href="{{ route('merchant.kyc.contactPerson') }}"
                        class="px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover text-white font-semibold rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <span>Continue to Contact Person</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
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
            let bmCount = 1;
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
                const template = document.querySelector('.board-member-card');
                const clone = template.cloneNode(true);

                clone.setAttribute('data-bm-index', index);
                clone.querySelector('h3').textContent = `Board Member #${index}`;

                const resetUploadZone = (zone) => {
                    zone.classList.remove('bg-green-50', 'border-green-300');
                    zone.innerHTML = `
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span class="text-brand-blue font-medium">browse</span></p>
                        <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                        <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                    `;
                };

                const inputs = clone.querySelectorAll('input');
                inputs.forEach(input => {
                    const oldId = input.id;
                    if (oldId) {
                        const base = oldId.replace(/-\d+$/, '');
                        const newId = `${base}-${index}`;
                        input.id = newId;
                        const relatedLabel = clone.querySelector(`label[for="${oldId}"]`);
                        if (relatedLabel) relatedLabel.setAttribute('for', newId);
                    }

                    if (input.type === 'checkbox') {
                        input.checked = false;
                    } else if (input.type === 'file') {
                        input.value = '';
                    } else {
                        input.value = '';
                    }

                    input.classList.remove('error-field');
                });

                const selects = clone.querySelectorAll('select');
                selects.forEach(select => {
                    const oldId = select.id;
                    if (oldId) {
                        const base = oldId.replace(/-\d+$/, '');
                        const newId = `${base}-${index}`;
                        select.id = newId;
                        const relatedLabel = clone.querySelector(`label[for="${oldId}"]`);
                        if (relatedLabel) relatedLabel.setAttribute('for', newId);
                    }
                    select.selectedIndex = 0;
                    select.classList.remove('error-field');
                });

                clone.querySelectorAll('.upload-zone').forEach(resetUploadZone);

                return clone;
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
                });
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

            function saveDraft() {
                showToast('Your progress has been saved.', 'success');
            }
        </script>
    @endpush
</x-merchant.kyc>