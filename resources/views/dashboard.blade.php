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

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-book f-30 text-c-purple"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Dana yang tersisa</h6>
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
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <i class="icon feather icon-activity f-30 text-c-orange"></i>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Jumlah Transaksi</h6>
                                    <h2 class="m-b-0">{{ $jumlahTransaksi }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

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
                                            <th style="width: 5%;">ID</th>
                                            <th style="width: 5%;">Tanggal</th>
                                            <th style="width: 15%;">Nama Transaksi</th>
                                            <th style="width: 15%;">Jenis Transaksi</th>
                                            <th style="width: 25%;">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr class="datarow" data-id="{{ $data->id }}">
                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->tanggal }}</td>
                                                <td>{{ $data->nama_transaksi}}</td>
                                                <td>{{ $data->jenis_transaksi }}</td>
                                                <td>{{ $data->deskripsi }}</td>
                                            </tr>                    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DataTable for User Access Menu end -->
            @endsection
