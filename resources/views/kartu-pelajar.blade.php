<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu Pelajar</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Perbaikan untuk header agar tidak keluar dari parent container */
        .header {
            background-color: #4564e5;
            color: white;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
            /* Menambahkan ini agar padding tidak menambah lebar total */
            border-top-left-radius: 8px;
            /* Tambahkan radius untuk menyesuaikan dengan container */
            border-top-right-radius: 8px;
        }

        /* Pastikan card container memiliki overflow hidden */
        .card-container {
            width: 100%;
            margin: 0 auto;
            max-width: 800px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: white;
            overflow: hidden;
            /* Menambahkan ini untuk memastikan konten tidak keluar */
            box-sizing: border-box;
        }

        .header-table {
            width: 100%;
        }

        .logo-cell {
            width: 80px;
            vertical-align: middle;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: white;
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
        }

        .logo img {
            max-width: 80px;
            max-height: 80px;
        }

        .school-name-cell {
            text-align: center;
            vertical-align: middle;
        }

        .school-name h1 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
        }

        .school-name p {
            margin: 5px 0 0;
            font-size: 12px;
            text-align: center;
        }

        .card-title {
            color: #4564e5;
            font-size: 20px;
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }

        .card-content {
            width: 100%;
            padding: 0 20px 20px 20px;
            text-align: center;
            /* Membantu pemusatan konten */
        }

        .content-table {
            width: 100%;
            margin: 0 auto;
            /* Menambahkan margin otomatis */
            padding: 0 40px;
            /* Menambahkan padding kiri-kanan untuk geser ke tengah */
            box-sizing: border-box;
        }

        .photo-cell {
            width: 150px;
            vertical-align: middle;
            /* Mengubah dari top menjadi middle untuk sejajar */
            padding-right: 20px;
            /* Menambahkan jarak antara foto dan informasi */
        }

        .photo {
            width: 150px;
            height: 140px;
            border: 1px solid #e5e7eb;
            text-align: center;
            vertical-align: middle;
        }

        .photo img {
            max-width: 100%;
            max-height: 100%;
        }

        .student-info {
            padding-left: 10px;
            /* Mengurangi padding kiri */
            font-size: 18px;
            line-height: 1.6;
            vertical-align: middle;
            /* Mengubah dari top menjadi middle untuk sejajar */
        }

        .student-info p {
            margin: 8px 0;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            padding: 20px;
        }

        .footer-table {
            width: 100%;
        }

        .expiry {
            font-size: 14px;
            width: 33%;
            vertical-align: bottom;
        }

        .expiry .date {
            font-weight: bold;
            font-size: 16px;
        }

        .principal {
            text-align: center;
            width: 34%;
            vertical-align: bottom;
        }

        .principal .title {
            font-style: italic;
        }

        .principal .name {
            color: #4f949e;
            font-weight: bold;
        }

        .signature {
            height: 28px;
            margin: 10px 0;
        }

        .qr-code-cell {
            width: 33%;
            text-align: right;
            vertical-align: bottom;
        }

        .qr-code {
            width: 80px;
            height: 80px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="card-container">
        <div class="header">
            <table class="header-table" border="0">
                <tr>
                    <td class="logo-cell">
                        <div class="logo">
                            <img src="data:image/png;base64,{{ $logo }}" alt="Logo Sekolah">
                        </div>
                    </td>
                    <td class="school-name-cell">
                        <div class="school-name">
                            <h1>{{ $pengaturan->nama_sekolah }}</h1>
                            <p>{{ $pengaturan->alamat }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="card-title">Kartu Tanda Siswa</div>

        <div class="card-content">
            <table class="content-table" border="0">
                <tr>
                    <td class="photo-cell">
                        <div class="photo">
                            <img src="data:image/png;base64,{{ $photo }}" alt="">
                            {{-- <div
                                style="width: 100%; height: 100%; background: #EEE; display: table; text-align: center">
                                <div style="display: table-cell; vertical-align: middle">
                                    <p style="margin: 0; font-size: 14px;">TIDAK ADA FOTO</p>
                                </div>
                            </div> --}}
                        </div>
                    </td>
                    <td class="student-info">
                        <p><span>Nama : </span> {{ $siswa->nama }}</p>
                        <p><span>NIS : </span> {{ $siswa->nis }}</p>
                        <p><span>Tanggal Lahir : </span> {{ $siswa->tanggal_lahir }}</p>
                        <p><span>Kelas : </span> {{ $siswa->kelas->nama_kelas }}</p>
                        <p><span>Alamat : </span> {{ $siswa->alamat }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <table class="footer-table" border="0">
                <tr>
                    <td class="expiry">
                        <p>Berlaku Sampai : </p>
                        <p class="date">{{ \Carbon\Carbon::now()->addYears(3)->format('d F Y') }}</p>
                    </td>
                    <td class="principal">
                        <p class="title">Kepala Sekolah</p>
                        <div class="signature"></div>
                        <p class="name">Yunus Almeida</p>
                    </td>
                    <td class="qr-code-cell">
                        <div class="qr-code">
                            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code"
                                style="width: 100px; height: 100px;">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
