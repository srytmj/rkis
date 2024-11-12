@extends('layout')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Data Transaksi</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Data Transaksi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- DataTable for Transaksi start -->
            <div class="col-sm-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="userAccessMenuTable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 30%;">Nama Transaksi</th>
                                        <th style="width: 15%;">Tanggal</th>
                                        <th style="width: 10%;">Jenis Transaksi</th>
                                        <th style="width: 50%;">Detail Akun</th>
                                        <th style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksis as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->id }}</td>
                                            <td>{{ $transaksi->nama_transaksi }}</td>
                                            <td>{{ $transaksi->tanggal }}</td>
                                            <td>{{ $transaksi->jenis_transaksi }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($transaksiakuns as $item)
                                                        @if ($item->id == $transaksi->id)
                                                            <li>{{ ucfirst($item->posisi) }} - {{ $item->no_akun }}
                                                                ({{ $item->nama_akun }})
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $transaksi->id }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('transaksi.destroy', $transaksi->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Transaksi -->
                                        <div class="modal fade" id="editModal{{ $transaksi->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $transaksi->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $transaksi->id }}">
                                                            Edit Transaksi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('transaksi.update', $transaksi->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group mb-3">
                                                                <label for="name">Nama Transaksi</label>
                                                                <input type="text" class="form-control" id="name"
                                                                    name="name" value="{{ $transaksi->nama_transaksi }}"
                                                                    required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="tanggal">Tanggal</label>
                                                                <input type="date" class="form-control" id="tanggal"
                                                                    name="tanggal" value="{{ $transaksi->tanggal }}"
                                                                    required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="jenis_transaksi">Jenis Transaksi</label>
                                                                <select id="jenis_transaksi" name="jenis_transaksi"
                                                                    class="form-control" required>
                                                                    <option value="pemasukan"
                                                                        @if ($transaksi->jenis_transaksi == 'pemasukan') selected @endif>
                                                                        Pemasukan</option>
                                                                    <option value="pengeluaran"
                                                                        @if ($transaksi->jenis_transaksi == 'pengeluaran') selected @endif>
                                                                        Pengeluaran</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="deskripsi">Deskripsi</label>
                                                                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" required>{{ $transaksi->deskripsi }}</textarea>
                                                            </div>

                                                            <!-- Detail Akun -->
                                                            <div id="account-wrapper-{{ $transaksi->id }}">
                                                                @foreach ($transaksiakuns as $i => $item)
                                                                    @if ($item->id == $transaksi->id)
                                                                        <div class="form-group row mt-2">
                                                                            <div class="col-md-3">
                                                                                <select
                                                                                    name="accounts[{{ $i }}][no_akun]"
                                                                                    class="form-control" required>
                                                                                    <option value="">Pilih Akun
                                                                                    </option>
                                                                                    @foreach ($akuns as $akun)
                                                                                        <option
                                                                                            value="{{ $akun->no_akun }}"
                                                                                            @if ($akun->no_akun == $item->no_akun) selected @endif>
                                                                                            {{ $akun->nama_akun }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <select
                                                                                    name="accounts[{{ $i }}][type]"
                                                                                    class="form-control" required>
                                                                                    <option value="debit"
                                                                                        @if ($item->posisi == 'debit') selected @endif>
                                                                                        Debit</option>
                                                                                    <option value="kredit"
                                                                                        @if ($item->posisi == 'kredit') selected @endif>
                                                                                        Kredit</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <input type="number"
                                                                                    name="accounts[{{ $i }}][saldo]"
                                                                                    class="form-control"
                                                                                    value="{{ $item->saldo }}" required>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <button type="button"
                                                                                    class="btn btn-danger"
                                                                                    onclick="removeAccount(this)">-</button>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>

                                                            {{-- <!-- Button to add a new account -->
                                                            <div class="mt-3">
                                                                <button type="button" class="btn btn-success"
                                                                    onclick="addAccount('{{ $transaksi->id }}')">Tambah
                                                                    Akun</button>
                                                            </div> --}}

                                                            <div class="modal-footer mt-3">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right mt-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                                Transaksi</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DataTable for Transaksi end -->

            <!-- Modal Tambah Transaksi -->
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Tambah Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('transaksi.store') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name">Nama Transaksi</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jenis_transaksi">Jenis Transaksi</label>
                                    <select id="jenis_transaksi" name="jenis_transaksi" class="form-control" required>
                                        <option value="pemasukan">Pemasukan</option>
                                        <option value="pengeluaran">Pengeluaran</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" required></textarea>
                                </div>

                                <!-- Detail Akun -->
                                <div id="account-wrapper">
                                    <div class="form-group row mt-2">
                                        <div class="col-md-3">
                                            <select name="accounts[0][no_akun]" class="form-control" required>
                                                <option value="">Pilih Akun</option>
                                                @foreach ($akuns as $akun)
                                                    <option value="{{ $akun->no_akun }}">{{ $akun->nama_akun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="accounts[0][type]" class="form-control" required>
                                                <option value="debit">Debit</option>
                                                <option value="kredit">Kredit</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="accounts[0][saldo]" class="form-control"
                                                placeholder="Saldo" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success"
                                                onclick="addAccount()">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let accountIndex = 1;

        function addAccount(id = null) {
            const wrapper = id ? document.getElementById('account-wrapper' + id) : document.getElementById(
                'account-wrapper');
            const accountDiv = document.createElement('div');
            accountDiv.className = 'form-group row mt-2';
            accountDiv.innerHTML = `
            <div class="col-md-3">
                <select name="accounts[${accountIndex}][no_akun]" class="form-control" required>
                    <option value="">Pilih Akun</option>
                    @foreach ($akuns as $akun)
                        <option value="{{ $akun->no_akun }}">{{ $akun->nama_akun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="accounts[${accountIndex}][type]" class="form-control" required>
                    <option value="debit">Debit</option>
                    <option value="kredit">Kredit</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="accounts[${accountIndex}][saldo]" class="form-control"
                    placeholder="Saldo" required>
                </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger" onclick="removeAccount(this)">-</button>
            </div>
        `;
            wrapper.appendChild(accountDiv);
            accountIndex++;
        }

        function removeAccount(button) {
            button.closest('.form-group').remove();
        }
    </script>
@endsection
