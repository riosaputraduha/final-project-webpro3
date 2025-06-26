@extends('layouts.admin')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="text-dark fw-bold">{{ $title }}</h2>

        <div class="d-flex gap-2 justify-content-end">
            <div class="dropdown">
                <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Filter Kelas
                </button>
                <ul class="dropdown-menu">
                    @foreach ($kelas as $itemKelas)
                        <li>
                            <a href="{{ route('siswa.filter', $itemKelas->id) }}" class="dropdown-item">
                                {{ $itemKelas->nama_kelas }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Siswa
            </a>
        </div>
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
                            <th>Kelas</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Nama Wali</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $item)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                                <td>{{ $item->kelas->nama_kelas }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>{{ $item->nama_orang_tua }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('siswa.show', $item->id) }}" class="btn btn-success btn-sm">
                                            <i class="bx bx-file-find"></i> Detail
                                        </a>
                                        <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('siswa.destroy', $item->id) }}" method="post">
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
            <div class="mt-3">
                {{ $siswa->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
