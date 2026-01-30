<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SolutionMasterExport implements FromCollection, WithHeadings, WithMapping
{
    private Collection $solutions;

    public function __construct(Collection $solutions)
    {
        $this->solutions = $solutions;
    }

    public function collection(): Collection
    {
        return $this->solutions;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Slug',
            'Category',
            'Status',
            'Description',
            'Country',
            'Tags',
            'Acquirers',
            'Payment Methods',
            'Alternative Methods',
            'Requirements',
            'Pricing Plan',
            'Created At',
            'Updated At',
        ];
    }

    public function map($solution): array
    {
        return [
            $solution->id,
            $solution->name,
            $solution->slug,
            $solution->category?->name ?? '',
            $solution->status,
            $solution->description,
            $solution->country,
            $this->implodeArray($solution->tags),
            $this->implodeArray($solution->acquirers),
            $this->implodeArray($solution->payment_methods),
            $this->implodeArray($solution->alternative_methods),
            $solution->requirements,
            $solution->pricing_plan,
            optional($solution->created_at)->toDateTimeString(),
            optional($solution->updated_at)->toDateTimeString(),
        ];
    }

    private function implodeArray($value): string
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return implode(', ', $decoded);
            }
            return $value;
        }

        if (is_array($value)) {
            return implode(', ', $value);
        }

        if ($value instanceof Collection) {
            return $value->implode(', ');
        }

        return '';
    }
}
