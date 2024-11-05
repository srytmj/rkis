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
                                <h5 class="m-b-10">Dashboard Kas</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Dashboard Kas</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- customar project start -->

                {{-- <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-book f-30 text-c-purple"></i>
                                </div>
                                <div class="col-auto">Dana yang tersisa</h6>
                                    <h2 class="m-b-0">{{ \App\Helpers\RupiahHelper::rupiah($totalKas) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-award f-30 text-c-blue"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Pengeluaran hari ini</h6>
                                    <h2 class="m-b-0">{{ \App\Helpers\RupiahHelper::rupiah($kasKeluar) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-users f-30 text-c-red"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Total kas masuk</h6>
                                    <h2 class="m-b-0">{{ \App\Helpers\RupiahHelper::rupiah($totalkasMasuk) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-navigation-2 f-30 text-c-green"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Total pengeluaran</h6>
                                    <h2 class="m-b-0">{{ \App\Helpers\RupiahHelper::rupiah($totalkasKeluar) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- customar project end -->


                <!-- DataTable for User Access Menu start -->
                <div class="col-sm-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Kas</h5>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="userAccessMenuTable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Tanggal</th>
                                            <th style="width: 25%;">Keterangan</th>
                                            <th style="width: 15%;">Saldo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr class="datarow" data-id="{{ $data->id }}">
                                                <td>{{ $data->tanggal }}</td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td>{{ \App\Helpers\RupiahHelper::rupiah($data->saldo) }}</td>
                                                <td>
                                                    {{-- <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $data->id }}">
                                                        Edit
                                                    </button> --}}
                                                </td>
                                            </tr>

                                            <!-- Modal Edit untuk setiap data -->
                                            <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Data Kas</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('dashboard.update', $data->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group mb-3">
                                                                    <label for="tanggal">Tanggal</label>
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal" name="tanggal"
                                                                        value="{{ $data->tanggal }}" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="akun_d">Akun Debit</label>
                                                                    <select class="form-control" id="akun_d"
                                                                        name="akun_d" required>
                                                                        <option value="" disabled selected>Pilih Akun
                                                                        </option>
                                                                        @foreach ($akunList as $akun)
                                                                            <option value="{{ $akun->id }}"
                                                                                {{ $data->no_akun == $akun->no_akun ? 'selected' : '' }}>
                                                                                {{ $akun->nama_akun }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="akun_k">Akun Kredit</label>
                                                                    <select class="form-control" id="akun_k"
                                                                        name="akun_k" required>
                                                                        <option value="" disabled selected>Pilih Akun
                                                                        </option>
                                                                        @foreach ($akunList as $akun)
                                                                            <option value="{{ $akun->id }}"
                                                                                {{ $data->no_akun == $akun->no_akun ? 'selected' : '' }}>
                                                                                {{ $akun->nama_akun }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="saldo">Saldo</label>
                                                                    <input type="number" class="form-control"
                                                                        id="saldo" name="saldo"
                                                                        value="{{ $data->saldo }}" step="0.01"
                                                                        placeholder="Masukkan saldo" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="keterangan">Keterangan</label>
                                                                    <textarea class="form-control" id="keterangan" name="keterangan" required>{{ $data->keterangan }}</textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Update
                                                                        Data</button>
                                                                    <!-- Tombol Hapus -->
                                                                    <form
                                                                        action="{{ route('dashboard.destroy', $data->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Hapus</button>
                                                                    </form>
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
                                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">Tambah
                                    Data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DataTable for User Access Menu end -->

                <!-- Modal -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">Tambah Data Kas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dashboard.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="akun_d">Akun Debit</label>
                                        <select class="form-control" id="akun_d" name="akun_d" required>
                                            <option value="" disabled selected>Pilih Akun</option>
                                            @foreach ($akunList as $akun)
                                                <option value="{{ $akun->no_akun }}">{{ $akun->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="akun_k">Akun Kredit</label>
                                        <select class="form-control" id="akun_k" name="akun_k" required>
                                            <option value="" disabled selected>Pilih Akun</option>
                                            @foreach ($akunList as $akun)
                                                <option value="{{ $akun->no_akun }}">{{ $akun->nama_akun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="saldo">Saldo</label>
                                        <input type="number" class="form-control" id="saldo" name="saldo"
                                            step="0.01" placeholder="Masukkan saldo" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @include('edit')
            @endsection
