<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KYC Summary</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.5;
        }

        h1, h2, h3, h4 {
            margin: 0;
        }

        .header {
            border-bottom: 2px solid #2D3A74;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #2D3A74;
            font-size: 22px;
            margin-bottom: 6px;
        }

        .meta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .meta td {
            padding: 6px 8px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .meta .label {
            width: 160px;
            font-weight: bold;
            background: #f9fafb;
        }

        .section {
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            color: #2D3A74;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .section-description {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 10px;
        }

        .entry-title {
            font-size: 12px;
            font-weight: bold;
            margin: 12px 0 8px;
            color: #4055A8;
        }

        .fields {
            width: 100%;
            border-collapse: collapse;
        }

        .fields th,
        .fields td {
            border: 1px solid #e5e7eb;
            padding: 7px 8px;
            vertical-align: top;
            text-align: left;
        }

        .fields th {
            background: #f9fafb;
            font-weight: bold;
        }

        .muted {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>KYC Summary</h1>
        <div>{{ $payload['onboarding']['legal_business_name'] ?? 'N/A' }}</div>
        <div class="muted">Exported at {{ $payload['exported_at'] ?? now()->toIso8601String() }}</div>
    </div>

    <table class="meta">
        <tr>
            <td class="label">Request ID</td>
            <td>{{ $payload['onboarding']['request_id'] ?? '—' }}</td>
            <td class="label">Status</td>
            <td>{{ $payload['onboarding']['status'] ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Country</td>
            <td>{{ $payload['onboarding']['country'] ?? '—' }}</td>
            <td class="label">Solution</td>
            <td>{{ $payload['onboarding']['solution'] ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Partner</td>
            <td>{{ $payload['onboarding']['partner'] ?? '—' }}</td>
            <td class="label">Price List</td>
            <td>{{ $payload['onboarding']['price_list'] ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Contact Email</td>
            <td>{{ $payload['onboarding']['merchant_contact_email'] ?? '—' }}</td>
            <td class="label">Phone</td>
            <td>{{ $payload['onboarding']['merchant_phone_number'] ?? '—' }}</td>
        </tr>
    </table>

    @foreach($payload['kyc_sections'] as $section)
        <div class="section">
            <h2 class="section-title">{{ $section['name'] }}</h2>
            <div class="section-description">{{ $section['description'] ?: 'KYC section details.' }}</div>

            @forelse($section['entries'] as $entry)
                @if($section['type'] === 'grouped')
                    <div class="entry-title">Entry #{{ ($entry['group_index'] ?? 0) + 1 }}</div>
                @endif

                <table class="fields">
                    <thead>
                        <tr>
                            <th style="width: 32%;">Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entry['fields'] as $field)
                            <tr>
                                <td>{{ $field['label'] }}</td>
                                <td>
                                    {{ is_array($field['display_value']) ? implode(', ', $field['display_value']) : $field['display_value'] }}
                                    @if(!empty($field['file_url']))
                                        <div class="muted">File URL: {{ $field['file_url'] }}</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @empty
                <div class="muted">No data available for this section.</div>
            @endforelse
        </div>
    @endforeach
</body>
</html>