<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void saveForSection(\App\Models\Onboarding|int $onboarding, \App\Models\KycSection|int|string $section, array $dynamicFields, int $groupIndex = 0)
 * @method static array getForSection(\App\Models\Onboarding|int $onboarding, \App\Models\KycSection|int|string $section, int $groupIndex = 0)
 * @method static array getGroupedForSection(\App\Models\Onboarding|int $onboarding, \App\Models\KycSection|int|string $section)
 *
 * @see \App\Services\KycFieldDataService
 */
class KycFieldData extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'kyc-field-data';
    }
}
