<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $report['title'] }} — IndoTech</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1e293b;
            font-size: 10px;
            margin: 0;
        }
        h1 {
            font-size: 20px;
            margin: 0 0 6px;
        }
        .meta {
            color: #64748b;
            font-size: 10px;
            margin-bottom: 18px;
        }
        .stats {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .stats td {
            width: 25%;
            border: 1px solid #cbd5e1;
            padding: 8px;
            background: #f8fafc;
        }
        .stats .value {
            display: block;
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }
        .stats .label {
            color: #64748b;
            font-size: 9px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
        }
        table.data th,
        table.data td {
            border: 1px solid #cbd5e1;
            padding: 5px 6px;
            text-align: left;
            vertical-align: top;
        }
        table.data th {
            background: #e2e8f0;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        table.data tr:nth-child(even) td {
            background: #f8fafc;
        }
        .footer {
            margin-top: 16px;
            color: #94a3b8;
            font-size: 9px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>{{ $report['title'] }}</h1>
    <div class="meta">
        {{ $report['id'] }} · {{ $report['type'] }} · {{ $report['period'] }} · {{ number_format($report['totalRows']) }} records
    </div>

    <table class="stats">
        <tr>
            @foreach ($report['stats'] as $label => $value)
                <td>
                    <span class="value">{{ number_format((int) $value) }}</span>
                    <span class="label">{{ $label }}</span>
                </td>
            @endforeach
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                @foreach ($report['columns'] as $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($report['rows'] as $row)
                <tr>
                    @foreach (array_keys($report['columns']) as $column)
                        <td>{{ $row[$column] ?? '-' }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($report['columns']) }}">Belum ada data untuk filter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dibuat {{ now()->format('d M Y H:i') }} · IndoTech
    </div>
</body>
</html>
