<!-- resources/views/admin/histori/pdf.blade.php -->

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
            margin-bottom: 5px;
        }
        ul {
            margin-top: 5px;
        }
        ul li {
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="title">Detail Konsultasi</div>
        <div class="item">
            <strong>Pasien :</strong> {{ $pasien }} <br>
            <strong>Ahli Gizi :</strong> {{ $ahli_gizi }} <br>
            <strong>Riwayat Penyakit :</strong> 
            <ul>
                @foreach($riwayat as $item)
                    Nama Penyakit : {{ $item['nama_penyakit'] }} <br>
                @endforeach
            </ul>
            <strong>Makanan :</strong> 
            <ul>
                @foreach($makanan as $item)
                    Nama Makanan : {{ $item['nama_makanan'] }} ||
                    Protein : {{ $item['protein'] }} ||
                    Lemak : {{ $item['lemak'] }} ||
                    Karbohidrat : {{ $item['karbo'] }} <br>
                @endforeach
            </ul>
            <strong>Makanan Alternatif:</strong>
            @if(count($makanan_alternative) > 0)
                @foreach($makanan_alternative as $group)
                    <ul>
                        @foreach ($group as $alt)
                            Nama Makanan : {{ $alt['nama_makanan_alternative'] }} ||
                            Protein : {{ $alt['protein'] }} ||
                            Lemak : {{ $alt['lemak'] }} ||
                            Karbohidrat : {{ $alt['karbo'] }} <br>
                        @endforeach
                    </ul>
                @endforeach
            @else
                Data tidak tersedia
            @endif
            <strong>Tanggal Konsultasi:</strong> {{ $tanggal_konsultasi }} <br>
        </div>
    </div>
</body>
</html>
