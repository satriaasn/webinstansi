@extends(getTheme('layouts.app'))
@section('title', 'Formulir Pendaftaran Layanan Sosial')
@push('css')
<style>
/* ===== FORM PENDAFTARAN ===== */
.form-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding: 30px;
    border-radius: 16px;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
}
.form-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='40' cy='40' r='30'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
    pointer-events: none;
}
.form-hero .container-fluid { position: relative; z-index: 1; padding:0; }
.form-hero h1 { color: #fff; font-size: 1.9rem; font-weight: 800; margin-bottom: 8px; }
.form-hero p  { color: rgba(255,255,255,.78); font-size: .95rem; margin-bottom: 0; }

.form-wrapper {

/* Stepper */
.is-stepper { display: flex; gap: 0; margin-bottom: 36px; }
.is-step {
    flex: 1;
    text-align: center;
    position: relative;
}
.is-step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    left: 50%;
    right: -50%;
    height: 2px;
    background: #dee2e6;
    z-index: 0;
}
.is-step.active::after,
.is-step.done::after { background: #c0392b; }
.step-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #dee2e6;
    color: #aaa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin: 0 auto 6px;
    position: relative;
    z-index: 1;
    font-size: .88rem;
    transition: all .3s;
    cursor: pointer;
}
.is-step.active .step-circle { background: #c0392b; color: #fff; transform: scale(1.1); box-shadow: 0 0 10px rgba(192,57,43,.3); }
.is-step.done   .step-circle { background: #27ae60; color: #fff; cursor: pointer; }
.step-label { font-size: .75rem; color: #888; font-weight: 600; }
.is-step.active .step-label { color: #c0392b; }

/* Main form card */
.form-step-card {
    display: none;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,.1);
    overflow: hidden;
    animation: fadeInForm .4s ease;
}
.form-step-card.active-step { display: block; }
@keyframes fadeInForm { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
.form-section-header {
    background: linear-gradient(90deg, #8b0000, #c0392b);
    color: #fff;
    padding: 14px 28px;
    font-weight: 700;
    font-size: .95rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.form-section-body { padding: 28px; }

/* Input styling */
.is-form-group {
    margin-bottom: 20px;
}
.is-form-group label {
    font-weight: 600;
    font-size: .85rem;
    color: #374151;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.is-form-group label .req { color: #e74c3c; font-size: 1rem; line-height: 1; }
.is-form-control {
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: .9rem;
    color: #111827 !important;
    width: 100%;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    background: #fafafa !important;
}
.is-form-control:focus {
    border-color: #c0392b;
    box-shadow: 0 0 0 3px rgba(192,57,43,.12);
    background: #fff !important;
    color: #000 !important;
}
.is-form-control.is-invalid { border-color: #e74c3c; }
select.is-form-control { cursor: pointer; }

/* File upload */
.file-upload-zone {
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    background: #f9fafb;
    padding: 18px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    position: relative;
}
.file-upload-zone:hover { border-color: #c0392b; background: #fef9f9; }
.file-upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.file-upload-zone .fuz-icon { font-size: 1.8rem; color: #9ca3af; margin-bottom: 6px; }
.file-upload-zone .fuz-text { font-size: .82rem; color: #6b7280; }
.file-upload-zone .fuz-hint { font-size: .73rem; color: #9ca3af; margin-top: 4px; }
.file-name-badge {
    display: none;
    background: #e8f5e9;
    color: #2e7d32;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: .8rem;
    font-weight: 600;
    margin-top: 6px;
    text-align: left;
}

/* Layanan select card */
.layanan-radio-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media(max-width:576px) { .layanan-radio-grid { grid-template-columns: 1fr; }}
.layanan-radio-item {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    position: relative;
}
.layanan-radio-item:hover { border-color: #c0392b; background: #fef9f9; }
.layanan-radio-item input { position: absolute; opacity: 0; }
.layanan-radio-item.selected { border-color: #c0392b; background: #fff5f5; }
.lri-icon { font-size: 1.4rem; margin-bottom: 6px; }
.lri-name { font-size: .82rem; font-weight: 700; color: #1a1a2e; }
.lri-jenis { font-size: .72rem; color: #888; }

/* Dynamic extra fields */
.extra-fields { display: none; }
.extra-fields.visible { display: block; }

/* Submit btn */
.btn-submit-is {
    background: linear-gradient(135deg, #8b0000, #c0392b);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 14px 40px;
    font-size: 1rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: opacity .2s, transform .15s;
}
.btn-submit-is:hover { opacity: .9; transform: translateY(-1px); }
.btn-submit-is:disabled { opacity: .6; cursor: not-allowed; }

.btn-submit-is:hover { opacity: .9; transform: translateY(-1px); }
.btn-submit-is:disabled { opacity: .6; cursor: not-allowed; }

.btn-is-next, .btn-is-prev {
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: .95rem;
    transition: all .2s;
    border: none;
    cursor: pointer;
}
.btn-is-next { background: #1e293b; color: #fff; }
.btn-is-next:hover { background: #0f172a; transform: translateY(-1px); }
.btn-is-prev { background: #f1f5f9; color: #475569; }
.btn-is-prev:hover { background: #e2e8f0; color: #1e293b; }

.alert-is-error {
    background: #fef2f2;
    border: 1px solid #fca5a5;
    border-radius: 10px;
    color: #991b1b;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-size: .88rem;
}

/* Responsive Adjustments */
@media(max-width: 768px) {
    .form-hero { padding: 24px; text-align: center; }
    .form-hero h1 { font-size: 1.35rem; }
    .is-stepper { flex-wrap: nowrap; overflow-x: auto; padding-bottom: 5px; justify-content: space-between; }
    .is-step { flex: 1; min-width: 75px; margin-bottom: 0; }
    .is-step:not(:last-child)::after { top: 16px; left: 50%; right: -50%; }
    .step-circle { width: 32px; height: 32px; font-size: .75rem; border-width: 2px; }
    .step-label { font-size: .65rem; line-height:1.1; }
    
    .form-section-header { font-size: .85rem; padding: 12px 16px; }
    .form-section-body { padding: 16px; }
    .btn-submit-is { width: 100%; justify-content: center; }
    .d-flex.flex-wrap.align-items-center.gap-3 { flex-direction: column; width: 100%; }
    .d-flex.flex-wrap.align-items-center.gap-3 a { text-align: center; width: 100%; }
}
</style>
@endpush
@section('content')

<section class="pb-5">
    <div class="container">
        <div class="content-wrapper">
            <div class="content">

                {{-- BREADCRUMB --}}
                <div class="breadcrumb text-truncate d-block mb-3" style="max-width: 1160px">
                    <a class="breadcrumb-item" href="{{url('')}}"><i class="icon-home2 mr-2"></i>Beranda</a>
                    <a class="breadcrumb-item" href="{{ route('informasi-sosial.index') }}">Informasi Sosial</a>
                    <span class="breadcrumb-item active">Formulir Pendaftaran</span>
                </div>

                {{-- HERO BANNER --}}
                <div class="form-hero">
                    <div class="container-fluid">
                        <h1><i class="fa-solid fa-file-pen mr-2"></i>Formulir Pendaftaran Layanan Sosial</h1>
                        <p class="mt-1 mb-0">Isi formulir berikut dengan lengkap dan benar. Semua dokumen dalam format PDF maksimal 500KB.</p>
                    </div>
                </div>

                <div class="form-wrapper">

                    {{-- Stepper --}}
                    <div class="is-stepper mb-4">
                        <div class="is-step active" id="step-ind-1" onclick="jumpToStep(1)">
                            <div class="step-circle">1</div>
                            <div class="step-label">Pilih Layanan</div>
                        </div>
                        <div class="is-step" id="step-ind-2" onclick="jumpToStep(2)">
                            <div class="step-circle">2</div>
                            <div class="step-label">Data Diri</div>
                        </div>
                        <div class="is-step" id="step-ind-3" onclick="jumpToStep(3)">
                            <div class="step-circle">3</div>
                            <div class="step-label">Dokumen</div>
                        </div>
                        <div class="is-step" id="step-ind-4" onclick="jumpToStep(4)">
                            <div class="step-circle">4</div>
                            <div class="step-label">Konfirmasi</div>
                        </div>
                    </div>

        <form method="POST" action="{{ route('informasi-sosial.submit') }}" enctype="multipart/form-data" id="formDaftar">
            @csrf

            {{-- Error --}}
            @if($errors->any())
            <div class="alert-is-error">
                <strong><i class="fa-solid fa-circle-exclamation mr-1"></i> Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1 ps-4">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif

            {{-- STEP 1: Pilih Layanan --}}
            <div class="form-step-card mb-4 active-step" id="step-1">
                <div class="form-section-header">
                    <i class="fa-solid fa-list-check"></i> Langkah 1 – Pilih Jenis Layanan
                </div>
                <div class="form-section-body">
                    <div class="is-form-group mb-0">
                        <label>Pilih Layanan Sosial Yang Dituju <span class="req">*</span></label>
                        <select name="layanan_sosial_id" id="layanan_sosial_id" class="is-form-control @error('layanan_sosial_id') is-invalid @enderror" onchange="dropdownLayananChanged(this)" style="font-size: 1.05rem; padding: 14px; font-weight: 600; cursor:pointer;" required>
                            <option value="" data-kode="">-- Klik Untuk Memilih Layanan --</option>
                            <optgroup label="BIDANG">
                                @foreach($layananList->where('jenis', 'bidang') as $item)
                                    <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" {{ old('layanan_sosial_id', $layanan->id ?? null) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="UNIT PELAKSANA TEKNIS DAERAH (UPTD)">
                                @foreach($layananList->where('jenis', 'uptd') as $item)
                                    <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" {{ old('layanan_sosial_id', $layanan->id ?? null) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        <div style="font-size:.8rem;color:#6b7280;margin-top:8px;">
                            <i class="fa-solid fa-circle-info mr-1"></i> Data formulir tambahan di Langkah 2 mungkin akan langsung menyesuaikan secara otomatis bergantung pada jenis layanan yang Anda pilih.
                        </div>
                        @error('layanan_sosial_id')<div style="color:#e74c3c;font-size:.82rem;margin-top:6px;">{{ $message }}</div>@enderror
                        
                        <div class="d-flex justify-content-end mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                            <button type="button" class="btn-is-next" onclick="nextStep(1)">Selanjutnya <i class="fa-solid fa-arrow-right ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 2: Data Diri --}}
            <div class="form-step-card mb-4" id="step-2">
                <div class="form-section-header">
                    <i class="fa-solid fa-user"></i> Langkah 2 – Data Diri & Formulir Khusus
                </div>
                <div class="form-section-body">
                    <div class="row">
                        <div class="col-md-6 is-form-group">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="nama_lengkap" class="is-form-control @error('nama_lengkap') is-invalid @enderror"
                                   placeholder="Sesuai KTP" value="{{ old('nama_lengkap') }}" required>
                        </div>
                        <div class="col-md-6 is-form-group">
                            <label>NIK (16 digit)</label>
                            <input type="text" name="nik" class="is-form-control @error('nik') is-invalid @enderror"
                                   placeholder="Nomor Induk Kependudukan" value="{{ old('nik') }}" maxlength="16">
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Jenis Kelamin <span class="req">*</span></label>
                            <select name="jenis_kelamin" class="is-form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Tempat Lahir <span class="req">*</span></label>
                            <input type="text" name="tempat_lahir" class="is-form-control" placeholder="Kota" value="{{ old('tempat_lahir') }}" required>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Tanggal Lahir <span class="req">*</span></label>
                            <input type="date" name="tanggal_lahir" class="is-form-control" value="{{ old('tanggal_lahir') }}" required>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Agama</label>
                            <select name="agama" class="is-form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Status Perkawinan</label>
                            <select name="status_perkawinan" class="is-form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $st)
                                <option value="{{ $st }}" {{ old('status_perkawinan') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="is-form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Tidak Sekolah','SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D3','S1','S2','S3'] as $pd)
                                <option value="{{ $pd }}" {{ old('pendidikan_terakhir') == $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>No. Telepon / HP <span class="req">*</span></label>
                            <input type="tel" name="no_telepon" class="is-form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}" required>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="is-form-control" placeholder="email@contoh.com" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="is-form-control" placeholder="Petani / Buruh / dll" value="{{ old('pekerjaan') }}">
                        </div>
                        <div class="col-12 is-form-group">
                            <label>Alamat Lengkap <span class="req">*</span></label>
                            <textarea name="alamat_lengkap" class="is-form-control" rows="2" placeholder="Jalan, Nomor Rumah, RT/RW" required>{{ old('alamat_lengkap') }}</textarea>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Kelurahan / Desa</label>
                            <input type="text" name="kelurahan_desa" class="is-form-control" value="{{ old('kelurahan_desa') }}">
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Kecamatan</label>
                            <input type="text" name="kecamatan" class="is-form-control" value="{{ old('kecamatan') }}">
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Kabupaten / Kota <span class="req">*</span></label>
                            <input type="text" name="kabupaten_kota" class="is-form-control" value="{{ old('kabupaten_kota') }}" required>
                        </div>
                        <div class="col-12 is-form-group">
                            <label>Alasan / Keterangan Permohonan</label>
                            <textarea name="alasan_permohonan" class="is-form-control" rows="3"
                                      placeholder="Jelaskan singkat tujuan dan kebutuhan Anda...">{{ old('alasan_permohonan') }}</textarea>
                        </div>
                    </div>

                    {{-- Data Wali (untuk layanan anak/lansia/disabilitas) --}}
                    <hr>
                    <p class="text-muted" style="font-size:.82rem;"><i class="fa-solid fa-info-circle mr-1"></i> Isi bagian berikut jika pemohon memiliki wali/penanggung jawab (untuk anak, lansia, atau penyandang disabilitas).</p>
                    <div class="row">
                        <div class="col-md-4 is-form-group">
                            <label>Nama Wali / Penanggung Jawab</label>
                            <input type="text" name="nama_wali" class="is-form-control" value="{{ old('nama_wali') }}">
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>Hubungan dengan Pemohon</label>
                            <select name="hubungan_wali" class="is-form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['Orang Tua','Saudara','Anak','Suami/Istri','Lainnya'] as $h)
                                <option value="{{ $h }}" {{ old('hubungan_wali') == $h ? 'selected' : '' }}>{{ $h }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 is-form-group">
                            <label>No. Telepon Wali</label>
                            <input type="tel" name="no_telepon_wali" class="is-form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon_wali') }}">
                        </div>
                    </div>

                    {{-- Data Tambahan Spesifik per Layanan (Di-embed ke dalam Step 2) --}}
                    
                    {{-- PBS: Lembaga Kesejahteraan Sosial --}}
                    <div class="extra-fields mt-4" id="extra-PBS">
                        <div class="form-section-header" style="background:linear-gradient(90deg,#1a6fa0,#2980b9); border-radius:10px 10px 0 0; margin:-28px -28px 20px -28px; padding:12px 28px;">
                            <i class="fa-solid fa-building-ngo"></i> Data Lembaga (Bidang Pemberdayaan Sosial)
                        </div>
                        <div class="row">
                            <div class="col-md-6 is-form-group">
                                <label>Nama Lembaga</label>
                                <input type="text" name="nama_lembaga" class="is-form-control" value="{{ old('nama_lembaga') }}">
                            </div>
                            <div class="col-md-3 is-form-group">
                                <label>Jenis Lembaga</label>
                                <select name="jenis_lembaga" class="is-form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Yayasan','Ormas','LSM','Koperasi','Lainnya'] as $j)
                                    <option value="{{ $j }}" {{ old('jenis_lembaga') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 is-form-group">
                                <label>Tahun Berdiri</label>
                                <input type="number" name="tahun_berdiri" class="is-form-control" min="1900" max="{{ date('Y') }}" value="{{ old('tahun_berdiri') }}">
                            </div>
                            <div class="col-md-6 is-form-group">
                                <label>No. Akta Notaris</label>
                                <input type="text" name="no_akta" class="is-form-control" value="{{ old('no_akta') }}">
                            </div>
                        </div>
                    </div>

                    {{-- RS: Rehabilitasi (Kaki Palsu/Pengangkatan Anak) --}}
                    <div class="extra-fields mt-4" id="extra-RS">
                        <div class="form-section-header" style="background:linear-gradient(90deg,#e67e22,#d35400); border-radius:10px 10px 0 0; margin:-28px -28px 20px -28px; padding:12px 28px;">
                            <i class="fa-solid fa-person-walking-with-cane"></i> Data Tambahan Rehabilitasi Sosial
                        </div>
                        <p class="text-muted" style="font-size:.82rem;">Isi bagian yang sesuai dengan jenis layanan yang diajukan.</p>
                        <div class="row">
                            <div class="col-md-4 is-form-group">
                                <label>Lokasi Amputasi / Bagian Tubuh</label>
                                <input type="text" name="lokasi_amputasi" class="is-form-control" placeholder="cth: kaki kiri bawah lutut" value="{{ old('lokasi_amputasi') }}">
                            </div>
                            <div class="col-md-4 is-form-group">
                                <label>Penyebab Amputasi</label>
                                <input type="text" name="penyebab_amputasi" class="is-form-control" placeholder="cth: kecelakaan, penyakit" value="{{ old('penyebab_amputasi') }}">
                            </div>
                            <div class="col-md-4 is-form-group">
                                <label>Nama RS / Puskesmas Rujukan</label>
                                <input type="text" name="nama_rumah_sakit" class="is-form-control" value="{{ old('nama_rumah_sakit') }}">
                            </div>

                            <div class="col-12"><hr></div>

                            <div class="col-md-6 is-form-group">
                                <label>Nama Anak (Pengangkatan Anak)</label>
                                <input type="text" name="nama_anak_angkat" class="is-form-control" value="{{ old('nama_anak_angkat') }}">
                            </div>
                            <div class="col-md-6 is-form-group">
                                <label>Usia Anak</label>
                                <input type="text" name="usia_anak" class="is-form-control" placeholder="cth: 5 tahun" value="{{ old('usia_anak') }}">
                            </div>
                        </div>
                    </div>

                    {{-- PRSPD: Disabilitas --}}
                    <div class="extra-fields mt-4" id="extra-PRSPD">
                        <div class="form-section-header" style="background:linear-gradient(90deg,#1abc9c,#16a085); border-radius:10px 10px 0 0; margin:-28px -28px 20px -28px; padding:12px 28px;">
                            <i class="fa-solid fa-wheelchair"></i> Data Disabilitas (UPTD PRSPD)
                        </div>
                        <div class="row">
                            <div class="col-md-6 is-form-group">
                                <label>Jenis Disabilitas</label>
                                <select name="jenis_disabilitas" class="is-form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Disabilitas Fisik','Disabilitas Intelektual','Disabilitas Mental','Disabilitas Sensorik','Disabilitas Ganda'] as $d)
                                    <option value="{{ $d }}" {{ old('jenis_disabilitas') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 is-form-group">
                                <label>Tingkat / Derajat Disabilitas</label>
                                <select name="tingkat_disabilitas" class="is-form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Ringan','Sedang','Berat'] as $t)
                                    <option value="{{ $t }}" {{ old('tingkat_disabilitas') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- PSBR: Remaja Putus Sekolah --}}
                    <div class="extra-fields mt-4" id="extra-PSBR">
                        <div class="form-section-header" style="background:linear-gradient(90deg,#8e44ad,#6c3483); border-radius:10px 10px 0 0; margin:-28px -28px 20px -28px; padding:12px 28px;">
                            <i class="fa-solid fa-graduation-cap"></i> Data Remaja (UPTD PSBR)
                        </div>
                        <div class="row">
                            <div class="col-md-4 is-form-group">
                                <label>Asal Sekolah Terakhir</label>
                                <input type="text" name="asal_sekolah" class="is-form-control" value="{{ old('asal_sekolah') }}">
                            </div>
                            <div class="col-md-4 is-form-group">
                                <label>Kelas Terakhir</label>
                                <input type="text" name="kelas_terakhir" class="is-form-control" placeholder="cth: Kelas 8 SMP" value="{{ old('kelas_terakhir') }}">
                            </div>
                            <div class="col-md-4 is-form-group">
                                <label>Alasan Putus Sekolah</label>
                                <input type="text" name="alasan_putus_sekolah" class="is-form-control" value="{{ old('alasan_putus_sekolah') }}">
                            </div>
                            <div class="col-12 is-form-group">
                                <label>Jenis Keterampilan yang Diminati</label>
                                <select name="jenis_keterampilan_diminati" class="is-form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Menjahit','Las','Komputer','Tata Rias','Otomotif','Pertanian','Lainnya'] as $k)
                                    <option value="{{ $k }}" {{ old('jenis_keterampilan_diminati') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                        <button type="button" class="btn-is-prev" onclick="prevStep(2)"><i class="fa-solid fa-arrow-left mr-2"></i> Sebelumnya</button>
                        <button type="button" class="btn-is-next" onclick="nextStep(2)">Selanjutnya <i class="fa-solid fa-arrow-right ml-2"></i></button>
                    </div>
                </div>
            </div>

            {{-- STEP 3: Dokumen --}}
            <div class="form-step-card mb-4" id="step-3">
                <div class="form-section-header">
                    <i class="fa-solid fa-folder-open"></i> Langkah 3 – Upload Dokumen Pendukung
                </div>
                <div class="form-section-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="alert alert-warning" style="border-radius:10px;font-size:.85rem;">
                                <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                <strong>Perhatian:</strong> Semua dokumen harus dalam format <strong>PDF</strong> dengan ukuran maksimal <strong>500 KB</strong> per file.
                            </div>
                        </div>
                        @php
                        $docFields = [
                            'file_ktp'               => ['label' => 'Scan KTP Pemohon', 'icon' => 'fa-id-card', 'hint' => 'KTP yang masih berlaku'],
                            'file_kk'                => ['label' => 'Scan Kartu Keluarga', 'icon' => 'fa-users', 'hint' => 'KK terbaru'],
                            'file_surat_keterangan'  => ['label' => 'Surat Keterangan (Tidak Mampu / Rujukan)', 'icon' => 'fa-file-signature', 'hint' => 'Dari Kelurahan/Desa atau instansi terkait'],
                            'file_dokumen_pendukung' => ['label' => 'Dokumen Pendukung Lainnya', 'icon' => 'fa-paperclip', 'hint' => 'Akta kelahiran, surat keterangan dokter, dll'],
                            'file_foto'              => ['label' => 'Pas Foto / Foto Kondisi', 'icon' => 'fa-image', 'hint' => 'Foto terbaru (dalam format PDF)'],
                        ];
                        @endphp
                        @foreach($docFields as $fieldName => $field)
                        <div class="col-md-6 is-form-group">
                            <label><i class="fa-solid {{ $field['icon'] }} mr-1" style="color:#c0392b;"></i> {{ $field['label'] }}</label>
                            <div class="file-upload-zone" id="zone_{{ $fieldName }}">
                                <input type="file" name="{{ $fieldName }}" id="{{ $fieldName }}" accept=".pdf"
                                       onchange="showFileName('{{ $fieldName }}')">
                                <div class="fuz-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                <div class="fuz-text">Klik untuk pilih file PDF</div>
                                <div class="fuz-hint">{{ $field['hint'] }}</div>
                            </div>
                            <div class="file-name-badge" id="badge_{{ $fieldName }}">
                                <i class="fa-solid fa-file-pdf mr-1"></i> <span id="fname_{{ $fieldName }}"></span>
                            </div>
                            @error($fieldName)<div style="color:#e74c3c;font-size:.82rem;margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                        <button type="button" class="btn-is-prev" onclick="prevStep(3)"><i class="fa-solid fa-arrow-left mr-2"></i> Sebelumnya</button>
                        <button type="button" class="btn-is-next" onclick="nextStep(3)">Selanjutnya <i class="fa-solid fa-arrow-right ml-2"></i></button>
                    </div>
                </div>
            </div>

            {{-- STEP 4: Konfirmasi --}}
            <div class="form-step-card mb-4" id="step-4">
                <div class="form-section-header">
                    <i class="fa-solid fa-check-double"></i> Langkah 4 – Konfirmasi & Kirim
                </div>
                <div class="form-section-body">
                    <div style="background:#f8f9fa;border-radius:12px;padding:18px;border-left:4px solid #c0392b;font-size:.88rem;color:#374151;">
                        <p class="mb-1"><i class="fa-solid fa-info-circle text-danger mr-1"></i> Dengan mengirimkan formulir ini, saya menyatakan bahwa:</p>
                        <ul class="mb-0 ps-4">
                            <li>Semua data yang saya isi adalah benar dan dapat dipertanggungjawabkan.</li>
                            <li>Saya bersedia memenuhi persyaratan yang ditetapkan oleh Dinas Sosial Provinsi Lampung.</li>
                            <li>Saya memahami bahwa pendaftaran ini akan diverifikasi oleh petugas.</li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <label class="d-flex align-items-center" style="cursor:pointer; gap:10px; background:#fff5f5; padding:14px; border:1px solid #fecaca; border-radius:10px;">
                            <input type="checkbox" id="termsAgree" required style="width:20px; height:20px; cursor:pointer;" onchange="document.getElementById('btnSubmit').disabled = !this.checked">
                            <span style="font-size:.92rem; color:#991b1b; font-weight:700;">Saya setuju dan mematuhi seluruh pernyataan di atas.</span>
                        </label>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-between mt-4 pt-3" style="border-top:1px solid #f1f5f9;">
                        <button type="button" class="btn-is-prev" onclick="prevStep(4)"><i class="fa-solid fa-arrow-left mr-2"></i> Sebelumnya</button>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('informasi-sosial.index') }}" class="mr-3" style="color:#6c757d;font-size:.88rem;">Batal</a>
                            <button type="submit" class="btn-submit-is" id="btnSubmit" disabled>
                                <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pendaftaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
// ---- Layanan selector ----
function dropdownLayananChanged(selectEl) {
    // Sembunyikan semua field tambahan
    document.querySelectorAll('.extra-fields').forEach(f => f.classList.remove('visible'));
    
    // Ambil opsi yang terpilih
    if (selectEl.selectedIndex <= 0) return;
    const option = selectEl.options[selectEl.selectedIndex];
    const kode = option.getAttribute('data-kode');
    
    // Tampilkan field spesifik berdasarkan kode layanan
    const mapping = {
        'PBS': 'extra-PBS',
        'RS': 'extra-RS',
        'PRSPD': 'extra-PRSPD',
        'PSBR': 'extra-PSBR',
    };
    if (mapping[kode]) {
        document.getElementById(mapping[kode]).classList.add('visible');
    }
}

// ---- File upload display ----
function showFileName(fieldName) {
    const input  = document.getElementById(fieldName);
    const badge  = document.getElementById('badge_' + fieldName);
    const fname  = document.getElementById('fname_' + fieldName);
    if (input.files.length > 0) {
        fname.textContent = input.files[0].name;
        badge.style.display = 'flex';
        badge.style.alignItems = 'center';
    } else {
        badge.style.display = 'none';
    }
}

// ---- WIZARD LOGIC ----
function updateStepperUI(stepIdx) {
    const inds  = ['step-ind-1', 'step-ind-2', 'step-ind-3', 'step-ind-4'];
    inds.forEach((sid, j) => {
        const s = document.getElementById(sid);
        if (j < stepIdx - 1) { 
            s.classList.remove('active'); s.classList.add('done'); 
        } else if (j === stepIdx - 1) { 
            s.classList.add('active'); s.classList.remove('done'); 
        } else { 
            s.classList.remove('active', 'done'); 
        }
    });

    // Update visibility of cards
    document.querySelectorAll('.form-step-card').forEach(el => el.classList.remove('active-step'));
    document.getElementById('step-' + stepIdx).classList.add('active-step');
    
    // Smooth scroll to top of wizard
    document.querySelector('.is-stepper').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function checkStepValidation(current) {
    const currentCard = document.getElementById('step-' + current);
    if(!currentCard) return false;
    const inputs = currentCard.querySelectorAll('select, input, textarea');
    let isValid = true;
    for (let i = 0; i < inputs.length; i++) {
        const input = inputs[i];
        if (!input.checkValidity()) {
            input.reportValidity();
            isValid = false;
            break;
        }
    }
    return isValid;
}

function nextStep(current) {
    if (checkStepValidation(current) && current < 4) {
        updateStepperUI(current + 1);
    }
}

function prevStep(current) {
    if (current > 1) {
        updateStepperUI(current - 1);
    }
}

function jumpToStep(target) {
    // Cari index step yang aktif saat ini
    let current = 1;
    document.querySelectorAll('.form-step-card').forEach((el, idx) => {
        if(el.classList.contains('active-step')) current = idx + 1;
    });
    
    if (target === current) return;
    
    if (target < current) { // Lompat ke belakang bebas tanpa validasi
        updateStepperUI(target);
    } else { // Lompat ke depan harus melewati pos validasi secara urut
        let runCurrent = current;
        while(runCurrent < target) {
            if(!checkStepValidation(runCurrent)) {
                // Berhenti di step yang tidak valid
                updateStepperUI(runCurrent);
                return;
            }
            runCurrent++;
        }
        updateStepperUI(target);
    }
}

// remove scroll listener, use wizard logic instead
// window.addEventListener('scroll', updateStepper);

// ---- Prevent double submit ----
document.getElementById('formDaftar').addEventListener('submit', function() {
    document.getElementById('btnSubmit').disabled = true;
    document.getElementById('btnSubmit').innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
});

// ---- Restore selected layanan on page reload (old input) ----
document.addEventListener('DOMContentLoaded', function() {
    const selector = document.getElementById('layanan_sosial_id');
    if (selector && selector.value) {
        dropdownLayananChanged(selector);
    }
});
</script>
@endpush
