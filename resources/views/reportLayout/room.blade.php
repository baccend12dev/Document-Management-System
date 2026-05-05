<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Equipment Qualification Report</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .report-table {
            width: auto;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
        }

        .report-table th {
            background-color: #f8f8f8;
            font-weight: bold;

        }

        .header-title {
            font-size: 35px;
            text-align: center!important;
            vertical-align: middle;
            font-family: "Tw Cen MT Condensed", "Tw Cen MT", "Arial Narrow", Arial, sans-serif;
        }

        .header-subtitle {
            text-align: center!important;
            font-weight: bold;
            font-size: 15px;

        }

        /* Untuk tampilan print */
        @media print {
            body {
                margin: 10mm;
            }

            .no-print {
                display: none;
            }

            .report-table th,
            .report-table td {
                border: 1px solid #000;
            }
        }

        .signature {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .signature td {
            padding: 5px;
            border: 1px solid #000;
            height: 25px;
        }

        .signature td:first-child {
            width: 50%;
        }
    </style>
</head>
<body>

    <table class="report-table">
        <tr>
            <td colspan="2" class="header-title">OTTO</td>
            <td colspan="9" class="header-subtitle">
                {{ strtoupper($category) }} QUALIFICATION REPORT
            </td>
        </tr>
        <tr>
            <!-- header kosong baris kedua -->
        </tr>
        <tr>
            <th>No</th>
            <th>Document No</th>
            <th>Revision</th>
            <th>Approve Date</th>
            <th>Next Requalification</th>
            <th>Service Area</th>
            <th>Location</th>
            <th>AHU</th>
            <th>Room No</th>
            <th>Room Name</th>
            <th>Room Class</th>
        </tr>
        @foreach($documents as $document)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $document->doc_number }}</td>
            <td>{{ $document->revision_number }}</td>
            <td>{{ $document->approved_date }}</td>
            <td>{{ $document->next_review != null ? $document->next_review : 'N/A' }}</td>

            <td>{{ $document->equipment->roomMaster->pluck('service_area')->unique()->implode(', ') }}</td>
            <td>{!! $document->equipment->roomMaster->pluck('location')->unique()->implode('<br>') !!}</td>
            <td>{!! $document->equipment->roomMaster->pluck('ahu_code')->unique()->implode('<br>') !!}</td>
            <td>{!! $document->equipment->roomMaster->pluck('room_code')->implode('<br>') !!}</td>
            <td>{!! $document->equipment->roomMaster->pluck('room_name')->implode('<br>') !!}</td>
            <td>{!! $document->equipment->roomMaster->pluck('room_class')->implode('<br>') !!}</td>
        </tr>
        @endforeach

        
    </table>
            
    <div class="footer" style="margin-top: 20px;">
        <strong>Printed by:</strong> {{ $userName }} |  
        <strong>Print date:</strong> {{ date('d M Y') }}
    </div>
    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()">🖨️ Print Page</button>
    </div>

</body>
</html>
