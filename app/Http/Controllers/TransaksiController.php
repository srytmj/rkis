<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Jurnal;
use App\Models\Akun;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua transaksi
        $transaksis = Transaksi::all();

        // Ambil semua transaksi dengan data akun yang relevan menggunakan join
        $transaksiakuns = DB::table('transaksi')
                        ->join('jurnal', 'transaksi.id', '=', 'jurnal.id_transaksi')
                        ->join('akun', 'jurnal.no_akun', '=', 'akun.no_akun')
                        ->select('transaksi.*', 'jurnal.no_akun', 'akun.nama_akun', 'jurnal.posisi', 'jurnal.saldo')
                        ->get();
    
                    
        $akuns = Akun::all();
        return view('transaksi', compact(['transaksis', 'transaksiakuns', 'akuns']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */    
    public function store(Request $request)
    {
        // validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|string|in:pemasukan,pengeluaran',
            'deskripsi' => 'required|string',
            'accounts' => 'required|array',
            'accounts.*.no_akun' => 'required|exists:akun,no_akun',
            'accounts.*.type' => 'required|in:debit,kredit',
            'accounts.*.saldo' => 'required|numeric',
        ]);
    
        $transaksi = Transaksi::create([
            'nama_transaksi' => $validated['name'],
            'tanggal' => $validated['tanggal'],
            'jenis_transaksi' => $validated['jenis_transaksi'],
            'deskripsi' => $validated['deskripsi'],
        ]);
    
        foreach ($validated['accounts'] as $account) {
            Jurnal::create([
                'tanggal' => $validated['tanggal'],
                'id_transaksi' => $transaksi->id,
                'no_akun' => $account['no_akun'],
                'posisi' => $account['type'],
                'saldo' => $account['saldo'],
            ]);
        }
    
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
    
    
        // // tamplin data yang baru disimpan (nama transaksi dan akun-akun)
        // return response()->json([
        //     'success' => true,
        //     'transaction' => $transaction,  // Data transaksi yang baru disimpan
        //     'accounts' => $transaction->accounts, // Akun-akun terkait dengan transaksi tersebut
        // ]);
    }
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|string|in:pemasukan,pengeluaran',
            'deskripsi' => 'required|string',
            'accounts' => 'required|array',
            'accounts.*.no_akun' => 'required|exists:akun,no_akun',
            'accounts.*.type' => 'required|in:debit,kredit',
            'accounts.*.saldo' => 'required|numeric',
        ]);
    
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'nama_transaksi' => $validated['name'],
            'tanggal' => $validated['tanggal'],
            'jenis_transaksi' => $validated['jenis_transaksi'],
            'deskripsi' => $validated['deskripsi'],
        ]);
    
        Jurnal::where('id_transaksi', $id)->delete();
    
        foreach ($validated['accounts'] as $account) {
            Jurnal::create([
                'tanggal' => $validated['tanggal'],
                'id_transaksi' => $transaksi->id,
                'no_akun' => $account['no_akun'],
                'posisi' => $account['type'],
                'saldo' => $account['saldo'],
            ]);
        }
    
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate');
        }

    /**
     * Remove the specified resource from storage.
     */
    // Menghapus transaksi beserta akun-akunnya
    public function destroy($id)
    {
        // Cari transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Hapus akun-akun terkait
        Jurnal::where('id_transaksi', $id)->delete();

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
