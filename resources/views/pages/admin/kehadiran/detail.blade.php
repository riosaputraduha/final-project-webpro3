@extends('layouts.admin')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="text-dark fw-bold mb-0">{{ $title }}</h2>
        <a href="{{ route('admin.kehadiran.show', $kelas->id) }}" class="btn btn-light border">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>

    <div class="card border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Status Kehadiran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nis }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->jenis_kelamin }}</td>
                                <td>
                                    @if ($item->status == 'Hadir')
                                        <span class="badge bg-success">Hadir</span>
                                    @elseif($item->status == 'Sakit')
                                        <span class="badge bg-warning">Sakit</span>
                                    @elseif($item->status == 'Izin')
                                        <span class="badge bg-info">Izin</span>
                                    @elseif($item->status == 'Alfa')
                                        <span class="badge bg-danger">Alfa</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
