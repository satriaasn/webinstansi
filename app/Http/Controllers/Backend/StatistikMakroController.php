<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StatistikMakro;
use App\Services\StatistikMakroApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StatistikMakroController extends Controller
{
    private function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('superadmin') || $user->hasRole('admin') || $user->can('settings'));
    }

    public function index()
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $items = StatistikMakro::orderByDesc('show_on_home')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $selectedCount = $items->where('show_on_home', true)->count();
        $lastSynced = $items->max('synced_at');

        return view('backend.statistik-makro.index', compact('items', 'selectedCount', 'lastSynced'));
    }

    public function sync(StatistikMakroApiService $service)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        try {
            $result = $service->sync();
            return redirect()->route('dashboard.statistik-makro.index')
                ->with('flash_message', "Sinkronisasi berhasil! {$result['synced']} data indikator makro diperbarui dari API.");
        } catch (\Throwable $e) {
            return redirect()->route('dashboard.statistik-makro.index')
                ->with('error_message', 'Gagal sinkronisasi API: ' . $e->getMessage());
        }
    }

    public function saveSelection(Request $request)
    {
        if (!$this->canAccess()) {
            return redirect('dashboard');
        }

        $selectedIds = array_map('intval', (array) $request->input('selected_ids', []));
        $urutanMap = (array) $request->input('urutan', []);

        $allItems = StatistikMakro::all();
        foreach ($allItems as $item) {
            $item->show_on_home = in_array($item->id, $selectedIds, true);
            if (isset($urutanMap[$item->id])) {
                $item->urutan = (int) $urutanMap[$item->id];
            }
            $item->save();
        }

        Cache::forget('home_statistik_makro');

        return redirect()->route('dashboard.statistik-makro.index')
            ->with('flash_message', 'Pilihan tampilan beranda disimpan! (' . count($selectedIds) . ' indikator aktif di Beranda).');
    }
}
