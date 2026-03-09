<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna - {{ $user->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            color: #059669;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table th,
        .details-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .details-table th {
            width: 30%;
            font-weight: bold;
            color: #4b5563;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>NexaDash</h1>
        <p>Profil Pengguna Detail</p>
    </div>

    <table class="details-table">
        <tr>
            <th>ID Pengguna</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Peran</th>
            <td>{{ ucfirst($user->role) }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $user->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</td>
        </tr>
        <tr>
            <th>Tanggal Bergabung</th>
            <td>{{ $user->created_at->format('d M Y H:i:s') }}</td>
        </tr>
        <tr>
            <th>Bio Lengkap</th>
            <td>{{ $user->bio ?: '-' }}</td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d M Y H:i:s') }}
    </div>
</body>

</html>