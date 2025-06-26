@extends('layouts.admin')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="text-dark fw-bold mb-0">{{ $title }}</h2>
        <a href="{{ route('rekap-absensi.index') }}" class="btn btn-light border">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>

    <div class="card border-0">
        <div class="card-body p-4">
            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Total Hadir</th>
                            <th>Total Sakit</th>
                            <th>Total Izin</th>
                            <th>Total Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalHadir = 0;
                            $totalSakit = 0;
                            $totalIzin = 0;
                            $totalAlpha = 0;
                        @endphp
                        @foreach ($kelas->siswa as $item)
                            @php
                                $totalHadir += $item
                                    ->absensi()
                                    ->whereMonth('tanggal', $bulan)
                                    ->whereYear('tanggal', $tahun)
                                    ->where('status', 'Hadir')
                                    ->count();
                                $totalSakit += $item
                                    ->absensi()
                                    ->whereMonth('tanggal', $bulan)
                                    ->whereYear('tanggal', $tahun)
                                    ->where('status', 'Sakit')
                                    ->count();
                                $totalIzin += $item
                                    ->absensi()
                                    ->whereMonth('tanggal', $bulan)
                                    ->whereYear('tanggal', $tahun)
                                    ->where('status', 'Izin')
                                    ->count();
                                $totalAlpha += $item
                                    ->absensi()
                                    ->whereMonth('tanggal', $bulan)
                                    ->whereYear('tanggal', $tahun)
                                    ->where('status', 'Alfa')
                                    ->count();
                            @endphp
                            <tr>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>
                                    {{ $item->absensi()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Hadir')->count() }}
                                </td>
                                <td>
                                    {{ $item->absensi()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Sakit')->count() }}
                                </td>
                                <td>
                                    {{ $item->absensi()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Izin')->count() }}
                                </td>
                                <td>
                                    {{ $item->absensi()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Alfa')->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>{{ number_format($totalHadir) }}</th>
                            <th>{{ number_format($totalSakit) }}</th>
                            <th>{{ number_format($totalIzin) }}</th>
                            <th>{{ number_format($totalAlpha) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
