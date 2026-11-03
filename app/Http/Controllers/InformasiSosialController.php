<?php

namespace App\Http\Controllers;

use App\Models\LayananSosial;
use App\Models\PendaftaranLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InformasiSosialController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $allowedHosts = ['dinsos.lampungprov.go.id', 'masterweblv10.test', 'localhost', '127.0.0.1'];
            if (!app()->environment('local') && !in_array($request->getHost(), $allowedHosts)) {
                abort(403, 'Akses ke halaman ini hanya diizinkan melalui domain yang sah.');
            }
            return $next($request);
        });
    }

    /**
     * Halaman daftar semua layanan (index)
     */
    public function index()
    {
        $layanan = LayananSosial::where('aktif', true)->orderBy('urutan')->get();

        $bidang = $layanan->where('jenis', 'bidang');
        $uptd   = $layanan->where('jenis', 'uptd');

        return view('theme-2024limitless.informasi-sosial.index', compact('layanan', 'bidang', 'uptd'));
    }

    /**
     * Halaman detail satu layanan
     */
    public function detail(string $kode)
    {
        $layanan       = LayananSosial::where('kode', $kode)->where('aktif', true)->firstOrFail();
        $sampelFolder  = $this->getSampleFolder($kode);
        $sampelFiles   = $this->getSampleFiles($sampelFolder);

        return view('theme-2024limitless.informasi-sosial.detail', compact('layanan', 'sampelFiles', 'sampelFolder'));
    }

    /**
     * Halaman form pendaftaran
     */
    public function formDaftar(Request $request, ?string $kode = null)
    {
        $layananList = LayananSosial::where('aktif', true)->orderBy('urutan')->get();
        $layanan     = $kode
            ? LayananSosial::where('kode', $kode)->where('aktif', true)->first()
            : null;

        return view('theme-2024limitless.informasi-sosial.daftar', compact('layananList', 'layanan'));
    }

    /**
     * Proses submit pendaftaran
     */
    public function submitDaftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layanan_sosial_id'     => 'required|exists:layanan_sosial,id',
            'nama_lengkap'          => 'required|string|max:255',
            'nik'                   => 'nullable|digits:16',
            'jenis_kelamin'         => 'required|in:laki-laki,perempuan',
            'tanggal_lahir'         => 'required|date',
            'tempat_lahir'          => 'required|string|max:100',
            'no_telepon'            => 'required|string|max:20',
            'email'                 => 'nullable|email|max:255',
            'alamat_lengkap'        => 'required|string',
            'kabupaten_kota'        => 'required|string|max:100',
            // File uploads - PDF only, max 500KB
            'file_ktp'              => 'nullable|mimes:pdf|max:512',
            'file_kk'               => 'nullable|mimes:pdf|max:512',
            'file_surat_keterangan' => 'nullable|mimes:pdf|max:512',
            'file_dokumen_pendukung'=> 'nullable|mimes:pdf|max:512',
            'file_foto'             => 'nullable|mimes:pdf|max:512',
        ], [
            'layanan_sosial_id.required'  => 'Silakan pilih jenis layanan.',
            'nama_lengkap.required'       => 'Nama lengkap wajib diisi.',
            'nik.digits'                  => 'NIK harus 16 digit.',
            'jenis_kelamin.required'      => 'Jenis kelamin wajib dipilih.',
            'tanggal_lahir.required'      => 'Tanggal lahir wajib diisi.',
            'tempat_lahir.required'       => 'Tempat lahir wajib diisi.',
            'no_telepon.required'         => 'Nomor telepon wajib diisi.',
            'alamat_lengkap.required'     => 'Alamat lengkap wajib diisi.',
            'kabupaten_kota.required'     => 'Kabupaten/Kota wajib diisi.',
            'file_ktp.mimes'              => 'File harus berformat PDF.',
            'file_ktp.max'                => 'Ukuran file maksimal 500KB.',
            'file_kk.mimes'               => 'File harus berformat PDF.',
            'file_kk.max'                 => 'Ukuran file maksimal 500KB.',
            'file_surat_keterangan.mimes' => 'File harus berformat PDF.',
            'file_surat_keterangan.max'   => 'Ukuran file maksimal 500KB.',
            'file_dokumen_pendukung.mimes'=> 'File harus berformat PDF.',
            'file_dokumen_pendukung.max'  => 'Ukuran file maksimal 500KB.',
            'file_foto.mimes'             => 'File harus berformat PDF.',
            'file_foto.max'               => 'Ukuran file maksimal 500KB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $layanan        = LayananSosial::findOrFail($request->layanan_sosial_id);
        $nomorRegistrasi = PendaftaranLayanan::generateNomorRegistrasi($layanan->kode);

        // Simpan file uploads
        $uploadDir   = 'pendaftaran/' . $layanan->kode . '/' . date('Ymd');
        $fileFields  = ['file_ktp', 'file_kk', 'file_surat_keterangan', 'file_dokumen_pendukung', 'file_foto'];
        $filePaths   = [];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $filePaths[$field] = $request->file($field)->store($uploadDir, 'public');
            }
        }

        // Kumpulkan data tambahan spesifik layanan
        $dataTambahan = $request->only([
            // PBS - Lembaga
            'nama_lembaga', 'jenis_lembaga', 'tahun_berdiri', 'no_akta',
            // RS - Kaki Palsu
            'lokasi_amputasi', 'penyebab_amputasi', 'nama_rumah_sakit',
            // RS - Pengangkatan Anak
            'nama_anak_angkat', 'usia_anak',
            // PRSPD/PSLU/PSAA/PSBR
            'jenis_disabilitas', 'tingkat_disabilitas',
            'asal_sekolah', 'kelas_terakhir', 'alasan_putus_sekolah',
            'jenis_keterampilan_diminati',
            // Umum tambahan
            'pekerjaan', 'penghasilan_bulanan', 'alasan_permohonan',
        ]);

        // Filter null/empty
        $dataTambahan = array_filter($dataTambahan, fn($v) => $v !== null && $v !== '');

        $pendaftaran = PendaftaranLayanan::create([
            'nomor_registrasi'       => $nomorRegistrasi,
            'layanan_sosial_id'      => $request->layanan_sosial_id,
            'nama_lengkap'           => $request->nama_lengkap,
            'nik'                    => $request->nik,
            'jenis_kelamin'          => $request->jenis_kelamin,
            'tanggal_lahir'          => $request->tanggal_lahir,
            'tempat_lahir'           => $request->tempat_lahir,
            'agama'                  => $request->agama,
            'status_perkawinan'      => $request->status_perkawinan,
            'pendidikan_terakhir'    => $request->pendidikan_terakhir,
            'alamat_lengkap'         => $request->alamat_lengkap,
            'kelurahan_desa'         => $request->kelurahan_desa,
            'kecamatan'              => $request->kecamatan,
            'kabupaten_kota'         => $request->kabupaten_kota,
            'no_telepon'             => $request->no_telepon,
            'email'                  => $request->email,
            'nama_wali'              => $request->nama_wali,
            'hubungan_wali'          => $request->hubungan_wali,
            'no_telepon_wali'        => $request->no_telepon_wali,
            'alamat_wali'            => $request->alamat_wali,
            'data_tambahan'          => !empty($dataTambahan) ? $dataTambahan : null,
            'file_ktp'               => $filePaths['file_ktp'] ?? null,
            'file_kk'                => $filePaths['file_kk'] ?? null,
            'file_surat_keterangan'  => $filePaths['file_surat_keterangan'] ?? null,
            'file_dokumen_pendukung' => $filePaths['file_dokumen_pendukung'] ?? null,
            'file_foto'              => $filePaths['file_foto'] ?? null,
            'status'                 => 'menunggu',
        ]);

        return redirect()->route('informasi-sosial.sukses', ['nomor' => $nomorRegistrasi])
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    /**
     * Halaman sukses setelah mendaftar
     */
    public function sukses(Request $request)
    {
        $nomor       = $request->query('nomor');
        $pendaftaran = PendaftaranLayanan::where('nomor_registrasi', $nomor)
                         ->with('layanan')
                         ->first();

        return view('theme-2024limitless.informasi-sosial.sukses', compact('pendaftaran', 'nomor'));
    }

    /**
     * Cek status pendaftaran (publik)
     */
    public function cekStatus(Request $request)
    {
        $nomor       = $request->query('nomor');
        $pendaftaran = null;

        if ($nomor) {
            $pendaftaran = PendaftaranLayanan::where('nomor_registrasi', $nomor)
                             ->with('layanan')
                             ->first();
        }

        return view('theme-2024limitless.informasi-sosial.cek-status', compact('pendaftaran', 'nomor'));
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    private function getSampleFolder(string $kode): ?string
    {
        $map = [
            'FM'      => 'Bidang Fakir Miskin',
            'PBS'     => 'Bidang Pemberdayaan Sosial',
            'PJS'     => 'Bidang Perlindungan dan Jaminan Sosial',
            'RS'      => 'Bidang Rehabilitasi Sosial',
            'PRSPD'   => 'UPTD PRSPD (Penyandang Disabilitas)',
            'PSAA_BA' => 'UPTD PSAA Budi Asih (Panti Asuhan Anak)',
            'PSAA_HB' => 'UPTD PSAA Harapan Bangsa (Panti Asuhan Anak)',
            'PSBR'    => 'UPTD PSBR (Remaja Putus Sekolah)',
            'PSLU'    => 'UPTD PSLU (Lanjut Usia Terlantar)',
        ];
        return $map[$kode] ?? null;
    }

    private function getSampleFiles(?string $folder): array
    {
        if (!$folder) return [];

        $path = public_path('sample/' . $folder);
        if (!is_dir($path)) return [];

        $files = [];
        foreach (scandir($path) as $file) {
            if ($file === '.' || $file === '..') continue;
            $ext      = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $files[]  = [
                'nama'      => $file,
                'ext'       => $ext,
                'url'       => asset('sample/' . rawurlencode($folder) . '/' . rawurlencode($file)),
                'icon'      => $ext === 'pdf' ? 'fa-file-pdf' : (in_array($ext, ['docx', 'doc']) ? 'fa-file-word' : (in_array($ext, ['jpg', 'jpeg', 'png']) ? 'fa-image' : 'fa-file')),
                'icon_color'=> $ext === 'pdf' ? 'text-danger' : (in_array($ext, ['docx', 'doc']) ? 'text-primary' : (in_array($ext, ['jpg','jpeg','png']) ? 'text-success' : 'text-secondary')),
            ];
        }
        return $files;
    }
}
