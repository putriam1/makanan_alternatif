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
                            <h3 class="card-title">Tambah Data Konsultasi</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('konsul.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="pasien" class="form-label">Nomor Pasien</label>
                                    <input type="text" class="form-control" id="pasien" name="pasien">
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="nama" name="nama" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="penyakit" class="form-label">Riwayat Penyakit</label>
                                    <input type="text" class="form-control" id="penyakit" name="penyakit" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="ahli-gizi" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="ahli-gizi" name="ahli-gizi">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_ahligizi" class="form-label">Nama Ahli Gizi</label>
                                    <input type="text" class="form-control" id="nama_ahligizi" name="nama_ahligizi" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_makanan" class="form-label">Makanan</label>
                                    <select name="kode_makanan" id="kode_makanan" class="form-control">
                                        <option value="">-- Pilih Makanan --</option>
                                        @foreach ($makanan as $data_makanan)
                                            <option value="{{ $data_makanan->kode_makanan }}" {{ old('kode_makanan', $selected_makanan ?? '') == $data_makanan->kode_makanan ? 'selected' : '' }}>
                                                {{ $data_makanan->nama_makanan }} || Protein : {{ $data_makanan->protein }} || Lemak : {{ $data_makanan->lemak }} || Karbohidrat : {{ $data_makanan->karbohidrat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2">
                                        <button type="submit" formaction="{{ route('konsul.cek-protein')}}" class="btn btn-info">Cek Protein</button>
                                        <button type="submit" formaction="{{ route('konsul.cek-lemak')}}" class="btn btn-success">Cek Lemak</button>
                                        <button type="submit" formaction="{{ route('konsul.cek-karbohidrat')}}" class="btn btn-warning">Cek Karbohidrat</button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_makanan_alternative" class="form-label">Makanan Alternatif</label>
                                    <table class="table">
                                        @foreach ( $kode_makanan_alternative as $makanan )
                                            <tr>
                                                <td><input type="checkbox" name="kode_makanan_alternative[]" value="{{ $makanan['kode_makanan'] }}" 
                                                    @if (is_array($selected_makanan_alternative) && in_array($makanan->kode_makanan, $selected_makanan_alternative))
                                                        checked
                                                    @endif
                                                    >
                                                </td>
                                                <td>{{ $makanan->nama_makanan }}</td>
                                                <td>Protein : {{$makanan->protein }}</td>
                                                <td>Lemak : {{$makanan->lemak }}</td>
                                                <td>Karbohidrat : {{$makanan->karbohidrat }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mb-3">
                                    <label for="tgl_konsultasi" class="form-label">Tanggal Konsultasi</label>
                                    <input type="date" class="form-control" id="tgl_konsultasi" name="tgl_konsultasi" value="{{ old('tgl_konsultasi', $tgl_konsultasi) }}">
                                </div>
                                <a href="{{ route('konsul.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#pasien').on('input', function() {
            var id_pasien = $(this).val();
            if (id_pasien) {
                $.ajax({
                    url: '/pasien/' + id_pasien,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#nama').val(data.nama);
                        } else {
                            $('#nama').val('');
                        }
                    },
                    error: function() {
                        $('#nama').val('');
                    }
                });
                $.ajax({
                    url: '/riwayatpenyakit/' + id_pasien,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#penyakit').val(data.nama_penyakit);
                        } else {
                            $('#penyakit').val('');
                        }
                    },
                    error: function() {
                        $('#penyakit').val('');
                    }
                });
            } else {
                $('#nama').val('');
                $('#penyakit').val('');
            }
        });
        $('#ahli-gizi').on('input', function() {
            var nip = $(this).val();
            if (nip) {
                $.ajax({
                    url: '/ahligizi/' + nip,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#nama_ahligizi').val(data.nama);
                        } else {
                            $('#nama_ahligizi').val('');
                        }
                    },
                    error: function() {
                        $('#nama_ahligizi').val('');
                    }
                });
            } else {
                $('#nama_ahligizi').val('');
            }
        });
    });
</script>


@endsection