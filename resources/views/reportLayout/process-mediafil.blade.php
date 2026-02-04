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
                margin: none;
            }

            .no-print {
                display: none;
            }

            .report-table th,
            .report-table td {
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body>

    <table class="report-table">
        <tr>
            <td colspan="2" class="header-title">OTTO</td>
            <td colspan="8" class="header-subtitle">
                PROCESS VALIDATION  MEDIA FILL REPORT
            </td>
        </tr>
        <tr>
            <!-- header kosong baris kedua -->
        </tr>
       <tr>
                    <th>NO</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th>No batch</th>
                    <th>Active Substance</th>
                    <th>Document No</th>
                    <th>Document Type</th>
                    <th>Rev</th>
                    <th>Approve Date</th>
                    <th>Remark</th>
                </tr>
        @foreach($documents as $index => $pmf)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{$pmf->equipment ? $pmf->equipment->product_name : '' }}</td>
                    <td>{{ $pmf->equipment ? $pmf->equipment->product_code : '' }}</td>
                    <td>{{ $pmf->equipment ? $pmf->equipment->no_batch : '' }}</td>
                    <td>{{ $pmf->equipment ? $pmf->equipment->active_subtance : '' }}</td>
                    <td>{{ $pmf->doc_number }}</td>
                    <td>{{ $pmf->document_type }}</td>
                    <td>{{ $pmf->revision_number }}</td>
                    <td>{{ $pmf->approved_date}}</td>
                    <td>{{ $pmf->remarks }}</td>
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
