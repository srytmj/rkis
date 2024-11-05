<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Jurnal;
use App\Models\Akun;
use App\Http\Requests\StoreJurnalRequest;
use App\Http\Requests\UpdateJurnalRequest;
use Illuminate\Http\Request;


class JurnalController extends Controller
{
    public function jurnalumum(Request $request)
    {
        // Ambil bulan dan tahun dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // query buat ambil data jurnal berdasarkan bulan dan tahun
        $jurnal = null;
        if ($bulan && $tahun) {
            $jurnal = Kas::whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();
        }

        return view('jurnalumum', compact('jurnal', 'bulan', 'tahun'));
    }

    public function fetchJurnal(Request $request)
    {
        $bulan = $request->input('bulan'); // ambil bulan dari request
        // misal kita ambil data dari model Jurnal berdasarkan bulan
        $data = Jurnal::whereMonth('tanggal', '=', date('m', strtotime($bulan)))
            ->whereYear('tanggal', '=', date('Y', strtotime($bulan)))
            ->join('akun', 'jurnal.no_akun', '=', 'akun.no_akun')
            ->get(['jurnal.tanggal', 'jurnal.id_transaksi', 'akun.nama_akun', 'jurnal.no_akun', 'jurnal.saldo', 'jurnal.posisi']); //gett

        // formatting data JSON
        $formattedData = $data->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'akun' => $item->nama_akun,
                'no_akun' => $item->no_akun,
                'saldo' => $item->saldo,
                'posisi' => $item->posisi,
            ];
        });

        return response()->json($formattedData);
    }

    public function bukubesar()
    {
        $akunList = Akun::all();
        return view('bukbes', compact('akunList'));
    }

    public function fetchBukbes(Request $request)
    {
        $bulan = $request->input('bulan');
        $noAkun = $request->input('no_akun');
    
        // ambil data bulan sama tahun sekarang
        $currentMonth = date('m', strtotime($bulan));
        $currentYear = date('Y', strtotime($bulan));
    
        // ambil data jurnal berdasarkan bulan dan tahun
        $data = Jurnal::whereMonth('tanggal', '=', $currentMonth)
            ->whereYear('tanggal', '=', $currentYear)
            ->where('jurnal.no_akun', $noAkun)
            ->join('akun', 'jurnal.no_akun', '=', 'akun.no_akun')
            ->get(['jurnal.tanggal', 'jurnal.no_akun', 'akun.nama_akun', 'jurnal.saldo', 'jurnal.posisi']);
    
        // buat nentuin bulan sebelumnya nanti dipake buat saldo awal
        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;
        if ($previousMonth < 1) {
            $previousMonth = 12;
            $previousYear -= 1;
        }
    
        // nentuin tipe akun
        $accountType = Akun::where('no_akun', $noAkun)->value('tipe_akun');
        $posisiAwal = $accountType == 'd' ? 'd' : 'k';
    
        // ambil data dari bulan sebelumnya
        $previousTransactions = Jurnal::whereMonth('tanggal', '=', $previousMonth)
            ->whereYear('tanggal', '=', $previousYear)
            ->where('no_akun', $noAkun)
            ->get();
    
        // itung saldo awal
        $totalDebet = $previousTransactions->where('posisi', 'd')->sum('saldo');
        $totalKredit = $previousTransactions->where('posisi', 'k')->sum('saldo');
    
        if ($posisiAwal == 'd') {
            $saldoAwal = $totalDebet - $totalKredit;
        } else {
            $saldoAwal = $totalKredit - $totalDebet;
        }
    
        return response()->json([
            'data' => $data,
            'saldoAwal' => $saldoAwal,
            'posisi_awal' => $posisiAwal
        ]);
    }
    
    
}