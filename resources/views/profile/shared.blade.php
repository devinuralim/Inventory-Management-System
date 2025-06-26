{{-- resources/views/profile/shared.blade.php --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <h2 class="mb-4 text-center">Profil Saya</h2>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Form Profil, Ganti Password, dan Hapus Akun ada di sini --}}
            {{-- Copy dari kode profil kamu sebelumnya --}}
        </div>
    </div>
</div>
