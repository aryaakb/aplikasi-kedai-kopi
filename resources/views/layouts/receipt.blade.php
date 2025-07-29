<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Roboto Slab', sans-serif; 
            font-size: 12px;
            color: #3E2723;
        }
        .receipt-container {
            max-width: 320px;
            margin: 20px auto;
            padding: 20px;
            background-color: #F5F5DC; /* Warna kertas kraft/krem */
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        .header { text-align: center; margin-bottom: 20px; }
        .title { 
            font-family: 'Lobster', cursive;
            font-size: 32px; 
            font-weight: normal;
            color: #5D4037;
        }
        .address { font-size: 12px; color: #5D4037; }
        .details { margin: 15px 0; font-size: 14px; color: #3E2723; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { border-bottom: 1px dashed #A1887F; padding: 8px 4px; text-align: left; }
        th { color: #5D4037; }
        thead tr { border-bottom: 2px solid #A1887F; }
        .total-section { margin-top: 15px; text-align: right; }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 14px;
        }
        .summary-item .label { text-align: left; }
        .summary-item .value { text-align: right; font-weight: bold; }
        .total { font-weight: bold; font-size: 16px; }
        .footer { margin-top: 25px; text-align: center; font-style: italic; font-size: 12px; color: #5D4037;}
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <div class="title">Coffee Shop</div>
            <div class="address">Jl. Contoh No. 123, Kota</div>
        </div>
        
        <div class="details">
            <div>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</div>
            <div>Kasir: {{ $transaction->user->name }}</div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>total</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="total-section mt-4">
            <div class="summary-item total">
                <span class="label">Total:</span>
                <span class="value">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span class="label">Uang Bayar:</span>
                <span class="value">Rp {{ number_format($paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span class="label">Kembalian:</span>
                <span class="value">Rp {{ number_format($change, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="footer">
            Terima kasih telah berkunjung!
        </div>
    </div>
</body>
</html>