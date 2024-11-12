<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKasRequest;
use App\Http\Requests\UpdateKasRequest;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data kas
        $datas = Transaksi::all();

        // Jumlah total transaksi
        $jumlahTransaksi = Transaksi::count();

        // Total kas masuk (debit) - asumsikan kolom 'posisi' menyimpan debit/kredit
        $totalkasMasuk = DB::table('jurnal')
            ->where('no_akun', '111')
            ->where('posisi', 'debit')
            ->sum('saldo');

        // Total kas keluar (kredit)
        $totalkasKeluar = DB::table('jurnal')
            ->where('no_akun', '111')
            ->where('posisi', 'kredit')
            ->sum('saldo');

        // Saldo kas yang tersisa
        $totalKas = $totalkasMasuk - $totalkasKeluar;

        // Mengirim data ke view
        return view('dashboard', [
            'jumlahTransaksi' => $jumlahTransaksi,
            'totalkasMasuk' => $totalkasMasuk,
            'totalkasKeluar' => $totalkasKeluar,
            'totalKas' => $totalKas,
            'datas' => $datas
        ]);

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
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(Kas $kas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kas $kas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 
    }
}
