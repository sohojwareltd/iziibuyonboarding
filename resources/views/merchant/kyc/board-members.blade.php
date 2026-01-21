@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Board Members / General Manager - 2iZii Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        window.FontAwesomeConfig = { autoReplaceSvg: 'nest' };
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#2D3A74',
                            blue: '#4055A8',
                            orange: '#FFA439',
                            orangeDark: '#E68A00',
                            alert: '#FF9900',
                            bg: '#F7F8FA',
                            success: '#28A745',
                            text: '#2D3A74',
                            subtext: '#6A6A6A',
                            border: '#D1D5DB'
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F8FA; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E0; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #A0AEC0; }
        .toggle-checkbox:checked { right: 0; border-color: #28A745; }
        .toggle-checkbox:checked + .toggle-label { background-color: #28A745; }
    </style>
@endsection

@section('body')
<body class="text-primary h-screen flex overflow-hidden">

    <x-merchant.kyc-stepper :active="3" />

    <!-- MAIN CONTENT AREA -->
    <main id="main-content" class="flex-1 overflow-y-auto bg-brand-bg relative">
        <div class="max-w-[1000px] mx-auto px-8 py-10 pb-32">
            
            <!-- Header Section -->
            <header id="page-header" class="mb-8">
                <h1 class="text-2xl font-semibold text-brand-dark mb-2">Board Members / General Manager</h1>
                <p class="text-gray-600 text-sm">Provide details of individuals responsible for running the company (Directors, Board Members, or General Manager).</p>
            </header>

            <!-- Alert Banner -->
            <div id="alert-banner" class="bg-[#FFF4E5] border-l-4 border-brand-alert p-4 mb-8 rounded-r-md flex items-start shadow-sm">
                <div class="text-brand-alert mt-0.5 mr-3">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="text-sm text-gray-700 leading-relaxed">
                    <span class="font-semibold">Requirement:</span> Please ensure that you list all active board members as they appear in your official company registration documents. At least one entry is required.
                </div>
            </div>

            <!-- Board Member Card -->
            <div id="board-member-card-1" class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                
                <!-- Card Header -->
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-brand-dark">Board Member #1</h2>
                    <button class="text-gray-400 hover:text-red-500 transition-colors cursor-pointer" title="Delete Board Member">
                        <i class="fa-regular fa-trash-can text-lg"></i>
                    </button>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    
                    <!-- Section: Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">First Name <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="Enter first name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="Enter last name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Date of Birth <span class="text-red-500">*</span></label>
                                <input type="date" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm text-gray-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nationality <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm appearance-none bg-white">
                                        <option value="" disabled selected>Select nationality</option>
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="CA">Canada</option>
                                    </select>
                                    <div class="absolute right-3 top-3.5 text-gray-400 pointer-events-none">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address <span class="text-gray-400 text-xs font-normal">(optional)</span></label>
                                <input type="email" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="example@company.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number <span class="text-gray-400 text-xs font-normal">(optional)</span></label>
                                <input type="tel" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Role Information -->
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Role Information</h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Position in Company <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="e.g. Director">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Date in Role <span class="text-red-500">*</span></label>
                                <input type="date" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm text-gray-600">
                            </div>
                            
                            <!-- Toggle -->
                            <div class="col-span-2 mt-2">
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-md border border-gray-200">
                                    <div>
                                        <div class="text-sm font-medium text-brand-dark">Is this person the General Manager?</div>
                                        <div class="text-xs text-gray-500 mt-1">Enable this if the individual holds the GM position for the entity.</div>
                                    </div>
                                    <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                        <input type="checkbox" name="toggle" id="toggle-gm" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300"/>
                                        <label for="toggle-gm" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Identification Details -->
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Identification Details</h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Identification Type <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm appearance-none bg-white">
                                        <option value="" disabled selected>Select ID type</option>
                                        <option value="passport">Passport</option>
                                        <option value="national_id">National ID</option>
                                        <option value="drivers_license">Driver's License</option>
                                    </select>
                                    <div class="absolute right-3 top-3.5 text-gray-400 pointer-events-none">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Identification Number <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="Enter ID number">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">ID Expiry Date <span class="text-red-500">*</span></label>
                                <input type="date" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm text-gray-600">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Country of Issue <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm appearance-none bg-white">
                                        <option value="" disabled selected>Select country</option>
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                    </select>
                                    <div class="absolute right-3 top-3.5 text-gray-400 pointer-events-none">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Residential Address -->
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Residential Address</h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Address Line 1 <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="Street address, P.O. box">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Address Line 2 <span class="text-gray-400 text-xs font-normal">(optional)</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="Apartment, suite, unit, building, floor">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">City <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="Enter city">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Postal Code <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm" placeholder="Enter postal code">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Country <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select class="w-full h-11 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-all text-sm appearance-none bg-white">
                                        <option value="" disabled selected>Select country</option>
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="CA">Canada</option>
                                    </select>
                                    <div class="absolute right-3 top-3.5 text-gray-400 pointer-events-none">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Document Uploads -->
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Document Uploads</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Identity <span class="text-red-500">*</span></label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brand-blue transition-colors cursor-pointer bg-gray-50">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span class="text-brand-blue font-medium">browse</span></p>
                                    <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Proof of Address <span class="text-red-500">*</span></label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-brand-blue transition-colors cursor-pointer bg-gray-50">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 mb-1">Drag and drop files here or <span class="text-brand-blue font-medium">browse</span></p>
                                    <p class="text-xs text-gray-400">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Add Another Board Member Button -->
            <button class="flex items-center gap-2 text-brand-orange font-medium text-sm hover:text-brand-orangeDark transition-colors">
                <i class="fa-solid fa-plus"></i>
                <span>Add Another Board Member</span>
            </button>

        </div>

        <!-- Footer Button Bar -->
        <footer id="footer" class="fixed bottom-0 right-0 w-[calc(100%-260px)] bg-white border-t border-gray-200 px-10 py-4 z-30">
            <div class="max-w-[1000px] mx-auto flex items-center justify-between">
                <a href="{{ route('merchant.kyc.beneficialOwners') }}" class="text-brand-dark text-sm font-medium hover:underline flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Back</span>
                </a>
                <div class="flex items-center gap-4">
                    <button class="h-11 px-6 border-2 border-brand-orange text-brand-orange font-medium rounded-md hover:bg-orange-50 transition-colors text-sm">
                        Save Draft
                    </button>
                    <a href="{{ route('merchant.kyc.contactPerson') }}" class="h-11 px-6 bg-brand-orange text-white font-medium rounded-md hover:bg-brand-orangeDark transition-colors text-sm flex items-center gap-2">
                        <span>Continue to Contact Person</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </footer>
    </main>

</body>
@endsection

