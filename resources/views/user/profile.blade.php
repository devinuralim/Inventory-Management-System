@extends('layouts.user')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary: #1e3a8a;
            --secondary: #64748b;
            --highlight: #00b4d8;
            --bg-light: #f8fafc;
        }

        .profile-container {
            max-width: 750px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .judul-section {
            border-bottom: 3px solid var(--highlight);
            display: inline-block;
            padding-bottom: 6px;
            color: #1d3557;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-profile {
            background: white;
            border-radius: 24px;
            border: none;
            box-shadow:
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 4rem 2rem;
            text-align: center;
            color: white;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 3.5rem;
            color: var(--primary);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            border: 5px solid rgba(255, 255, 255, 0.2);
        }

        /* Info Grid Styling */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            padding: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-item.full-width {
            grid-column: span 2;
        }

        .info-label {
            font-weight: 700;
            color: var(--secondary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            padding-left: 0.25rem;
        }

        .info-value {
            background: var(--bg-light);
            padding: 1rem 1.25rem;
            border-radius: 12px;
            color: #1e293b;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            min-height: 55px;
            transition: all 0.2s ease;
        }

        .info-value i {
            width: 20px;
            margin-right: 12px;
            color: var(--primary);
            opacity: 0.7;
        }

        .info-value:hover {
            border-color: var(--primary);
            background: white;
        }

        /* Footer Components */
        .admin-note {
            background: #fffbeb;
            border: 1px solid #fef3c7;
            border-left: 4px solid var(--highlight);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin: 0 2rem;
        }

        .btn-back {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 700;
            color: var(--secondary);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
        }

        .btn-back:hover {
            color: var(--primary);
            background: #eff6ff;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .info-item.full-width {
                grid-column: span 1;
            }
        }
    </style>

    <div class="profile-container">
        <div class="text-center mb-5 animate__animated animate__fadeIn">
            <h2 class="judul-section">Identitas Pegawai</h2>
        </div>

        <div class="card-profile animate__animated animate__fadeInUp">
            {{-- Header --}}
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3 class="fw-bold mb-1 text-white">{{ $karyawan->nama_lengkap ?? $user->name }}</h3>
            </div>

            {{-- Grid Content --}}
            <div class="info-grid">
                {{-- ID Pegawai --}}
                <div class="info-item">
                    <span class="info-label">ID Pegawai</span>
                    <div class="info-value">
                        <i class="fas fa-id-card"></i>
                        {{ $karyawan->id_pegawai ?? 'REG-' . str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                {{-- Jabatan --}}
                <div class="info-item">
                    <span class="info-label">Jabatan Struktural</span>
                    <div class="info-value">
                        <i class="fas fa-layer-group"></i>
                        {{ $karyawan->jabatan ?? 'Pegawai Tetap' }}
                    </div>
                </div>

                {{-- Nama Lengkap --}}
                <div class="info-item full-width">
                    <span class="info-label">Nama Lengkap (Sesuai KTP)</span>
                    <div class="info-value">
                        <i class="fas fa-user-check"></i>
                        {{ $karyawan->nama_lengkap ?? $user->name }}
                    </div>
                </div>

                {{-- Tanggal Bergabung --}}
                <div class="info-item full-width">
                    <span class="info-label">Masa Kerja / Tanggal Bergabung</span>
                    <div class="info-value">
                        <i class="fas fa-calendar-check"></i>
                        @if ($karyawan && $karyawan->tanggal_bergabung)
                            {{ \Carbon\Carbon::parse($karyawan->tanggal_bergabung)->translatedFormat('d F Y') }}
                        @else
                            {{ $user->created_at->translatedFormat('d F Y') }}
                            <small class="ms-2 text-muted">(Sejak Registrasi Akun)</small>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Footer Note --}}
            <div class="admin-note animate__animated animate__fadeIn animate__delay-1s mb-4">
                <div class="d-flex align-items-start">
                    <i class="fas fa-shield-alt text-warning me-3 mt-1"></i>
                    <div>
                        <p class="mb-1 small text-dark fw-bold">Akses Terbatas</p>
                        <p class="mb-0 small text-muted">
                            Hanya
                            <strong>Admin</strong>
                            yang memiliki otoritas untuk mengubah data profil. Silakan hubungi admin jika terdapat data
                            yang tidak sesuai.
                        </p>
                    </div>
                </div>
            </div>

            <div class="pb-5 text-center">
                <a
                    href="{{ route('user.dashboard') }}"
                    class="btn-back text-decoration-none d-inline-flex align-items-center">
                    <i class="fas fa-chevron-left me-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
