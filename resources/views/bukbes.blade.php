@extends('layout')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Buku Besar</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Buku Besar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="row">
                <div class="col-sm-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Buku Besar</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="GET" id="filterForm" class="mb-3">
                                <div class="form-group">
                                    <label for="bulan_tahun">Bulan dan Tahun:</label>
                                    <input type="month" class="form-control" name="bulan" id="bulan_tahun" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_akun">Akun:</label>
                                    <select name="no_akun" id="no_akun" class="form-control" required>
                                        <option value="">Pilih Akun</option>
                                        @foreach ($akunList as $akun)
                                            <option value="{{ $akun->no_akun }}">{{ $akun->nama_akun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </form>

                            <h4 class="text-center" id="judulPeriode"></h4>

                            <div class="dt-responsive table-responsive" id="bukuBesarTableContainer">
                                <table id="bukuBesarTable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">Tanggal</th>
                                            <th rowspan="2" class="text-center">Nama Akun</th>
                                            <th rowspan="2" class="text-center">No. Akun</th>
                                            <th rowspan="2" class="text-center">Debet</th>
                                            <th rowspan="2" class="text-center">Kredit</th>
                                            <th colspan="2" class="text-center">Saldo </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Debet</th>
                                            <th class="text-center">Kredit</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody id="bukuBesarTableBody">
                                        <!-- Baris saldo awal -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                            <td id="totalSaldoD"></td>
                                            <td id="totalSaldoK"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="text-right mt-3">
                                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const bulan = document.getElementById('bulan_tahun').value;
            const noAkun = document.getElementById('no_akun').value;

            $('#bukuBesarTableBody').empty();
            $('#saldoAwal').text('');
            $('#judulPeriode').text('');
            $('#totalSaldoD').text('');
            $('#totalSaldoK').text('');

            if (bulan && noAkun) {
                $.ajax({
                    url: '{{ route('jurnal.bukbes') }}',
                    type: 'GET',
                    data: {
                        bulan: bulan,
                        no_akun: noAkun
                    },
                    success: function(response) {
                        const data = response.data;
                        let saldo = parseFloat(response.saldoAwal) || 0;
                        const posisiAwal = response.posisi_awal;
                        let debetAwal = 0;
                        let kreditAwal = 0;

                        // nentuin saldo awal berdasarkan posisi awal
                        if (posisiAwal === 'd') {
                            $('#bukuBesarTableBody').append(`
                            <tr>
                                <td>-</td>
                                <td>Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>${saldo}</td>
                                <td></td>
                            </tr>
                        `);
                        } else if (posisiAwal === 'k') {
                            $('#bukuBesarTableBody').append(`
                            <tr>
                                <td>-</td>
                                <td>Saldo Awal</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>${saldo}</td>
                            </tr>
                        `);
                        }

                        let totalSaldo = saldo;

                        // proses tambah baris baru setiap transaksi
                        data.forEach(function(item) {
                            let debet = 0;
                            let kredit = 0;

                            if (item.posisi === 'd') {
                                debet = item.saldo;
                                $('#bukuBesarTableBody').append(`
                                <tr>
                                    <td>${item.tanggal}</td>
                                    <td>${item.nama_akun}</td>
                                    <td>${item.no_akun}</td>
                                    <td>${debet}</td>
                                    <td></td>
                            `);
                            } else if (item.posisi === 'k') {
                                kredit = item.saldo;
                                $('#bukuBesarTableBody').append(`
                                <tr>
                                    <td>${item.tanggal}</td>
                                    <td>${item.nama_akun}</td>
                                    <td>${item.no_akun}</td>
                                    <td></td>
                                    <td>${kredit}</td>
                            `);
                            }

                            // apdet saldo berdasarkan posisi awal dan transaksi
                            if (posisiAwal === 'd') {
                                totalSaldo += debet - kredit;
                                // apdet saldo di baris tabel
                                $('#bukuBesarTableBody').last().find('tr:last').append(
                                    `<td>${totalSaldo}</td>
                                    <td></td></tr>`);
                            } else if (posisiAwal === 'k') {
                                totalSaldo += kredit - debet;
                                // apdet saldo di baris tabel
                                $('#bukuBesarTableBody').last().find('tr:last').append(
                                    `<td></td>
                                    <td>${totalSaldo}</td></tr>`);
                            }
                        });
                        
                        // tampilin total saldo di bagian footer tabel
                        if (posisiAwal === 'd') {
                            $('#totalSaldoD').text(totalSaldo);
                        } else if (posisiAwal === 'k') {
                            $('#totalSaldoK').text(totalSaldo);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengambil data.');
                    }
                });
            }
        });
    </script>
@endsection
