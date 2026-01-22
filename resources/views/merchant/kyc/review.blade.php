
<x-merchant.kyc>
    @push('css')
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }

            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }

            .sidebar-item {
                transition: all 0.2s ease;
            }

            .accordion-content {
                transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
                max-height: 0;
                opacity: 0;
                overflow: hidden;
            }

            .accordion-content.expanded {
                max-height: 2000px;
                opacity: 1;
            }

            .chevron-icon {
                transition: transform 0.3s ease;
            }

            .chevron-icon.rotated {
                transform: rotate(180deg);
            }
        </style>
    @endpush

    <!-- 1. Header Section -->
    <section id="header-section" class="mb-4">
        <h1 class="text-2xl font-semibold text-primary mb-2">Review & Submit</h1>
        <p class="text-gray-500">Review all the information you have provided. Confirm accuracy before
            submitting your application to the acquirer(s).</p>
    </section>

    <form id="kyc-form" action="" method="POST" onsubmit="handleFormSubmit(event)">

        <!-- 2. Accordion List Section -->
        <section id="review-cards-section" class="space-y-4">

            <!-- Card 1: Company Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden accordion-item">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 cursor-pointer hover:bg-gray-50 transition-colors accordion-header"
                    onclick="toggleAccordion(this)">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-base sm:text-lg">Company Information</h3>
                        <span class="text-xs sm:text-sm text-gray-400 font-normal truncate"> | TechFlow Solutions
                            Ltd.</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 chevron-icon flex-shrink-0"></i>
                </div>
                <div class="accordion-content border-t border-gray-100 bg-white relative">
                    <button type="button" class="edit-btn absolute top-4 sm:top-6 right-4 sm:right-6 border border-accent text-accent hover:bg-orange-50 text-xs font-medium px-2 sm:px-3 py-1.5 rounded transition-colors" data-route="{{ route('merchant.kyc.company') }}">
                        <i class="fa-solid fa-pen mr-1 hidden sm:inline"></i> Edit
                    </button>
                    <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 sm:gap-y-6 gap-x-4 sm:gap-x-8 pt-12 sm:pt-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Company
                                Name</label>
                            <div class="text-sm text-gray-900">TechFlow Solutions Ltd.</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Registration
                                Number</label>
                            <div class="text-sm text-gray-900">HE 123456</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Date of
                                Incorporation</label>
                            <div class="text-sm text-gray-900">15 March 2018</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Country of
                                Incorporation</label>
                            <div class="text-sm text-gray-900">Cyprus</div>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Registered
                                Address</label>
                            <div class="text-sm text-gray-900">123 Innovation Avenue, Tech Park Building A, 4th
                                Floor, 2023 Nicosia, Cyprus</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Beneficial Owners -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden accordion-item">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 cursor-pointer hover:bg-gray-50 transition-colors accordion-header"
                    onclick="toggleAccordion(this)">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-base sm:text-lg">Beneficial Owners</h3>
                        <span class="text-xs sm:text-sm text-gray-400 font-normal truncate"> | 2 Owners
                            Listed</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 chevron-icon flex-shrink-0"></i>
                </div>
                <div class="accordion-content border-t border-gray-100 bg-white relative">
                    <button type="button" class="edit-btn absolute top-4 sm:top-6 right-4 sm:right-6 border border-accent text-accent hover:bg-orange-50 text-xs font-medium px-2 sm:px-3 py-1.5 rounded transition-colors" data-route="{{ route('merchant.kyc.beneficialOwners') }}">
                        <i class="fa-solid fa-pen mr-1 hidden sm:inline"></i> Edit
                    </button>
                    <div class="p-4 sm:p-6 space-y-4 sm:space-y-6 pt-12 sm:pt-6">
                        <div class="bg-gray-50 p-4 rounded border border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full
                                        Name</label>
                                    <div class="text-sm text-gray-900 font-medium">Alexander Smith</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ownership
                                        %</label>
                                    <div class="text-sm text-gray-900">60%</div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase mb-1">Nationality</label>
                                    <div class="text-sm text-gray-900">British</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">PEP
                                        Status</label>
                                    <div class="text-sm text-gray-900">No</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded border border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full
                                        Name</label>
                                    <div class="text-sm text-gray-900 font-medium">Maria Garcia</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ownership
                                        %</label>
                                    <div class="text-sm text-gray-900">40%</div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase mb-1">Nationality</label>
                                    <div class="text-sm text-gray-900">Spanish</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">PEP
                                        Status</label>
                                    <div class="text-sm text-gray-900">No</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Contact Person -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden accordion-item">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 cursor-pointer hover:bg-gray-50 transition-colors accordion-header"
                    onclick="toggleAccordion(this)">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-base sm:text-lg">Contact Person</h3>
                        <span class="text-xs sm:text-sm text-gray-400 font-normal truncate"> | John Doe</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 chevron-icon flex-shrink-0"></i>
                </div>
                <div class="accordion-content border-t border-gray-100 bg-white relative">
                    <button type="button" class="edit-btn absolute top-4 sm:top-6 right-4 sm:right-6 border border-accent text-accent hover:bg-orange-50 text-xs font-medium px-2 sm:px-3 py-1.5 rounded transition-colors" data-route="{{ route('merchant.kyc.contactPerson') }}">
                        <i class="fa-solid fa-pen mr-1 hidden sm:inline"></i> Edit
                    </button>
                    <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 sm:gap-y-6 gap-x-4 sm:gap-x-8 pt-12 sm:pt-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full
                                Name</label>
                            <div class="text-sm text-gray-900">John Doe</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Position</label>
                            <div class="text-sm text-gray-900">Chief Financial Officer</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                            <div class="text-sm text-gray-900">john.doe@techflow.com</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone
                                Number</label>
                            <div class="text-sm text-gray-900">+357 99 123 456</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Purpose & Sales -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden accordion-item">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 cursor-pointer hover:bg-gray-50 transition-colors accordion-header"
                    onclick="toggleAccordion(this)">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-base sm:text-lg">Purpose & Sales</h3>
                        <span class="text-xs sm:text-sm text-gray-400 font-normal truncate"> | Software
                            Development</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 chevron-icon flex-shrink-0"></i>
                </div>
                <div class="accordion-content border-t border-gray-100 bg-white relative">
                    <button type="button" class="edit-btn absolute top-4 sm:top-6 right-4 sm:right-6 border border-accent text-accent hover:bg-orange-50 text-xs font-medium px-2 sm:px-3 py-1.5 rounded transition-colors" data-route="{{ route('merchant.kyc.purposeOfService') }}">
                        <i class="fa-solid fa-pen mr-1 hidden sm:inline"></i> Edit
                    </button>
                    <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 sm:gap-y-6 gap-x-4 sm:gap-x-8 pt-12 sm:pt-6">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Business
                                Activities</label>
                            <div class="text-sm text-gray-900">Development and licensing of SaaS products for
                                financial institutions.</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Annual
                                Turnover</label>
                            <div class="text-sm text-gray-900">€2,000,000 - €5,000,000</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sales
                                Channels</label>
                            <ul class="text-sm text-gray-900 list-disc list-inside">
                                <li>Direct Sales Website</li>
                                <li>Partner Resellers</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5: Bank Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden accordion-item">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 cursor-pointer hover:bg-gray-50 transition-colors accordion-header"
                    onclick="toggleAccordion(this)">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-base sm:text-lg">Bank Information</h3>
                        <span class="text-xs sm:text-sm text-gray-400 font-normal truncate"> | Bank of
                            Cyprus</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 chevron-icon flex-shrink-0"></i>
                </div>
                <div class="accordion-content border-t border-gray-100 bg-white relative">
                    <button type="button" class="edit-btn absolute top-4 sm:top-6 right-4 sm:right-6 border border-accent text-accent hover:bg-orange-50 text-xs font-medium px-2 sm:px-3 py-1.5 rounded transition-colors" data-route="{{ route('merchant.kyc.bankInformation') }}">
                        <i class="fa-solid fa-pen mr-1 hidden sm:inline"></i> Edit
                    </button>
                    <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 sm:gap-y-6 gap-x-4 sm:gap-x-8 pt-12 sm:pt-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Bank
                                Name</label>
                            <div class="text-sm text-gray-900">Bank of Cyprus</div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Currency</label>
                            <div class="text-sm text-gray-900">EUR</div>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">IBAN</label>
                            <div class="text-sm text-gray-900 font-mono">CY12 0020 0123 4567 8901 2345 6789
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 6: Documents Uploaded -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden accordion-item">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 cursor-pointer hover:bg-gray-50 transition-colors accordion-header"
                    onclick="toggleAccordion(this)">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-base sm:text-lg">Documents Uploaded</h3>
                        <span class="text-xs sm:text-sm text-gray-400 font-normal truncate"> | 5 Files</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 chevron-icon flex-shrink-0"></i>
                </div>
                <div class="accordion-content border-t border-gray-100 bg-white relative">
                    <button type="button" class="edit-btn absolute top-4 sm:top-6 right-4 sm:right-6 border border-accent text-accent hover:bg-orange-50 text-xs font-medium px-2 sm:px-3 py-1.5 rounded transition-colors" data-route="{{ route('merchant.kyc.bankInformation') }}">
                        <i class="fa-solid fa-pen mr-1 hidden sm:inline"></i> Edit
                    </button>
                    <div class="p-4 sm:p-6 mt-8 sm:mt-0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                            <div
                                class="flex items-start p-3 border border-gray-100 rounded-lg hover:shadow-sm transition-shadow bg-gray-50">
                                <div class="text-red-500 text-2xl mr-3"><i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">Certificate_Inc.pdf
                                    </p>
                                    <p class="text-xs text-gray-500">2.4 MB • 12 Jan 2024</p>
                                    <a href="#"
                                        class="text-xs text-primary hover:underline mt-1 inline-block">View
                                        Document</a>
                                </div>
                            </div>
                            <div
                                class="flex items-start p-3 border border-gray-100 rounded-lg hover:shadow-sm transition-shadow bg-gray-50">
                                <div class="text-blue-500 text-2xl mr-3"><i class="fa-solid fa-file-image"></i></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">Passport_Smith.jpg
                                    </p>
                                    <p class="text-xs text-gray-500">1.8 MB • 12 Jan 2024</p>
                                    <a href="#"
                                        class="text-xs text-primary hover:underline mt-1 inline-block">View
                                        Document</a>
                                </div>
                            </div>
                            <div
                                class="flex items-start p-3 border border-gray-100 rounded-lg hover:shadow-sm transition-shadow bg-gray-50">
                                <div class="text-red-500 text-2xl mr-3"><i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">Bank_Statement.pdf
                                    </p>
                                    <p class="text-xs text-gray-500">3.1 MB • 13 Jan 2024</p>
                                    <a href="#"
                                        class="text-xs text-primary hover:underline mt-1 inline-block">View
                                        Document</a>
                                </div>
                            </div>
                            <div
                                class="flex items-start p-3 border border-gray-100 rounded-lg hover:shadow-sm transition-shadow bg-gray-50">
                                <div class="text-blue-500 text-2xl mr-3"><i class="fa-solid fa-file-image"></i></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">Passport_Garcia.png
                                    </p>
                                    <p class="text-xs text-gray-500">2.2 MB • 13 Jan 2024</p>
                                    <a href="#"
                                        class="text-xs text-primary hover:underline mt-1 inline-block">View
                                        Document</a>
                                </div>
                            </div>
                            <div
                                class="flex items-start p-3 border border-gray-100 rounded-lg hover:shadow-sm transition-shadow bg-gray-50">
                                <div class="text-red-500 text-2xl mr-3"><i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        Articles_Association.pdf</p>
                                    <p class="text-xs text-gray-500">1.5 MB • 14 Jan 2024</p>
                                    <a href="#"
                                        class="text-xs text-primary hover:underline mt-1 inline-block">View
                                        Document</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- 3. Declaration Section -->
        <section id="declaration-section" class="bg-white mt-4 rounded-lg shadow-sm border border-gray-100 p-6">
            <div class="flex items-start gap-3">
                <input type="checkbox" id="declaration-checkbox"
                    class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent focus:ring-2 mt-0.5 cursor-pointer">
                <div>
                    <label for="declaration-checkbox"
                        class="text-sm font-medium text-gray-900 cursor-pointer block mb-1">
                        I confirm that all information provided is accurate and complete to the best of my
                        knowledge.
                    </label>
                    <p class="text-xs text-gray-500">
                        Submitting false or misleading information may delay or impact the approval process.
                    </p>
                </div>
            </div>
        </section>

        <footer id="footer"
            class="fixed bottom-0 right-0 w-full md:w-[calc(100%-260px)] bg-white border-t border-brand-border px-4 sm:px-6 md:px-12 py-3 sm:py-4 z-30">
            <div class="max-w-[900px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('merchant.kyc.authorizedSignatories') }}"
                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 border border-brand-dark text-brand-dark bg-white hover:bg-gray-50 font-medium text-sm sm:text-base rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                    <span>Back</span>
                </a>

                <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                    <button onclick="saveDraft()"
                        class="flex-1 sm:flex-none px-3 sm:px-6 py-2.5 border border-brand-orange text-brand-orange bg-white hover:bg-orange-50 font-medium text-xs sm:text-sm rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fa-regular fa-floppy-disk text-sm hidden sm:inline"></i>
                        <span>Draft</span>
                    </button>

                    <button id="submit-btn" type="submit"
                        class="flex-1 sm:flex-none px-3 sm:px-8 py-2.5 bg-brand-orange hover:bg-brand-orangeHover disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold text-xs sm:text-base rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                        disabled>
                        <span>Submit</span>
                        <i class="fa-solid fa-arrow-right text-sm hidden sm:inline"></i>
                    </button>
                </div>
            </div>
        </footer>
    </form>

    @push('js')
        <script>
            function toggleAccordion(header) {
                const content = header.nextElementSibling;
                const chevron = header.querySelector('.chevron-icon');
                const allItems = document.querySelectorAll('.accordion-item');

                allItems.forEach(item => {
                    const itemContent = item.querySelector('.accordion-content');
                    const itemChevron = item.querySelector('.chevron-icon');
                    if (itemContent !== content) {
                        itemContent.classList.remove('expanded');
                        itemChevron.classList.remove('rotated');
                    }
                });

                content.classList.toggle('expanded');
                chevron.classList.toggle('rotated');
            }

            window.addEventListener('load', function() {
                const firstAccordion = document.querySelector('.accordion-header');
                if (firstAccordion) {
                    toggleAccordion(firstAccordion);
                }
            });

            const checkbox = document.getElementById('declaration-checkbox');
            const submitBtn = document.getElementById('submit-btn');

            checkbox.addEventListener('change', function() {
                submitBtn.disabled = !this.checked;
            });

            // Setup Edit Button Handlers
            function setupEditButtons() {
                const editButtons = document.querySelectorAll('.edit-btn');
                editButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const route = this.getAttribute('data-route');
                        if (route) {
                            window.location.href = route;
                        }
                    });
                });
            }

            // Handle Form Submission
            function handleFormSubmit(event) {
                if (!checkbox || !checkbox.checked) {
                    event.preventDefault();
                    alert('Please confirm that all information is accurate and complete before submitting.');
                    return false;
                }
                return true;
            }

            // Save Draft Function
            function saveDraft() {
                const formData = new FormData(document.getElementById('kyc-form'));
                const data = Object.fromEntries(formData);
                
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    showNotification('Your progress has been saved as draft.', 'success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to save draft. Please try again.', 'error');
                });
            }

            // Show Notification
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } z-50`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            // Setup edit buttons on load
            window.addEventListener('load', function() {
                setupEditButtons();
            });
        </script>
    @endpush
</x-merchant.kyc>
