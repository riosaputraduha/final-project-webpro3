@extends('layouts.admin')

@section('content')
    <h2 class="font-bold mb-3">{{ $title }}</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row g-3 mt-3">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body p-4">
                    <h5 class="mb-3">Daftar Siswa</h5>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kehadiran</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->siswa as $item)
                                    <tr class="align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->nis }} <br>
                                            {{ $item->nama }}
                                        </td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>
                                            @if ($kelas->absensi->where('siswa_id', $item->id)->where('tanggal', now()->format('Y-m-d'))->count() > 0)
                                                @php
                                                    $status = $kelas->absensi
                                                        ->where('siswa_id', $item->id)
                                                        ->where('tanggal', now()->format('Y-m-d'))
                                                        ->first()->status;
                                                @endphp
                                                @if ($status == 'Hadir')
                                                    <span class="badge bg-success">Hadir</span>
                                                @elseif($status == 'Izin')
                                                    <span class="badge bg-warning">Izin</span>
                                                @elseif($status == 'Sakit')
                                                    <span class="badge bg-info">Sakit</span>
                                                @elseif($status == 'Alfa')
                                                    <span class="badge bg-danger">Alfa</span>
                                                @endif
                                            @else
                                                <span class="badge bg-light text-dark">Belum Absen</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->absensi->where('jam_pulang')->where('tanggal', now()->format('Y-m-d'))->first() != null)
                                                <span class="badge bg-success">Sudah Pulang</span>
                                            @else
                                                <span class="badge bg-info">Belum Pulang</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light border dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    @if ($kelas->absensi->where('siswa_id', $item->id)->where('tanggal', now()->format('Y-m-d'))->count() > 0)
                                                        Ubah Status
                                                    @else
                                                        Pilih Kehadiran
                                                    @endif
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="{{ route('absensi.storeManual') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="siswa_id"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="status" value="Hadir">
                                                            <button class="dropdown-item" type="submit">
                                                                Hadir
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('absensi.storeManual') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="siswa_id"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="status" value="Alfa">
                                                            <button class="dropdown-item" type="submit">
                                                                Alfa
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('absensi.storeManual') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="siswa_id"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="status" value="Izin">
                                                            <button class="dropdown-item" type="submit">
                                                                Izin
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('absensi.storeManual') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="siswa_id"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="status" value="Sakit">
                                                            <button class="dropdown-item" type="submit">
                                                                Sakit
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0">
                <div class="card-body p-4">
                    <h5 class="mb-3">Scan Disini</h5>
                    <video style="width: 100%; height: auto; border-radius: 10px" id="preview"></video>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        scanner.addListener('scan', function(content) {
            fetch("{{ route('absensi.storeQr') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        siswa_id: content
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.message == 'sudah absen') {
                        alert('Siswa sudah absen hari ini')
                        location.reload();
                    } else if (data.message == 'absen berhasil') {
                        alert('Siswa berhasil absen')
                        location.reload();
                    } else if (data.message == 'terlambat') {
                        alert('Siswa terlambat absen')
                        location.reload();
                    } else if (data.message == 'pulang') {
                        alert('Siswa sudah pulang')
                        location.reload();
                    } else if (data.message == 'siswa tidak terdaftar') {
                        alert('Siswa tidak terdaftar')
                        location.reload();

                    } else {
                        alert('Siswa tidak terdaftar')
                        location.reload();
                    }
                }).catch(error => {
                    console.error('Error:', error);
                })
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.log('No Camera Found.');
            }
        }).catch(function(e) {
            console.log(e);

        })
    </script>
@endpush
