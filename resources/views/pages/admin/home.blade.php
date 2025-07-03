@extends('layouts.admin')

@section('content')
    <h1 class="text-dark fw-bold mb-3">{{ $title }}</h1>

    <div class="row row-cols-2 row-cols-md-4 g-3">
        <div class="col">
            <a href="{{ route('kelas.index') }}" class="card card-dashboard">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <span class="icon">
                            <i class='bx bxs-school'></i>
                        </span>
                        <div>
                            <p class="fw-semibold text-secondary mb-0">Jumlah Kelas</p>
                            <h4 class="fw-bold">{{ number_format($jumlahKelas) }} Kelas</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('wali-kelas.index') }}" class="card card-dashboard">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <span class="icon">
                            <i class='bx bx-user-pin'></i>
                        </span>
                        <div>
                            <p class="fw-semibold text-secondary mb-0">Jumlah Wali Kelas</p>
                            <h4 class="fw-bold">{{ number_format($jumlahWaliKelas) }} Wali Kelas</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('siswa.index') }}" class="card card-dashboard">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <span class="icon">
                            <i class='bx bxs-user-badge'></i>
                        </span>
                        <div>
                            <p class="fw-semibold text-secondary mb-0">Jumlah Siswa</p>
                            <h4 class="fw-bold">{{ number_format($jumlahSiswa) }} Siswa</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
