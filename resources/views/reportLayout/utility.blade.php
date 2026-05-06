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
            <td colspan="12" class="header-subtitle">
                {{ strtoupper($category) }} QUALIFICATION REPORT
            </td>
        </tr>
        <tr>
            <th >NO</th>
            <th >Subject</th>
            <th >System</th>
            <th >Model</th>
            <th >Building</th>
            <th >Location</th>
            <th >Service Area</th>
            <th >Room Name</th>
            <th >Room Number</th>
            <th >Document Number</th>
            <th >Document Type</th>
            <th >Rev</th>
            <th >Approve Date</th>
            <th >Next Req /<br> Next Periodic</th>
        </tr>
        @foreach($documents as $index => $doc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $doc->utility ? $doc->utility->subject : 'N/A' }}</td>
                <td>{{ $doc->utility ? $doc->utility->system : 'N/A' }}</td>
                <td>{{ $doc->utility ? $doc->utility->model : 'N/A' }}</td>
                <td>{{ $doc->utility ? $doc->utility->building : 'N/A' }}</td>
                <td>{{ $doc->utility ? $doc->utility->location : 'N/A' }}</td>
                <td>{{ $doc->utility ? $doc->utility->servicearea : 'N/A' }}</td>
                <td>{{ $doc->utility ? $doc->utility->roomName : 'N/A' }}</td>
                <td>{{ $doc->utility ? $doc->utility->roomNumber : 'N/A' }}</td>
                <td>{{ $doc->doc_number }}</td>
                <td>{{ $doc->document_type }}</td>
                <td>{{ $doc->revision_number ? $doc->revision_number : 'N/A' }}</td>
                <td>{{ date('d/m/Y', strtotime($doc->approved_date)) }}</td>
                <td>{{ $doc->next_review ? date('d/m/Y', strtotime($doc->next_review)) : 'N/A' }}</td>
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
