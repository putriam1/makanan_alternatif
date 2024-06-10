@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="card p-3">
                <div class="card-body">
                    <h1>Selamat Datang</h1>
                    <h3 class="text-sm">Dashboard Informasi Pasien</h3>
                </div>
            </div>
        </div>
    </section>

    <div class="row justify-content-center mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Informasi Tentang RS Bhayangkara Kediri
            </div>
            <div class="card-body">
                <h2 class="card-title">RS Bhayangkara Kediri</h2>
                <p class="card-text">RS Bhayangkara Kediri adalah rumah sakit yang terletak di Kediri, Jawa Timur, menyediakan layanan kesehatan berkualitas dengan fokus pada pelayanan prima bagi masyarakat.</p>
                <a href="https://rsbhayangkarakediri.com/beranda" class="btn btn-primary" target="_blank">Lihat Informasi</a>
            </div>
            <div class="card-footer">
                <small class="text-muted">Terakhir diperbarui: {{ date('d F Y') }}</small>
            </div>
        </div>
    </div>


    <div class="col-md-6">
    <div class="card">
        <div class="card-header bg-success text-white">
            Informasi Kesehatan Pribadi
        </div>
        <div class="card-body">
            <h5 class="card-title">Selamat datang, [Nama Pasien]</h5>
            <p class="card-text">Berikut adalah data terkait informasi kesehatan Anda. Anda dapat melihat riwayat konsultasi dan informasi terkait di bawah ini.</p>
            <ul class="list-group mb-3">
                <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                    Riwayat Konsultasi
                    <span class="badge badge-primary badge-pill">0</span>
                </li> -->
                <!-- Anda dapat menambahkan informasi kesehatan lainnya di sini -->
            </ul>
            <a href="/histori" class="btn btn-success">Lihat Riwayat Konsultasi</a>
        </div>
        <div class="card-footer">
            <small class="text-muted">Terakhir diperbarui: {{ date('d F Y') }}</small>
        </div>
    </div>
</div>


</div>

@endsection
