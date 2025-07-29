<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Roboto Slab', sans-serif; 
            font-size: 12px;
            color: #3E2723;
        }
        .header { text-align: center; margin-bottom: 25px; }
        .title { 
            font-family: 'Lobster', cursive;
            font-size: 28px; 
            font-weight: normal;
            color: #3E2723;
            margin-bottom: 5px;
        }
        .period { text-align: center; margin-bottom: 25px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #D2B48C; padding: 10px; text-align: left; }
        th { 
            background-color: #EAE0C8;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
        }
        .total { font-weight: bold; text-align: right; }
        tfoot tr { background-color: #EAE0C8; font-weight: 700; }
        tfoot td { border: 1px solid #D2B48C; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laporan Transaksi Coffee Shop</div>
    </div>
    <div class="period">Periode: {{ date('d F Y', strtotime($startDate)) }} &mdash; {{ date('d F Y', strtotime($endDate)) }}</div>
    
    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>#{{ $transaction->id }}</td>
                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total Pendapatan:</td>
                <td style="text-align: left;">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>