@extends('layouts.admin')

@section('content')
    <h2 class="text-dark fw-bold mb-3">{{ $title }}</h2>

    <div class="card border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kelas</th>
                            <th>Nama Wali Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Jumlah Siswa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $item)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kelas }}</td>
                                <td>{{ optional($item->waliKelas)->nama ?? '-' }}</td>
                                <td>{{ $item->tahunAjaran->tahun_ajaran }}</td>
                                <td>{{ $item->siswa->count() }} Siswa</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.kehadiran.show', $item->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-file"></i> Lihat Kehadiran
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
