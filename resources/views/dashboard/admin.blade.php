@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Main content -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="card p-3">
        <div class="card-body">
          <h1>Selamat Datang</h1>
          <h3 class="text-sm">Dashboard Admin Rumah Sakit Bhayangkara</h3>
        </div>
      </div>
    </div>
  </section>
  <div class= "row justify-content-center">
    <div class="col-md-3">
      <div class="card card-body bg-primary text-white mb-3" style="display: flex; justify-content: space-between; align-items: center;">
          <label>Jumlah Pasien</label>
          <h2>0</h2>
          <a href="/pasien" class="btn btn-link text-white" >Lihat</a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-body bg-success text-white mb-3" style="display: flex; justify-content: space-between; align-items: center;">
        <label>Jumlah Makanan</label>
        <h2>0</h2>
        <a href="/makanan" class="btn btn-link text-white" >Lihat</a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-body bg-warning text-white mb-3" style="display: flex; justify-content: space-between; align-items: center;">
        <label>Jumlah Konsultasi</label>
        <h2>0</h2>
        <a href="/konsul" class="btn btn-link text-white" >Lihat</a>
      </div>
    </div>
  </div>
  <!-- /.content -->
</div>

@endsection