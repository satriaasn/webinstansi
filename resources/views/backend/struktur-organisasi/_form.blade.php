<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Atasan / Parent Unit</label>
            <select name="parent_id" class="form-control select2">
                <option value="">-- Root (Pimpinan Tertinggi / Kepala Badan) --</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}" {{ old('parent_id', $item->parent_id ?? '') == $p->id ? 'selected' : '' }}>
                        {{ $p->jabatan }} {{ $p->nama ? '(' . $p->nama . ')' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label required">Tipe Jabatan / Node</label>
            @php
                $types = [
                    'pimpinan' => 'Pimpinan (Kepala Badan)',
                    'sekretaris' => 'Sekretaris',
                    'kasubbag' => 'Kasubbag',
                    'uptd' => 'Kepala UPTD',
                    'kabid' => 'Kepala Bidang (Kabid)',
                    'kasi' => 'Kepala Seksi / Kasubbag TU',
                    'fungsional' => 'Kelompok Jabatan Fungsional',
                ];
                $selectedType = old('tipe_node', $item->tipe_node ?? 'kabid');
            @endphp
            <select name="tipe_node" class="form-control select2" required>
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ $selectedType == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Urutan Tampil</label>
            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $item->urutan ?? 1) }}" min="0">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label required">Nama Jabatan / Unit Kerja</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $item->jabatan ?? '') }}" required placeholder="Contoh: KABID PERENCANAAN PEREKONOMIAN">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Nama Pejabat (Opsional untuk Fungsional)</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $item->nama ?? '') }}" placeholder="Contoh: ENDANG WAHYUNI, S.T., M.Si.">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $item->nip ?? '') }}" placeholder="Contoh: 19750617 200003 2 001">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">Pangkat / Golongan</label>
            <input type="text" name="pangkat" class="form-control" value="{{ old('pangkat', $item->pangkat ?? '') }}" placeholder="Contoh: PEMBINA (IV/a)">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">TMT Pangkat</label>
            <input type="text" name="tmt_pangkat" class="form-control" value="{{ old('tmt_pangkat', $item->tmt_pangkat ?? '') }}" placeholder="dd-mm-yyyy">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">TMT Jabatan</label>
            <input type="text" name="tmt_jabatan" class="form-control" value="{{ old('tmt_jabatan', $item->tmt_jabatan ?? '') }}" placeholder="dd-mm-yyyy">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label">Foto Pejabat (Otomatis dikompres ke WebP)</label>
    @if(!empty($item->foto))
        <div class="mb-2">
            @include('backend.partials.image_preview', ['file' => $item->foto, 'alt' => $item->nama ?? $item->jabatan, 'maxHeight' => '150px'])
        </div>
    @endif
    <input type="file" name="foto" class="form-control-file" accept="image/*">
</div>

<div class="form-group">
    <label class="control-label">Tugas &amp; Fungsi / Keterangan (Tampil saat kartu diklik)</label>
    <textarea name="deskripsi" rows="3" class="form-control" placeholder="Uraian singkat tugas dan fungsi jabatan...">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label">Status</label>
    @php $activeVal = old('active', $item->active ?? 'Y'); @endphp
    <select name="active" class="form-control select2" required>
        <option value="Y" {{ $activeVal == 'Y' ? 'selected' : '' }}>Active</option>
        <option value="N" {{ $activeVal == 'N' ? 'selected' : '' }}>Non Active</option>
    </select>
</div>

<hr>
<div class="form-group text-right">
    <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>
