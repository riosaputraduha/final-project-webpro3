@extends('layouts.admin')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="text-dark fw-bold">{{ $title }}</h2>
        <a href="{{ route('kelas.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Kelas
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                                <td>{{ $item->waliKelas?->nama ?? '-' }}</td>
                                <td>{{ $item->tahunAjaran->tahun_ajaran }}</td>
                                <td>{{ $item->siswa->count() }} Siswa</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('kelas.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('kelas.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')">
                                                <i class="bx bx-trash"></i> Hapus
                                            </button>
                                        </form>
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
