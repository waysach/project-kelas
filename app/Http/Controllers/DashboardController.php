<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Bulan yang dipilih
        $bulanDipilih = $request->bulan ?? Carbon::now()->format('Y-m');

        // Ubah menjadi tanggal
        $tanggal = Carbon::createFromFormat('Y-m', $bulanDipilih);

        $tahun = $tanggal->year;
        $bulanAngka = $tanggal->month;

        // Ambil transaksi sesuai bulan
        $transaksiBulanIni = Transaction::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->get();

        // Total pemasukan bulan yang dipilih
        $totalPemasukan = $transaksiBulanIni
            ->where('jenis', 'pemasukan')
            ->sum('jumlah');

        // Total pengeluaran bulan yang dipilih
        $totalPengeluaran = $transaksiBulanIni
            ->where('jenis', 'pengeluaran')
            ->sum('jumlah');

        // Saldo bulan yang dipilih
        $saldo = $totalPemasukan - $totalPengeluaran;

        // 5 transaksi terbaru pada bulan yang dipilih
        $transaksiTerbaru = Transaction::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulanAngka)
            ->latest('tanggal')
            ->take(5)
            ->get();

        // Data grafik 6 bulan terakhir
        $bulan = [];
        $pemasukanBulanan = [];
        $pengeluaranBulanan = [];

        for ($i = 5; $i >= 0; $i--) {

            $tanggalGrafik = Carbon::now()->subMonths($i);

            $bulan[] = $tanggalGrafik->translatedFormat('M Y');

            $pemasukanBulanan[] = Transaction::where('jenis', 'pemasukan')
                ->whereYear('tanggal', $tanggalGrafik->year)
                ->whereMonth('tanggal', $tanggalGrafik->month)
                ->sum('jumlah');

            $pengeluaranBulanan[] = Transaction::where('jenis', 'pengeluaran')
                ->whereYear('tanggal', $tanggalGrafik->year)
                ->whereMonth('tanggal', $tanggalGrafik->month)
                ->sum('jumlah');
        }

        return view('welcome', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'transaksiTerbaru',
            'bulan',
            'pemasukanBulanan',
            'pengeluaranBulanan',
            'bulanDipilih'
        ));
    }
}