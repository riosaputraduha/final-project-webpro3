@extends('layouts.admin')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="text-dark fw-bold">Tahun Ajaran</h2>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bx bx-plus"></i> Tambah Tahun Ajaran
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @error(['tahun_ajaran', 'semester'])
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    <div class="card border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tahun_ajaran as $item)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tahun_ajaran }}</td>
                                <td>{{ $item->semester }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id }}">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('tahun-ajaran.destroy', $item->id) }}" method="post">
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

                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                aria-labelledby="editModal{{ $item->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editModal{{ $item->id }}Label">Edit Tahun
                                                Ajaran</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('tahun-ajaran.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                                    <input type="text" name="tahun_ajaran" id="tahun_ajaran"
                                                        class="form-control" value="{{ $item->tahun_ajaran }}">
                                                </div>
                                                <div>
                                                    <label for="semester" class="form-label">Semester</label>
                                                    <select name="semester" id="semester" class="form-select">
                                                        <option value="" selected disabled>
                                                            -- Pilih Semester --
                                                        </option>
                                                        <option value="Ganjil" @selected(old('semester', $item->semester) == 'Ganjil')>Ganjil</option>
                                                        <option value="Genap" @selected(old('semester', $item->semester) == 'Genap')>Genap</option>
                                                    </select>
                                                    @error('semester')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bx bx-save"></i> Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Tambah Tahun Ajaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tahun-ajaran.store') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control">
                        </div>

                        <div>
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" id="semester" class="form-select">
                                <option value="" selected disabled>-- Pilih Semester --</option>
                                <option value="Ganjil" @selected(old('semester') == 'Ganjil')>Ganjil</option>
                                <option value="Genap" @selected(old('semester') == 'Genap')>Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Simpan Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
