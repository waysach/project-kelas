<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $jenis = $request->jenis;

    $transactions = Transaction::when($search, function ($query) use ($search) {
            $query->where('keterangan', 'like', '%' . $search . '%');
        })
        ->when($jenis, function ($query) use ($jenis) {
            $query->where('jenis', $jenis);
        })
        ->latest('tanggal')
        ->paginate(10)
        ->withQueryString();

    return view('transactions.index', compact(
        'transactions',
        'search',
        'jenis'
    ));
}

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        Transaction::create($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $transaction->update($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}