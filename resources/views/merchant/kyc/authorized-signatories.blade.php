@extends('layouts.html')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized Signatories - 2iZii Admin Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2D3A74',
                        accent: '#FFA439',
                        success: '#28A745',
                        neutral: '#F7F8FA',
                        'accent-light': '#FFF4E5',
                        'accent-border': '#FF9900',
                        'gray-step': '#BFC4CC'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F8FA; }
        /* Custom scrollbar for main content */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #D1D5DB; }
        
        /* Checkbox/Radio custom styles */
        .custom-checkbox:checked {
            background-color: #2D3A74;
            border-color: #2D3A74;
        }
    </style>
@endsection

@section('body')
<body class="text-primary h-screen flex overflow-hidden">

    <x-merchant.kyc-stepper :active="8" />

    <!-- MAIN CONTENT AREA -->
    <main id="main-content" class="flex-1 h-full overflow-y-auto bg-neutral relative">
        <div class="max-w-5xl mx-auto p-8 pb-24">
            
            <!-- HEADER -->
            <header id="page-header" class="mb-8">
                <h1 class="text-2xl font-semibold text-primary mb-2">Authorized Signatories</h1>
                <p class="text-slate-500 text-sm">Provide details of individuals legally authorized to sign agreements on behalf of the company.</p>
            </header>

            <!-- INFO BANNER -->
            <div id="info-banner" class="mb-8 bg-accent-light border-l-4 border-accent-border p-4 rounded-r-md flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-accent-border mt-0.5"></i>
                <p class="text-sm text-slate-700 font-medium">Acquirers require details of individuals with legal signing authority for compliance verification.</p>
            </div>

            <!-- ADD BUTTON -->
            <div class="mb-6">
                <button class="flex items-center gap-2 px-4 py-2.5 border border-primary text-primary rounded-md text-sm font-medium hover:bg-primary/5 transition-colors">
                    <i class="fa-solid fa-plus"></i>
                    Add Authorized Signatory
                </button>
            </div>

            <!-- SIGNATORY CARD 1 -->
            <section id="signatory-card-1" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                
                <!-- Card Header -->
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-slate-800">Authorized Signatory #1</h2>
                    <button class="text-slate-400 hover:text-red-500 transition-colors" title="Remove Signatory">
                        <i class="fa-regular fa-trash-can text-lg"></i>
                    </button>
                </div>

                <!-- SECTION A: PERSONAL INFO -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Personal Information</h3>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <!-- First Name -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">First Name*</label>
                            <input type="text" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="e.g. John">
                        </div>
                        <!-- Last Name -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Last Name*</label>
                            <input type="text" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="e.g. Doe">
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address*</label>
                            <input type="email" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="john.doe@company.com">
                        </div>
                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number*</label>
                            <input type="tel" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="+1 234 567 8900">
                        </div>
                        <!-- DOB -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Date of Birth*</label>
                            <div class="relative">
                                <input type="date" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm text-slate-600">
                            </div>
                        </div>
                        <!-- Nationality -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nationality*</label>
                            <div class="relative">
                                <select class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select nationality</option>
                                    <option value="US">United States</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="CA">Canada</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION B: ROLE & AUTHORIZATION -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Role & Authorization Details</h3>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Role in Company*</label>
                            <div class="relative">
                                <select class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select role</option>
                                    <option>Director</option>
                                    <option>Legal Representative</option>
                                    <option>Managing Director</option>
                                    <option>Owner</option>
                                    <option>Other</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Start Date in Role*</label>
                            <input type="date" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm text-slate-600">
                        </div>

                        <!-- Authorization Type -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Authorization Type*</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center space-x-2 cursor-pointer p-2 border border-gray-200 rounded hover:bg-slate-50 transition-colors">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4">
                                    <span class="text-sm text-slate-700">Sole Signatory</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer p-2 border border-gray-200 rounded hover:bg-slate-50 transition-colors">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4">
                                    <span class="text-sm text-slate-700">Joint Signatory</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer p-2 border border-gray-200 rounded hover:bg-slate-50 transition-colors">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4">
                                    <span class="text-sm text-slate-700">Limited Authority</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer p-2 border border-gray-200 rounded hover:bg-slate-50 transition-colors">
                                    <input type="checkbox" class="rounded text-primary focus:ring-primary border-gray-300 w-4 h-4">
                                    <span class="text-sm text-slate-700">Power of Attorney</span>
                                </label>
                            </div>
                        </div>

                        <!-- Is Beneficial Owner -->
                        <div class="col-span-2 flex items-center justify-between p-3 bg-slate-50 rounded border border-gray-100">
                            <div>
                                <span class="text-sm font-medium text-slate-700">Is this person also a Beneficial Owner?</span>
                                <p class="text-xs text-slate-500 mt-0.5">If yes, their information will be linked to the Beneficial Owners section.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- SECTION C: IDENTIFICATION DETAILS -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Identification Details</h3>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <!-- ID Type -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Identification Type*</label>
                            <div class="relative">
                                <select class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select ID Type</option>
                                    <option>Passport</option>
                                    <option>National ID Card</option>
                                    <option>Driver's License</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ID Number -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Identification Number*</label>
                            <input type="text" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="ID Number">
                        </div>
                        <!-- Expiry -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">ID Expiry Date*</label>
                            <input type="date" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm text-slate-600">
                        </div>
                        <!-- Country of Issue -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Country of Issue*</label>
                            <div class="relative">
                                <select class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select Country</option>
                                    <option>United States</option>
                                    <option>United Kingdom</option>
                                    <option>France</option>
                                    <option>Germany</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION D: RESIDENTIAL ADDRESS -->
                <div class="mb-8">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Residential Address</h3>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Address 1 -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Address Line 1*</label>
                            <input type="text" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="Street address, P.O. box">
                        </div>
                        <!-- Address 2 -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Address Line 2</label>
                            <input type="text" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="Apartment, suite, unit, building, floor, etc.">
                        </div>
                        <!-- City -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">City*</label>
                            <input type="text" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="e.g. New York">
                        </div>
                        <!-- Postal Code -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Postal Code*</label>
                            <input type="text" class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm" placeholder="e.g. 10001">
                        </div>
                        <!-- Country -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Country*</label>
                            <div class="relative">
                                <select class="w-full h-10 px-3 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-sm bg-white appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select Country</option>
                                    <option>United States</option>
                                    <option>United Kingdom</option>
                                    <option>Canada</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION E: DOCUMENT UPLOADS -->
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Document Uploads</h3>
                    
                    <!-- Upload Area -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-primary transition-colors cursor-pointer bg-slate-50/50">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-3"></i>
                        <p class="text-sm font-medium text-slate-700 mb-1">Click to upload or drag and drop</p>
                        <p class="text-xs text-slate-500">ID Document, Proof of Address, Authorization Document, Signature Specimen</p>
                        <p class="text-xs text-slate-400 mt-2">PDF, PNG, JPG up to 10MB</p>
                    </div>

                    <!-- Uploaded Files Preview (Example) -->
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-file-pdf text-red-500"></i>
                                <div>
                                    <p class="text-sm font-medium text-slate-700">passport_john_doe.pdf</p>
                                    <p class="text-xs text-slate-500">2.4 MB</p>
                                </div>
                            </div>
                            <button class="text-slate-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </section>
            <!-- END SIGNATORY CARD 1 -->

        </div>

        <!-- FOOTER BUTTON ROW -->
        <footer id="footer" class="fixed bottom-0 right-0 w'[calc(100%-260px)] bg-white border-t border-gray-200 px-8 py-4 z-30">
            <div class="max-w-5xl mx-auto flex justify-between items-center">
                <a href="{{ route('merchant.kyc.bankInformation') }}" class="flex items-center gap-2 text-primary text-sm font-medium hover:underline">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>
                <div class="flex items-center gap-3">
                    <button class="px-6 py-2.5 border border-accent text-accent rounded-md text-sm font-medium hover:bg-accent/5 transition-colors">
                        Save Draft
                    </button>
                    <a href="{{ route('merchant.kyc.review') }}" class="px-6 py-2.5 bg-accent text-white rounded-md text-sm font-medium hover:bg-accent/90 transition-colors flex items-center gap-2">
                        Continue to Review & Submit
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </footer>

    </main>

</body>
@endsection

