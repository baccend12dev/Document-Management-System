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
        .link-section {
            margin: 20px 0;
        }
        .link-item {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .link-item.overdue {
            border-left-color: #dc3545;
        }
        .link-item.warning {
            border-left-color: #ffc107;
        }
        .link-item h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #333333;
        }
        .link-item a {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .link-item.overdue a {
            background-color: #dc3545;
        }
        .link-item.warning a {
            background-color: #ffc107;
            color: #333333;
        }
        .link-item a:hover {
            opacity: 0.9;
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
            <p>Halo,</p>
            <p>Berikut adalah ringkasan jadwal qualification yang perlu Anda perhatikan:</p>
            
            <div class="link-section">
                @foreach($links as $title => $url)
                    @php
                        $class = '';
                        if (strpos($title, 'Overdue') !== false) {
                            $class = 'overdue';
                        } elseif (strpos($title, '1 Week') !== false) {
                            $class = 'warning';
                        }
                    @endphp
                    <div class="link-item {{ $class }}">
                        <h3>{{ $title }}</h3>
                        <a href="{{ $url }}" target="_blank">Lihat Detail</a>
                    </div>
                @endforeach
            </div>
            
            <p>Silakan klik tombol di atas untuk melihat detail masing-masing qualification.</p>
            <p>Terima kasih atas perhatian Anda.</p>
        </div>
        
        <div class="email-footer">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} QA Qualification System</p>
        </div>
    </div>
</body>
</html>
