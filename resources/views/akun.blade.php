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
                                <h5 class="m-b-10">Data Akun</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Data Akun</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- DataTable for Akun start -->
            <div class="col-sm-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Akun</h5>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="akunTable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">No Akun</th>
                                        <th style="width: 45%;">Nama Akun</th>
                                        <th style="width: 10%;">Tipe Akun</th>
                                        <th style="width: 25%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($akuns as $akun)
                                        <tr class="datarow" data-id="{{ $akun->no_akun }}">
                                            <td>{{ $akun->no_akun }}</td>
                                            <td>{{ $akun->nama_akun }}</td>
                                            <td>{{ $akun->tipe_akun == 'debit' ? 'Debit' : 'Kredit' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $akun->no_akun }}">
                                                    Edit
                                                </button>
                                                <!-- Button Hapus -->
                                                <form action="{{ route('akun.destroy', $akun->no_akun) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit setiap data -->
                                        <div class="modal fade" id="editModal{{ $akun->no_akun }}" tabindex="-1"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Akun</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('akun.update', $akun->no_akun) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group mb-3">
                                                                <label for="no_akun">No Akun</label>
                                                                <input type="text" class="form-control"
                                                                    id="no_akun" name="no_akun"
                                                                    value="{{ $akun->no_akun }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="nama_akun">Nama Akun</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_akun" name="nama_akun"
                                                                    value="{{ $akun->nama_akun }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="tipe_akun">Tipe Akun</label><br>
                                                                <input type="radio" id="debit{{ $akun->no_akun }}" name="tipe_akun" value="d" {{ $akun->tipe_akun == 'debit' ? 'checked' : '' }}>
                                                                <label for="debit{{ $akun->no_akun }}">Debit</label>
                                                                <input type="radio" id="kredit{{ $akun->no_akun }}" name="tipe_akun" value="k" {{ $akun->tipe_akun == 'kredit' ? 'checked' : '' }}>
                                                                <label for="kredit{{ $akun->no_akun }}">Kredit</label>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Update
                                                                    Akun</button>
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
                                Akun</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DataTable for Akun end -->

            <!-- Modal Tambah Akun -->
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Tambah Akun</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('akun.store') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="no_akun">No Akun</label>
                                    <input type="text" class="form-control" id="no_akun" name="no_akun" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nama_akun">Nama Akun</label>
                                    <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tipe_akun">Tipe Akun</label><br>
                                    <input type="radio" id="debit" name="tipe_akun" value="d" required>
                                    <label for="debit">Debit</label>
                                    <input type="radio" id="kredit" name="tipe_akun" value="k">
                                    <label for="kredit">Kredit</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Akun</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
