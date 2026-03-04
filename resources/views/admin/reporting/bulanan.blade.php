@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-3">Laporan Bulanan</h4>

    <!-- FORM FILTER BULAN & TAHUN -->
    <form method="GET" action="{{ url()->current() }}" class="mb-4">
        <div class="row g-2">

            <!-- BULAN -->
            <div class="col-md-4">
                <label>Bulan</label>
                <select name="bulan" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Bulan --</option>
                    <option value="01" {{ request('bulan')=='01'?'selected':'' }}>Januari</option>
                    <option value="02" {{ request('bulan')=='02'?'selected':'' }}>Februari</option>
                    <option value="03" {{ request('bulan')=='03'?'selected':'' }}>Maret</option>
                    <option value="04" {{ request('bulan')=='04'?'selected':'' }}>April</option>
                    <option value="05" {{ request('bulan')=='05'?'selected':'' }}>Mei</option>
                    <option value="06" {{ request('bulan')=='06'?'selected':'' }}>Juni</option>
                    <option value="07" {{ request('bulan')=='07'?'selected':'' }}>Juli</option>
                    <option value="08" {{ request('bulan')=='08'?'selected':'' }}>Agustus</option>
                    <option value="09" {{ request('bulan')=='09'?'selected':'' }}>September</option>
                    <option value="10" {{ request('bulan')=='10'?'selected':'' }}>Oktober</option>
                    <option value="11" {{ request('bulan')=='11'?'selected':'' }}>November</option>
                    <option value="12" {{ request('bulan')=='12'?'selected':'' }}>Desember</option>
                </select>
            </div>

            <!-- TAHUN -->
            <div class="col-md-4">
                <label>Tahun</label>
                <select name="tahun" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun --</option>
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('tahun')==$i?'selected':'' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

        </div>
    </form>

    <!-- TAMPIL DATA LAPORAN (NANTI) -->
    <div class="alert alert-info">
        Pilih bulan dan tahun untuk melihat laporan.
    </div>

</div>
@endsection