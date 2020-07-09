    <div class="form-group @error('prodi_id') has-error @enderror">
        <label for="prodi_id">Prodi</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="prodi_id" class="form-control" required>
                <option value="">- Pilih Prodi -</option>
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" @if($update && $takkumulatif->prodi_id==$prodi->id) selected @endif>
                    {{ $prodi->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.prodi.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Prodi</a>
        </div>
        </div>
        @error('prodi_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group @error('angkatan_id') has-error @enderror">
        <label for="angkatan_id">Prodi</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="angkatan_id" class="form-control" required>
                <option value="">- Pilih Angkatan -</option>
                @foreach($angkatans as $angkatan)
                    <option value="{{ $angkatan->id }}" @if($update && $takkumulatif->angkatan_id==$angkatan->id) selected @endif>
                    {{ $angkatan->tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.angkatan.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Angkatan</a>
        </div>
        </div>
        @error('angkatan_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <div class="col-sm-6">
          <label for="inputPoin">Poin Minimum</label>
              <input type="text" name="poinminimum" id="poinminimum" class="form-control @error('poinminimum') is-invalid @enderror" placeholder="Poin Minimum.." value="{{ old('poinminimum', $update ? $takkumulatif->poinminimum:'') }}">
            </div>
          </div>
          