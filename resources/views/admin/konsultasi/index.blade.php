@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Konsultasi</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">Data Konsultasi</h3>
                            <a href="{{ route('konsul.create') }}" class="btn btn-primary ml-auto btn-sm"><i class="fas fa-plus fa-sm"></i> Tambah</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Table -->
                            <table class="table table-bordered">
                                <thead>
                                    <th>NO</th>
                                    <th>PASIEN</th>
                                    <th>AHLI GIZI</th>
                                    <th>MAKANAN </th>
                                    <th>MAKANAN ALTERNATIF</th>
                                    <th>TANGGAL KONSULTASI</th>
                                </thead>
                                <tbody>
                                @foreach ($data as $konsul)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $konsul->pasien->nama }}</td>
                                        <td>{{ $konsul->ahligizi->nama }}</td>
                                        <td>{{ $konsul->makanan ? $konsul->makanan->nama_makanan : 'N/A' }}</td>
                                        <td>
                                            @foreach ($konsul->makanan_alternative_by_category as $makanan_alternatif)
                                                @foreach ($makanan_alternatif as $makanan)s
                                                    ID Kategori: {{ $makanan['id_kategori'] }} - Nama Makanan: {{ $makanan['nama_makanan'] }}<br>
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>{{ $konsul->tgl_konsultasi }}</td>
                                    </tr>
                                @endforeach

                                    <!-- Tambahkan baris tabel lainnya di sini -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $data->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection