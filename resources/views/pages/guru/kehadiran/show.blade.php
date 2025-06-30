@extends('layouts.admin')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="text-dark fw-bold mb-0">{{ $title }}</h2>
        <a href="{{ route('guru.kehadiran') }}" class="btn btn-light border">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>

    <div class="card border-0">
        <div class="card-body p-4">
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total Siswa</th>
                            <th>Total Hadir</th>
                            <th>Total Sakit</th>
                            <th>Total Izin</th>
                            <th>Total Alpha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $item)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($item->tanggal)->translatedFormat('j F Y') }}</td>
                                <td>{{ $kelas->siswa->count() }}</td>
                                <td>
                                    {{ $kelas->absensi->where('tanggal', $item->tanggal)->where('status', 'Hadir')->count() }}
                                </td>
                                <td>
                                    {{ $kelas->absensi->where('tanggal', $item->tanggal)->where('status', 'Sakit')->count() }}
                                </td>
                                <td>
                                    {{ $kelas->absensi->where('tanggal', $item->tanggal)->where('status', 'Izin')->count() }}
                                </td>
                                <td>
                                    {{ $kelas->absensi->where('tanggal', $item->tanggal)->where('status', 'Alfa')->count() }}
                                </td>
                                <td>
                                    <a href="{{ route('kehadiran.detail', ['id' => $kelas->id, 'tanggal' => $item->tanggal]) }}"
                                        class="btn btn-sm btn-success" style="width: max-content">
                                        <i class="bx bx-file"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
