<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Akun;
use App\Models\Jurnal;
use App\Http\Requests\StoreKasRequest;
use App\Http\Requests\UpdateKasRequest;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::today();

        // // Ambil data kas dari model dengan filter tanggal
        // $kasMasuk = Kas::where('no_akun', 'like', '1%') // filter akun yang dimulai dengan '1'
        //     ->whereDate('tanggal', $today) // filter berdasarkan tanggal hari ini
        //     ->sum('saldo'); // total kas masuk hari ini

        // $kasKeluar = Kas::where('no_akun', 'not like', '1%') // filter akun yang tidak dimulai dengan '1'
        //     ->whereDate('tanggal', $today) // filter berdasarkan tanggal hari ini
        //     ->sum('saldo'); // total kas keluar hari ini

        // $totalkasKeluar = Kas::where('no_akun', 'not like', '1%') // Total kas keluar
        //     ->sum('saldo');

        // $totalkasMasuk = Kas::where('no_akun', 'like', '1%') // Total kas masuk
        //     ->sum('saldo');

        // // Menghitung total kas keseluruhan (tanpa filter tanggal)
        // $masuk = Kas::where('no_akun', 'like', '1%') // Total kas masuk
        //     ->sum('saldo');

        // $keluar = Kas::where('no_akun', 'not like', '1%') // Total kas keluar
        //     ->sum('saldo');

        // $totalKas = $masuk - $keluar; // Total keseluruhan kas


        $akunList = Akun::all(); // Ambil semua akun dari tabel akun

        $datas = Kas::all(); // Ambil semua data kas

        // Kirim data ke view
        // return view('dashboard', compact('akunList', 'datas', 'totalkasMasuk', 'kasKeluar', 'totalkasKeluar', 'totalKas'));
        return view('dashboard', compact('akunList', 'datas'));

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
        // Validasi data
        $request->validate([
            'tanggal' => 'required|date',
            'saldo' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
            'akun_d' => 'required',
            'akun_k' => 'required',
        ]);

        // Buat data kas baru
        Kas::create([
            'tanggal' => $request->tanggal,
            'saldo' => $request->saldo,
            'keterangan' => $request->keterangan,
        ]);

        Jurnal::create([
            'tanggal' => $request->tanggal,
            'id_transaksi' => Kas::latest()->first()->id,
            'no_akun' => $request->akun_d,
            'saldo' => $request->saldo,
            'posisi' => 'd',
        ]);

        Jurnal::create([
            'tanggal' => $request->tanggal,
            'id_transaksi' => Kas::latest()->first()->id,
            'no_akun' => $request->akun_k,
            'saldo' => $request->saldo,
            'posisi' => 'k',
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Data kas berhasil ditambahkan.');
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
        // Validasi data
        $request->validate([
            'tanggal' => 'required|date',
            'akun' => 'required|exists:akun,id', // Pastikan akun ada dalam tabel akun
            'saldo' => 'required|numeric',
            'keterangan' => 'required|string|max:255',
        ]);

        // Temukan data kas berdasarkan ID
        $kas = Kas::findOrFail($id);
        
        // Perbarui data kas
        $kas->update([
            'tanggal' => $request->tanggal,
            'no_akun' => $request->akun,
            'saldo' => $request->saldo,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Data kas berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kas = Kas::findOrFail($id);
        $kas->delete(); // Hapus data kas
        return redirect()->route('dashboard.index')->with('success', 'Data kas berhasil dihapus.');
    }
}
