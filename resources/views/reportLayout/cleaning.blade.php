<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cleaning Validation Report</title>
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
            text-align: center;
        }

        .report-table th {
            background-color: #f8f8f8;
            font-weight: bold;

        }

        .header-title {
            font-size: 35px;
            text-align: center;
            vertical-align: middle;
            font-family: "Tw Cen MT Condensed", "Tw Cen MT", "Arial Narrow", Arial, sans-serif;
        }

        .header-subtitle {
            text-align: center;
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
                Cleaning Validation Report
            </td>
        </tr>
        <tr>
            <!-- header kosong baris kedua -->
        </tr>
        <tr>
            <th style="width: 3%;">NO</th>
            <th style="width: 15%;">Product Name</th>
            <th style="width: 10%;">Product Code</th>
            <th style="width: 10%;">Equipment Name</th>
            <th style="width: 8%;">Equipment ID</th>
            <!-- <th style="width: 15%;">Room No</th> -->
            <!-- <th style="width: 12%;">Room Name</th> -->
            <!-- <th style="width: 5%;">No Batch</th> -->
            <th style="width: 10%;">Active Subtance</th>
            <th style="width: 10%;">Document No</th>
            <th style="width: 10%;">Document Type</th>
            <th style="width: 10%;">Rev</th>
            <th style="width: 10%;">Aprove Date</th>
            <th style="width: 10%;">Remark</th>
        </tr>
        @foreach($documents as $index => $doc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left; padding-left: 10px;">{{ $doc->equipment ? $doc->equipment->product_name : 'N/A' }}</td>
                <td>{{ $doc->equipment ? $doc->equipment->product_code : 'N/A' }}</td>
                <td>{{ $doc->equipment ? $doc->equipment->equipment_name : 'N/A' }}</td>
                <td>{{ $doc->equipment ? $doc->equipment->equipment_id : 'N/A' }}</td>
                <!-- <td>{{ $doc->equipment ? $doc->equipment->roomNumber : 'N/A' }}</td>
                  <td>{{ $doc->equipment ? $doc->equipment->roomName : 'N/A' }}</td>
                <td>{{ $doc->equipment ? $doc->equipment->no_batch :'' }}</td> -->
                <td>{{ $doc->equipment ? $doc->equipment->active_subtance : '' }}</td>
                <td>{{ $doc->doc_number }}</td>
                <td>{{ $doc->document_type }}</td>
                <td>{{ $doc->revision_number ? $doc->revision_number : 'N/A' }}</td>
                <td>{{ date('d/m/Y', strtotime($doc->approved_date)) }}</td>
                <td>{{ $doc->remarks}}</td>
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
