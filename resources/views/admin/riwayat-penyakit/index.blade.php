@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Riwayat Penyakit Pasien</h1>
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
                            <h3 class="card-title">Data Riwayat Penyakit Pasien</h3>
                            <a href="{{ route('riwayat-penyakit.create') }}" class="btn btn-primary ml-auto btn-sm"><i class="fas fa-plus fa-sm"></i> Tambah</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>ID PASIEN</th>
                                        <th>NAMA PASIEN</th>
                                        <th>JENIS KELAMIN</th>
                                        <th>RIWAYAT PENYAKIT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $riwayat_penyakit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $riwayat_penyakit->pasien->nomor_pasien }}</td>
                                        <td>{{ $riwayat_penyakit->pasien->nama }}</td>
                                        <td>{{ $riwayat_penyakit->pasien->jk }}</td>
                                        <td>{{ $riwayat_penyakit->nama_penyakit }}</td>
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
