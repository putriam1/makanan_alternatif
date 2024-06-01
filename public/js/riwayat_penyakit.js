$(document).ready(function(){
    $('#id_pasien').on('input', function() {
        var id_pasien = $(this).val();
        if (id_pasien) {
            $.ajax({
                url: '/riwayat-penyakit/' + id_pasien,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data && Array.isArray(data)) {
                        console.log(data);
                        // Hapus semua baris sebelum menambahkan yang baru
                        $('#riwayat_penyakit').empty();

                        if (data.length > 0) {
                            data.forEach(function(penyakit) {
                                // Tambahkan baris-baris data ke dalam tabel
                                $('#riwayat_penyakit').append('<tr><td><input type="checkbox" name="riwayat_penyakit[]" value="' + penyakit.id + '"></td><td>' + penyakit.nama_penyakit + '</td></tr>');
                            });
                        } else {
                            // Tampilkan pesan jika tidak ada riwayat penyakit
                            $('#riwayat_penyakit').append('<tr><td>Tidak Ada Riwayat Penyakit</td></tr>');
                        }
                    } else {
                        // Kosongkan tabel jika data tidak valid
                        $('#riwayat_penyakit').empty();
                    }
                },
                error: function() {
                    // Kosongkan tabel jika terjadi kesalahan
                    $('#riwayat_penyakit').empty();
                }
            });
        } else {
            // Kosongkan tabel jika id pasien kosong
            $('#riwayat_penyakit').empty();
        }
    });
});