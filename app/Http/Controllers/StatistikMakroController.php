<?php

namespace App\Http\Controllers;

use App\Models\StatistikMakro;
use Illuminate\Http\Request;

class StatistikMakroController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $kategori = trim((string) $request->input('kategori', ''));

        $query = StatistikMakro::query()->orderBy('urutan', 'asc')->orderBy('id', 'asc');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', '%' . $q . '%')
                    ->orWhere('deskripsi', 'like', '%' . $q . '%')
                    ->orWhere('kategori_nama', 'like', '%' . $q . '%');
            });
        }

        if ($kategori !== '') {
            $query->where('kategori_nama', $kategori);
        }

        $items = $query->get();

        $categories = StatistikMakro::whereNotNull('kategori_nama')
            ->where('kategori_nama', '!=', '')
            ->distinct()
            ->orderBy('kategori_nama')
            ->pluck('kategori_nama');

        return view('theme-2024limitless.data-pembangunan', compact('items', 'categories', 'q', 'kategori'));
    }
}
