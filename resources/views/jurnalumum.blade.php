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
                                <h5 class="m-b-10">Jurnal Umum</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Jurnal Umum</a></li>
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
                            <h5>Data Jurnal Umum</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('jurnalumum') }}" method="GET" class="mb-3">
                                <div class="form-group">
                                    <label for="bulan_tahun">Bulan dan Tahun:</label>
                                    <input type="month" class="form-control" name="bulan_tahun" id="bulan_tahun" required
                                        onchange="fetchJurnal()">
                                </div>
                            </form>

                            <h4 class="text-center">Jurnal Umum</h4>
                            <h4 class="text-center" id="judulPeriode"></h4>

                            <div class="dt-responsive table-responsive" id="jurnalTableContainer">
                                <table id="jurnalUmumTable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Tanggal</th>
                                            <th style="width: 30%;">Akun</th>
                                            <th style="width: 20%;">No Akun</th>
                                            <th style="width: 15%;">Debet</th>
                                            <th style="width: 15%;">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="jurnalTableBody">
                                        <!-- Data akan dimuat di sini melalui AJAX -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                            <td id="totalDebet">0</td>
                                            <td id="totalKredit">0</td>
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

    <!-- Scripts for DataTable -->
    <script>
        // Function to format numbers into Rupiah currency
        function formatRupiah(angka) {
            const rupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(angka);
            return rupiah;
        }

        // Function to fetch jurnal
        function fetchJurnal() {
            const bulan = document.getElementById('bulan_tahun').value;

            // Kosongkan tabel terlebih dahulu
            $('#jurnalTableBody').empty();
            $('#totalDebet').text('0');
            $('#totalKredit').text('0');
            $('#judulPeriode').text(''); // Kosongkan judul periode

            if (bulan) {
                $.ajax({
                    url: '{{ route('jurnal.fetch') }}',
                    type: 'GET',
                    data: {
                        bulan: bulan
                    },
                    success: function(data) {
                        // Cek apakah data adalah array kosong
                        if (!Array.isArray(data) || data.length === 0) {
                            // Jika data kosong, tidak ada yang perlu ditampilkan
                            return; // Keluar dari fungsi jika array kosong
                        }

                        let totalDebet = 0;
                        let totalKredit = 0;

                        // Set judul periode
                        const bulanTahun = new Date(bulan);
                        const options = {
                            month: 'long',
                            year: 'numeric'
                        };
                        const bulanTahunText = bulanTahun.toLocaleDateString('id-ID', options);
                        $('#judulPeriode').text(`Periode: ${bulanTahunText}`);

                        // masukin data baru ke tabel
                        data.forEach(function(item) {
                            let debet = 0;
                            let kredit = 0;

                            // logika buat nentuin debet ato kredit berdasarkan 'ket'
                            if (item.posisi === 'debit') {
                                debet = item.saldo; // buat masukin saldo ke debit

                                $('#jurnalTableBody').append(`
                            <tr>
                                <td>${item.tanggal}</td>
                                <td>${item.akun}</td>
                                <td>${item.no_akun}</td>
                                <td>${formatRupiah(debet)}</td>
                                <td></td>
                            </tr>
                        `);
                            } else if (item.posisi === 'kredit') {
                                kredit = item.saldo; // buat masukin saldo ke kredit

                                $('#jurnalTableBody').append(`
                            <tr>
                                <td>${item.tanggal}</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;${item.akun}</td>
                                <td>${item.no_akun}</td>
                                <td></td>
                                <td>${formatRupiah(kredit)}</td>
                            </tr>
                        `);
                            }

                            totalDebet += debet;
                            totalKredit += kredit;
                        });

                        // Update total
                        $('#totalDebet').text(formatRupiah(totalDebet));
                        $('#totalKredit').text(formatRupiah(totalKredit));

                        // Inisialisasi DataTable setelah data diisi
                        $('#jurnalUmumTable').DataTable().destroy(); // Hapus instance sebelumnya
                        $('#jurnalUmumTable').DataTable(); // Buat instance baru
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengambil data.');
                    }
                });
            }
        }
    </script>
@endsection
