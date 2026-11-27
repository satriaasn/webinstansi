<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Cache;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $nodes = Cache::remember('struktur_organisasi_tree', 3600, function () {
            return StrukturOrganisasi::where('active', 'Y')
                ->orderBy('urutan', 'asc')
                ->orderBy('id', 'asc')
                ->get();
        });

        $root = $nodes->whereNull('parent_id')->first();
        $sekretaris = $root ? $nodes->where('parent_id', $root->id)->firstWhere('tipe_node', 'sekretaris') : null;
        $sekretarisChildren = $sekretaris ? $nodes->where('parent_id', $sekretaris->id)->values() : collect();

        $bidangList = $root
            ? $nodes->where('parent_id', $root->id)->where('tipe_node', '!=', 'sekretaris')->values()
            : collect();

        $childrenByParent = $nodes->groupBy('parent_id');

        return view(getTheme('struktur-organisasi'), compact(
            'nodes',
            'root',
            'sekretaris',
            'sekretarisChildren',
            'bidangList',
            'childrenByParent'
        ));
    }
}
