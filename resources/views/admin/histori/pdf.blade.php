<!-- resources/views/admin/histori/pdf_single.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF Template</title>
    <!-- Tambahkan CSS sesuai kebutuhan -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .content-wrapper {
            padding: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .item {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="title">Detail Konsultasi</div>
        <div class="item">
            <strong>Pasien:</strong> {{ $pasien }} <br>
            <strong>Ahli Gizi:</strong> {{ $ahli_gizi }} <br>
            <strong>Riwayat Penyakit:</strong> {{ $riwayat }} <br>
            <strong>Makanan:</strong> {{ $makanan }} <br>
            <strong>Makanan Alternatif:</strong> 
            @if(is_array($makanan_alternative) && count($makanan_alternative) > 0)
                <ul>
                    @foreach($makanan_alternative as $alt)
                        <li>
                            <strong>Nama:</strong> {{ $alt['nama_makanan_alternative'] }},
                            <strong>Protein:</strong> {{ $alt['protein'] }},
                            <strong>Lemak:</strong> {{ $alt['lemak'] }},
                            <strong>Karbo:</strong> {{ $alt['karbo'] }}
                        </li>
                    @endforeach
                </ul>
            @else
                Data tidak tersedia
            @endif
            <br>
            <strong>Tanggal Konsultasi:</strong> {{ $tanggal_konsultasi }} <br>
        </div>
    </div>
</body>


</html>
