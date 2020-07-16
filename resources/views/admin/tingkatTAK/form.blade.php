    <div class="form-group @error('kegiatantak_id') has-error @enderror">
        <label for="kegiatantak_id">Kegiatan</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="kegiatantak_id" class="form-control" required>
                <option value="">- Pilih Kegiatan -</option>
                @foreach($kegiatantaks as $kegiatantak)
                    <option value="{{ $kegiatantak->id }}" @if($update && $tingkatTAK->kegiatantak_id==$kegiatantak->id) selected @endif>
                    {{ $kegiatantak->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.kegiatanTAK.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Kegiatan TAK</a>
        </div>
        </div>
        @error('kegiatantak_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="InputNama">Nama Tingkat</label>
              <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan.." value="{{ old('keterangan', $update ? $tingkatTAK->keterangan:'') }}">
            </div>
         @error('keterangan')
        <p class="help-block">{{ $message }}</p>
        @enderror
          </div>
          