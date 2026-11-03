<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LayananSosial;
use App\Models\PendaftaranLayanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * API Informasi Sosial - Dinas Sosial Provinsi Lampung
 *
 * Base URL: /api/informasi-sosial
 */
class InformasiSosialController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Validasi API Token
            $token = $request->header('x-api-token-dinsos');
            $validToken = env('API_TOKEN_DINSOS', 'dinsos-api-2024'); // Fallback token if not set in .env

            if ($token !== $validToken) {
                return response()->json(['success' => false, 'message' => 'Token API tidak valid atau tidak ditemukan (x-api-token-dinsos).'], 401);
            }

            $allowedHosts = ['dinsos.lampungprov.go.id', 'dinsos.test'];
            if (!in_array($request->getHost(), $allowedHosts)) {
                return response()->json(['success' => false, 'message' => 'Akses API tidak diizinkan dari domain ini.'], 403);
            }
            return $next($request);
        });
    }

    /**
     * GET /api/informasi-sosial/layanan
     * Daftar semua layanan sosial aktif
     */
    public function layananIndex(): JsonResponse
    {
        $layanan = LayananSosial::where('aktif', true)
            ->orderBy('urutan')
            ->get(['id', 'kode', 'nama', 'singkatan', 'jenis', 'deskripsi', 'persyaratan', 'icon', 'warna']);

        return response()->json([
            'success' => true,
            'data'    => $layanan,
            'total'   => $layanan->count(),
        ]);
    }

    /**
     * GET /api/informasi-sosial/layanan/{kode}
     * Detail satu layanan sosial
     */
    public function layananShow(string $kode): JsonResponse
    {
        $layanan = LayananSosial::where('kode', strtoupper($kode))
            ->where('aktif', true)
            ->first();

        if (!$layanan) {
            return response()->json(['success' => false, 'message' => 'Layanan tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $layanan,
        ]);
    }

    /**
     * POST /api/informasi-sosial/daftar
     * Submit pendaftaran layanan
     *
     * Content-Type: multipart/form-data
     * Fields: layanan_sosial_id, nama_lengkap, nik, jenis_kelamin, tanggal_lahir,
     *         tempat_lahir, no_telepon, alamat_lengkap, kabupaten_kota, ...
     * Files: file_ktp, file_kk, file_surat_keterangan, file_dokumen_pendukung, file_foto (PDF only, max 500KB)
     */
    public function daftar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'layanan_sosial_id'      => 'required|exists:layanan_sosial,id',
            'nama_lengkap'           => 'required|string|max:255',
            'nik'                    => 'nullable|digits:16',
            'jenis_kelamin'          => 'required|in:laki-laki,perempuan',
            'tanggal_lahir'          => 'required|date',
            'tempat_lahir'           => 'required|string|max:100',
            'no_telepon'             => 'required|string|max:20',
            'email'                  => 'nullable|email|max:255',
            'alamat_lengkap'         => 'required|string',
            'kabupaten_kota'         => 'required|string|max:100',
            'file_ktp'               => 'nullable|mimes:pdf|max:512',
            'file_kk'                => 'nullable|mimes:pdf|max:512',
            'file_surat_keterangan'  => 'nullable|mimes:pdf|max:512',
            'file_dokumen_pendukung' => 'nullable|mimes:pdf|max:512',
            'file_foto'              => 'nullable|mimes:pdf|max:512',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $layanan         = LayananSosial::findOrFail($request->layanan_sosial_id);
        $nomorRegistrasi = PendaftaranLayanan::generateNomorRegistrasi($layanan->kode);

        // Handle file uploads
        $uploadDir  = 'pendaftaran/' . $layanan->kode . '/' . date('Ymd');
        $fileFields = ['file_ktp', 'file_kk', 'file_surat_keterangan', 'file_dokumen_pendukung', 'file_foto'];
        $filePaths  = [];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $filePaths[$field] = $request->file($field)->store($uploadDir, 'public');
            }
        }

        // Data tambahan spesifik layanan
        $extraKeys    = [
            'nama_lembaga', 'jenis_lembaga', 'tahun_berdiri', 'no_akta',
            'lokasi_amputasi', 'penyebab_amputasi', 'nama_rumah_sakit',
            'nama_anak_angkat', 'usia_anak',
            'jenis_disabilitas', 'tingkat_disabilitas',
            'asal_sekolah', 'kelas_terakhir', 'alasan_putus_sekolah',
            'jenis_keterampilan_diminati',
            'pekerjaan', 'penghasilan_bulanan', 'alasan_permohonan',
        ];
        $dataTambahan = array_filter($request->only($extraKeys), fn($v) => $v !== null && $v !== '');

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

        return response()->json([
            'success'          => true,
            'message'          => 'Pendaftaran berhasil dikirim.',
            'nomor_registrasi' => $nomorRegistrasi,
            'data'             => [
                'id'               => $pendaftaran->id,
                'nomor_registrasi' => $pendaftaran->nomor_registrasi,
                'layanan'          => $layanan->nama,
                'nama_lengkap'     => $pendaftaran->nama_lengkap,
                'status'           => $pendaftaran->status,
                'tanggal_daftar'   => $pendaftaran->created_at,
            ],
        ], 201);
    }

    /**
     * GET /api/informasi-sosial/status/{nomor}
     * Cek status pendaftaran berdasarkan nomor registrasi
     */
    public function cekStatus(Request $request): JsonResponse
    {
        $nomor = $request->nomor;
        $pendaftaran = PendaftaranLayanan::where('nomor_registrasi', $nomor)
            ->with('layanan:id,kode,nama,singkatan')
            ->first(['id', 'nomor_registrasi', 'layanan_sosial_id', 'nama_lengkap', 'status', 'catatan_petugas', 'created_at', 'updated_at']);

        if (!$pendaftaran) {
            return response()->json(['success' => false, 'message' => 'Nomor registrasi tidak ditemukan.'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'nomor_registrasi' => $pendaftaran->nomor_registrasi,
                'nama_lengkap'     => $pendaftaran->nama_lengkap,
                'layanan'          => $pendaftaran->layanan->nama ?? '-',
                'status'           => $pendaftaran->status,
                'status_label'     => $pendaftaran->status_label,
                'catatan_petugas'  => $pendaftaran->catatan_petugas,
                'tanggal_daftar'   => $pendaftaran->created_at,
                'terakhir_diupdate'=> $pendaftaran->updated_at,
            ],
        ]);
    }
}
