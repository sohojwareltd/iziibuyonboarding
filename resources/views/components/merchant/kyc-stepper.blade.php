@props([
    'active' => 1,
])

@php
    $steps = [
        1 => 'Company Information',
        2 => 'Beneficial Owners',
        3 => 'Board Members / GM',
        4 => 'Contact Person',
        5 => 'Purpose of Service',
        6 => 'Sales Channels',
        7 => 'Bank Information',
        8 => 'Authorized Signatories',
        9 => 'Review & Submit',
    ];
@endphp

<aside id="kyc-sidebar" class="w-[260px] bg-white border-r border-gray-200 flex flex-col h-full overflow-y-auto shrink-0 z-20 shadow-sm">
    <div class="p-6 border-b border-gray-100 flex items-center gap-3">
         <div class="text-primary text-xl font-bold tracking-tight">2iZii <span class="font-light text-slate-400">Admin</span></div>
    </div>
    
    <nav class="flex-1 py-6">
        <ul class="space-y-0">
            @foreach($steps as $num => $label)
                @php
                    $isActive = $active === $num;
                    $isCompleted = $num < $active;
                @endphp
                <li class="relative group {{ $isActive ? 'bg-orange-50/50 border-l-4 border-accent' : '' }}">
                    <div class="flex items-center px-{{ $isActive ? '5' : '6' }} py-3 text-sm font-medium {{ $isActive ? 'text-slate-900' : 'text-slate-600' }}">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full {{ $isCompleted ? 'bg-green-100 text-success' : ($isActive ? 'bg-accent text-white' : 'border border-gray-step text-gray-step bg-white') }} mr-3 text-xs {{ $isActive ? '' : '' }}">
                            @if($isCompleted)
                                <i class="fa-solid fa-check text-xs"></i>
                            @else
                                {{ $num }}
                            @endif
                        </span>
                        <span class="{{ $isCompleted ? '' : '' }}">{{ $label }}</span>
                    </div>
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

