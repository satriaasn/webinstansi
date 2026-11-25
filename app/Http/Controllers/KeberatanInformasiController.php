<?php

namespace App\Http\Controllers;

use App\Models\KeberatanInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeberatanInformasiController extends Controller
{
    public function index()
    {
        $nomorRegistrasi = KeberatanInformasi::generateNomorRegistrasi();
        return view('theme-2024limitless.keberatan-informasi.index', compact('nomorRegistrasi'));
    }

    public function tracking(Request $request)
    {
        $nomor = trim($request->input('nomor') ?? $request->input('tiket') ?? '');
        $keberatan = null;
        $searched = false;

        if (!empty($nomor)) {
            $searched = true;
            $keberatan = KeberatanInformasi::where('nomor_registrasi_keberatan', $nomor)
                ->orWhere('nomor_permohonan_informasi', $nomor)
                ->first();
        }

        return view('theme-2024limitless.keberatan-informasi.tracking', compact('keberatan', 'nomor', 'searched'));
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'informasi_pengaju_keberatan' => 'required|string|max:255',
            'nomor_permohonan_informasi'  => 'nullable|string|max:100',
            'tujuan_penggunaan_informasi' => 'required|string',
            'nama'                        => 'required|string|max:255',
            'alamat_lengkap'              => 'required|string',
            'pekerjaan'                   => 'nullable|string|max:150',
            'nomor_telepon'               => 'required|string|max:30',
            'alasan_keberatan'            => 'required|string',
            'kasus_posisi'                => 'required|string',
        ], [
            'informasi_pengaju_keberatan.required' => 'Informasi pengaju keberatan wajib diisi.',
            'tujuan_penggunaan_informasi.required' => 'Tujuan penggunaan informasi wajib diisi.',
            'nama.required'                        => 'Nama lengkap wajib diisi.',
            'alamat_lengkap.required'              => 'Alamat lengkap wajib diisi.',
            'nomor_telepon.required'               => 'Nomor telepon / WhatsApp wajib diisi.',
            'alasan_keberatan.required'            => 'Alasan keberatan wajib diisi.',
            'kasus_posisi.required'                => 'Kasus posisi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nomorRegistrasi = KeberatanInformasi::generateNomorRegistrasi();

        $keberatan = KeberatanInformasi::create([
            'nomor_registrasi_keberatan'  => $nomorRegistrasi,
            'informasi_pengaju_keberatan' => $request->input('informasi_pengaju_keberatan'),
            'nomor_permohonan_informasi'  => $request->input('nomor_permohonan_informasi'),
            'tujuan_penggunaan_informasi' => $request->input('tujuan_penggunaan_informasi'),
            'nama'                        => $request->input('nama'),
            'alamat_lengkap'              => $request->input('alamat_lengkap'),
            'pekerjaan'                   => $request->input('pekerjaan'),
            'nomor_telepon'               => $request->input('nomor_telepon'),
            'alasan_keberatan'            => $request->input('alasan_keberatan'),
            'kasus_posisi'                => $request->input('kasus_posisi'),
            'status'                      => 'pending',
        ]);

        return redirect()->route('keberatan-informasi.sukses', ['nomor' => $keberatan->nomor_registrasi_keberatan]);
    }

    public function sukses($nomor)
    {
        $keberatan = KeberatanInformasi::where('nomor_registrasi_keberatan', $nomor)->firstOrFail();
        return view('theme-2024limitless.keberatan-informasi.sukses', compact('keberatan'));
    }
}
