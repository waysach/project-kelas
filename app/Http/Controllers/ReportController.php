<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Bulan yang dipilih
        $bulan = $request->bulan ?? Carbon::now()->format('Y-m');

        // Ambil tahun dan bulan
        $tanggal = Carbon::createFromFormat('Y-m', $bulan);

        $tahun = $tanggal->year;
        $bulanAngka = $tanggal->month;

        // Ambil transaksi sesuai bulan
        $transaksi = Transaction::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Total pemasukan
        $totalPemasukan = $transaksi
            ->where('jenis', 'pemasukan')
            ->sum('jumlah');

        // Total pengeluaran
        $totalPengeluaran = $transaksi
            ->where('jenis', 'pengeluaran')
            ->sum('jumlah');

        // Saldo bulan tersebut
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('reports.index', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'bulan'
        ));
    }

    public function pdf(Request $request)
    {
        // Bulan yang dipilih
        $bulan = $request->bulan ?? Carbon::now()->format('Y-m');

        // Ambil tahun dan bulan
        $tanggal = Carbon::createFromFormat('Y-m', $bulan);

        $tahun = $tanggal->year;
        $bulanAngka = $tanggal->month;

        // Ambil transaksi sesuai bulan
        $transaksi = Transaction::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Total pemasukan
        $totalPemasukan = $transaksi
            ->where('jenis', 'pemasukan')
            ->sum('jumlah');

        // Total pengeluaran
        $totalPengeluaran = $transaksi
            ->where('jenis', 'pengeluaran')
            ->sum('jumlah');

        // Saldo
        $saldo = $totalPemasukan - $totalPengeluaran;

        // Buat PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'reports.pdf',
            compact(
                'transaksi',
                'totalPemasukan',
                'totalPengeluaran',
                'saldo',
                'bulan'
            )
        );

        // Download PDF
        return $pdf->download('laporan-kas-' . $bulan . '.pdf');
    }
}