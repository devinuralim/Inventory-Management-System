@extends('layouts.admin')

@section('content')
    <style>
        .page-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: #0f172a;
        }

        .card-clean {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .table tbody tr:hover {
            background-color: #f1f5f9;
            transition: 0.2s;
        }

        .btn-primary {
            background-color: #3b82f6;
            border: none;
            padding: 0.6rem 1.5rem;
        }

        /* Perbaikan UI Password */
        .input-group-sm .form-control {
            border-radius: 8px 0 0 8px;
            border-right: none;
        }
        .input-group-sm .btn {
            border-radius: 0 8px 8px 0;
            border: 1px solid #ced4da;
            border-left: none;
        }

        @media print {
            body * {
                visibility: hidden !important;
            }
            #print-section,
            #print-section * {
                visibility: visible !important;
            }
            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="container pt-3 pb-5">
        {{-- Header --}}
        <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <div class="page-title">Daftar Karyawan</div>
                <p class="text-muted small mb-0">Kelola data akun dan informasi karyawan secara terpusat</p>
            </div>

            <div class="d-flex flex-wrap gap-2 btn-group-flex">
                <form
                    action="{{ route('admin.karyawans.index') }}"
                    method="GET"
                    class="input-group"
                    style="max-width: 280px">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control rounded-start-pill"
                        placeholder="Cari nama/id..." />
                    <button class="btn btn-outline-secondary rounded-end-pill px-3">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.karyawans.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-user-plus me-1"></i>
                    Buat Akun
                </a>
            </div>
        </div>

        {{-- Export & Print --}}
        <div class="mb-3 d-flex flex-wrap gap-2 no-print">
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="fas fa-print me-1"></i>
                Cetak
            </button>
            <a
                href="{{ route('admin.karyawans.export.pdf') }}"
                class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="fas fa-file-pdf me-1"></i>
                PDF
            </a>
            <a
                href="{{ route('admin.karyawans.export.csv') }}"
                class="btn btn-outline-success btn-sm rounded-pill px-3">
                <i class="fas fa-file-csv me-1"></i>
                CSV
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div id="print-section" class="card-clean table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>ID Pegawai</th>
                        <th>Nama</th>
                        <th>Tanggal Bergabung</th>
                        <th>Jabatan</th>
                        <th>Password</th>
                        <th class="text-center no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawans as $index => $karyawan)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $karyawan->id_pegawai }}</td>
                            <td>{{ $karyawan->nama_lengkap }}</td>
                            <td>{{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->format('d M Y') }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $karyawan->jabatan }}</span></td>
                            <td>
                                @if ($karyawan->password_plain)
                                    <div class="input-group input-group-sm" style="max-width: 150px">
                                        <input
                                            type="password"
                                            class="form-control password-input"
                                            value="{{ $karyawan->password_plain }}"
                                            readonly />
                                        <button type="button" class="btn btn-outline-secondary toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-muted small">Tidak tersedia</span>
                                @endif
                            </td>
                            <td class="text-center no-print">
                                {{-- Tombol Edit dengan Ikon --}}
                                <a
                                    href="{{ route('admin.karyawans.edit', $karyawan->id_pegawai) }}"
                                    class="btn btn-sm btn-outline-warning rounded-pill me-1"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Tombol Hapus dengan Ikon --}}
                                <form
                                    action="{{ route('admin.karyawans.delete', $karyawan->id_pegawai) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-users fa-2x mb-3 d-block opacity-50"></i>
                                Tidak ada karyawan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach((btn) => {
            btn.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fas fa-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'fas fa-eye';
                }
            });
        });
    </script>
@endsection
