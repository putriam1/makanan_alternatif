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
                                    <label for="id_pasien" class="form-label">Nomor Pasien</label>
                                    <input type="text" class="form-control" id="id_pasien" name="id_pasien" value="{{ session('input_data.id_pasien') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="nama" name="nama" readonly value="{{ session('input_data.nama') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="id_ahli_gizi" class="form-label">NIP Ahli Gizi</label>
                                    <input type="text" class="form-control" id="id_ahli_gizi" name="id_ahli_gizi" value="{{ session('input_data.id_ahli_gizi') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_ahli_gizi" class="form-label">Nama Ahli Gizi</label>
                                    <input type="text" class="form-control" id="nama_ahli_gizi" name="nama_ahli_gizi" readonly value="{{ session('input_data.nama_ahli_gizi') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="id_riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                    <table class="table">
                                        <tbody id="riwayat_penyakit">

                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="kode_makanan_sayur" class="form-label">Makanan Sayur</label>
                                    <select name="kode_makanan_sayur" id="kode_makanan_sayur" class="form-control">
                                        <option value="">-- Pilih Makanan --</option>
                                        @foreach ($makanan_sayur as $data_makanan)
                                            <option value="{{ $data_makanan->kode_makanan }}" {{ old('kode_makanan', $selected_makanan_sayur ?? '') == $data_makanan->kode_makanan ? 'selected' : '' }}>
                                                {{ $data_makanan->nama_makanan }} || Protein : {{ $data_makanan->protein }} || Lemak : {{ $data_makanan->lemak }} || Karbohidrat : {{ $data_makanan->karbohidrat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2">
                                        <button type="submit" formaction="{{ route('konsul.cek-makanan-sayur')}}" class="btn btn-info">Cek Makanan</button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_makanan_alternative_sayur" class="form-label">Makanan Alternatif Sayur</label>
                                    <table class="table">
                                        @foreach ( $rekomendasi_makanan_alternative_sayur as $makanan )
                                            <tr>
                                                <td><input type="checkbox" name="kode_makanan_alternative_sayur[]" value="{{ $makanan['kode_makanan'] }}" 
                                                    @if (is_array($selected_makanan_alternative_sayur) && in_array($makanan->kode_makanan, $selected_makanan_alternative_sayur))
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
                                <hr>
                                <div class="mb-3">
                                    <label for="kode_makanan_lauk" class="form-label">Makanan Lauk</label>
                                    <select name="kode_makanan_lauk" id="kode_makanan_lauk" class="form-control">
                                        <option value="">-- Pilih Makanan --</option>
                                        @foreach ($makanan_lauk as $data_makanan)
                                            <option value="{{ $data_makanan->kode_makanan }}" {{ old('kode_makanan', $selected_makanan_lauk ?? '') == $data_makanan->kode_makanan ? 'selected' : '' }}>
                                                {{ $data_makanan->nama_makanan }} || Protein : {{ $data_makanan->protein }} || Lemak : {{ $data_makanan->lemak }} || Karbohidrat : {{ $data_makanan->karbohidrat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2">
                                        <button type="submit" formaction="{{ route('konsul.cek-makanan-lauk')}}" class="btn btn-info">Cek Makanan</button>    
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_makanan_alternative_lauk" class="form-label">Makanan Alternatif Lauk</label>
                                    <table class="table">
                                        @foreach ( $rekomendasi_makanan_alternative_lauk as $makanan )
                                            <tr>
                                                <td><input type="checkbox" name="kode_makanan_alternative_lauk[]" value="{{ $makanan['kode_makanan'] }}" 
                                                    @if (is_array($selected_makanan_alternative_lauk) && in_array($makanan->kode_makanan, $selected_makanan_alternative_lauk))
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
                                <hr>
                                <div class="mb-3">
                                    <label for="kode_makanan_buah" class="form-label">Makanan Buah</label>
                                    <select name="kode_makanan_buah" id="kode_makanan_buah" class="form-control">
                                        <option value="">-- Pilih Makanan --</option>
                                        @foreach ($makanan_buah as $data_makanan)
                                            <option value="{{ $data_makanan->kode_makanan }}" {{ old('kode_makanan', $selected_makanan_buah ?? '') == $data_makanan->kode_makanan ? 'selected' : '' }}>
                                                {{ $data_makanan->nama_makanan }} || Protein : {{ $data_makanan->protein }} || Lemak : {{ $data_makanan->lemak }} || Karbohidrat : {{ $data_makanan->karbohidrat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2">
                                        <button type="submit" formaction="{{ route('konsul.cek-makanan-buah')}}" class="btn btn-info">Cek Makanan</button>    
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_makanan_alternative_buah" class="form-label">Makanan Alternatif Buah</label>
                                    <table class="table">
                                        @foreach ( $rekomendasi_makanan_alternative_buah as $makanan )
                                            <tr>
                                                <td><input type="checkbox" name="kode_makanan_alternative_buah[]" value="{{ $makanan['kode_makanan'] }}" 
                                                    @if (is_array($selected_makanan_alternative_buah) && in_array($makanan->kode_makanan, $selected_makanan_alternative_buah))
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
                                <hr>
                                <div class="mb-3">
                                    <label for="kode_makanan_pokok" class="form-label">Makanan Pokok</label>
                                    <select name="kode_makanan_pokok" id="kode_makanan_pokok" class="form-control">
                                        <option value="">-- Pilih Makanan --</option>
                                        @foreach ($makanan_pokok as $data_makanan)
                                            <option value="{{ $data_makanan->kode_makanan }}" {{ old('kode_makanan', $selected_makanan_pokok ?? '') == $data_makanan->kode_makanan ? 'selected' : '' }}>
                                                {{ $data_makanan->nama_makanan }} || Protein : {{ $data_makanan->protein }} || Lemak : {{ $data_makanan->lemak }} || Karbohidrat : {{ $data_makanan->karbohidrat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="mt-2">
                                        <button type="submit" formaction="{{ route('konsul.cek-makanan-pokok')}}" class="btn btn-info">Cek Makanan</button>    
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_makanan_alternative_pokok" class="form-label">Makanan Alternatif Pokok</label>
                                    <table class="table">
                                        @foreach ( $rekomendasi_makanan_alternative_pokok as $makanan )
                                            <tr>
                                                <td><input type="checkbox" name="kode_makanan_alternative_pokok[]" value="{{ $makanan['kode_makanan'] }}" 
                                                    @if (is_array($selected_makanan_alternative_pokok) && in_array($makanan->kode_makanan, $selected_makanan_alternative_pokok))
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
                                    <input type="date" class="form-control" id="tgl_konsultasi" name="tgl_konsultasi" value="{{ session('input_data.tgl_konsultasi') }}">
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

<script src="{{ asset('js/riwayat_penyakit.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#id_pasien').on('input', function() {
            var id_pasien = $(this).val();
            if (id_pasien) {
                $.ajax({
                    url: '/pasien/' + id_pasien,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#nama').val(data.nama); // Perbarui ini untuk menggunakan kolom 'jk'
                        } else {
                            $('#nama').val('');
                        }
                    },
                    error: function() {
                        $('#nama').val('');
                    }
                });
            } else {
                $('#nama').val('');
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#id_ahli_gizi').on('input', function() {
            var id_ahli_gizi = $(this).val();
            if (id_ahli_gizi) {
                $.ajax({
                    url: '/ahli_gizi/' + id_ahli_gizi,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#nama_ahli_gizi').val(data.nama); // Perbarui ini untuk menggunakan kolom 'jk'
                        } else {
                            $('#nama_ahli_gizi').val('');
                        }
                    },
                    error: function() {
                        $('#nama_ahli_gizi').val('');
                    }
                });
            } else {
                $('#nama_ahli_gizi').val('');
            }
        });
    });
</script>

@endsection