@extends('layouts.admin')

@section('content')
    <h2 class="fw-bold mb-3">{{ $title }}</h2>

    <div class="card border-0">
        <div class="card-body">
            <form action="{{ route('siswa.store') }}" method="post">
                @csrf

                <div class="row g-3">
                    <div class="col-12">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas_id" id="kelas" class="form-select">
                            <option value="" selected disabled>-- Pilih Kelas --</option>
                            @foreach ($kelas as $kl)
                                <option value="{{ $kl->id }}" @selected(old('kelas_id') == $kl->id)>
                                    {{ $kl->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Siswa</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                            class="form-control @error('nama') is-invalid @enderror">
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis') }}"
                            class="form-control @error('nis') is-invalid @enderror">
                        @error('nis')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            class="form-control @error('tempat_lahir') is-invalid @enderror">
                        @error('tempat_lahir')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror">
                        @error('tanggal_lahir')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" @selected(old('jenis_kelamin') == 'Laki-laki')>
                                Laki-laki
                            </option>
                            <option value="Perempuan" @selected(old('jenis_kelamin') == 'Perempuan')>
                                Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
                            class="form-control @error('alamat') is-invalid @enderror">
                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nama_orang_tua" class="form-label">Nama Orang Tua</label>
                        <input type="text" name="nama_orang_tua" id="nama_orang_tua" value="{{ old('nama_orang_tua') }}"
                            class="form-control @error('nama_orang_tua') is-invalid @enderror">
                        @error('nama_orang_tua')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="no_hp" class="form-label">Nomor HP Orang Tua</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                            class="form-control @error('no_hp') is-invalid @enderror">
                        @error('no_hp')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex gap-1 mt-3">
                    <button class="btn btn-primary" type="submit">Simpan Baru</button>
                    <a href="{{ route('siswa.index') }}" class="btn btn-light border">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
