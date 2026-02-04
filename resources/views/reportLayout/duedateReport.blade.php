<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Due Date Instrument Calibration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @media print {
        body {
            margin: 0;
            padding: 15mm;
            font-size: 12pt;
        }

        .no-print {
            display: none;
        }

        .page-break {
            page-break-before: always;
        }
    }

    body {
        font-family: 'Times New Roman', serif;
        line-height: 1.4;
        color: #000;
        background: #fff;
        padding: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
    }

    .title {
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 10px;
        letter-spacing: 1px;
    }

    .subtitle {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .info-section {
        margin-bottom: 20px;
    }

    .info-item {
        display: inline-block;
        margin-right: 40px;
        font-weight: bold;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 11px;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
        vertical-align: top;
    }

    .data-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        text-align: center;
        font-size: 10px;
        text-transform: uppercase;
    }



    .data-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .data-table td.number {
        text-align: center;
        font-weight: bold;
    }

    .data-table td.date {
        text-align: center;
        font-weight: bold;
    }

    .footer {
        margin-top: 30px;
        text-align: right;
        font-size: 12px;
    }

    

    .print-button {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .print-button:hover {
        background: #0056b3;
    }

    .date-generated {
        text-align: right;
        font-size: 12px;
        margin-bottom: 20px;
        font-style: italic;
    }

        .status-badge-OVERDUE {
        background-color: #f44336 !important;
    }

    .status-badge-URGENT {
        background-color: #ff9800 !important;
    }

    .status-badge-WARNING {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .status-badge-NORMAL {
        background-color: #0dcaf0 !important;
    }


    .status-badge-FUTURE {
        background-color: #4caf50 !important;
    }
    </style>
</head>

<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Print Laporan</button>

    <div class="date-generated">
        Tanggal Generate: <span id="currentDate"></span>
    </div>

    <div class="header">
        <div class="title">Notification Due Date Document Qulification</div>
    </div>

    <div class="info-section">
        <div class="info-item">Jumlah Data: <span style="color: #d32f2f; font-size: 16px;">{{ count($duedateSchedule) }}</span>
        </div>
        <div class="info-item">Status: {{ request()->get('priority', 'All') }}</div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="no-col">NO.</th>
                <th class="status-col">STATUS</th>
                <th class="date-col">NEXT REVIEW</th>
                <th class="identity-col">IDENTITY NUMBER</th>
                <th class="equipment-col">NAME</th>
                <th class="subject-col">SUBJECT</th>
                <th class="roomname-col">DOC NUMBER</th>
                <th class="equipment-col">TYPE DOCUMENT</th>
                <th class="remarks-col">REMARKS</th>
            </tr>
        </thead>
        <tbody id="dataTableBody">
            @foreach ($duedateSchedule as $index => $dueDate)
            <tr>
                <td class="number">{{ $index + 1 }}</td>
                                    <td>
                                        <i class="fas
                                            @if($dueDate->next_review < \Carbon\Carbon::now())
                                                fa-exclamation-circle text-danger
                                            @elseif($dueDate->next_review <= \Carbon\Carbon::now()->addDays(7))
                                                fa-exclamation-triangle text-warning
                                            @elseif($dueDate->next_review <= \Carbon\Carbon::now()->addDays(60))
                                                fa-calendar-check text-info
                                            @else
                                                fa-check-circle text-success
                                            @endif
                                        "></i>
                                        <span class="ms-1">
                                            @if($dueDate->next_review < \Carbon\Carbon::now()) <span
                                                class="badge bg-danger">Overdue</span>
                                        @elseif($dueDate->next_review <= \Carbon\Carbon::now()->addDays(7))
                                            <span class="badge bg-warning text-dark">Warning</span>
                                            @elseif($dueDate->next_review <= \Carbon\Carbon::now()->addDays(60))
                                                <span class="badge bg-info">Normal</span>
                                                @else
                                                <span class="badge bg-success">Future</span>
                                                @endif
                                                </span>
                                    </td>
                <td class="date">{{ \Carbon\Carbon::parse($dueDate->NextCalibration)->format('d - M - y') }}</td>
                <td>{{ $dueDate->equipment ? $dueDate->equipment->equipment_id : '' }} {{ $dueDate->equipment ? $dueDate->equipment->product_code : '' }}</td>
                <td>{{ $dueDate->equipment ? $dueDate->equipment->equipment_name : '' }} | {{ $dueDate->equipment ? $dueDate->equipment->product_name : '' }}</td>
                <td>{{ $dueDate->subject }}</td>
                <td>{{ $dueDate->doc_number }}</td>
                <td>{{ $dueDate->document_type }}</td>
                <td>{{ $dueDate->remarks }}</td>
            </tr>
            @endforeach
            

        </tbody>
    </table>
    <script>
    // Set tanggal saat ini
    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });


    </script>
</body>

</html>