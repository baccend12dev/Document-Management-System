<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Qualification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-body p {
            color: #333333;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin: 0;
        }
        th, td {
            padding: 4px;
            border: 1px solid #ccc;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #eee;
            font-weight: bold;
        }
        .text-danger {
            color: #dc3545;
            font-weight: bold;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>📋 Notifikasi Qualification</h1>
        </div>
        
        <div class="email-body">
            <p>Halo <strong>{{ $picName }}</strong>,</p>
            <p>Berikut adalah daftar dokumen yang menjadi tanggung jawab Anda dan dijadwalkan untuk review (jatuh tempo) pada bulan ini:</p>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Dokumen</th>
                            <th>Tipe Dokumen</th>
                            <th>Kategori</th>
                            <th>Next Review Date</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $index => $picDoc)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $picDoc->document ? $picDoc->document->doc_number : '-' }}</td>
                                <td>{{ $picDoc->document ? $picDoc->document->document_type : '-' }}</td>
                                <td>{{ $picDoc->document ? $picDoc->document->sub_menu : '-' }}</td>
                                <td>
                                    @if($picDoc->document)
                                        <span class="{{ \Carbon\Carbon::parse($picDoc->document->next_review)->isPast() ? 'text-danger' : '' }}">
                                            {{ \Carbon\Carbon::parse($picDoc->document->next_review)->format('d M Y') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $details = [];
                                        if ($picDoc->document) {
                                            $isUtility = strtolower($picDoc->document->sub_menu) === 'utility';
                                            
                                            if ($picDoc->document->equipment && !$isUtility) {
                                                $eq = $picDoc->document->equipment;
                                                $fields = [
                                                    'equipment_id' => 'Equipment ID',
                                                    'product_code' => 'Product Code',
                                                    'equipment_name' => 'Equipment Name',
                                                    'product_name' => 'Product Name',
                                                    'no_batch' => 'No Batch',
                                                    'active_subtance' => 'Active Substance',
                                                    'systemName' => 'System Name',
                                                    'dosageCode' => 'Dosage Code',
                                                    'department' => 'Department',
                                                    'building' => 'Building',
                                                    'roomName' => 'Room Name',
                                                    'roomNumber' => 'Room Number',
                                                    'location' => 'Location',
                                                    'serviceArea' => 'Service Area',
                                                    'type' => 'Type',
                                                    'model' => 'Model',
                                                    'serial_number' => 'Serial Number'
                                                ];
                                                foreach ($fields as $key => $label) {
                                                    if (!empty($eq->$key)) {
                                                        $details[] = "<strong>{$label}:</strong> " . htmlspecialchars($eq->$key);
                                                    }
                                                }
                                            } elseif ($picDoc->document->utility) {
                                                $util = $picDoc->document->utility;
                                                $fields = [
                                                    'subject' => 'Subject',
                                                    'system' => 'System',
                                                    'model' => 'Model',
                                                    'building' => 'Building',
                                                    'location' => 'Location',
                                                    'servicearea' => 'Service Area',
                                                    'roomNumber' => 'Room Number',
                                                    'roomName' => 'Room Name'
                                                ];
                                                foreach ($fields as $key => $label) {
                                                    if (!empty($util->$key)) {
                                                        $details[] = "<strong>{$label}:</strong> " . htmlspecialchars($util->$key);
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    @if(count($details) > 0)
                                        {!! implode('<br>', $details) !!}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <p>Silakan segera lakukan pengecekan pada sistem QA Qualification.</p>
            <p>Terima kasih atas perhatian Anda.</p>
        </div>
        
        <div class="email-footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} QA Qualification System</p>
        </div>
    </div>
</body>
</html>
