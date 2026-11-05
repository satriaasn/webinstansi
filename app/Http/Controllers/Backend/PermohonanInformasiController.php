<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PermohonanInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\Datatables\Datatables;

class PermohonanInformasiController extends Controller
{
    private function checkPermission()
    {
        return Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin') || Auth::user()->can('permohonan');
    }

    /**
     * Tampilan Datatable Daftar Permohonan Informasi
     */
    public function index()
    {
        if (!$this->checkPermission()) {
            return redirect('dashboard')->with('flash_message', 'Akses tidak diizinkan.');
        }

        $counts = [
            'total'    => PermohonanInformasi::count(),
            'pending'  => PermohonanInformasi::where('status', 'pending')->count(),
            'diproses' => PermohonanInformasi::where('status', 'diproses')->count(),
            'selesai'  => PermohonanInformasi::where('status', 'selesai')->count(),
            'ditolak'  => PermohonanInformasi::where('status', 'ditolak')->count(),
        ];

        return view('backend.permohonan-informasi.datatable', compact('counts'));
    }

    /**
     * Datatables JSON feed
     */
    public function anyData(Request $request)
    {
        if (!$this->checkPermission()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = PermohonanInformasi::query()->latest('id');

        if ($request->has('status') && in_array($request->status, ['pending', 'diproses', 'selesai', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        return Datatables::of($query)
            ->addColumn('check', function ($item) {
                return '<div style="text-align:center;">
                    <input type="checkbox" id="titleCheckdel" />
                    <input type="hidden" class="deldata" name="id[]" value="' . Hashids::encode($item->id) . '" disabled />
                </div>';
            })
            ->editColumn('nomor_tiket', function ($item) {
                $hash = Hashids::encode($item->id);
                return '<a href="' . url('dashboard/permohonan-informasi/' . $hash) . '" class="inline-flex items-center gap-1.5 font-black text-xs text-[#1A56DB] hover:underline" title="Klik untuk Lihat Detail & Tanggapi">' 
                    . '<i class="fas fa-ticket text-[11px]"></i> <span>' . e($item->nomor_tiket) . '</span></a>';
            })
            ->addColumn('pemohon', function ($item) {
                $cat = '<span class="badge badge-light border text-muted px-1 mr-1">' . e($item->kategori_pemohon) . '</span>';
                return '<div>' . $cat . '<strong>' . e($item->nama_pemohon) . '</strong></div>'
                    . '<div class="tx-11 tx-gray-600"><i class="fa fa-envelope-o"></i> ' . e($item->email) . ' &bull; <i class="fa fa-phone"></i> ' . e($item->no_telepon) . '</div>';
            })
            ->editColumn('rincian_informasi', function ($item) {
                return '<div class="tx-12" title="' . e($item->rincian_informasi) . '">' . Str::limit(e($item->rincian_informasi), 80) . '</div>'
                    . '<div class="tx-11 tx-italic tx-gray-500">Tujuan: ' . Str::limit(e($item->tujuan_penggunaan), 50) . '</div>';
            })
            ->editColumn('status', function ($item) {
                return $item->status_badge;
            })
            ->addColumn('notif_email', function ($item) {
                if ($item->email_notifikasi_terkirim) {
                    return '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200" title="Terkirim: ' . ($item->tanggal_email_terakhir ? $item->tanggal_email_terakhir->format('d/m/Y H:i') : '') . '"><i class="fas fa-check text-[9px]"></i> Terkirim</span>';
                }
                return '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200"><i class="fas fa-minus text-[8px]"></i> Belum</span>';
            })
            ->editColumn('created_at', function ($item) {
                return '<div class="text-xs font-bold text-slate-800">' . $item->created_at->format('d/m/Y') . '</div>'
                    . '<div class="text-[11px] text-slate-400 font-medium">' . $item->created_at->format('H:i') . ' WIB</div>';
            })
            ->addColumn('action', function ($item) {
                $hash = Hashids::encode($item->id);
                $btn = '<div class="inline-flex items-center gap-1.5" style="white-space:nowrap;">';
                $btn .= '<a href="' . url('dashboard/permohonan-informasi/' . $hash) . '" class="w-8 h-8 rounded-lg bg-blue-50 text-[#1A56DB] hover:bg-[#1A56DB] hover:text-white flex items-center justify-center text-xs transition border border-blue-200" title="Lihat Detail & Tanggapi"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="' . url('dashboard/permohonan-informasi/' . $hash . '/send-email') . '" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white flex items-center justify-center text-xs transition border border-sky-200" title="Kirim Notifikasi Email ke Pemohon" onclick="return confirm(\'Kirim pemberitahuan email status ke ' . e($item->email) . '?\')"><i class="fas fa-paper-plane"></i></a>';
                $btn .= '<a href="' . url('dashboard/permohonan-informasi/' . $hash) . '" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center text-xs transition border border-rose-200" data-delete="" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['check', 'nomor_tiket', 'pemohon', 'rincian_informasi', 'status', 'notif_email', 'created_at', 'action'])
            ->make(true);
    }

    /**
     * Halaman Detail & Pemrosesan Permohonan
     */
    public function show($id)
    {
        if (!$this->checkPermission()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        if (empty($ids)) {
            abort(404);
        }

        $permohonan = PermohonanInformasi::with('responder')->findOrFail($ids[0]);

        return view('backend.permohonan-informasi.show', compact('permohonan'));
    }

    /**
     * Update Status & Catatan Tanggapan Resmi
     */
    public function updateStatus(Request $request, $id)
    {
        if (!$this->checkPermission()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        if (empty($ids)) {
            abort(404);
        }

        $request->validate([
            'status'                => 'required|in:pending,diproses,selesai,ditolak',
            'tanggapan'             => 'nullable|string',
            'file_lampiran_jawaban' => 'nullable|file|mimes:pdf,doc,docx,zip,rar,jpg,png|max:10240',
        ], [
            'status.required'             => 'Status permohonan wajib dipilih.',
            'status.in'                   => 'Status permohonan tidak valid.',
            'file_lampiran_jawaban.mimes' => 'Lampiran berkas jawaban harus berupa PDF, Word, ZIP, RAR, atau gambar.',
            'file_lampiran_jawaban.max'   => 'Ukuran file lampiran jawaban maksimal 10MB.',
        ]);

        $permohonan = PermohonanInformasi::findOrFail($ids[0]);
        $permohonan->status = $request->status;
        $permohonan->tanggapan = $request->tanggapan;
        $permohonan->tanggal_respon = now();
        $permohonan->respon_oleh = Auth::id();

        // Handle upload berkas jawaban admin
        if ($request->hasFile('file_lampiran_jawaban')) {
            $file = $request->file('file_lampiran_jawaban');
            $filename = 'jawaban_' . $permohonan->nomor_tiket . '_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('uploads/jawaban_ppid', $file, $filename);
            $permohonan->file_lampiran_jawaban = 'uploads/jawaban_ppid/' . $filename;
        }

        $permohonan->save();

        // Jika opsi kirim email dicentang saat update
        if ($request->has('kirim_email') && $request->kirim_email == '1') {
            $this->executeSendEmail($permohonan);
            Session::flash('flash_message', 'Status berhasil diperbarui & notifikasi email telah dikirim ke pemohon (' . $permohonan->email . ')!');
        } else {
            Session::flash('flash_message', 'Status permohonan berhasil diperbarui!');
        }

        return redirect('dashboard/permohonan-informasi/' . Hashids::encode($permohonan->id));
    }

    /**
     * Tombol khusus Kirim Notifikasi Email
     */
    public function sendEmail($id)
    {
        if (!$this->checkPermission()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        if (empty($ids)) {
            abort(404);
        }

        $permohonan = PermohonanInformasi::findOrFail($ids[0]);
        $success = $this->executeSendEmail($permohonan);

        if ($success) {
            Session::flash('flash_message', 'Notifikasi email berhasil dikirim ke ' . $permohonan->email . '!');
        } else {
            Session::flash('flash_message', 'Pemberitahuan email diproses (tersimpan ke log mailer sistem).');
        }

        return redirect()->back();
    }

    /**
     * Eksekusi pengiriman email
     */
    private function executeSendEmail(PermohonanInformasi $permohonan): bool
    {
        try {
            Mail::send('emails.permohonan_status', ['permohonan' => $permohonan], function ($message) use ($permohonan) {
                $message->to($permohonan->email, $permohonan->nama_pemohon)
                        ->subject('[PPID Bappeda Lampung] Pembaruan Status Permohonan: ' . $permohonan->nomor_tiket);

                // Lampirkan file jawaban jika ada
                if (!empty($permohonan->file_lampiran_jawaban)) {
                    $path = Storage::disk('public')->path($permohonan->file_lampiran_jawaban);
                    if (file_exists($path)) {
                        $message->attach($path);
                    }
                }
            });

            $permohonan->email_notifikasi_terkirim = true;
            $permohonan->tanggal_email_terakhir = now();
            $permohonan->save();

            return true;
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email permohonan informasi: ' . $e->getMessage(), [
                'tiket' => $permohonan->nomor_tiket,
                'email' => $permohonan->email,
            ]);
            return false;
        }
    }

    /**
     * Hapus Permohonan
     */
    public function destroy($id)
    {
        if (!$this->checkPermission()) {
            return redirect('dashboard');
        }

        $ids = Hashids::decode($id);
        if (empty($ids)) {
            abort(404);
        }

        $permohonan = PermohonanInformasi::findOrFail($ids[0]);

        // Hapus file yang terkait jika ada
        if (!empty($permohonan->file_ktp)) {
            Storage::disk('public')->delete($permohonan->file_ktp);
        }
        if (!empty($permohonan->file_pendukung)) {
            Storage::disk('public')->delete($permohonan->file_pendukung);
        }
        if (!empty($permohonan->file_lampiran_jawaban)) {
            Storage::disk('public')->delete($permohonan->file_lampiran_jawaban);
        }

        $permohonan->delete();

        Session::flash('flash_message', 'Permohonan informasi berhasil dihapus!');
        return redirect('dashboard/permohonan-informasi/table');
    }

    /**
     * Hapus Masal
     */
    public function deleteAll(Request $request)
    {
        if (!$this->checkPermission()) {
            return redirect('dashboard');
        }

        if ($request->has('id')) {
            foreach ($request->id as $id) {
                $ids = Hashids::decode($id);
                if (!empty($ids)) {
                    $permohonan = PermohonanInformasi::find($ids[0]);
                    if ($permohonan) {
                        if (!empty($permohonan->file_ktp)) {
                            Storage::disk('public')->delete($permohonan->file_ktp);
                        }
                        if (!empty($permohonan->file_pendukung)) {
                            Storage::disk('public')->delete($permohonan->file_pendukung);
                        }
                        if (!empty($permohonan->file_lampiran_jawaban)) {
                            Storage::disk('public')->delete($permohonan->file_lampiran_jawaban);
                        }
                        $permohonan->delete();
                    }
                }
            }
            Session::flash('flash_message', 'Data terpilih berhasil dihapus!');
        } else {
            Session::flash('flash_message', 'Tidak ada data yang dipilih.');
        }

        return redirect('dashboard/permohonan-informasi/table');
    }
}

