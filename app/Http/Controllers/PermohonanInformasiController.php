<?php

namespace App\Http\Controllers;

use App\Models\PermohonanInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PermohonanInformasiController extends Controller
{
    /**
     * Halaman Formulir Permohonan Informasi Publik
     */
    public function index()
    {
        return view('theme-2024limitless.permohonan-informasi.index');
    }

    /**
     * Halaman Tracking / Pelacakan Status Permohonan
     */
    public function tracking(Request $request)
    {
        $tiket = trim($request->input('tiket') ?? $request->input('nomor') ?? '');
        $email = trim($request->input('email') ?? '');
        $permohonan = null;
        $searched = false;

        if (!empty($tiket)) {
            $searched = true;
            $query = PermohonanInformasi::where('nomor_tiket', $tiket);
            if (!empty($email)) {
                $query->where('email', $email);
            }
            $permohonan = $query->first();
        }

        return view('theme-2024limitless.permohonan-informasi.tracking', compact('permohonan', 'tiket', 'email', 'searched'));
    }

    /**
     * Proses Submit Formulir
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_pemohon'  => 'required|in:Perorangan,Kelompok Orang,Badan Hukum',
            'nama_pemohon'      => 'required|string|max:255',
            'nik'               => 'required|string|min:15|max:25',
            'email'             => 'required|email|max:255',
            'no_telepon'        => 'required|string|max:30',
            'pekerjaan'         => 'nullable|string|max:150',
            'instansi'          => 'nullable|string|max:200',
            'alamat'            => 'required|string',
            'rincian_informasi' => 'required|string',
            'tujuan_penggunaan' => 'required|string',
            'cara_memperoleh'   => 'required|string|max:200',
            'cara_penyerahan'   => 'required|string|max:200',
            'file_ktp'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:3072',
            'file_pendukung'    => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar|max:5120',
        ], [
            'kategori_pemohon.required'  => 'Kategori pemohon wajib dipilih.',
            'nama_pemohon.required'      => 'Nama lengkap pemohon wajib diisi.',
            'nik.required'               => 'Nomor Identitas (NIK/KTP/Paspor) wajib diisi.',
            'email.required'             => 'Alamat email aktif wajib diisi.',
            'email.email'                => 'Format alamat email tidak valid.',
            'no_telepon.required'        => 'Nomor telepon / WhatsApp wajib diisi.',
            'alamat.required'            => 'Alamat lengkap wajib diisi.',
            'rincian_informasi.required' => 'Rincian informasi yang dibutuhkan wajib diisi.',
            'tujuan_penggunaan.required' => 'Tujuan penggunaan informasi wajib diisi.',
            'file_ktp.required'          => 'Wajib mengunggah scan / foto kartu identitas (KTP).',
            'file_ktp.mimes'             => 'File identitas harus berformat JPG, PNG, atau PDF.',
            'file_ktp.max'               => 'Ukuran file identitas maksimal 3MB.',
            'file_pendukung.mimes'       => 'File dokumen pendukung harus berformat JPG, PNG, PDF, Word, atau ZIP.',
            'file_pendukung.max'         => 'Ukuran file dokumen pendukung maksimal 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate Nomor Tiket Unik
        $nomorTiket = PermohonanInformasi::generateNomorTiket();

        // Upload Berkas KTP
        $pathKtp = null;
        if ($request->hasFile('file_ktp')) {
            $fileKtp = $request->file('file_ktp');
            $ktpName = 'ktp_' . $nomorTiket . '_' . time() . '.' . $fileKtp->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('uploads/permohonan_informasi', $fileKtp, $ktpName);
            $pathKtp = 'uploads/permohonan_informasi/' . $ktpName;
        }

        // Upload Berkas Dokumen Pendukung (opsional)
        $pathPendukung = null;
        if ($request->hasFile('file_pendukung')) {
            $filePendukung = $request->file('file_pendukung');
            $pendukungName = 'doc_' . $nomorTiket . '_' . time() . '.' . $filePendukung->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('uploads/permohonan_informasi', $filePendukung, $pendukungName);
            $pathPendukung = 'uploads/permohonan_informasi/' . $pendukungName;
        }

        // Simpan Data Permohonan
        $permohonan = PermohonanInformasi::create([
            'nomor_tiket'       => $nomorTiket,
            'kategori_pemohon'  => $request->kategori_pemohon,
            'nama_pemohon'      => $request->nama_pemohon,
            'nik'               => $request->nik,
            'file_ktp'          => $pathKtp,
            'email'             => $request->email,
            'no_telepon'        => $request->no_telepon,
            'pekerjaan'         => $request->pekerjaan,
            'instansi'          => $request->instansi,
            'alamat'            => $request->alamat,
            'rincian_informasi' => $request->rincian_informasi,
            'tujuan_penggunaan' => $request->tujuan_penggunaan,
            'cara_memperoleh'   => $request->cara_memperoleh,
            'cara_penyerahan'   => $request->cara_penyerahan,
            'file_pendukung'    => $pathPendukung,
            'status'            => 'pending',
            'tanggapan'         => null,
        ]);

        // Kirim email tanda terima registrasi otomatis
        try {
            Mail::send('emails.permohonan_status', ['permohonan' => $permohonan], function ($message) use ($permohonan) {
                $message->to($permohonan->email, $permohonan->nama_pemohon)
                        ->subject('[PPID Bappeda Lampung] Tanda Terima Permohonan Informasi: ' . $permohonan->nomor_tiket);
            });
            $permohonan->email_notifikasi_terkirim = true;
            $permohonan->tanggal_email_terakhir = now();
            $permohonan->save();
        } catch (\Throwable $e) {
            Log::info('Email tanda terima pendaftaran tercatat di log: ' . $e->getMessage());
        }

        return redirect()->route('permohonan-informasi.sukses', ['tiket' => $nomorTiket]);
    }

    /**
     * Halaman Bukti / Sukses Registrasi
     */
    public function sukses($tiket)
    {
        $permohonan = PermohonanInformasi::where('nomor_tiket', $tiket)->firstOrFail();
        return view('theme-2024limitless.permohonan-informasi.sukses', compact('permohonan'));
    }

    /**
     * Download Berkas Jawaban Admin
     */
    public function downloadJawaban($tiket)
    {
        $permohonan = PermohonanInformasi::where('nomor_tiket', $tiket)->firstOrFail();

        if (empty($permohonan->file_lampiran_jawaban) || !Storage::disk('public')->exists($permohonan->file_lampiran_jawaban)) {
            abort(404, 'Berkas jawaban belum tersedia atau tidak ditemukan.');
        }

        $fullPath = Storage::disk('public')->path($permohonan->file_lampiran_jawaban);
        return response()->download($fullPath, 'Jawaban_PPID_' . $permohonan->nomor_tiket . '.' . pathinfo($fullPath, PATHINFO_EXTENSION));
    }
}
