@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "lengthMenu": [5, 10, 25, 50], // Menambahkan opsi jumlah entri
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [5, 10, 25, 50], // Menambahkan opsi jumlah entri
        });
    });
</script>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RS. Bayangkara Kediri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
    <link rel="icon" href="../../dist/img/rs.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
        background: linear-gradient(to bottom, #007bff, #ffffff);
        color: #fff;
        padding: 10px 20px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
        }
        .address {
            margin-top: 50px;
        }
        .copyright {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .img-circle {
        width: 50px; /* Lebar gambar */
        height: 50px; /* Tinggi gambar */
        margin-top: 5px; /* Jarak dari atas */
        margin-left: 10px; /* Jarak dari kiri */
        }

        footer {
        background-color: #333; /* Warna latar belakang abu tua */
        color: white; /* Warna teks putih */
        padding: 20px; /* Padding untuk memberi jarak antara konten dan tepi footer */
        margin-top: 15px;
        }

        .map-container {
        display: flex;
        justify-content: center;
        margin-top: 15px;
        }

        .table-borderless tbody tr td {
            border-top: none; /* Menghapus garis atas */
            border-bottom: none; /* Menghapus garis bawah */
            background-color: #333;
            color: white; 
        }

        .table-borderless tbody tr:not(:last-child) td {
            border-bottom: 1px solid white; /* Garis horizontal */
            background-color: #333;
            color: white; 
        }

        
    </style>
</head>
<body>
    <div class="navbar">
        <a style="color: black; font-size: 20px;" >
        <img src="{{ asset('assets/dist/img/rs.png') }}" class="img-circle elevation-3" alt="logo rumah sakit" >
        <img src="{{ asset('assets/dist/img/kk.png') }}" class="img-circle elevation-3" alt="logo rkesehatan kedokteran" >
        <b >Bhayangkara </b>KEDIRI 
        </a>
    </div>

    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" >
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('assets/dist/img/dbd.jpg') }}" class="d-block w-100" alt="..." style="height: 500px;">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/dist/img/malaria.jpg') }}" class="d-block w-100" alt="..." style="height: 500px;">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/dist/img/genggam.jpg') }}" class="d-block w-100" alt="..." style="height: 500px;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container">
        <h1><b>Selamat Datang di Rumah Sakit Bayangkara Kediri</b></h1>
        <h2> "Kami Peduli, Kami Mendengarkan, Kami Melayani"</h2>  
    </div>

    <div class="d-flex justify-content-center" style ="margin-top: 15px; margin-bottom: 15px;">
    <button type="button" class="btn btn-info" style="margin-right: 30px; width: 150px; height: 150px; ">
        <img src="{{ asset('assets/dist/img/kalender.png') }}" alt="Gambar" style="width: 50px; height: 50px; margin-right: 5px;">
        <p style="color: white;"><b>Jadwal Pelayanan Dokter</b></p>
    </button>
    <a href="{{ url('/login') }}" class="btn btn-info" style="margin-right: 30px; width: 150px; height: auto; display: flex; flex-direction: column; align-items: center; text-decoration: none;">
        <img src="{{ asset('assets/dist/img/gizi.png') }}" alt="Gambar" style="width: 75px; height: 75px; margin-right: 5px;">
        <p style="color: white;"><b>Konsultasi Gizi</b></p>
    </a>


    <button type="button" class="btn btn-info" style="margin-right: 30px; width: 150px; height: 150px;">
        <img src="{{ asset('assets/dist/img/p3k.png') }}" alt="Gambar" style="width: 50px; height: 50px; margin-right: 5px;">
        <p style="color: white;"><b>Medical Chek Up</b></p>
    </button>
</div>

<div style="text-align: center;">
    <h3><b>"Temukan Lokasi Kami" </b></h3>
</div>

<div class="map-container">
    <iframe
        width="750"
        height="450"
        style="border:0"
        loading="lazy"
        allowfullscreen
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.8459745117895!2d112.01557059999999!3d-7.813381299999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785715e1321bc9%3A0xcb0149418d463465!2sRumah%20Sakit%20Bhayangkara%20Kediri!5e0!3m2!1sen!2sid!4v1642340169817!5m2!1sen!2sid">
    </iframe>
</div>


<footer>
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="info-links">
            <h5><b>Alamat Kami</b></h5>
            <div class="info contact">
                <a><span>Jl. Kombes Pol Duryat No.17, Dandangan, Kec. Kota, Kota Kediri, Jawa Timur 64122</span> <i class="fa fa-map-marker" aria-hidden="true"></i> </a>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-lg-4 ">
        <div class="info-links">
            <h5><b>Hubungi Kami</b></h5>
            <div class="info contact">
                <p> <img src="{{ asset('assets/dist/img/tlpn.png') }}" alt="Gambar" style="width: 25px; height: 25px; margin-right: 5px;">
                    <a >0354 671100</a></p>
                <p><img src="{{ asset('assets/dist/img/tlpn2.png') }}" alt="Gambar" style="width: 25px; height: 25px; margin-right: 5px;">
                    <a >0354 683840</a></p>
                <p>  <img src="{{ asset('assets/dist/img/email.png') }}" alt="Gambar" style="width: 25px; height: 25px; margin-right: 5px;">
                    <a >rsbayangkarakediri@gmail.com</a></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="info-links">
            <h5><b>Jadwal Pelayanan</b></h5>
            <div class="info contact">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="text-left">Jam Operasional Poliklinik</td>
                            <td class="text-right">07:00 - 20:00</td>
                        </tr>
                        <tr>
                            <td class="text-left">Layanan IGD</td>
                            <td class="text-right">24 JAM</td>
                        </tr>
                        <tr>
                            <td class="text-left">Ambulance</td>
                            <td class="text-right">Standby 24/7</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



    

    <div class="copyright">
        <p>&copy; 2024 All Rights Reserved By RS Bhayangkara Kediri.</p>
    </div>
</footer>

</body>
</html>
