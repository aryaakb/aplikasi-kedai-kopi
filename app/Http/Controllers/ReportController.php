<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        
        $transactions = Transaction::with(['user', 'details.product'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $total = $transactions->sum('total');
        
        // Debug log
        \Log::info('ReportController@index called. Transactions count: ' . $transactions->count());
        
        return view('reports.index', compact('transactions', 'total', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        $startDate = $request->start_date ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        
        $transactions = Transaction::with(['user', 'details.product'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $total = $transactions->sum('total');
        
        $format = $request->get('format', 'pdf');
        $csvType = $request->get('csv_type', 'detailed'); // detailed or summary
        
        if ($format === 'csv') {
            return $this->exportCsv($transactions, $startDate, $endDate, $csvType);
        }
        
        $pdf = Pdf::loadView('reports.export', compact('transactions', 'total', 'startDate', 'endDate'));
        return $pdf->download('laporan-nofvckingcoffee-'.$startDate.'-'.$endDate.'.pdf');
    }
    
    private function exportCsv($transactions, $startDate, $endDate, $csvType = 'detailed')
    {
        $filename = 'laporan-nofvckingcoffee-'.$startDate.'-'.$endDate.'.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];
        
        $callback = function() use ($transactions, $csvType) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 (Excel compatibility)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            if ($csvType === 'summary') {
                // Summary CSV Header
                fputcsv($file, [
                    'No Transaksi',
                    'Tanggal',
                    'Kasir',
                    'Daftar Item',
                    'Total Item',
                    'Total Transaksi',
                    'Uang Dibayar',
                    'Kembalian',
                    'Status'
                ]);
                
                // Summary CSV Data
                foreach ($transactions as $transaction) {
                    $itemList = $transaction->details->map(function($detail) {
                        return $detail->quantity . 'x ' . ($detail->product->name ?? 'Product Deleted');
                    })->join('; ');
                    
                    $totalItems = $transaction->details->sum('quantity');
                    
                    fputcsv($file, [
                        $transaction->id,
                        $transaction->created_at->format('d/m/Y H:i:s'),
                        $transaction->user->name ?? 'Unknown',
                        $itemList,
                        $totalItems,
                        number_format($transaction->total),
                        number_format($transaction->paid_amount),
                        number_format($transaction->paid_amount - $transaction->total),
                        ucfirst($transaction->status)
                    ]);
                }
            } else {
                // Detailed CSV Header (existing format)
                fputcsv($file, [
                    'No Transaksi',
                    'Tanggal',
                    'Kasir',
                    'Produk',
                    'Kategori',
                    'Harga Satuan',
                    'Jumlah',
                    'Subtotal',
                    'Total Transaksi',
                    'Uang Dibayar',
                    'Kembalian',
                    'Status'
                ]);
                
                // Detailed CSV Data (existing format)
                foreach ($transactions as $transaction) {
                    foreach ($transaction->details as $detail) {
                        fputcsv($file, [
                            $transaction->id,
                            $transaction->created_at->format('d/m/Y H:i:s'),
                            $transaction->user->name ?? 'Unknown',
                            $detail->product->name ?? 'Product Deleted',
                            $detail->product->category ?? 'Unknown',
                            number_format($detail->product->price ?? 0),
                            $detail->quantity,
                            number_format($detail->subtotal),
                            number_format($transaction->total),
                            number_format($transaction->paid_amount),
                            number_format($transaction->paid_amount - $transaction->total),
                            ucfirst($transaction->status)
                        ]);
                    }
                }
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}