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
                                    <!-- <th>RIWAYAT PENYAKIT</th> -->
                                    <th>MAKANAN</th>
                                    <th>MAKANAN ALTERNATIF</th>
                                    <th>TANGGAL KONSULTASI</th>
                                </thead>
                                <tbody>
                                @foreach ($data as $konsul)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $konsul->pasien->nama }}</td>
                                        <td>{{ $konsul->ahligizi->nama }}</td>
                                        <!-- <td>
                                            <div class="list-group">
                                                @foreach ($konsul->group_penyakit as $penyakit)
                                                    <div class="w-100">
                                                        - {{$penyakit}}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td> -->
                                        <td>
                                            <div class="list-group">
                                                @foreach ($konsul->group_makanan as $kategori => $makanan)
                                                    <div class="w-100 text-bold">
                                                        {{$loop->iteration}}. {{$kategori}}
                                                    </div>
                                                    <p class="mb-0 ml-3">
                                                        @foreach ($makanan as $makanan)
                                                            - {{$makanan}}<br>
                                                        @endforeach
                                                    </p>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="list-group">
                                                @foreach ($konsul->group_makanan_alternative as $kategori => $makanan_alternatif)
                                                    <div class="w-100 text-bold">
                                                        {{$loop->iteration}}. {{$kategori}}
                                                    </div>
                                                    <p class="mb-0 ml-3">
                                                        @foreach ($makanan_alternatif as $makanan)
                                                            - {{$makanan}}<br>
                                                        @endforeach
                                                    </p>
                                                @endforeach
                                            </div>
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