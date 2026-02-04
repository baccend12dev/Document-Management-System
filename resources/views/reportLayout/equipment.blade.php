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
            <td colspan="8" class="header-subtitle">
                {{ strtoupper($category) }} QUALIFICATION REPORT
            </td>
        </tr>
        <tr>
            <!-- header kosong baris kedua -->
        </tr>
        <tr>
            <th >NO</th>
            <th > Name</th>
            <th >Equipment ID</th>
            <!-- <th style="width: 10%;">Location</th> -->
            <th >Room NO</th>
            <th >Room Name</th>
            <th >Document NO</th>
            <th >Document Type</th>
            <th >Rev</th>
            <th >Approve Date</th>
            <th >Next Req /<br> Next Periodic</th>
        </tr>
        @foreach($documents as $index => $doc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if ($category == 'computer')
                        {{ $doc->equipment ? $doc->equipment->systemName : 'N/A' }}
                    @else
                        {{ $doc->equipment ? $doc->equipment->equipment_name : 'N/A' }}
                    @endif
                </td>
                <td>{{ $doc->equipment ? $doc->equipment->equipment_id : 'N/A' }}</td>
                <!-- <td>{{ $doc->equipment ? $doc->equipment->location : 'N/A' }}</td> -->
                <td>{{ $doc->equipment ? $doc->equipment->roomNumber : 'N/A' }}</td>
                <td>{{ $doc->equipment ? $doc->equipment->roomName : 'N/A' }}</td>
                <td>{{ $doc->doc_number }}</td>
                <td>{{ $doc->document_type }}</td>
                <td>{{ $doc->revision_number ? $doc->revision_number : 'N/A' }}</td>
                <td>{{ date('d/m/Y', strtotime($doc->approved_date)) }}</td>
                <td>{{ $doc->next_review ? date('d/m/Y', strtotime($doc->next_review)) : 'N/A' }}</td>
            </tr>
        @endforeach

        
    </table>
            (User Name)
            (Printed Date)
    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()">🖨️ Print Page</button>
    </div>

</body>
</html>
