<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Surat Konsultasi - RS Bhayangkara Kediri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
        display: flex;
        align-items: center; /* Memposisikan item ke tengah vertikal */
        margin-bottom: 20px; /* Jarak bawah untuk memisahkan dengan konten berikutnya */
    }
    .logo {
        width: 100px; /* Sesuaikan lebar gambar sesuai kebutuhan */
        height: auto; /* Biarkan ketinggian disesuaikan dengan proporsi aslinya */
        margin-right:20px
    }
    .rs-info {
        display: flex;
        flex-direction: column; /* Menyusun teks RS info secara vertikal */
    }
    .rs-name {
        font-size: 18px; /* Ukuran teks nama RS */
        font-weight: bold; /* Bold untuk teks nama RS */
        margin-bottom: 5px; /* Jarak bawah teks nama RS */
    }
    .address {
        font-size: 14px; /* Ukuran teks alamat */
    }
        .content-wrapper {
            padding: 20px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .item {
            margin-bottom: 15px;
        }
        .item strong {
            display: inline-block;
            width: 150px;
        }
        ul {
            margin-top: 5px;
            padding-left: 20px;
        }
        ul li {
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
        }
        hr {
            border: 2px solid black;
            margin: 0 20px;
        }
    </style>
</head>
<body>
<div class="kop-surat">
    <img class="logo" src="{{ public_path('assets/dist/img/rs.png') }}" alt="Logo RS Bhayangkara Kediri">
    <div class="rs-info">
        <div class="rs-name">RS Bhayangkara Kediri</div>
        <div class="address">
            Jl. Letjen S. Parman No.1, Kediri, Jawa Timur 64123<br>
            Telepon: (0354) 123456, Fax: (0354) 123457
        </div>
    </div>
</div>

    <hr>
    <div class="content-wrapper">
        <div class="title">Berikut Adalah Detail Hasil Konsultasi Anda</div>
        <div class="item">
            <strong>Pasien :</strong> {{ $pasien }} <br>
            <strong>Ahli Gizi :</strong> {{ $ahli_gizi }} <br>

        </div>
        <div class="item">
            <h2>Makanan</h2>
            @if(count($makanan) > 0)
                <ul>
                    @foreach($makanan as $item)
                        <li>{{ $item['nama_makanan'] }} - Protein: {{ $item['protein'] }}g, Lemak: {{ $item['lemak'] }}g, Karbohidrat: {{ $item['karbohidrat'] }}g</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada data makanan.</p>
            @endif
        </div>
        <div class="item">
            <h2>Dari hasil konsultasi makanan yang boleh dikonsumsi sebagai berikut </h2>

            <!-- {{-- <strong>Riwayat Penyakit :</strong> 
            <ul>
                @foreach($riwayat as $item)
                    Nama Penyakit : {{ $item['nama_penyakit'] }} <br>
                @endforeach
            </ul> --}} -->
            <strong>Makanan :</strong> 
            <ul>
                @foreach($makanan as $item)
                    Nama Makanan : {{ $item['nama_makanan'] }} ||
                    Protein : {{ $item['protein'] }} ||
                    Lemak : {{ $item['lemak'] }} ||
                    Karbohidrat : {{ $item['karbohidrat'] }} <br>
                @endforeach
            </ul>
            <strong>Makanan Alternatif:</strong>
            @if(count($makanan_alternative) > 0)
                @foreach($makanan_alternative as $group)
                    <ul>
                        @foreach ($group as $alt)
                            <li>Nama Makanan: {{ $alt['nama_makanan_alternative'] }} - Protein: {{ $alt['protein'] }}g, Lemak: {{ $alt['lemak'] }}g, Karbohidrat: {{ $alt['karbohidrat'] }}g</li>
                        @endforeach
                    </ul>
                @endforeach
            @else
                <p>Data tidak tersedia</p>
            @endif
        </div>
        <div class="item">
            <strong>Tanggal Konsultasi:</strong> {{ $tanggal_konsultasi }} <br>
        </div>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} RS Bhayangkara Kediri. All rights reserved.
    </div>
</body>
</html>
