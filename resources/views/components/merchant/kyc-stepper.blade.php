@props([
    'active' => null,
    'kycLink' => null,
])

@php
    use App\Models\KycSection;
    use App\Models\KYCFieldMaster;

    $kycLink = $kycLink ?? request()->route('kyc_link');

    // Fetch all active KYC sections with their fields, sorted by sort_order
    $kycSections = KycSection::where('status', 'active')
        ->with(['kycFields' => function ($query) {
            $query->where('status', 'active')->orderBy('sort_order');
        }])
        ->orderBy('sort_order')
        ->get();

    // Map section slugs to actual route names
    $slugToRouteMap = [
        'company-information' => 'company',
        'beneficial-owners' => 'beneficialOwners',
        'board-members-gm' => 'boardMembers',
        'contact-person' => 'contactPerson',
        'purpose-of-service' => 'purposeOfService',
        'sales-channels' => 'salesChannels',
        'bank-information' => 'bankInformation',
        'authorized-signatories' => 'authorizedSignatories',
        'review' => 'review',
    ];

    // Build steps array from database
    $steps = [];
    $routeStepMap = [];
    
    foreach ($kycSections as $index => $section) {
        $stepNumber = $index + 1;
        $steps[$stepNumber] = $section->name;
        // Map route names using slug mapping
        $routeName = $slugToRouteMap[$section->slug] ?? null;
        if ($routeName) {
            $routeStepMap['merchant.kyc.' . $routeName] = $stepNumber;
        }
    }

    $stepRoutes = array_flip($routeStepMap);

    // Auto-detect active step from current route if not provided
    if ($active === null) {
        $currentRoute = Route::currentRouteName();
        $active = $routeStepMap[$currentRoute] ?? 1;
    }
@endphp

<aside id="kyc-sidebar" class="fixed md:relative -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex w-[280px] md:w-[260px] bg-white border-r border-gray-200 flex-col h-full overflow-y-auto shrink-0 z-50 md:z-20 shadow-2xl md:shadow-sm">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
        <div class="text-primary text-xl font-bold tracking-tight">2iZii <span class="font-light text-slate-400">Admin</span></div>
        <button id="mobile-close-btn" class="md:hidden text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>
    
    <nav class="flex-1 py-6">
        <ul class="space-y-0">
            @foreach($steps as $num => $label)
                @php
                    $isActive = $active === $num;
                    $isCompleted = $num < $active;
                    $routeName = $stepRoutes[$num] ?? null;
                    $routeParams = $routeName ? ['kyc_link' => $kycLink] : [];
                    // Get the section and its fields
                    $section = $kycSections[$num - 1] ?? null;
                    $fields = $section ? $section->kycFields : collect();
                    $fieldList = $fields->pluck('field_name')->implode(', ');
                @endphp
                <li class="relative group {{ $isActive ? 'bg-orange-50/50 border-l-4 border-accent' : '' }}">
                    <a href="{{ $routeName ? route($routeName, $routeParams) : '#' }}" class="flex items-center {{ $isActive ? 'px-5' : 'px-6' }} py-3 text-sm font-medium {{ $isActive ? 'text-slate-900' : 'text-slate-600' }} focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-white" title="{{ $fieldList ? 'Fields: ' . $fieldList : '' }}">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full {{ $isCompleted ? 'bg-green-100 text-success' : ($isActive ? 'bg-white border border-gray-step flex h-6 items-center justify-center mr-3 rounded-full text-gray-step text-xs w-6' : 'border border-gray-step text-gray-step bg-white') }} mr-3 text-xs">
                            @if($isCompleted)
                                <i class="fa-solid fa-check text-xs"></i>
                            @else
                                {{ $num }}
                            @endif
                        </span>
                        <span>{{ $label }}</span>
                    </a>
                    @if($fieldList && count($fields) > 0)
                        <div class="hidden group-hover:block absolute left-full ml-2 top-0 bg-slate-900 text-white text-xs rounded-lg p-3 w-48 z-10 pointer-events-none whitespace-normal">
                            <p class="font-semibold mb-2">Fields:</p>
                            <ul class="space-y-1">
                                @foreach($fields as $field)
                                    <li class="text-xs">{{ $field->field_name }}
                                        @if($field->is_required)
                                            <span class="text-red-400">*</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
    
    <div class="p-6 border-t border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold">
                AD
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-700">Admin User</p>
                <p class="text-[10px] text-slate-500">admin@2izii.com</p>
            </div>
        </div>
    </div>
</aside>

